<?php

use \Illuminate\Support\Str;
use \Illuminate\Support\HtmlString;

if (!function_exists('routeIsActive')) {
    function routeIsActive()
    {
        return 'test';
    }
}
function actionURL($url, $arr = null)
{
    if (strpos($url, '@')) {
        $arr_url = explode('@', $url);
        $class = 'App\\Http\\Controllers\\' . $arr_url[0];
        $classNew = new $class;
        $classNew = get_class($classNew);
        return action([$classNew, $arr_url[1]], $arr);
    }
    return null;
}
function assetV($v)
{
    return asset($v) . '?v=' . config('app.version');
}
function modalBox($link, $funcallback = null, $title = "ยืนยันการลบข้อมูล", $confirmbutton = "ลบข้อมูล", $cancelbutton = "ยกเลิก", $type_icon = "warning", $method = "POST")
{
    $html = 'data-modalbox-method=' . $method . ' data-modalbox=' . $title . ' data-modalbox-href=' . $link . '  data-modalbox-confirmbutton=' . $confirmbutton . ' data-modalbox-cancelbutton=' . $cancelbutton . ($funcallback ? ' funcallback=' . $funcallback : '');
    if (!empty($type_icon))
        $html .= ' data-modalbox-type=' . $type_icon;
    return $html;
}
function modalBoxVal($link, $funcallback = null, $title = "ยืนยันการลบข้อมูล", $confirmbutton = "ลบข้อมูล", $cancelbutton = "ยกเลิก", $placeholder = "กรุณากรอกหมายเหตุ...", $type_input = "text", $type_icon = "warning", $method = "POST")
{
    $html = 'data-modalbox-method=' . $method . ' data-modalbox=' . $title . ' data-modalbox-href=' . $link . ' data-modalbox-input=' . $type_input . ' data-modalbox-confirmbutton=' . $confirmbutton . ' data-modalbox-cancelbutton=' . $cancelbutton . ' data-modalbox-placeholder=' . (empty($placeholder) ? 'กรุณากรอกข้อมูล' : $placeholder) . ($funcallback ? ' funcallback=' . $funcallback : '');
    if (!empty($type_icon))
        $html .= ' data-modalbox-type=' . $type_icon;
    return $html;
}
function hashids_codeset()
{
    return new Hashids('CODE', 10, 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789');
}
function codeset()
{
    return "NOPQ9CRKDGB8A4HX5ZYST3M6UVWJ1L72EF";
}
function encode_I($n)
// function encodeI($n)
{
    $base = strlen(codeset());
    $converted = '';
    while ($n > 0) {
        $converted = substr(codeset(), bcmod($n, $base), 1) . $converted;
        $n = bcmul(bcdiv($n, $base), '1', 0);
    }
    return $converted;
}
function decode_I($code)
// function decodeI($code)
{
    $base = strlen(codeset());
    $c = '0';
    for ($i = strlen($code); $i; $i--) {
        $c = bcadd($c, bcmul(strpos(codeset(), substr($code, (-1 * ($i - strlen($code))), 1)), bcpow($base, $i - 1)));
    }
    return bcmul($c, 1, 0);
}
function encodeI($n)
{
    if (!is_integer($n)) return 'null';
    // return encode_I($n);
    $base = encode_I($n);
    $time = encode_I(date('dmy'));
    $time_encode = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($time));
    $id_encode = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($base . $time));
    $converted = $id_encode . "|" . $time_encode;
    return $converted;
}
function decodeI($data)
{
    // return decode_I($data);
    if (count(explode("|", $data)) < 2) return decode_I($data);
    list($payload, $signature) = explode("|", $data);
    $signature = strtr($signature, '-_', '+/');
    $payload = strtr($payload, '-_', '+/');
    $code = base64_decode($signature);
    $base64UrlSignature = str_replace($code, '', base64_decode($payload));
    return decode_I($base64UrlSignature);
}

function createCode($barcode, $format = "B%012d")
{
    $barcodeO = sprintf($format, $barcode);
    preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $barcodeO, $regs);
    $barcode = $regs[1];
    $sum = 0;
    for ($i = (strlen($barcode) - 1); $i >= 0; $i--) {
        $sum += (($i % 2) * 2 + 1) * $barcode[$i];
    }
    return $barcodeO;
}

function createPID($barcode, $format = "B%012d")
{
    //if(strlen($barcode) != $len-1) return "erro";
    //return sprintf("B%0".$format."d",$barcode);
    $barcodeO = sprintf($format, $barcode);
    preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $barcodeO, $regs);
    $barcode = $regs[1];
    //$barcode = str_pad($barcode, 12, "0", STR_PAD_LEFT);
    $sum = 0;
    for ($i = (strlen($barcode) - 1); $i >= 0; $i--) {
        $sum += (($i % 2) * 2 + 1) * $barcode[$i];
    }
    return $barcodeO . substr(10 - ($sum % 10), -1, 1);
}

function checkPID($barcode)
{
    preg_match('/[^0-9]*([0-9]+)[^0-9]*/', $barcode, $regs);
    $barcode = $regs[1];
    $barcode_cut = substr($barcode, 0, strlen($barcode) - 1);
    $sum = 0;
    for ($i = (strlen($barcode_cut) - 1); $i >= 0; $i--) {
        $sum += (($i % 2) * 2 + 1) * $barcode_cut[$i];
    }
    if (substr(10 - ($sum % 10), -1, 1) == substr($barcode, -1, 1))
        return true;
    return false;
}
function formatDateToDB($val)
{
    if (empty($val)) return null;
    list($dd, $mm, $yyyy) = explode('/', $val);
    return $yyyy . "-" . $mm . "-" . $dd;
}
// function formatDBToDateTh($val) {
// 	if(empty($val)) return null;
// 	list($yyyy,$mm,$dd) = explode('-', $val);
// 	return $dd."/".$mm."/".($yyyy+543);
// }
// function formatDBToDateThMY($val) {
// 	if(empty($val)) return null;
// 	list($yyyy,$mm) = explode('-', $val);
// 	return $mm."/".($yyyy+543);
// }
function getCurrentDate($format)
{

    if (!empty($format) && 'TH' == $format) {
        $date = now();
        return substr($date, 8, 2) . '/' . substr($date, 5, 2) . '/' . (substr($date, 0, 4) + 543);
    } else {
        $date = now();
        return substr($date, 0, 10);
    }
}
function formatDate($date, $set = "d/m/y h:i:s", $month = NULL, $null = 'Error')
{ // แสดงวัน ตามที่ set d=วัน m=เดือน  Y,y=ปี tY,ty=ปีไทย   h=ชม i=นาที  s=วินาที
    if (!$date) {
        return $null;
    }
    $t_d = substr($date, 8, 2);
    $t_m = isset($month) ? $month[((int)substr($date, 5, 2))] : substr($date, 5, 2);
    $t_y = substr($date, 0, 4) + 543;
    $e_y = substr($date, 0, 4);
    $t_h = substr($date, 11, 2);
    $t_i = substr($date, 14, 2);
    $t_s = substr($date, 17, 2);
    $se = array("d", "ty", "tY", "y", "Y", "h", "i", "s", "m");
    $in = array((int)$t_d, substr($t_y, 2, 2), $t_y, substr($e_y, 2, 2), $e_y, $t_h, $t_i, $t_s, $t_m);
    return str_replace($se, $in, $set);
}
function isMobileDevice()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    return stripos($useragent, 'mobile') !== false || stripos($useragent, 'nokia') !== false || stripos($useragent, 'phone') !== false;
}

function urlAction($val, $arr = null)
{  // for menu
    $goto = $val;
    if (strpos($val, '@')) {
        if (strpos($val, "?")) $goto = substr($goto, 0, strpos($goto, "?"));
        if (strpos($val, '@')) {
            $arr_url = explode('@', $goto);
            $class = 'App\\Http\\Controllers\\' . $arr_url[0];
            $classNew = new $class;
            $classNew = get_class($classNew);
            $goto = '#!' . str_replace(url('/'), '', app('url')->action([$classNew, $arr_url[1]], $arr));
        }
        if (strpos($val, "?")) $goto .= substr($val, strpos($val, "?"), strlen($val));
    }
    return $goto;
}

function utf8_strlen($s)
{
    $c = strlen($s);
    $l = 0;
    for ($i = 0; $i < $c; ++$i)
        if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
    return $l;
}

function removeComma($num)
{ // เอา , ออกจากตัวเลข
    return floatval(preg_replace('/[^\d.]/', '', $num));
}

function encodeJWT($data)
{
    $n = rand(1, 5);
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256', 'cn' => encodeI($n)]);
    $payload = json_encode($data);
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    // $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
    $signature = 'MANGKORN.' . encodeI(time());
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    $code_first = substr(encode_I(date('ismdmh')), 0, $n);
    $code_last = substr(encode_I(date('msdih')), $n * -1);
    $jwt = $base64UrlHeader . "." . $code_first . $base64UrlPayload . $code_last . "." . $base64UrlSignature;
    return $jwt;
}
function decodeJWT($data, $strict = false)
{
    if (count(explode(".", $data)) < 3) return '';
    list($header, $payload, $signature) = explode(".", $data);
    $cn = json_decode(base64_decode($header));
    $payload = substr_replace($payload, '', 0, decodeI($cn->cn));
    $payload = substr_replace($payload, '', decodeI($cn->cn) * -1);
    $b64 = strtr($payload, '-_', '+/');
    return json_decode(base64_decode($b64, $strict));
}

function timeJWT($data)
{
    if (count(explode(".", $data)) < 3) return 999999;
    list($header, $payload, $signature) = explode(".", $data);
    $signature = strtr($signature, '-_', '+/');
    $signatures =  base64_decode($signature);
    list($header, $exp) = explode(".", $signatures);
    $pastTime = decodeI($exp);
    $currentTime = time();
    $differenceInSeconds = $currentTime - $pastTime;
    $differenceInMinutes = floor($differenceInSeconds / 60); // นาที
    return $differenceInMinutes;
}

