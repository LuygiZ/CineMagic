<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Screening;
use App\Models\Theater;
use App\Models\Seat;
use App\Models\Movie;

class SeatController extends Controller
{
    public function index($screening): View
    {
        $screening = Screening::find($screening);
        $movie = $screening->movie;
        $theater = $screening->theater; 
        $seats = $theater->seats;
        
        return view('seats.index', compact('screening', 'seats', 'movie'));
    }
}
