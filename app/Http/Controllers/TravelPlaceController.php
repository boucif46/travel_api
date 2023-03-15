<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\TravelPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class TravelPlaceController extends Controller

{
    public function getTravelPlaces()
    {
        $travelPlaces = TravelPlace::with('galeries')->get();

        
        return Response::json([
            'places_count' => count($travelPlaces),
            'places' => $travelPlaces
            
        ], 200);
    }

    public function create(Request $request)
        {
           
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'stars' => 'required|integer|min:1|max:5',
                'travelTime'=>'required|integer|min:1|max:10',
                'description' => 'required|string',
                'price'=> 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2500'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
             // Create the "public/images" directory if it doesn't exist
              $destinationPath = public_path('/images');
              if (!File::exists($destinationPath)) {
                  File::makeDirectory($destinationPath, 0775, true);
              }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);
            }

            $travelPlace = TravelPlace::create([
                'name' => $request->name,
                'stars' => $request->stars,
                'travelTime'=>$request->travelTime,
                'description' => $request->description,
                'price'=>$request->price,
                'image' => '/images/'.$name,
                
            ]);

            return response()->json([
                'message' => 'Travel Place created successfully.',
                'travelPlace' => $travelPlace,
                
            ], 200);
        }
        
        public function search(Request $request) {
            $tags = explode(',', $request->input('tags'));
            $travelPlaces = TravelPlace::where(function ($query) use ($tags) {
                foreach ($tags as $tag) {
                    $query->orWhere('tag', 'like', '%' . $tag . '%');
                }
            })->with('galeries')->get();

            return response()->json([
                'places_count' => count($travelPlaces),
                'places' => $travelPlaces               
            ], 200);
        }


        public function nearby(Request $request)
            {
                $lat = $request->input('lat');
                $lng = $request->input('lng');

                $places = TravelPlace::selectRaw('*, ( 3959 * acos( cos( radians(?) ) *
                    cos( radians( latitude ) ) * cos( radians( longitude) - radians(?) ) +
                    sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance', [$lat, $lng, $lat])
                    ->having('distance', '<', 1500)
                    ->orderBy('distance', 'asc')
                    ->with('galeries')->get();

                    foreach ($places as $place) {
                        $place->makeHidden(['created_at', 'updated_at', 'tag','distance']);
                    }

                return Response::json([
            'places_count' => count($places),
            'places' => $places
            
        ], 200);
            }
        
}
