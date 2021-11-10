<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product as Product;
use App\Models\Order as Order;
use App\Models\Order_details as detailOrder;

class FotocopyController extends Controller
{
    //
    private function upload_process($file){

    }

    public function store(Request $request){
        $orderId = time();
        $productId = time();
        $validatedData = $request->validate([
            'customerId'    => 'required',
            'categorySubId' => 'required',
            'document'      => 'required|file|mimes:jpg,png,jpeg,doc,docx,pdf',
            'qty'           => 'required'
        ]);
        
        $path = $validatedData['document']->store('documents');
        /*
        $fileName = time().'.'.$validatedData['document']->extension();
        $validatedData['doxument']->move(public_path('upload'), $fileName);
        */

        $product = Product::create([
            'productId'         => $productId,
            'categorySubId'     => $validatedData['categorySubId'],
            'name'              => $validatedData['document']->getClientInfoName,
            'path_file'         => Storage::url($path)
        ]);

        $order = Order::create([
            'orderId'       => $orderId,
            'customerId'    => user()->id,
            'statusId'      => 1
        ]);

        $detailOrder = detailOrder::create([
            'orderId'       => $orderId,
            'productId'     => $productId,
            'qty'           => $validatedData['qty'],
            'total'         => $validatedData['total']
        ]);

        $msg = [
            'success' => true,
            'message' => 'Fotocopy order created successfully'
        ];

        return response()->json($msg);
    }
}
