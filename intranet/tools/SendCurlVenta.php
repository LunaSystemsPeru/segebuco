<?php


class SendCurlVenta
{
    private $id_tido;
    private $id_venta;
    private $ruta;

    /**
     * SendCurlVenta constructor.
     */
    public function __construct()
    {
        //$this->ruta = "http://" . $_SERVER["HTTP_HOST"] . "/clientes/efacturacion/";
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $rutabase= dirname(dirname($url)) . DIRECTORY_SEPARATOR;
        $this->ruta =  $rutabase;
        //echo $rutabase;
    }

    /**
     * @param mixed $id_tido
     */
    public function setIdTido($id_tido)
    {
        $this->id_tido = $id_tido;
    }

    /**
     * @param mixed $id_venta
     */
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
    }

    function enviar_json() {
        //$this->llenar_venta();
        $post = [
            'id_venta' => $this->id_venta,
        ];

        $archivo = "factura";
        if ($this->id_tido == 2) {
            $archivo = "factura";
        }
        if ($this->id_tido == 1) {
            $archivo = "boleta";
        }
        if ($this->id_tido == 3) {
            $archivo = "nota_credito";
        }

        $ruta = $this->ruta . "greenter/generates/" . $archivo . ".php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);

        return $respuesta;
    }

    function generar_pdf() {
        $post = [
            'id_venta' => $this->id_venta,
        ];

        $archivo = "";
        if ($this->id_tido == 2 || $this->id_tido == 1) {
            $archivo = "documento_venta";
        }

        $ruta = $this->ruta . "reports/" . $archivo . ".php";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);

        return $respuesta;
    }
}