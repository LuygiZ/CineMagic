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
use App\Models\Genre;

class MovieController extends Controller
{

    public function index(Request $request): View
    {
        $movies = Movie::paginate(15);
        $genres = Genre::orderBy("name", "asc")->pluck("name", "code")->toArray();
        $genres = array_merge([null => 'Any Genre'], $genres);
        $filterByGenre = $request->query('genre_code');
        $filterByYear = $request->query('year');
        $filterByTitle = $request->query('title');

        $moviesQuery = Movie::query();

        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }

        if ($filterByYear !== null) {
            $moviesQuery->where('year', $filterByYear);
        }

        if ($filterByTitle !== null) {
            $moviesQuery->where(function ($query) use ($filterByTitle) {
                $query->where('title', 'like', '%' . $filterByTitle . '%')
                    ->orWhere('synopsis', 'like', '%' . $filterByTitle . '%');
            });
        }
        

        $allMovies = $moviesQuery
            ->paginate(20)
            ->withQueryString();

        return view('movies.index', compact('allMovies', 'filterByGenre', 'filterByYear', 'filterByTitle', 'genres'));
    }

    public function indexPoster(): View
    {
        $today = Carbon::today();
        $twoWeeksFromNow = Carbon::today()->addWeeks(2);

        // Get upcoming screenings within the next two weeks including today
        $upcomingScreenings = Screening::with('movie')
            ->whereBetween('date', [$today, $twoWeeksFromNow])->get();

        // Extract unique movie IDs from the screenings
        $movieIds = $upcomingScreenings->pluck('movie_id')->unique();

        // Fetch movies corresponding to these IDs
        $movies = Movie::whereIn('id', $movieIds)->get();

        return view('home')->with('movies', $movies);
    }


    public function create(): View
    {
        $movie = new Movie();
        $genres = Genre::orderBy("name", "asc")->pluck("name", "code")->toArray();
        return view('movies.create',compact('genres','movie'));
    }

    public function store(MovieFormRequest $request): RedirectResponse
    {
        $newMovie = Movie::create($request->validated());

        if ($request->hasFile('poster_filename')) {
            $path=$request->poster_filename->store('public/posters');
        }
        $newMovie->poster_filename=basename($path);
        $newMovie->save();

        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> has been created successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
    
    public function edit(Movie $movie): View
    {
        $genres = Genre::orderBy("name", "asc")->pluck("name", "code")->toArray();
        return view('movies.edit', compact('genres','movie'));
    }

    public function update(MovieFormRequest $request, Movie $movie): RedirectResponse
    {
        $movie->update($request->validated());

        if ($request->hasFile('poster_filename')) {
            if ($movie->imageExists) {
                Storage::delete("public/posters/{$movies->poster_filename}");
            }
            $path = $request->poster_filename->store('public/posters');
            $movie->poster_filename = basename($path);

            $movie->save();
        }

        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "Movie <a href='$url'><u>{$movie->title}</u></a> has been updated successfully!";
        return redirect()->route('movies.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
    public function destroy(Movie $movie): RedirectResponse
    {
        try {
            $url = route('movies.show', ['movie' => $movie]);
            $totalMovieScreenings = $movie->screenings()->count();
            if ($totalMovieScreenings == 0) {
                $movie->delete();
                $alertType = 'success';
                $alertMsg = "Movie {$movie->title} ({$movie->id}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalMovieScreenings <= 0 => "",
                    $totalMovieScreenings == 1 => "Existe 1 sessão para este filme",
                    $totalMovieScreenings > 1 => "Existem $totalMovieScreenings sessões para este filme",
                };
                $alertMsg = "Movie <a href='$url'><u>{$movie->title}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the movie
                            <a href='$url'><u>{$movie->title}</u></a>
                            because there was an error with the operation!";
        }
        return redirect()->route('movies.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Movie $movie): View
    {
        $genres = Genre::orderBy("name", "asc")->pluck("name", "code")->toArray();
        return view('movies.show', compact('genres','movie'));
    }
}
