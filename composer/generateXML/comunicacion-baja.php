<?php
declare(strict_types=1);

use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';
require '../src/Config.php';

require '../../models/Empresa.php';
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
$arrayComprobantes = $Anulada->verVentasAnuladas('F', $Empresa->getIdempresa(), $fecha);

$arrayDetalle = array();
$nroitems = 0;
foreach ($arrayComprobantes as $fila) {
    $nroitems++;
    $detalle = new VoidedDetail();
    $detalle->setTipoDoc($Util->zerofill($fila['cod_sunat'], 2))
        ->setSerie($fila['serie'])
        ->setCorrelativo($fila['numero'])
        ->setDesMotivoBaja('ERROR EN CÁLCULOS');
    array_push($arrayDetalle, $detalle);
}
if ($nroitems > 0) {

    $voided = new Voided();
    $voided->setCorrelativo('00001')
        // Fecha Generacion menor que Fecha comunicacion
        ->setFecGeneracion(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setFecComunicacion(\DateTime::createFromFormat('Y-m-d', $fecha))
        ->setCompany($company)
        ->setDetails($arrayDetalle);


    // Envio a SUNAT.
    $res = $see->send($voided);
    // Guardar XML firmado digitalmente.
    file_put_contents("../../public/xml/" . $voided->getName() . '.xml',
        $see->getFactory()->getLastXml());

    if (!$res->isSuccess()) {
        print_r($res->getError());
        return;
    }

    /**@var $res SummaryResult */
    $ticket = $res->getTicket();
    echo 'Ticket :<strong>' . $ticket . '</strong>';

    $res = $see->getStatus($ticket);
    if (!$res->isSuccess()) {
        print_r($res->getError());
        return;
    }

    $cdr = $res->getCdrResponse();
    //$util->writeCdr($sum, $res->getCdrZip());
    // Guardamos el CDR
    file_put_contents("../../public/cdr/" . 'R-' . $voided->getName() . '.zip', $res->getCdrZip());
    //$util->showResponse($sum, $cdr);


}