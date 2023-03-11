<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'reserve_date'=>$this->reserve_date,
            'reserve_time'=>$this->reserve_time,
            'status'=>$this->status,
            'User'=>$this->User->name,
            'Speciality'=>$this->Speciality->name,
            'expect_waiting'=>$this->expect_waiting,
        ];

    }
}