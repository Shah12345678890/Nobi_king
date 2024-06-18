<?php

$id = @$_GET['id'];
$currentTimestamp = time();
$portal_url = "http://jiotv.be/stalker_portal/c/";
$host = "jiotv.be";
$mac = "00:1A:79:83:A3:04";
$deviceid = "";
$deviceid2 = "";
$serial = "";
$sig = "";

$n1 = "http://$host/stalker_portal/server/load.php?type=stb&action=handshake&prehash=false&JsHttpRequest=1-xml";

$h1 = [
    "Cookie: mac=$mac; stb_lang=en; timezone=GMT",
    "Referer: $portal_url",
    "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3",
    "X-User-Agent: Model: MAG250; Link:",
];

$c1_curl = curl_init();
curl_setopt($c1_curl, CURLOPT_URL, $n1);
curl_setopt($c1_curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($c1_curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($c1_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c1_curl, CURLOPT_HTTPHEADER, $h1);
curl_setopt($c1_curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3');
$res1 = curl_exec($c1_curl);
curl_close($c1_curl);

$response = json_decode($res1, true);
$token = $response['js']['random'];
$real = $response['js']['token'];

$h2 = [
    "Cookie: mac=$mac; stb_lang=en; timezone=GMT",
    "Authorization: Bearer B78A41ADFD8F27100A3371D374EF255B",
    "Referer: $portal_url",
    "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3",
    "X-User-Agent: Model: MAG250; Link:",
];

$n2 = "http://jiotv.be/stalker_portal/stalker_portal/server/load.php?type=stb&action=get_profile&hd=1&ver=ImageDescription: 0.2.18-r14-pub-250; ImageDate: Fri Jan 15 15:20:44 EET 2016; PORTAL version: 5.5.0; API Version: JS API version: 328; STB API version: 134; Player Engine version: 0x566&num_banks=2&sn=$serial&stb_type=MAG254&image_version=218&video_out=hdmi&device_id=$deviceid&device_id2=$deviceid2&signature=$sig&auth_second_step=1&hw_version=1.7-BD-00&not_valid_token=0&client_type=STB&hw_version_2=7c431b0aec69b2f0194c0680c32fe4e3&timestamp=$currentTimestamp&api_signature=263&metrics={\"mac\":\"$mac\",\"sn\":\"$serial\",\"model\":\"MAG254\",\"type\":\"STB\",\"uid\":\"$deviceid\",\"random\":\"$token\"}&JsHttpRequest=1-xml";

$c2_curl = curl_init();
curl_setopt($c2_curl, CURLOPT_URL, $n2);
curl_setopt($c2_curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($c2_curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($c2_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c2_curl, CURLOPT_HTTPHEADER, $h2);
curl_setopt($c2_curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3');
$res2 = curl_exec($c2_curl);
curl_close($c2_curl);

$n3 = "http://$host/stalker_portal/server/load.php?type=itv&action=create_link&cmd=ffrt%http://localhost/ch/$id&JsHttpRequest=1-xml";

$c3_curl = curl_init();
curl_setopt($c3_curl, CURLOPT_URL, $n3);
curl_setopt($c3_curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($c3_curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($c3_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c3_curl, CURLOPT_HTTPHEADER, $h2);
curl_setopt($c3_curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3');
$res3 = curl_exec($c3_curl);
curl_close($c3_curl);

$i6 = json_decode($res3, true);

if (isset($i6["js"]["cmd"])) {

    $d7 = $i6["js"]["cmd"];
    $flink = str_replace("index.m3u8", "tracks-v1a1/mono.m3u8", $d7);
    $parsedUrl = parse_url($flink);
    $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'] . $parsedUrl['path'];
    $encodeurl = str_replace("mono.m3u8", "", $baseUrl);

    function fetchData($flink, $encodeurl)
    {

        $n3 = curl_init();
        curl_setopt($n3, CURLOPT_URL, $flink);
        curl_setopt($n3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($n3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($n3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($n3, CURLOPT_USERAGENT, 'Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3');
        curl_setopt($n3, CURLOPT_FOLLOWLOCATION, true);
        $html = curl_exec($n3);
        $flink = curl_getinfo($n3, CURLINFO_EFFECTIVE_URL);
        curl_close($n3); 

        $subject = $html;
        $search = "/hlsr/";
        preg_match('/(http.*80)/', $flink, $xn);
        $x = $xn=0;

        // Add the main URL to the paths in the M3U playlist
        $subject = preg_replace('/(\d{4}\/\d{2}\/\d{2}\/\d{2}\/\d{2}\/\d{2}-\d+\.ts)/', "ts.php?ts=$encodeurl$1", $subject);
        $trimmed = str_replace($search, "ts.php?ts=$x/hlsr/", $subject);
        return $trimmed;
    }

    function sendStreamData($data)
    {
        $chunkSize = 1024; //Adjust chunk size as needed
        $dataLength = strlen($data);
        ("Content-Length: " . $dataLength); // Set content length
        echo $data;
        exit(); //Exit after sending one chunk
    }

    sendStreamData(fetchData($flink, $encodeurl));

    // Adjust delay between sending data (in seconds)
    $delaySeconds = 25; // Adjust this value as needed

    // Send stream data continuously with adjusted delay
    while (true) {
        sleep($delaySeconds);
        sendStreamData(fetchData($flink, $encodeurl)); // Call fetchData again to get updated stream data
    }
}
?>
