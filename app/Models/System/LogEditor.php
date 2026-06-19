<?php

namespace App\Models\System;

use App\Models\BaseModel;
use App\Models\User;
use App\Models\VeUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class LogEditor extends BaseModel
{
    use HasFactory;

    const UPDATED_AT = null;
    const UPDATED_BY = null;

    protected $fillable = [
        'table_name',
        'table_id',
        'json_log',
        'msg',
        'created_at',
        'created_by'
    ];

    protected $casts = [
        'json_log' => 'array',
    ];



    public static function saveLog($old_data, $new_data, $msg = null)
    {
        $editArr = array();
        $id = (empty($new_data->id) ? $old_data->id : $new_data->id);
        foreach ($new_data->getFillable() as $key => $val) {
            if ($old_data->$val != $new_data->$val) {
                if (!empty($new_data->getCasts()[$val]) && $new_data->getCasts()[$val] == "array")
                    $editArr += array($val => array(addslashes(json_encode($old_data->$val, JSON_UNESCAPED_UNICODE)), addslashes(json_encode($new_data->$val, JSON_UNESCAPED_UNICODE))));
                else
                    $editArr += array($val => array(addslashes($old_data->$val), addslashes($new_data->$val))); //"|".$val."|:|".$old_data->$val."|>|".$new_data->$val ."|;" ;
            }
        }
        if (count($editArr) > 0) {
            $data = new LogEditor();
            $data->table_name = $new_data->getTable();
            $data->table_id =  $id;
            $data->json_log = ($editArr);
            $data->msg = $msg ?? null;
            $data->save();
        }
    }

    public static function saveJson($dataJson, $msg = null)
    {
        $data = new LogEditor();
        $data->table_name = 'JSON';
        $data->table_id =  0;
        $data->json_log = ($dataJson);
        $data->msg = $msg ?? null;
        $data->save();
    }

    public static function viewNote($data, $limit = null)
    {
        $dataLog = LogEditor::where('table_name', $data->getTable())
            ->Where('table_id', $data->id)
            ->orderBy('created_at', 'desc')
            ->first();
        if (!isset($dataLog->msg)) return '';
        $tooltip = (strlen($dataLog->msg) > 15) ? 'data-toggle="tooltip" data-original-title="' . $dataLog->msg . '"' : '';
        return '<div class="text-dark" ' . $tooltip . '>' . Str::limit($dataLog->msg, 255, '...') . '</div>';
    }

    public static function viewEditByLog($table, $table_idCode, $log_name, $log_val)
    {
        $dataLog = LogEditor::where('table_name', $table)
            ->Where('table_id', decodeI($table_idCode))
            ->where('json_log->' . $log_name, 'like', '%"' . $log_val . '"]%')
            ->whereNotNull('json_log->' . $log_name)
            ->orderBy('created_at', 'desc')
            ->first();
        return $dataLog;
    }
}
