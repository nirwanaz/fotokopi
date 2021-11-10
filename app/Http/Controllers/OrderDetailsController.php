<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order_details as Od;

class OrderDetailsController extends Controller
{
    //
    public function update(Request $request, $id) {

        $validateData = $request->validate([
            'qty'   => 'required',
            'total' => 'required'
        ]);

        $order_details = Od::find($id);
        $order_details->qty = $validateData['qty'];
        $order_details->total = $validateData['total'];

        $order_details->save();

        $msg = [
            'success' => true,
            'message' => 'Order Details updated succesfully'
        ];

        return response()->json($msg);
    }
}
