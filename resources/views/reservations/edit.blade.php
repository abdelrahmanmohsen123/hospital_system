@extends('layouts.app')
@section('title','Edit Reservation')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-9">
                <h2>Edit Reservation</h2>
            </div>
            @if (auth()->user()->type =='admin')
            <div class="col-3">
                <a href="{{route('reservations.index')}}" class="btn btn-success">All Reservation</a>
            </div>
            @endif
        </div>
        <p>the hospital timing is from 12pm tell 9pm Egypt time.</p>
    </div>
    <form action="{{ route('reservations.update',$reservation->id) }}" method="post" >
        @csrf
        @method('put')
        <div class="container my-5 card p-3 w-50 text-center m-auto ">
            @if ($errors->any())
                <div class="col-sm-12 container mt-3"  >
                    <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                </div>
            @endif
            <div class="mb-3">
                <label for="" class="form-label">Sepeciality</label>
                <select class="form-select" name="speciality_id" aria-label="Default select example" >
                    <option selected disabled>Open this select menu</option>
                    @foreach ($specialities as $speciality)
                    <option value="{{  $speciality->id}}" @if ($reservation->speciality_id == $speciality->id) {{'selected'}} @endif>{{  $speciality->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">User</label>
                    <select class="form-select" name="user_id" aria-label="Default select example" >
                        <option  disabled>Open this select menu</option>
                        @foreach ($users as $user)
                        <option value="{{  $user->id}}" @if ($reservation->user_id == $user->id) {{'selected'}} @endif>{{  $user->name}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <label for="" class="form-label">Status</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox1" value="finishing" @if ($reservation->status =='finishing') {{'checked'}} @endif name="status">
                        <label class="form-check-label" for="inlineCheckbox1">finishing</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox2" value="waiting" @if ($reservation->status =='waiting') {{'checked'}} @endif name="status">
                        <label class="form-check-label" for="inlineCheckbox2">waiting</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox2" value="cancelled" @if ($reservation->status =='cancelled') {{'checked'}} @endif name="status">
                        <label class="form-check-label" for="inlineCheckbox2">Cancelled</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox2" value="postponed" @if ($reservation->status =='postponed') {{'checked'}} @endif name="status">
                        <label class="form-check-label" for="inlineCheckbox2">Postponed</label>
                      </div>
                </div>
            <div class="row mb-3">
                <div class="col-4">
                    <label for="" class="form-label">Prefered  Reservation Date</label>
                    <input type="date" class="form-control" name="reserve_date" id="" value="{{old('reserve_date',$reservation->reserve_date)}}">
                </div>
                <div class="col-4">
                    <label for="" class="form-label">Prefered  Reservation time</label>
                    <input type="time" class="form-control" name="reserve_time" id="" min="12:00" max="21:00" value="{{old('reserve_time',$reservation->reserve_time)}}">
                </div>
                <div class="col-4">
                    <label for="" class="form-label">Waiting Doctor</label>
                    <input type="text" class="form-control" name="expect_waiting" id=""  value="{{old('expect_waiting',$reservation->expect_waiting)}}">
                </div>
            </div>

            <div class="mb-3  w-50 text-center m-auto " >
                <button type="submit" class="btn btn-primary p-3 form-control"> Send</button>
            </div>
        </div>
    </form>
 @endsection











