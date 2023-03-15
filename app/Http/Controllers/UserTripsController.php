<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserDestination;

class UserTripsController extends Controller
{
     public function store(Request $request)
     {
         
         $validatedData = Validator::make($request->all(),
         [
             'destination_id'       => 'required|integer',
             'user_id'              => 'required|integer',
             'destination_name'     => 'required|string',
             'name'                 => 'required|string',
             'last_name'            => 'required|string',
             'starting_trip'        => 'required|date',
             'ending_trip'          => 'required|date',
             'adult_number'         => 'required|integer',
             'children_number'      => 'required|integer',
             'confirmed'            => 'boolean',
         ]
        );
         if ($validatedData->fails()) {
             return response()->json($validatedData->errors(), 400);
         }
        // $validatedData['starting_trip'] = Carbon::createFromFormat('d m Y', $validatedData['starting_trip'])->format('Y-m-d');
        // $validatedData['ending_trip'] = Carbon::createFromFormat('d m Y', $validatedData['ending_trip'])->format('Y-m-d');
        
          $userTrip = UserDestination::create(
            [
                'destination_id'  =>$request-> destination_id  ,
                'user_id'         =>$request-> user_id,
                'destination_name'=>$request-> destination_name,
                'name'            =>$request-> name           ,
                'last_name'       =>$request-> last_name       ,
                'starting_trip'   =>$request-> starting_trip   ,
                'ending_trip'     =>$request-> ending_trip   ,
                'adult_number'    =>$request-> adult_number   ,
                'children_number' =>$request-> children_number ,
                'confirmed'       =>$request-> confirmed       ,
            ]
        
        );
         
         return response()->json(['trips'=>$userTrip],200);
     }


     public function getUserTrips(Request $request)
        {
            $trips = UserDestination::with('travel_places')->where('user_id',$request->input('id'))->get();

            
			
			
            return response()->json($trips);
        }
}
