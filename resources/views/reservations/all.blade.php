@extends('layouts.app')
@section('title','All Reservations')

@section('content')
<?php
use Carbon\Carbon;
?>
    <div class="container my-5">
        <div class="row">
            <div class="col-8 mb-4">
            <h2>All Reservations</h2>
            </div>

            <div class="col-4">
                <div class="row">
                    <div class="col-6">
                        <h3><a href="{{ route('reservations.create') }}" class="btn btn-primary">Add reservations</a></h3>
                    </div>
                </div>
            </div>
        </div>
        <form action="" method="get">
            <div class="row my-2">
                <div class="col-3">
                    <label for="">Filter By Date</label>
                    <input type="date" value="{{ Request::get('reserve_date') ?? date('Y-m-d') }}" name="reserve_date" class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Filter By Speciality</label>
                    <select name="speciality_id" id="" class="form-select">
                        <option value=""  selected> Choose Speciality</option>
                        @foreach ($specialities as $speciality)
                        <option value="{{$speciality->id}}" @if (app('request')->input('speciality_id') == $speciality->id)
                            {{'selected'}}
                        @endif>
                            {{$speciality->name}}
                        </option>
                        @endforeach

                    </select>
                </div>
                <div class="col-6">
                    <br>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        @if (session('success'))
            <div class="col-sm-12 text-center">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('fail'))
            <div class="col-sm-12 text-center">
                <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                    {{ session('fail') }}
                </div>
            </div>
        @endif
        <table class="table table-striped table-bordered my-4  ">
            <thead>
              <tr>
                <th scope="col">#</th>
                {{-- <th scope="col">Speciality</th> --}}
                <th scope="col">User</th>
                <th scope="col">Speciality</th>

                <th scope="col">Date Reservation</th>
                <th scope="col">Time Reservation</th>
                <th scope="col">Expectation  arrival </th>
                <th scope="col">Status</th>
                <th scope="col"> Actions</th>

              </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr>
                    <th scope="row">{{ $loop->index+1 }}</th>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->speciality->name }}</td>
                    <td>{{ $reservation->reserve_date }}</td>
                    <td>{{Carbon::createFromFormat('H:i:s',$reservation->reserve_time)->format('g:i a')}} </td>
                    <td>{{$reservation->expect_waiting}}</td>
                    <td>{{$reservation->status}}</td>
                    <td>
                        <div class="row">
                            <div class="col-3">
                                <a href="{{ route('reservations.edit',$reservation->id) }}" class="btn btn-warning">Edit</a>
                            </div>
                            <div class="col-3">
                                <form action="{{ route('reservations.destroy',$reservation->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" id="delete_id"  name="delete_post_id">
                                    <button type="submit" class="btn btn-danger"> Delete</button>
                                  </form>
                            </div>
                        </div>
                    </td>
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
@endsection
