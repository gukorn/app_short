<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Master\UrlAnalysis;
use App\Models\Master\URLShort;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{


    public function index()
    {
        $startDate =  Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate =  Carbon::now()->addDays(1)->format('Y-m-d');
        $user = Auth::user();
        $URLShort = URLShort::where('user_id',$user->id)->pluck('id')->toArray();
        $stats = UrlAnalysis::whereIn('urlshort_id', $URLShort)
            ->whereBetween('number_date', [$startDate, $endDate])
            ->selectRaw('number_date, SUM(number_view) as total_view, SUM(number_review) as total_review')
            ->groupBy('number_date')
            ->orderBy('number_date', 'asc')
            ->take(30)
            ->get();
        $dates = $stats->pluck('number_date')->toArray();
        $views = $stats->pluck('total_view')->toArray();
        $reviews = $stats->pluck('total_review')->toArray();

        //  top 10 ใน 1 เดือน
        $dataLists = UrlAnalysis::whereIn('urlshort_id', $URLShort)
            ->whereBetween('number_date', [$startDate, $endDate])
            ->selectRaw('urlshort_id, SUM(number_view) as total_view, SUM(number_review) as total_review')
            ->groupBy('urlshort_id')
            ->orderBy('total_view', 'desc')
            ->orderBy('total_review', 'desc')
            ->take(10)
            ->get();

        return view('analytics.index', compact('dates', 'views', 'reviews','dataLists'));
    }

    public function view($code)
    {
        $startDate =  Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate =  Carbon::now()->addDays(1)->format('Y-m-d');
        $data = URLShort::where('id',decodeI($code))->first();
        $stats = UrlAnalysis::where('urlshort_id', $data->id)
            ->whereBetween('number_date', [$startDate, $endDate])
            ->selectRaw('number_date, SUM(number_view) as total_view, SUM(number_review) as total_review')
            ->groupBy('number_date')
            ->orderBy('number_date', 'asc')
            ->take(30)
            ->get();
        $dates = $stats->pluck('number_date')->toArray();
        $views = $stats->pluck('total_view')->toArray();
        $reviews = $stats->pluck('total_review')->toArray();


        return view('analytics.view', compact('data','dates', 'views', 'reviews'));
    }


}
