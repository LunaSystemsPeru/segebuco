<?php
declare(strict_types=1);

use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Document;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\SummaryPerception;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';
require '../src/Config.php';

require '../../models/Empresa.php';
require '../../models/SunatResumen.php';
require '../../models/Venta.php';
require '../../models/VentaNota.php';
require '../../models/VentaAnulada.php';

require '../../tools/Util.php';

$Util = new Util();

$Empresa = new Empresa();
$Empresa->setIdempresa(filter_input(INPUT_GET, 'empresaid'));
$Empresa->obtenerDatos();

$Config = new Config();
$Config->setRuc($Empresa->getRuc());
$Config->setUsersol($Empresa->getUsersol());
$Config->setClavesol($Empresa->getClavesol());

$see = $Config->getSee();

$Resumen = new SunatResumen();

// Emisor
$address = (new Address())
    ->setUbigueo($Empresa->getUbigeo())
    ->setDepartamento($Empresa->getDepartamento())
    ->setProvincia($Empresa->getProvincia())
    ->setDistrito($Empresa->getDistrito())
    ->setUrbanizacion('-')
    ->setDireccion($Empresa->getDireccion())
    ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

$company = (new Company())
    ->setRuc($Empresa->getRuc())
    ->setRazonSocial($Empresa->getRazon())
    ->setNombreComercial($Empresa->getRazon())
    ->setAddress($address);

$Anulada = new VentaAnulada();
$fecha = filter_input(INPUT_GET, 'fecha');
$arrayBoletas = $Anulada->verVentasAnuladas('B', $Empresa->getIdempresa(), $fecha);

$arrayDetalle = array();
$nroitems = 0;
// Summary
foreach ($arrayBoletas as $fila) {
    $nroitems++;
    $doccliente = $fila['documento'];
    $tipocliente = "1";
    if (strlen($doccliente) == "8") {
        if (strpos($doccliente, "SD") == 0) {
            $doccliente = '00000000';
            $tipocliente = "0";
        } else {
            $tipocliente = "1";
        }
    } else if (strlen($doccliente) == 11) {
        $tipocliente = "6";
    } else {
        $tipocliente = "0";
        $doccliente = '00000000';
    }
    $total = $fila['total'];
    $igv = $fila['igv'];
    $base = $igv / 0.18;
    $exonerado = $total - $base - $igv;
    $detalle = new SummaryDetail();
    $detalle->setTipoDoc($Util->zerofill($fila['cod_sunat'], 2))
        ->setSerieNro($fila['serie'] . "-" . $fila['numero'])
        ->setEstado('3')
        ->setClienteTipo($tipocliente)
        ->setClienteNro($doccliente)
        ->setTotal(floatval($total))
        ->setMtoOperGravadas($base)
        ->setMtoOperInafectas(0)
        ->setMtoOperExoneradas($exonerado)
        ->setMtoOperExportacion(0)
        ->setMtoOtrosCargos(0)
        ->setMtoIGV(floatval($igv));

    if ($fila['id_tido'] == 6) {
        $Nota = new VentaNota();
        $Nota->setNotaid($fila['id_ventas']);
        $Nota->obtenerDatos();
        $VReferencia = new Venta();
        $VReferencia->setIdventa($Nota->getReferenciaid());
        $VReferencia->obtenerDatos();

        $detalle->setDocReferencia((new Document())
            ->setTipoDoc('03')
            ->setNroDoc($VReferencia->getSerie() . "-" . $VReferencia->getNumero()));
    }

    array_push($arrayDetalle, $detalle);
}

if ($nroitems > 0) {

$sum = new Summary();
// Fecha Generacion menor que Fecha Resumen
$sum->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
    ->setFecResumen(\DateTime::createFromFormat('Y-m-d', $fecha))
    ->setCorrelativo('002')
    ->setCompany($company)
    ->setDetails($arrayDetalle);


// Envio a SUNAT.
    $res = $see->send($sum);
// Guardar XML firmado digitalmente.
    file_put_contents("../../public/xml/" . $sum->getName() . '.xml',
        $see->getFactory()->getLastXml());

    $Resumen->setEstado(1);
    if (!$res->isSuccess()) {
        echo "<br> error al enviar ";
        print_r($res->getError());
        $Resumen->setEstado(0);
        // return;
    }

    /**@var $res SummaryResult */
    $ticket = $res->getTicket();
    echo 'Ticket :<strong>' . $ticket . '</strong>';


    $Resumen->setIdempresa($Empresa->getIdempresa());
    $Resumen->setNombre($sum->getName());
    $Resumen->setFechaenvio(date("Y-m-d"));
    $Resumen->setTikect($ticket);
    $Resumen->setTipo(2); //anulados
    $Resumen->setCantidad($nroitems);
    $Resumen->obtenerId();

    $Resumen->insertar();

    if ($Resumen->getEstado() == 0) {
        return;
    }

    $res = $see->getStatus($ticket);
    if (!$res->isSuccess()) {
        echo "<br> error al obtener estado de ticket ";
        print_r($res->getError());
        $Resumen->setEstado(0);
        return;
    }

    $cdr = $res->getCdrResponse();
//$util->writeCdr($sum, $res->getCdrZip());
// Guardamos el CDR
    file_put_contents("../../public/cdr/" . 'R-' . $sum->getName() . '.zip', $res->getCdrZip());
//$util->showResponse($sum, $cdr);

}