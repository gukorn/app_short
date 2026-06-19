<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{

    public function index(Request $request)
    {
        return QrCode::size(300)->generate('https://www.google.com');
    }
}
