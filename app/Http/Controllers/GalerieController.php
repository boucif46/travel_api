<?php

namespace App\Http\Controllers;

use App\Models\Galerie;
use App\Models\TravelPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator ;
class GalerieController extends Controller
{
    public function create(Request $request, $travelPlaceId)
    {
        $travelPlace = TravelPlace::findOrFail($travelPlaceId);
            
        $validator = Validator::make($request->all(), [
            'travel_place_id' => 'required|integer',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2500', 
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $destinationPath = public_path('/galerieImage');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0775, true);
        }
    
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $name =$image->getClientOriginalName();
    
            $existingImage = Galerie::where('image_url', '/galerieImage/'.$name)
                                    ->first();
            if (!$existingImage) {
                $image->move($destinationPath, $name);
    
                $Galerie = Galerie::create([
                    'travel_place_id' =>$request->travel_place_id ,
                    'image_url' => '/galerieImage/'.$name,
                ]);
            } else {
                return response()->json([
                    'message' => 'Galerie image already exist',
                ], 201);
            }
        }
        return response()->json([
            'message' => 'Galerie image created successfully',
            'galerie' => $Galerie
        ], 201);
    }

    
    public function getImagesById($travelPlaceId)
    {
        $travelPlace = TravelPlace::findOrFail($travelPlaceId);
        $images = $travelPlace->galeries;

        return response()->json([
            'images' => $images
        ], 200);
        
    }
    
}
