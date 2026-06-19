<?php

namespace App\Models\Master;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class URLShort extends BaseModel
{
    protected $table = 'url_shorts';
    protected $fillable = [
        'status',
        'user_id',
        'url_short',
        'url_real',
        'title',
        'is_public',
        'number_view',
        'number_review',
    ];


     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
