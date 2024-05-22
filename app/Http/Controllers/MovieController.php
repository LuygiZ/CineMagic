<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{

    public function index(): View
    {

        $today = Carbon::today();
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);
        $upcomingScreenings = Screening::with('movie')
            ->whereBetween('date', [$today, $twoWeeksFromNow])->get();

        $movieIds = $upcomingScreenings->pluck('movie_id');

        $movies = Movie::whereIn('id', $movieIds)->get();

        debug($upcomingScreenings->first()->movie_id);

        return view('home')->with('movies', $movies);
    }
}
