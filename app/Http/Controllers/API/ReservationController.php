<?php

namespace App\Http\Controllers\API;

use Throwable;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\V1\ReservationResource;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\V1\ReservationCollection;
use App\Http\Requests\Api\FilterReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct()
    {
        $this->middleware('dashboard')->except('store','my_reservations');

    }

    public function index(Request $request)
    {
        //
        // return $request->all();
        try{
            $todayDate = Carbon::now()->format('Y-m-d');
            if(isset($request->reserve_date) && $request->speciality_id ==null) {
                $reservations = Reservation::where('reserve_date', $request->reserve_date)->get();
            }elseif(isset($request->speciality_id) && $request->reserve_date==null) {
                $reservations = Reservation::where('reserve_date', $todayDate)
                                            ->where('speciality_id', $request->speciality_id)
                                            ->get();
            } elseif(isset($request->reserve_date) && isset($request->speciality_id)) {
                $reservations = Reservation::where('reserve_date', $request->reserve_date)
                ->where('speciality_id', $request->speciality_id)
                ->get();
            } else {
                $reservations = Reservation::where('reserve_date', $todayDate)->get();
            }

            return new ReservationCollection($reservations);
        }catch(\Throwable $th){
                return response()->json([
                    'success'=>'false',
                    'message'=>$th->getMessage()
                ],500);
            }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $new_reservation =  Reservation::create($data);
        $response_data =new ReservationResource($new_reservation);
        if($new_reservation){
            return [
              'success'=>true,
              'message'=>'created Reservation Successfully',
              'data' =>   $response_data,
            ];
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $reservation = Reservation::findOrFail($id);
            $response_data =new ReservationResource($reservation);
            if($reservation){
                return [
                  'success'=>true,
                  'message'=>"show reservation Successfully",
                  'data' =>   $response_data,
                ];
                // return returnApi(true,'show reservation Successfully',$response_data);

            }
        }


        catch(Throwable $th){
            return [
                'success'=>false,
                'message'=>"Not Found",
                'data' =>   [],
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, string $id)
    {
        //

        $reservation = Reservation::find($id);

        if(!$reservation){
            return [
                'success'=>false,
                'message'=>"Not Found",
                'data' =>   [],
              ];
        }
        $reservation->update($request->validated());
        if($reservation==true){
            return [
              'success'=>true,
              'message'=>"Update Reservaion Successfully",
              'data' =>   $reservation,
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            Reservation::findOrFail($id)->delete();
            return [
                'success'=>true,
                'message'=>"Deleted Reservaion Successfully",
                'data' =>   [],
            ];
        }catch(Throwable $th){
            return [
                'success'=>false,
                'message'=>"Not Found",
                'data' =>   [],
            ];
        }

    }

    public function my_reservations(){
        $myreservations = Reservation::where('user_id',auth()->id())->get();

        if($myreservations){
            return [
              'success'=>true,
              'message'=>"Show My Reservaions ",
              'data' =>   $myreservations,
            ];
        }
    }





}