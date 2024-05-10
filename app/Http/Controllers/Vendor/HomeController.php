<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Venue;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    public function home()
    {
        $data['customers'] = Customer::all()->count();
        $data['orders'] = Order::where('vendor_id', auth()->user()->id)->count();
        $data['venues'] = Venue::where('vendor_id', auth()->user()->id)->count();

        $chart_options = [
            'chart_title' => 'Monthly Sales Report',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'filter_field' => 'created_at',
            'filter_days' => 30,
            'aggregate_function' => 'sum',
            'aggregate_field' => 'total_price',
            'chart_type' => 'line',
            'where_raw'          => 'vendor_id = ' . auth()->id()
        ];

        $data['chart1'] = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Orders by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'where_raw' => 'vendor_id = ' . auth()->id()
        ];

        $data['chart2'] = new LaravelChart($chart_options);

        return view("vendors.home", $data);
    }
}
