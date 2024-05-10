<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Customer';
        $this->resources = 'vendors.customers.';
        parent::__construct();
        $this->route = 'vendor.customers.';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->crudInfo();
        $data['hideEdit'] = true;
        $data['hideCreate'] = true;

        $data['customers'] = Customer::all();

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
     */
    public function show($id)
    {
        $data = $this->crudInfo();
        $data['hideDelete'] = true;
        $data['hideEdit'] = true;
        $data['item'] = Customer::findorFail($id);
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
     * @param $id
     */
    public function destroy($id)
    {
        $customer = Customer::findorFail($id);
        $orders = Order::where('customer_id', $customer->id)->get();
        foreach ($orders as $order)
        {
            $order->delete();
        }
        $customer->clearMediaCollection();
        $customer->delete();
        return view($this->indexRoute())->with('success', 'Customer Deleted Successfully.');
    }
}
