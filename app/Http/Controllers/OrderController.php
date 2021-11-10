<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Order as Order;
use App\Models\Product as Product;
use App\Models\Order_details as OD;
use App\Models\Customer as Customer;
use App\Models\Transactions as Transaction;

class OrderController extends Controller {
    public function index(){
        $table = 'orders';
        $orders = DB::table($table)
                    ->leftjoin('customers', $table.'.customers_id', '=', 'customers.id')
                    ->leftjoin('statuses', $table.'.statuses_id', '=', 'statuses.id')
                    ->leftjoin('order_details', $table.'.id', '=', 'order_details.orders_id')
                    ->leftjoin('products', 'order_details.products_id', '=', 'products.id')
                    ->leftjoin('categories', $table.'.categories_id', '=', 'categories.id')
                    ->select(
                        $table.'.*', 
                        'customers.name as custname',
                        'customers.address as custaddr',
                        'customers.phone as custphone', 
                        'statuses.name as statsname',
                        'order_details.id as od_id',
                        'order_details.qty',
                        'order_details.total',
                        'order_details.updated_at as od_verify',
                        'products.name as prodname',
                        'products.filename',
                        'products.file_ext',
                        'categories.name as catname'
                        )
                    ->get();

        return $orders->toJson();
    }

    private function upload($file){
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filenameFixed = preg_replace('/\s+/', '_', $filename);
        $extension = $file->getClientOriginalExtension();
        $newFilename = $filenameFixed.'_'.time().'.'.$extension;
        
        if ($extension === 'pdf'){
            
            $directory = 'public/upload_doc';

        } else if ($extension === 'jpg' || $extension === 'png') {

            $directory = 'public/upload_img';

        }

        if ($path = Storage::putFileAs($directory, $file, $newFilename)) {
            $uploaded = [
                'name'      => $filenameFixed,
                'filename'  => $newFilename,
                'file_ext'  => $extension
            ];
        }

        return $uploaded; 
    }

    private function generateId(){
        $randNumber = rand(0,9).rand(1,9).rand(2,8);

        return substr(time().$randNumber, 3, 10);
    }
    public function store(Request $request){

        $validatedData = $request->validate([
            'categories_id'          => 'required',
            'customer_name'          => 'required',
            'customer_address'       => 'required',
            'customer_phone'         => 'required',
            'customer_document'      => 'required'  
        ]);
        
        if ($file = $validatedData['customer_document']){
            $upload = $this->upload($file);
        }
    
        $idTransaction = $this->generateId();
        $idOrder = $this->generateId();
        $idProduct = $this->generateId();
        $idCustomer = $this->generateId();

        DB::beginTransaction();
        
        $customer = Customer::create([
            'id'        => $idCustomer,
            'name'      => $validatedData['customer_name'],
            'phone'     => $validatedData['customer_phone'],
            'address'   => $validatedData['customer_address']
        ]);

        $order = Order::create([
            'id'                => $idOrder,
            'customers_id'      => $idCustomer,
            'categories_id'     => $validatedData['categories_id'],
            'statuses_id'       => 1
        ]);
        
        $product = Product::create([
            'id'                => $idProduct,
            'name'              => $upload['name'],
            'filename'          => $upload['filename'],
            'file_ext'          => $upload['file_ext']
        ]);

        $order_detail = OD::create([
            'orders_id'      => $idOrder,
            'products_id'    => $idProduct
        ]);

        $tracking = Transaction::create([
            'id'            => 'T'.$idTransaction,
            'orders_id'      => $idOrder
        ]);    
        
        DB::commit();
   
        $msg = [
            'success' => true,
            'message' => 'Order created successfully'
        ];
    
        return response()->json($msg);
    }

    public function getOrder($id){
        $table = 'orders';
        $order = DB::table($table)
                    ->where($table.'.id', $id)
                    ->leftjoin('order_details', $table.'.id', '=', 'order_details.orders_id')
                    ->leftjoin('products', 'order_details.products_id', '=', 'products.id')
                    ->leftjoin('customers', $table.'.customers_id', '=', 'customers.id')
                    ->select(
                                $table.'.*', 
                                'order_details.id as od_id', 
                                'order_details.qty', 
                                'order_details.total', 
                                'products.filename', 
                                'products.file_ext',
                                'customers.name as custname',
                                'customers.address as custaddr',
                                'customers.phone as custphone'
                                )
                    ->get();


        return $order->toJson();
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'customerId'    => 'required',
            'statusId'      => 'required'
        ]);

        $order = Order::find($id);
        $order->customer_id  = $validatedData['customerId'];
        $order->status_id    = $validatedData['statusId'];
        $order->save();

        $msg = [
            'success' => true,
            'message' => 'Order updated successfully'
        ];

        return response()->json($msg);
    }

    public function delete($id){
        $order = Order::find($id);

        if (!empty($order)){
            $order->delete();

            $msg = [
                'success' => true,
                'message' => 'Order deleted successfully'
            ];
        } else {
            $msg = [
                'success' => false,
                'message' => 'Order deleted failed'
            ];
        }

        return response()->json($msg);
    }

    

}