<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Order';
        $this->resources = 'vendors.order.';
        parent::__construct();
        $this->route = 'vendor.orders.';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->crudInfo();
        $data['hideEdit'] = true;
        $data['hideCreate'] = true;

        $data['hideDelete'] = true;
        $data['orders'] = Order::where('vendor_id', auth()->user()->id)->get();

        return view($this->indexResource(), $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($id)
    {
        $data = $this->crudInfo();
        $data['hideDelete'] = true;
        $data['hideEdit'] = true;
        $data['item'] = Order::findorFail($id);
        return view($this->showResource(), $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
