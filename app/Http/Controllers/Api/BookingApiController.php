<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingApiController extends BaseApiController
{
    public function allVenues(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'vendor_id' => 'required',

            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->messages()->first();
                $response['status'] = false;
                return $response;
            }

            $venues = Venue::where(['vendor_id' => $request->vendor_id, 'status' => 'available'])->get();
            return response()->json([
                'status' => true,
                'data' =>
                [
                    'venues' => $venues
                ]
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function addBooking(Request $request)
    {
        try {
            $user = auth()->user();
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'vendor_id' => 'required',
                'category_id' => 'required',
                'start_date' => 'required',
                'venue_id' => 'required',
                'end_date' => 'required',
                'total_price' => 'required'
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->messages()->first();
                $response['status'] = false;
                return $response;
            }
            // Convert datetime format
            $startDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date)->format('Y-m-d H:i:s');
            $endDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->format('Y-m-d H:i:s');

            $venue = Venue::where('id', $request->venue_id)->first();
            if (!$venue) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error! Venue is not found.',
                ]);
            }
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date)->format('H:i:s');
            $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->format('H:i:s');
            if (strtotime($venue->open_time) > strtotime($startTime) || strtotime($venue->close_time) < strtotime($endTime)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error! Booking time is less or more than venue open and close time.',
                ]);
            }

            $existingOrder = Order::where(['vendor_id' => $request->vendor_id, 'category_id' => $request->category_id, 'venue_id' => $request->venue_id])->where(function ($query) use ($startDatetime, $endDatetime) {
                $query->whereBetween('start_date', [$startDatetime, $endDatetime])
                    ->orWhereBetween('end_date', [$startDatetime, $endDatetime])
                    ->orWhere(function ($query) use ($startDatetime, $endDatetime) {
                        $query->where('start_date', '<=', $startDatetime)
                            ->where('end_date', '>=', $endDatetime);
                    });
            })->first();

            if ($existingOrder) {
                // The datetime range is already booked
                return response()->json([
                    'status' => false,
                    'message' => 'Error! Booking for the following date and time is already made.',
                ]);
            } else {
                $booking = new Order([
                    'customer_id' => $user->id,
                    'vendor_id' => $request->vendor_id,
                    'category_id' => $request->category_id,
                    'venue_id' => $request->venue_id,
                    'start_date' => $startDatetime,
                    'end_date' => $endDatetime,
                    'payment_method' => $request->payment_method,
                    'total_price' => $request->total_price,
                ]);
                $booking->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Booking made successfully.',
                    'data' => [
                        'booking' => $booking,
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function verifyPayment(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'order_id' => 'required',
                'token' => 'required',
                'amount' => 'required',

            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->messages()->first();
                $response['status'] = false;
                return $response;
            }
            $token = $request->token;
            $amount = $request->amount;

            $args = http_build_query(array(
                'token' => $token,
                'amount' => $amount
            ));

            $url = "https://khalti.com/api/v2/payment/verify/";


            # Make the call using API.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $headers = ['Authorization: Key test_secret_key_37e47644e0be4e2590ca7134949f7305'];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Response
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status_code == 400) {
                return response()->json([
                    "success" => false,
                    "message" => "Payment failed."
                ]);
            }

            $order = Order::where('id', $request->order_id)->first();
            if (!$order) {
                return response([
                    'status' => false,
                    'message' => 'Order is not found.'
                ]);
            }
            $payment = new Payment([
                'customer_id' => $order->customer_id,
                'vendor_id' => $order->vendor_id,
                'transaction_id' => $request->transaction_id,
                'amount' => $order->amount,
                'payment_method' => 'khalti',
                'order_id' => $order->id,
            ]);
            $payment->save();
            return $response;
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getAllBookings(Request $request)
    {
        try {
            $user = auth()->user();
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'vendor_id' => 'required',

            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->messages()->first();
                $response['status'] = false;
                return $response;
            }
            $bookings = Order::where('vendor_id', $request->vendor_id)->with(['vendor', 'category', 'venue'])->get();
            return response()->json([
                'status' => true,
                'data' => [
                    'booking' => $bookings,
                ]
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function searchBookings(Request $request)
    {
        try {
            $user = auth()->user();
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'vendor_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',

            ]);

            if ($validator->fails()) {
                $response['message'] = $validator->messages()->first();
                $response['status'] = false;
                return $response;
            }

            // Convert datetime format
            $startDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date)->format('Y-m-d H:i:s');
            $endDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date)->format('Y-m-d H:i:s');
            $existingVenuesIds = Order::where('vendor_id', $request->vendor_id)->where(function ($query) use ($startDatetime, $endDatetime) {
                $query->whereBetween('start_date', [$startDatetime, $endDatetime])
                    ->orWhereBetween('end_date', [$startDatetime, $endDatetime])
                    ->orWhere(function ($query) use ($startDatetime, $endDatetime) {
                        $query->where('start_date', '<=', $startDatetime)
                            ->where('end_date', '>=', $endDatetime);
                    });
            })
                ->pluck('venue_id')
                ->toArray();
            $venues = Venue::WhereNotIn('id', $existingVenuesIds)->get();

            return response()->json([
                'status' => true,
                'data' =>
                [
                    'venues' => $venues
                ]
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function bookingDetails(Request $request)
    {
        try {
            $user = auth()->user();

            $booking = Order::where('id', $request->id)->with(['vendor', 'category', 'venue'])->first();
            if (!$booking) {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking is not found.'
                ]);
            }
            return response()->json([
                'status' => true,
                'data' =>
                [
                    'booking' => $booking
                ]
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }


    public function bookingHistory()
    {
        try {
            $user = auth()->user();

            $booking = Order::where('id', $user->id)->with(['vendor', 'category', 'venue'])->first();
            if (!$booking) {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking is not found.'
                ]);
            }
            return response()->json([
                'status' => true,
                'data' =>
                [
                    'booking' => $booking
                ]
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function viewOrder(Request $request)
    {
        try {
            $user = auth()->user();

            $orders = Order::with('vendor', 'venue')
                ->where('customer_id', $user->id)
                ->get();

            return response()->json([
                'status' => true,
                'data' => [
                    'orders' => $orders,
                ],
            ], 200);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
