<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreFormRequest;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class GenreController extends Controller
{
    public function index(Request $request): View
    {
        $filterByName = $request->query('name');

       $filterAction = route('genre.index');

        $genreQuery = Genre::query();

        if ($filterByName !== null) {
            $genreQuery->where('name', 'like', '%' . $filterByName . '%');
        }

        $allGenres = $genreQuery->paginate(20)->withQueryString();

        @debug($filterByName);

        return view('genre.index', compact('allGenres', 'filterByName', 'filterAction'));
    }

    public function create(): View
    {
        return view('genre.create');
    }

    public function store(GenreFormRequest $request): RedirectResponse
{
    $validated = $request->validated();

        $newGenre = Genre::create([
            'code' => Str::random(15),
            'name' => $validated['name'],
        ]);

    $htmlMessage = "Genre $newGenre->name created successfully!";
    return redirect()->route('genre.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
}


    public function edit(Genre $genre): View
    {
        return view('genre.edit')->with('genre', $genre);
    }

    public function update(GenreFormRequest $request, Genre $genre): RedirectResponse
    {
        $genre->update($request->validated());

        $htmlMessage = "Genre $genre->name has been updated successfully!";
        return redirect()->route('genre.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        try {

            $totalMovies =  DB::table('movies')
            ->where('genre_code', $genre->code)
            ->count();

            if ($totalMovies == 0) {
                $genre->delete();
                $alertType = 'success';
                $alertMsg = "Genre {$genre->name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalMovies == 1 => "There is 1 Movie associated with this genre",
                    $totalMovies > 1 => "There are $totalMovies Movies associated with this genre",
                };
                $alertMsg = "Genre {$genre->name} cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the genre {$genre->name} because there was an error with the operation!";
        }
        return redirect()->route('genre.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

}
