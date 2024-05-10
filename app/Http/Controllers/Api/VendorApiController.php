<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorApiController extends BaseApiController
{
    public function allVendors()
    {
        try {

            $vendors = User::where('role', 'vendor')->get();
            return response()->json([
                'status' => true,
                'data' =>
                    [
                        'vendors' => $vendors
                    ]
            ]);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
    public function vendorDetails($id)
    {
        try {
            $vendor = User::where(['id' => $id ,'role' => 'vendor'])->with('venues')->get();
            return response()->json([
                'status' => true,
                'data' =>
                    [
                        'vendors' => $vendor
                    ]
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
