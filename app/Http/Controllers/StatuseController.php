<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuse as Statuse;

class StatuseController extends Controller
{
    //
    public function index(){
        $statuses = Statuse::all();

        return $statuses->toJson();
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'note' => 'required'
        ]);
        
        $project = Statuse::create([
            'name' => $validatedData['name'],
            'note' => $validatedData['note']
        ]);

        $msg = [
            'success' => true,
            'message' => 'Statuse created succesfully'
        ];

        return response()->json($msg);
    }

    public function getStatuse($id){
        $statuse = Statuse::find($id);

        return $statuse->toJson();
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required',
            'note' => 'required'
        ]);

        $statuse = Statuse::find($id);
        $statuse->name = $validatedData['name'];
        $statuse->note = $validatedData['note'];

        $statuse->save();

        $msg = [
            'success' => true,
            'message' => 'Statuse updated successfully'
        ];

        return response()->json($msg);
    }

    public function delete($id){
        $statuse = Statuse::find($id);

        if (!empty($statuse)){
            $statuse->delete();

            $msg = [
                'success' => true,
                'message' => 'Statuse deleted successfully'
            ];

            return response()->json($msg);
        } else {
            $msg = [
                'success' => false,
                'message' => 'Statuse deleted failed'
            ];

            return response()->json($msg);
        }
    }
}
