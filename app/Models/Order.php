<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    
    protected $fillable = [
        'id', 
        'customers_id', 
        'statuses_id',
        'categories_id', 
        'created_at', 
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function getOrdersLeftJoinCustomersAndStatuses() {
        $orders = DB::table($table)
                    ->leftjoin('customers', $table.'customers_id', '=', 'customers.id')
                    ->leftjoin('statuses', $table.'statuses_id', '=', 'statuses.id')
                    ->select($table.'.*', 'customers.name', 'statuses.name')
                    ->get();
        return $orders;            
    }
}
