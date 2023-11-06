<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class AnalysisController extends Controller
{
    //

    public function index()
    {

        $startDate = '2023-11-01';
        $endDate = '2023-11-10';

        $subQuery = Order::betweenDate($startDate, $endDate);
        $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") AS date')
            ->groupBy('date');

        $data = DB::table($subQuery)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get()
            ->sortBy('date');

        // dd($data);
        return Inertia::render('Analysis');
    }
}
