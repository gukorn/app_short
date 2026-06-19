<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class UrlAnalysis extends BaseModel
{
    protected $fillable = [
        'urlshort_id',
        'number_date',
        'number_view',
        'number_review',
    ];


    public function urlshort()
    {
        return $this->belongsTo(URLShort::class, 'urlshort_id');
    }
}
