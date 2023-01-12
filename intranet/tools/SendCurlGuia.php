<?php


class SendCurlGuia
{
    private $id_guia;
    private $ruta;

    /**
     * SendCurlGuia constructor.
     */
    public function __construct()
    {
        //$this->ruta = "http://" . $_SERVER["HTTP_HOST"] . "/clientes/efacturacion/";
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $rutabase= dirname(dirname($url)) . DIRECTORY_SEPARATOR;
        //echo $rutabase;
        $this->ruta =  $rutabase;
    }

    /**
     * @return mixed
     */
    public function getIdGuia()
    {
        return $this->id_guia;
    }

    /**
     * @param mixed $id_guia
     */
    public function setIdGuia($id_guia)
    {
        $this->id_guia = $id_guia;
    }

    function enviar_json() {
        //$this->llenar_venta();
        $post = [
            'id_guia' => $this->id_guia,
        ];

        $ruta = $this->ruta . "greenter/generates/guia-remision.php";

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
            'id_guia' => $this->id_guia,
        ];

        $ruta = $this->ruta . "reports/rpt_guia_remision.php";

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