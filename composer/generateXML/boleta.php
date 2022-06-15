<?php
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

require __DIR__.'/../vendor/autoload.php';
require '../src/Config.php';

require '../../models/Venta.php';
require '../../models/VentaProducto.php';
require '../../models/Cliente.php';
require '../../models/Empresa.php';
require '../../models/Almacen.php';
require '../../models/DocumentoSunat.php';
require '../../models/VentaSunat.php';
require '../../tools/NumerosaLetras.php';

require '../../generate_qr/class/GenerarQr.php';

$NumeroLetras = new NumerosaLetras();

$ventaid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$Venta = new Venta();
$Venta->setIdventa($ventaid);
$Venta->obtenerDatos();

$SunatVenta = new VentaSunat();
$SunatVenta->setVentaid($Venta->getIdventa());
$SunatVenta->setFechaEnvio(date("Y-m-d"));

$Tienda = new Almacen();
$Tienda->setIdalmacen($Venta->getIdalmacen());
$Tienda->obtenerDatos();

$Empresa = new Empresa();
$Empresa->setIdempresa($Tienda->getIdempresa());
$Empresa->obtenerDatos();

$ProductoVenta = new VentaProducto();
$ProductoVenta->setIdventa($Venta->getIdventa());

$Cliente = new Cliente();
$Cliente->setIdcliente($Venta->getIdcliente());
$Cliente->obtenerDatos();

$Config = new Config();
$Config->setRuc($Empresa->getRuc());
$Config->setUsersol($Empresa->getUsersol());
$Config->setClavesol($Empresa->getClavesol());

$see = $Config->getSee();

// Cliente
$client = (new Client())
    ->setTipoDoc('6')
    ->setNumDoc($Cliente->getDocumento())
    ->setRznSocial($Cliente->getNombre());

// Emisor
$address = (new Address())
    ->setUbigueo($Tienda->getUbigeo())
    ->setDepartamento($Tienda->getDepartamento())
    ->setProvincia($Tienda->getProvincia())
    ->setDistrito($Tienda->getDistrito())
    ->setUrbanizacion('-')
    ->setDireccion($Tienda->getDireccion())
    ->setCodLocal($Tienda->getTicketera()); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

$company = (new Company())
    ->setRuc($Empresa->getRuc())
    ->setRazonSocial($Empresa->getRazon())
    ->setNombreComercial($Empresa->getRazon())
    ->setAddress($address);

//lista de productos
$arrayProductos = $ProductoVenta->verFilas();
$arrayItems = array();
$totalBaseIGV = 0;
$totalBase = 0;
foreach ($arrayProductos as $item) {
    $itemProducto = (new SaleDetail());

    $itemProducto
        ->setCodProducto($item['id_producto'])
        ->setUnidad('NIU') // Unidad - Catalog. 03
        ->setCantidad($item['cantidad'])
        ->setDescripcion( utf8_encode($item['descripcion']));

    $itemSinIGV = 0;
    $base = 0;
    $base=$item['cantidad'] * $item['precio'];
    if ($item['afecto_igv'] == 0) {
        $itemSinIGV = $item['precio'] / 1.18;
        $base = $base/1.18;
        $totalBaseIGV = $totalBaseIGV + $base;

        $itemProducto
            ->setPorcentajeIgv(18.00) // 18%
            ->setIgv(number_format($base*0.18,2))
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos(number_format($base*0.18,2)) // Suma de impuestos en el detalle
            ->setMtoPrecioUnitario(number_format($itemSinIGV*1.18,2));
    } else {
        $itemSinIGV = $item['precio'];
        $totalBase = $totalBase + $base;

        $itemProducto
            ->setPorcentajeIgv(0.00) // 18%
            ->setIgv(0)
            ->setTipAfeIgv('20') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos(0)
            ->setMtoPrecioUnitario(number_format($itemSinIGV,2));
    }
    $itemProducto
        ->setMtoValorUnitario($itemSinIGV)
        ->setMtoBaseIgv($base)
        ->setMtoValorVenta($base)
    ;

    array_push($arrayItems, $itemProducto);
}

$totalGeneral = $totalBaseIGV * 1.18 + $totalBase;

// Venta
$invoice = (new Invoice())
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101') // Venta - Catalog. 51
    ->setTipoDoc('03') // Factura - Catalog. 01
    ->setSerie($Venta->getSerie())
    ->setCorrelativo($Venta->getNumero())
    ->setFechaEmision(\DateTime::createFromFormat('Y-m-d', $Venta->getFecha())) // Zona horaria: Lima
    ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
    ->setTipoMoneda('PEN') // Sol - Catalog. 02
    ->setCompany($company)
    ->setClient($client)
    ->setMtoOperGravadas($totalBaseIGV)
    ->setMtoOperExoneradas($totalBase)
    ->setMtoIGV(number_format($totalBaseIGV*0.18,2))
    ->setTotalImpuestos(number_format($totalBaseIGV*0.18,2))
    ->setValorVenta($totalBaseIGV + $totalBase)
    ->setSubTotal($totalGeneral)
    ->setMtoImpVenta($totalGeneral)
;

$legend = (new Legend())
    ->setCode('1000') // Monto en letras - Catalog. 52
    ->setValue($NumeroLetras->to_word($totalGeneral, "PEN"));

$invoice->setDetails($arrayItems)
    ->setLegends([$legend]);

$igv = number_format($totalBaseIGV*0.18,2);
$totalGeneral = number_format($totalGeneral,2);

$nombre_archivo = $invoice->getName();
$tipoDoc = 1;
//generar qr
$qr = $Empresa->getRuc() . "|" . "03" . "|" . $Venta->getSerie() . "|" . $Venta->getNumero() . "|" . $igv . "|" . $totalGeneral . "|" . $Venta->getFecha() . "|" . $tipoDoc . "|" . $Cliente->getDocumento();
$generarQR = new generarQr();
$generarQR->setTexto_qr($qr);
$generarQR->setNombre_archivo($nombre_archivo);
$generarQR->generar_qr();

//boletas no se envian xml a sunat
//$result = $see->send($invoice);
$see->getXmlSigned($invoice);

// Guardar XML firmado digitalmente.
file_put_contents("../../public/xml/".$invoice->getName().'.xml',
    $see->getFactory()->getLastXml());


$aceptadosunat = true;
$indiceaceptado = 1;
$observaciones  ="";
$code ="";

$SunatVenta->setCodigoSunat($code);
$SunatVenta->setEstadoAceptado($indiceaceptado);
$SunatVenta->setNombreDocumento($invoice->getName());
$SunatVenta->setRespuesta($observaciones);
$SunatVenta->setHash($Config->getHash($invoice));
$SunatVenta->insertar();

//echo json_encode(["aceptado" => $aceptadosunat, "observaciones" => $observaciones, "nombreDocumento" => $invoice->getName(), "codigoSunat" => $code]);

