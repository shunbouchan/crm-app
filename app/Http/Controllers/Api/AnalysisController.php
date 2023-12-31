<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalysisController extends Controller
{
    //

    public function index(Request $request)
    {
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        if ($request->type === 'perDay') {
            $subQuery->where('status', true)
                ->groupBy('id')
                ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") AS date')
                ->groupBy('date');

            $data = DB::table($subQuery)
                ->groupBy('date')
                ->selectRaw('date, sum(totalPerPurchase) as total')
                ->get()
                ->sortBy('date');
        }
        Log::debug("debug ログ!");
        Log::debug($data);

        $labels = $data->pluck('date');
        $totals = $data->pluck('total');

        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' => $labels,
            'totals' => $totals,
        ], Response::HTTP_OK);
    }
}
