<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Screening;
use App\Models\Theater;
use App\Models\Seat;
use App\Models\Movie;
use Carbon\Carbon;

class SeatController extends Controller
{
    public function index($screening): View
    {
        $screening = Screening::find($screening);
        $seats = $screening->theater->seats;

        $screeningDate = Carbon::parse($screening->date);
        $hasScreeningPassed = $screeningDate->isPast();

        foreach($seats as $seat){
            /*if($hasScreeningPassed) 
            {
                $seat->ocupado = true;
                continue;
            }*/
            $seat->lugar = $seat->row.$seat->seat_number;
            $seat->ocupado = $screening->tickets->contains('seat_id', $seat->id);
        }

        return view('seats.index', compact('screening', 'seats'));
    }
}
