<?php

namespace App\Models;

use App\Models\Master\Location;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{

    protected $dateFormat = 'Y-m-d H:i:s.v';

    protected $casts = [
        'created_at' => 'datetime',
        // 'updated_at' => 'datetime',
        'updated_at' => 'datetime:Y-m-d H:i:s.v',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            // $lastid = DB::table($model->getTable())
            // ->select('id')->orderBy('id', 'desc')->first();
            // $model->id = isset($lastid)?$lastid->id+1:10;
            if (Schema::hasColumn($model->getTable(), 'created_by')) $model->created_by =  $user->id ?? 0;
            if (Schema::hasColumn($model->getTable(), 'updated_by')) $model->updated_by =  $user->id ?? 0;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            if (Schema::hasColumn($model->getTable(), 'updated_by')) $model->updated_by =  $user->id ?? 0;
            if (Schema::hasColumn($model->getTable(), 'updated_at')) $model->updated_at = Carbon::now()->format('Y-m-d H:i:s.v');
        });
    }

    public function getIdCode()
    {
        return encodeI($this->id);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
