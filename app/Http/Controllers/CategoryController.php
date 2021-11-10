<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category as Category;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::all();

        return $categories->toJson();
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'note' => 'required'
        ]);
        
        $project = Category::create([
            'name' => $validatedData['name'],
            'note' => $validatedData['note']
        ]);

        $msg = [
            'success' => true,
            'message' => 'Category created succesfully'
        ];

        return response()->json($msg);
    }

    public function getCategory($id){
        $category = Category::find($id);

        return $category->toJson();
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required',
            'note' => 'required'
        ]);

        $category = Category::find($id);
        $category->name = $validatedData['name'];
        $category->note = $validatedData['note'];

        $category->save();

        $msg = [
            'success' => true,
            'message' => 'Category updated successfully'
        ];

        return response()->json($msg);
    }

    public function delete($id){
        $category = Category::find($id);

        if (!empty($category)){
            $category->delete();

            $msg = [
                'success' => true,
                'message' => 'Category deleted successfully'
            ];

            return response()->json($msg);
        } else {
            $msg = [
                'success' => false,
                'message' => 'Category deleted failed'
            ];

            return response()->json($msg);
        }
    }
}
