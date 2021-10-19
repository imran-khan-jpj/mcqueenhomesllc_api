<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Helpers\Helpers;

class PropertyController extends Controller
{
    public function index(){

        $properties = Property::with('images')->get();
        if(count($properties)){
            return Helpers::response('success', 'properties found', $properties, 200);
        }
        return Helpers::response('success', '', [], 200);
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

            return Helpers::response('success', 'property created successfully', $property, 200);
           
        }else{
            return Helpers::response('success', 'Something went wrong please try again', "", 401);
           
        }
    }

    public function show(Property $property){
        
        return Helpers::response('success', $property, 'Property Found', 200);
    }

    public function update(Request $request, Property $property){

        if($property->user->id !== auth()->user()->id){
            return Helpers::response('success', 'Unauthorized', "", 401);
        }

        $data = $this->validateRequest($request);
    
        $data['user_id'] =  auth()->user()->id;
        if($request->has('images')){
           
            $imagePath = $request->images->store('uploads', 'public');
            $saveImage = new PropertyImage(['name' => $imagePath]);

            $property->images()->save($saveImage);

        }
       


        if($property->update($data)){
            return Helpers::response('success', 'property updated successfully', $property, 200);
        }else{
            
            return Helpers::response('error', 'something went wrong please try again', "", 401);
        }
    }

    public function destroy(Property $property){

        if($property->user->id !== auth()->user()->id){
            return Helpers::response('error', 'something went wrong', "", 401);
        }
        if($property->delete()){
            
            return Helpers::response('success', 'property deleted successfully', "", 200);
        }else{
            return Helpers::response('error', 'something went wrong', "", 401);

        }
    }

    public function imageDelete(Request $request, Property $property){

        
        $image = PropertyImage::find($request->image);
        

        
            if($image->delete()){
                return Helpers::response('success', 'property image deleted successfully', "", 200);
            }else{
                return Helpers::response('error', 'something went wrong please try again', "", 401);
               
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
