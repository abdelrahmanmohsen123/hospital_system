@extends('layouts.app')
@section('title','Create Reservation')
<?php
use Carbon\Carbon;
?>
@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-9">
                <h2>Book Appointment</h2>
            </div>
        </div>
        <p class="fs-5"><span style="color:tomato">Notes </span>: the hospital timing is from 12pm tell 9pm Egypt time.</p>
    </div>
    <form action="{{ route('reservations.store') }}" method="post" >
        @csrf
        <div class="container my-5 card p-3 w-50 text-center m-auto ">
            @if (session('success'))
            <div class="col-sm-12 text-center">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif
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
                <select class="form-select" name="speciality_id" aria-label="Default select example" required>
                    <option selected disabled>Open this select menu</option>
                    @foreach ($specialities as $speciality)
                    <option value="{{  $speciality->id}}" @if (old('speciality_id') == $speciality->id) selected @endif>{{  $speciality->name}}</option>
                    @endforeach
                  </select>

            </div>
            @if (auth()->user()->type =='admin')
            <div class="mb-3">
                <label for="" class="form-label">User</label>
                <select class="form-select" name="user_id" aria-label="Default select example" required>
                    <option  disabled>Open this select menu</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id}}" @if (old('user_id') === $user->id) selected @endif>{{  $user->name}}</option>
                    @endforeach
                  </select>
            </div>
            @endif

            <div class="row mb-3">
                <div class="col-6">
                    <label for="" class="form-label">Prefered  Reservation Date</label>
                    <input type="date" class="form-control" name="reserve_date" id="" value="{{old('reserve_date')}}" required>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Prefered  Reservation time</label>
                    <input type="time" class="form-control" min="12:00" max="21:00" name="reserve_time" id="" value="{{old('reserve_time')}}" required>
                </div>
            </div>

            <div class="mb-3  w-50 text-center m-auto " >
                <button type="submit" class="btn btn-primary p-3 form-control"> Send</button>
            </div>
        </div>
    </form>
    {{-- users reservation --}}
    @if(auth()->user()->type =='user'  )
        <div class="container my-5" id="table5">
            <table class="table table-striped table-bordered my-4  ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Speciality</th>
                    <th scope="col">Date Reservation</th>
                    <th scope="col">Time Reservation</th>
                    <th scope="col">Expectation Time arrival the doctor</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                    <tr>
                        <th scope="row" id="tdIndex">{{ $loop->index+1 }}</th>
                        <td>{{ $reservation->speciality->name }}</td>
                        <td>{{ $reservation->reserve_date }}</td>
                        <td>{{Carbon::createFromFormat('H:i:s',$reservation->reserve_time)->format('g:i a')}} </td>
                        <td>{{$reservation->expect_waiting}}</td>
                        <td>{{$reservation->status}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- paginate --}}
            <div class="container my-5 w-50 m-auto text-center">
                <div class="row" style="float: right">
                {{ $reservations->links() }}
                </div>
            </div>

        </div>
    @endif
    {{-- script to hide table if reservations users not have any value --}}
    <script>
        let tdIndex = document.getElementById('tdIndex');
        if (tdIndex==null) {
           document.getElementById('table5').style.display='none';
        }
     </script>
 @endsection












