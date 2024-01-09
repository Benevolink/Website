<?php
$url = 'https://api-adresse.data.gouv.fr/search/?q=paris&type=street';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === FALSE) {
    echo 'Erreur lors de la requête cURL : ' . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);
?>