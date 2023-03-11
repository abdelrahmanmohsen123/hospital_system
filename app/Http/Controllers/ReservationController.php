<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\speciality;
use App\Models\Reservation;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    public  function __construct()
    {
        $this->middleware('dashboard')->except(['create','store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $todayDate = Carbon::now()->format('Y-m-d');

        $reservations = Reservation::when($request->reserve_date !=null ,function($q) use ($request){
            return $q->whereDate('reserve_date',$request->reserve_date);
        }
        ,function($q) use ($todayDate){
            $q->whereDate('reserve_date',$todayDate);
        }
        )
        ->when($request->speciality_id !=null ,function($q) use ($request){
            return $q->where('speciality_id',$request->speciality_id);
        })

        ->paginate(4);
        // dd($reservations);
        $specialities = speciality::all();

        // $reservations = Reservation::paginate(4);
        return view('reservations.all',compact('reservations','specialities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $specialities = speciality::all();
        $users = User::all();
        $reservations = Reservation::where('user_id',auth()->id())->paginate(4);
        // dd($reservations);
        return view('reservations.create',compact('specialities','users','reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        //
        $data = $request->validated();

        if ($request->user_id) {
            $data['user_id'] = $request->user_id;
            # code...
        }else{
            $data['user_id'] = Auth::user()->id;
        }
        // dd($data);

        $new_reservation = Reservation::create($data);
        if($new_reservation){

            if(Auth::user()->type =='admin'){
                    return redirect()->route('reservations.index')->with('success','Reservation Cretaed Successffully');
            }else{
                    return redirect()->back()->with('success','Reservation Cretaed Successffully');
            }

        }else{
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
        $users = User::all();
        $specialities = speciality::all();
        return view('reservations.edit',compact('specialities','users','reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    // dd($request->validated());

        $update = $reservation->update($request->validated());
        // dd($reservation);
        if ($update == true) {
            return redirect()->route('reservations.index')->with('success', 'Reservation Updated Successffully');
        } else {
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
        $reservation->delete();
        return redirect()->back()->with('success','Reservation Deleted Successffully');
    }


}
