<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Food;
use Illuminate\Http\Request;
use App\Http\Resources\FoodResource;
use App\Http\Resources\FoodsResource;

class FoodController extends Controller
{
    //
    public function index(){
        $foods = Food::All();

        return response([
            'foods' => $foods,
            'message' => 'server is running'
        ], 200);
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'message' => 'The given data was invalid'                
            ], 422);
        } else {
            $food = Food::create($request->all());
            return response([
                'food' => $food,
                'message' => 'Success add food to database',
            ], 201);
    
        }
    }

    public function show($id)
    {
        $food = Food::find($id);
        if (!$food) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $food->retrieve = 1;
        $food->update();

        return new FoodResource($food);
    }

    public function retrieve(){
        $foods = Food::All();

        return new FoodsResource($foods);
    }

    public function update(Request $request, $id) {
    try {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response([
                'message' => 'The given data was invalid'                
            ], 422);
        } else {
            // Cari data berdasarkan id
            $food = Food::findOrFail($id);

            // Update data sesuai input
            $food->update($request->all());

            return response([
                'food' => $food,
                'message' => 'Success update the given food resource.',
            ], 200);
        }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response([
            'message' => 'Food with the given id not found',
        ], 404);
    } 
}

    public function destroy($id) {
        try {
            $food = Food::findOrFail($id);
            $food->delete();
    
            return response([
                'message' => 'Success delete the given food resource',                
            ], 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'message' => 'Not Found',
            ], 404);
        }
    }
}
