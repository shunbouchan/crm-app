<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


use Inertia\Inertia;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Order::paginate(50));
        $orders = Order::groupBy('id')->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')->paginate(50);

        return Inertia::render('Purchases/Index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $items = Item::select('id', 'name', 'price')->where('is_selling', true)->get();
        return Inertia::render('Purchases/Create', [
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'customer_id' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);

            foreach ($request->items as $item) {
                $purchase->items()->attach($purchase->id, [
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return to_route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {

        //小計
        $items = Order::where('id', $purchase->id)->get();

        //合計
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')
            ->get();


        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
        $purchase = Purchase::find($purchase->id);
        $all_items = Item::select('id', 'name', 'price')->get();

        $items = [];

        foreach ($all_items as $all_item) {
            $quantity = 0;
            foreach ($purchase->items as $item) {
                if ($all_item->id === $item->id) {
                    $quantity = $item->pivot->quantity;
                }
            }
            array_push($items, [
                'id' => $all_item->id,
                'name' => $all_item->name,
                'price' => $all_item->price,
                'quantity' => $quantity,
            ]);
        }

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_name, customer_id, status, created_at')
            ->get();


        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {

        DB::beginTransaction();
        try {
            $purchase->status = $request->status;
            $purchase->save();


            $items = [];
            foreach ($request->items as $item) {
                $items = $items + [
                    $item['id'] => [
                        'quantity' => $item['quantity']
                    ]
                ];
            }

            $purchase->items()->sync($items);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
