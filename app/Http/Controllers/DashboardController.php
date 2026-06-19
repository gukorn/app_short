<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Master\UserController;
use App\Models\Master\Warehouse;
use App\Models\Project\VeProject;
use App\Models\Project\VeProjectFlow;
use App\Models\Project\VeProjectMember;
use App\Models\User;
use App\Models\VeUser;
use App\Models\Warehouse\GoodsIssue;
use App\Models\Warehouse\GoodsReceipt;
use App\Models\Warehouse\StockAdjustment;
use App\Models\Warehouse\StockItemRemain;
use App\Models\Warehouse\StockTransfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {

        // $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }
}
