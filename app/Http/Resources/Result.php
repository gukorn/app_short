<?php

namespace App\Http\Resources;


class Result
{
    var $status = false;
    var $message = null;
    var $data = null;
    var $url = null;


    /*
200: OK การส่งคำขอสำเร็จแล้ว
400: Bad Request ไม่ตอบสนองเพราะมี syntax ไม่ถูกต้อง / request ที่เข้ามา มีอะไรผิดพลาดซักอย่าง
404: Not Found ไม่พบหน้าที่ร้องขอ
422: Unprocessable Entity ทำอะไรซักอย่างยังไม่ได้
    */
    public function __construct() {}

    public function show()
    {
        return response()->json(array("status" => $this->status, "message" => $this->message, "data" => $this->data, "url" => $this->url));
        //json_encode(array("status"=> $this->status ,"message"=> $this->message,"data"=> $this->data ,"url"=> $this->url));
    }
    public static function message($message, $code = 400, $err = null)
    {
        $arr = array("status" => false, "message" => $message);
        $arr += array("code" => $code);
        if (isset($err)) $arr += array("error" => $err);
        return response()->json($arr);
    }
    public static function data($data, $message = null, $code = 200)
    {
        $arr = array("status" => true, "data" => $data);
        if (isset($message)) $arr += array("message" => $message);
        $arr += array("code" => $code);
        return response()->json($arr);
    }

    public static function actionURL($url, $array = null, $message = null, $code = 200)
    {
        return self::url(actionURL($url, $array), $message, $code);
    }
    public static function url($url, $message = null, $code = 200)
    {
        $url_action = $url;
        if (strpos($url, "?")) $url_action = substr($url_action, 0, strpos($url_action, "?"));
        if (strpos($url, '@')) $url_action = actionURL($url_action);
        if (strpos($url, "?")) $url_action .= substr($url, strpos($url, "?"), strlen($url));

        $arr = array("status" => true, "url" => $url_action);
        if (isset($message)) $arr += array("message" => $message);
        $arr += array("code" => $code);
        return response()->json($arr);
    }
}
