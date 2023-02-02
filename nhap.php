
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '{{BASE_URL}}',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "action_type": "update",
  "data_type": "device",
  "date": "2020-12-11 11:14:40",
  "deviceID": "C20371B164",
  "deviceName": "C20371B164",
  "hash": "e4a296a0a9d3f958b4262d9680db4bee",
  "id": "de73e412-7baf-4237-9b09-7470eddd4996",
  "keycode": "",
  "placeID": "108",
  "placeName": "Team dev",
  "time": 1607660080000
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Authorization'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;