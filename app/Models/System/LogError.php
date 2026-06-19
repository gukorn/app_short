<?php

namespace App\Models\System;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogError extends BaseModel
{

    use HasFactory;

    const UPDATED_AT = null;
    const UPDATED_BY = null;

    protected $fillable = [
        'path_info',
        'method',
        'code',
        'message'
    ];

    public static function saveError($exception)
    {
        $data = new LogError();
        $data->path_info = request()->getPathInfo();
        $data->method =  request()->getMethod();
        $data->code = $exception->getCode();
        $data->message = $exception->getMessage();
        $data->line = $exception->getLine();
        $data->save();
    }
}
