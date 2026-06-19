<?php

namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use App\Models\System\LogEditor;
use Illuminate\Support\Facades\Crypt;

class LogEditorController extends Controller
{


    public function view($table, $id = null, $column = null)
    {
        if (empty($column))
            $dataLists = LogEditor::leftJoin('users', 'users.id', '=', 'log_editors.created_by')
                ->select('log_editors.json_log', 'log_editors.msg', 'log_editors.created_at', 'users.firstname', 'users.lastname')
                ->where('log_editors.table_name', Crypt::decryptString($table))
                ->Where('log_editors.table_id', decodeI($id))
                ->orderBy('log_editors.created_at', 'desc')
                ->orderBy('log_editors.id', 'desc')
                ->paginate(config('cache.paginate'));
        else {
            $column = Crypt::decryptString($column);
            $dataLists = LogEditor::leftJoin('users', 'users.id', '=', 'log_editors.created_by')
                ->select('log_editors.json_log->' . $column . ' as log', 'log_editors.msg', 'log_editors.created_at', 'users.firstname', 'users.lastname')
                ->where('log_editors.table_name', Crypt::decryptString($table))
                ->Where('log_editors.table_id', decodeI($id))
                ->whereNotNull('log_editors.json_log->' . $column)
                ->orderBy('log_editors.created_at', 'desc')
                ->orderBy('log_editors.id', 'desc')
                ->paginate(config('cache.paginate'));
        }
        return view('system.viewlog', compact('dataLists'));
    }
}
