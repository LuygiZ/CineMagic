<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MovieFormRequest;

class MovieController extends Controller
{

    public function dados(): View
    {
        $allMovies = Movie::all();
        return view('home')->with('movies', $allMovies);
    }

    public function index(): View
    {
        $today = Carbon::today();
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);

        // Get upcoming screenings within the next two weeks including today
        $upcomingScreenings = Screening::with('movie')
        ->whereBetween('date', [$today, $twoWeeksFromNow])
            ->get();

        // Extract unique movie IDs from the screenings
        $movieIds = $upcomingScreenings->pluck('movie_id')->unique();

        // Fetch movies corresponding to these IDs
        $movies = Movie::whereIn('id', $movieIds)->get();

        return view('home')->with('movies', $movies);
    }

    public function showCase(): View
    {
        return view('movies.showcase');
    }

    public function create(): View
    {
        $newMovie = new Movie();
        return view('movies.create')->with('course', $newMovie);
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());
        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Movie $movie): View
    {
        return view('movies.edit')->with('movie', $movie);
    }

    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());
        $url = route('movies.show', ['course' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->title}</u></a> has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Movie $movie)
     {
         $oldName = $movie->title;
         try {
             $movie->delete();
             return redirect()->route('movies')
                 ->with('alert-msg', 'Movie "' . $oldName . '" foi apagado com sucesso!')
                 ->with('alert-type', 'success');
         } catch (\Throwable $th) {
 
             if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                 return redirect()->route('movies')
                     ->with('alert-msg', 'Não foi possível apagar o Filme "' . $oldName . '", porque este Filme já está em uso!')
                     ->with('alert-type', 'danger');
             } else {
                 return redirect()->route('filmes')
                     ->with('alert-msg', 'Não foi possível apagar o Filme "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                     ->with('alert-type', 'danger');
             }
         }
     }

    public function show(Movie $movie): View
    {
        return view('movies.show')->with('movie', $movie);
    }

}
