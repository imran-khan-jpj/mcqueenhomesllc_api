<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyController extends Controller
{
    public function index(){

        $properties = Property::with('images')->get();
        if(count($properties)){
            return response()->json(['status'=> 'success', 'data' => $properties], 200);
        }
        return response()->json(['status'=> 'success', 'data' => []], 200);
    }
    

    public function store(Request $request){
        $data = $this->validateRequest($request);
        
        $data['user_id'] =  auth()->user()->id;

   
    
    if($property = Property::create($data)){
            if($request->has('images')){

                $imagePath = $request->images->store('uploads', 'public');
                $saveImages = new PropertyImage(['name' => $imagePath]);

                $property->images()->save($saveImages);
            }


            return response()->json([
                'status'=> 'success', 
                'msg' => "property created successfully", 
                'data' => $property
            ], 200);
        }else{
            return response()->json([
                'status'=> 'error', 
                'msg' => "Something went wrong pleast try again", 
                'data' => ""
            ], 200);
        }
    }

    public function show(Property $property){
        
        return response()->json(['status' => 'success', 'data' => $property, 'msg' => 'property found successfully']);
    }

    public function update(Request $request, Property $property){

        if($property->user->id !== auth()->user()->id){
            return response()->json(['status' => 'error','msg' => 'something went wrong'], 401);
        }

        $data = $this->validateRequest($request);
    
        $data['user_id'] =  auth()->user()->id;
        if($request->has('images')){
           
            $imagePath = $request->images->store('uploads', 'public');
            $saveImage = new PropertyImage(['name' => $imagePath]);

            $property->images()->save($saveImage);

        }
       


        if($property->update($data)){
            return response()->json(['status'=> 'success', 'msg' => "property updated successfully", 'data' => $property], 200);
        }else{
            return response()->json([
                'status'=> 'error', 
                'msg' => "something went wrong please try again later", 
                'data' => ""
            ], 401);
        }
    }

    public function destroy(Property $property){

        if($property->user->id !== auth()->user()->id){
            return response()->json(['status' => 'error','msg' => 'something went wrong'], 401);
        }
        if($property->delete()){
            return response()->json([
                'status'=> 'success', 
                'msg' => "property deleted successfully", 
                'data' => $property
            ], 200);
        }else{
            return response()->json(['status' => 'error','msg' => 'something went wrong'], 401);

        }
    }

    public function imageDelete(Request $request, Property $property){

        
        $image = PropertyImage::find($request->image);
        

        
            if($image->delete()){
                return response()->json([
                    'status'=> 'success', 
                    'msg' => "property image deleted successfully", 
                    'data' => ""
                ], 200);
            }else{
                return response()->json([
                    'status'=> 'error', 
                    'msg' => "something went wrong please try again", 
                    'data' => ""
                ], 401);
            }
    }

    private function validateRequest($request){
        $arr2 = [];
        $type = $request->type;
        $arr1 = $request->validate([
            'type' => 'required|string', // home or land
            'description' => 'string', // optional 
            'propertyFor' => 'required|string', // sale or rent
            'longitude' => 'string', // optional 
            'latitude' => 'string', //  optional
            'currentStatus' => 'required|string', // available for rent, rented, for sale, sold
        ]);

        if($type == "home"){
            $arr2 = $request->validate([
                'NoOfBeds' => 'required|integer', // no of beds
                'NoOfBaths' => 'required|integer', // no of baths
            ]);
        }
     

        return array_merge($arr1, $arr2);
        
    }

    


}
