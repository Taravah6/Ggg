<?php
system('clear');
error_reporting(0);
function timer($t){
$p=$t;
for ($x=$p;$x>0;$x--){
$wak = date("[i:s]", $x);
echo "\r                          \r";
echo "\r  \033[1;97mwait \033[1;93m".$wak." \r";
sleep(1);
}
}


function curl_request($url, $method, $data = null) {
	
    $header = array(
        "Host: bitcositeplus.com",
        "upgrade-insecure-requests: 1",
        "content-type: application/x-www-form-urlencoded",
        "X-Requested-With: XMLHttpRequest",
        "cookie: ci_session=66108aee03b0c75c72b7bfab62555c0b35c1b3fd; csrf_cookie_name=75fd6516e8ba2cecbd517332b2f1bdb8",
        "user-agent: Mozilla/5.0 (Linux; Android 11; V2043 Build/RP1A.200720.012; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 Mobile Safari/537.36",
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function capxx() {
	global $key,$sit,$urls;
    $header = array(             
        "origin: http://api.multibot.in/",
        "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7",
        "Connection: keep-alive",
        "content-type: application/json",
        "user-agent: Mozilla/5.0 (Linux; Android 11; V2043 Build/RP1A.200720.012; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 Mobile Safari/537.36"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    a:
    $url = "http://80.64.218.109:80/in.php?key=".$key."&method=userrecaptcha&googlekey=".$sit."&pageurl=".$urls."";
    curl_setopt($ch, CURLOPT_URL, $url);
    $respo = curl_exec($ch);
    $id = str_replace("OK|", "", $respo);
    if ($id == '') { goto a; }
    $r = 1;
    if ($r == "30") { goto a; }
    
    c:
    $url = "http://80.64.218.109:80/res.php?action=get&id=" . $id . "&key=".$key."&header_acao=1&json=1";
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    $jons = json_decode($res);
    $rest = $jons->request;
    if ($rest == 'CAPCHA_NOT_READY') {
        echo "\r` \033[1;94m wait.. " . $r . " \r";
        $r = $r + 1;
        sleep(5);
        goto c;
    }
    if ($rest == "ERROR_CAPTCHA_UNSOLVABLE") {
        echo "\r` \033[1;94m  Error.. " . $r . " \r";
        $r = $r + 1;
        sleep(5);
        goto a;
    }
    if ($rest == "") {
        echo "\r` \033[1;94m  WAIT...." . $r . " \r";
        $r = $r + 1;
        sleep(20);
       
    }

    return $rest;
}
$key = "7r11rX0WXQMloixxt79WHGdehz3eMj7c";
//$sit = "6Lf6CTspAAAAAML0t4IXktxDw3ve60E6d8WVwdHj";
$urls = "https://bitcositeplus.com/mining/take";

while(true):


$url = "https://bitcositeplus.com/visit";
$response = curl_request($url, 'GET');
//$timm = explode(';' ,explode('var count =', $response)[1])[0];
$csf = explode('">' ,explode('<input type="hidden" name="csrf_token_name" id="token" value="', $response)[1])[0];
$sit = explode('">' ,explode('<div class="g-recaptcha" data-sitekey="', $response)[1])[0];

$timm="20";
timer($timm);

$captcha=capxx();

$url = 'https://bitcositeplus.com/mining/take';
$data = "csrf_token_name=".$csf."&captcha=recaptchav2&g-recaptcha-response=".$captcha."";
$resi = curl_request($url, 'POST', $data);
$suc = explode("Balance!`,",explode("html: `", $resi)[1])[0];

$url = "https://bitcositeplus.com/";
$respo = curl_request($url, 'GET');
$ball = explode('<div class="h5 mb-0 font-weight-bold text-gray-800">' ,explode('<small>0000</small>', $respo)[0])[1];
echo "\033[1;94m Balance : \033[1;93m".$ball."$\n";

$fot = sprintf("%.2f", $ball);
if($fot == "0.03"){
$url = "https://bitcositeplus.com/withdraw";
$response = curl_request($url, 'GET');
$csf = explode('">' ,explode('<input type="hidden" name="csrf_token_name" id="token" value="', $response)[1])[0];
$tok = explode('">' ,explode('<input type="hidden" name="token" value="', $response)[1])[0];
$url = 'https://bitcositeplus.com/wdrequest';
$data = "csrf_token_name=".$csf."&token=".$tok."&amount=0.03&currency=BTC";
$resi = curl_request($url, 'POST', $data);
}


$gg = 300;
timer($gg);
endwhile;

