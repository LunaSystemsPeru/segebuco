<?php

$ruta = "https://ruc.com.pe/api/v1/ruc";
$token = "249ac913-5214-4b9f-9596-c6cff12ba192-93c65dd9-e572-485c-832b-e5355780ec73";

$rucaconsultar = filter_input(INPUT_GET, 'ruc'); ///filter_input(INPUT_GET, 'ruc');

$data = array(
    "token"	=> $token,
    "ruc"   => $rucaconsultar
);
	
$data_json = json_encode($data);

// Invocamos el servicio a ruc.com.pe
// Ejemplo para JSON
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ruta);
curl_setopt(
	$ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	)
);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta  = curl_exec($ch);
curl_close($ch);

$leer_respuesta = json_decode($respuesta, true);
if (isset($leer_respuesta['errors'])) {
	//Mostramos los errores si los hay
    echo $leer_respuesta['errors'];
} else {
	//Mostramos la respuesta
	//echo "Respuesta de la API:<br>";
	print_r(json_encode($leer_respuesta));
}

?>