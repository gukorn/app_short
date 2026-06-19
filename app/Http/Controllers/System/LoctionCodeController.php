<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Master\Location;

class LoctionCodeController extends Controller
{


    public function getLoctionMap()
    {
        return view('system.loctionCodeMap');
    }
    public function getLoction()
    {
        //'id','subdistrict','district','province','zipcode'
        $datas = Location::where('subdistrict', 'like',  '%' . $_GET['q'] . '%')
            ->orWhere('district', 'like',  '%' . $_GET['q'] . '%')
            ->orWhere('province', 'like',  '%' . $_GET['q'] . '%')
            ->orWhere('zipcode', 'like',  '%' . $_GET['q'] . '%')
            ->take(20)->get();
        $arr = array();
        foreach ($datas as $data) {
            $text = "" . $data->subdistrict . " / " . $data->district . " / " . $data->province . " / " . $data->zipcode;
            $arr[] = array(
                'id' =>  $data->id,
                'text' => $text,
                'subdis' =>  $data->subdistrict,
                'dis' =>  $data->district,
                'pro' =>  $data->province,
                'zipcode' =>  $data->zipcode
            );
        }

        return  [
            'total_count' => '' . $_GET['q'],
            'items' => $arr
        ];
    }
}
