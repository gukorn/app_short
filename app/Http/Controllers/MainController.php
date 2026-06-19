<?php

namespace App\Http\Controllers;

use App\Models\Master\UrlAnalysis;
use App\Models\Master\URLShort;
use Illuminate\Http\Request;

class MainController extends Controller
{


    public function page()
    {
        return view('welcome');
    }

    public function index()
    {
        // SystemController::setSystemAll();
        return view('layouts.main');
    }


    public function url(Request $request, $url)
    {
        $data = URLShort::where('url_short', $url)->first();
        if(isset($data)){

            $dataAnalysis = UrlAnalysis::where('urlshort_id', $data->id)->where('number_date', date('Y-m-d'))->first();
            $cookieName = 'view_' . $data->id;
            // ตรวจสอบว่าเคยเข้าดูหรือไม่
            if (!$request->hasCookie($cookieName)) {
                $minutesUntilMidnight = now()->diffInMinutes(now()->endOfDay());
                cookie()->queue($cookieName, 'true', $minutesUntilMidnight);
                $data->number_view = ++$data->number_view;
                $data->number_review = ++$data->number_review;

                // UrlAnalysis
                if(isset($dataAnalysis)){
                    $dataAnalysis->number_view = ++$dataAnalysis->number_view;
                    $dataAnalysis->number_review = ++$dataAnalysis->number_review;
                    $dataAnalysis->update();
                }else{
                    $dataAnalysis = new UrlAnalysis();
                    $dataAnalysis->urlshort_id = $data->id;
                    $dataAnalysis->number_date = date('Y-m-d');
                    $dataAnalysis->number_view = 1;
                    $dataAnalysis->number_review = 1;
                    $dataAnalysis->save();
                }
            } else { // เคยเข้าดูแล้ว
                $data->number_review = ++$data->number_review;

                // UrlAnalysis
                if(isset($dataAnalysis)){
                    $dataAnalysis->number_review = ++$dataAnalysis->number_review;
                    $dataAnalysis->update();
                }
            }
            $data->update();
            return redirect($data->url_real);
        }else{
            return abort('404');
        }
    }
}
