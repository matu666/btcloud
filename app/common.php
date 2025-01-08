<?php
// 应用公共文件
use think\facade\Db;

function get_data_dir($os = 'Linux'){
	if($os == 'en'){
		return app()->getRootPath().'data/en/';
	}elseif($os == 'Windows'){
		return app()->getRootPath().'data/win/';
	}else{
		return app()->getRootPath().'data/';
	}
}


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if(((int)substr($result, 0, 10) == 0 || (int)substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}

function get_curl($url, $post=0, $referer=0, $cookie=0, $header=0, $ua=0, $nobody=0, $addheader=0)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$httpheader[] = "Accept: */*";
	$httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
	$httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
	$httpheader[] = "Connection: close";
	if($addheader){
		$httpheader = array_merge($httpheader, $addheader);
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if ($header) {
		curl_setopt($ch, CURLOPT_HEADER, true);
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	if($referer){
		curl_setopt($ch, CURLOPT_REFERER, $referer);
	}
	if ($ua) {
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	}
	else {
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36");
	}
	if ($nobody) {
		curl_setopt($ch, CURLOPT_NOBODY, 1);
	}
	curl_setopt($ch, CURLOPT_ENCODING, "gzip");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}

function jsonp_decode($jsonp, $assoc = false)
{
	$jsonp = trim($jsonp);
	if(isset($jsonp[0]) && $jsonp[0] !== '[' && $jsonp[0] !== '{') {
		$begin = strpos($jsonp, '(');
		if(false !== $begin)
		{
			$end = strrpos($jsonp, ')');
			if(false !== $end)
			{
				$jsonp = substr($jsonp, $begin + 1, $end - $begin - 1);
			}
		}
	}
	return json_decode($jsonp, $assoc);
}

function config_get($key, $default = null)
{
    $value = config('sys.'.$key);
    return $value!==null ? $value : $default;
}

function config_set($key, $value)
{
    $res = Db::name('config')->replace()->insert(['key'=>$key, 'value'=>$value]);
    return $res!==false;
}

function real_ip($type=0){
    $ip = $_SERVER['REMOTE_ADDR'];
    if($type<=0 && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] AS $xip) {
            if (filter_var($xip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $ip = $xip;
                break;
            }
        }
    } elseif ($type<=0 && isset($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ($type<=1 && isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif ($type<=1 && isset($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;
}

function getSubstr($str, $leftStr, $rightStr)
{
	$left = strpos($str, $leftStr);
	$start = $left+strlen($leftStr);
	$right = strpos($str, $rightStr, $start);
	if($left < 0) return '';
	if($right>0){
		return substr($str, $start, $right-$start);
	}else{
		return substr($str, $start);
	}
}

function checkRefererHost(){
    if(!request()->header('referer'))return false;
    $url_arr = parse_url(request()->header('referer'));
    $http_host = request()->header('host');
    if(strpos($http_host,':'))$http_host = substr($http_host, 0, strpos($http_host, ':'));
    return $url_arr['host'] === $http_host;
}

function checkIfActive($string) {
	$array=explode(',',$string);
	$action = request()->action();
	if (in_array($action,$array)){
		return 'active';
	}else
		return null;
}

function checkDomain($domain){
	if(empty($domain) || !preg_match('/^[-$a-z0-9_*.]{2,512}$/i', $domain) || (stripos($domain, '.') === false) || substr($domain, -1) == '.' || substr($domain, 0 ,1) == '.' || substr($domain, 0 ,1) == '*' && substr($domain, 1 ,1) != '.' || substr_count($domain, '*')>1 || strpos($domain, '*')>0 || strlen($domain)<4) return false;
	return true;
}

function errorlog($msg){
	$handle = fopen(app()->getRootPath()."record.txt", 'a');
	fwrite($handle, date('Y-m-d H:i:s')."\t".$msg."\r\n");
	fclose($handle);
}

function licenseEncrypt($data, $key){
	$iv = substr($key, 0, 16);
	return openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
}

function licenseDecrypt($data, $key){
	$iv = substr($key, 0, 16);
	return openssl_decrypt($data, 'AES-256-CBC', $key, 0, $iv);
}

function generateKeyPairs(){
	$pkey_dir = app()->getRootPath().'data/config/';
	$public_key_path = $pkey_dir.'public_key.pem';
	$private_key_path = $pkey_dir.'private_key.pem';
	if(file_exists($public_key_path) && file_exists($private_key_path)){
		return [file_get_contents($public_key_path), file_get_contents($private_key_path)];
	}
	$pkey_config = ['private_key_bits'=>4096];
	$pkey_res = openssl_pkey_new($pkey_config);
	$private_key = '';
	openssl_pkey_export($pkey_res, $private_key, null, $pkey_config);
	$pkey_details = openssl_pkey_get_details($pkey_res);
	if(!$pkey_details) return false;
	$public_key = $pkey_details['key'];
	file_put_contents($public_key_path, $public_key);
	file_put_contents($private_key_path, $private_key);
	return [$public_key, $private_key];
}

function pemToBase64($pem){
    $lines = explode("\n", $pem);
    $encoded = '';
    foreach ($lines as $line) {
        if (trim($line) != '' && strpos($line, '-----BEGIN') === false && strpos($line, '-----END') === false) {
            $encoded .= trim($line);
        }
    }
    return $encoded;
}

function makeSelfSignSSL(string $commonName, array $domainList, $validity = 3650){
	// 加载 CA 证书和私钥
	$dir = app()->getBasePath().'script/';
	$caCert = file_get_contents($dir.'ca.crt');
	$caPrivateKey = file_get_contents($dir.'ca.key');

	$opensslConfigFile = sys_get_temp_dir().'/openssl'.time().mt_rand(1000, 9999).'.cnf';
	$opensslConfigContent = <<<EOF
[req]
req_extensions = extension_section
x509_extensions	= extension_section
distinguished_name = dn

[dn]

[extension_section]
basicConstraints = CA:FALSE
keyUsage = nonRepudiation, digitalSignature, keyEncipherment
subjectAltName = @alt_names

[alt_names]
EOF;
	$ip_index = 1;
	$dns_index = 1;
	foreach ($domainList as $value) {
		if(empty($value)) continue;
		if(filter_var($value, FILTER_VALIDATE_IP)){
			$opensslConfigContent .= sprintf("\nIP.%d = %s", $ip_index, $value);
			$ip_index++;
		}else{
			$opensslConfigContent .= sprintf("\nDNS.%d = %s", $dns_index, $value);
			$dns_index++;
		}
	}

	if(!file_put_contents($opensslConfigFile, $opensslConfigContent)) return false;

	// 生成域名证书的私钥和 CSR
	$domainPrivateKey = openssl_pkey_new([
		'private_key_bits' => 2048,
		'private_key_type' => OPENSSL_KEYTYPE_RSA,
	]);
	if(!$domainPrivateKey) return false;

	$csrConfig = ['digest_alg' => 'sha256', 'config' => $opensslConfigFile];

	$domainCsr = openssl_csr_new([
		'commonName' => $commonName
	], $domainPrivateKey, $csrConfig);
	if(!$domainCsr) return false;

	// 生成域名证书
	$domainCertificate = openssl_csr_sign($domainCsr, $caCert, $caPrivateKey, $validity, $csrConfig);
	if(!$domainCertificate) return false;

	// 导出域名证书
	openssl_x509_export($domainCertificate, $certificate);
	openssl_pkey_export($domainPrivateKey, $privateKey);
	$certificate .= $caCert;

	unlink($opensslConfigFile);

	return ['cert' => $certificate, 'key' => $privateKey];
}

function deleteDir($dir){
	$rd = opendir($dir);
	if (!$rd) {
		return false;
	}

	while (($file = readdir($rd)) !== false) {
		if ($file == '.' || $file == '..') {
			continue;
		}

		$file = $dir . '/' . $file;

		if (is_dir($file)) {
			deleteDir($file);
		}
		else {
			unlink($file);
		}
	}

	closedir($rd);
	rmdir($dir);
	return true;
}