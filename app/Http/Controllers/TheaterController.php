<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Seat;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TheaterFormRequest;
use Illuminate\Support\Facades\Storage;

class TheaterController extends Controller
{

    public function index(Request $request): View
    {
        $filterByName = $request->query('name');

        $filterAction = route('theater.index');

        $theaterQuery = Theater::query();

        if ($filterByName !== null) {
            $theaterQuery->where('name', 'like', '%' . $filterByName . '%');
        }

        $allTheaters = $theaterQuery->paginate(20)->withQueryString();

        @debug($filterByName);

        return view('theater.index', compact('allTheaters', 'filterByName', 'filterAction'));
    }

    public function create(): View
    {
        return view('theater.create');
    }

    public function store(TheaterFormRequest $request): RedirectResponse
{
    $validated = $request->validated();

    $newTheater = Theater::create([
        'name' => $validated['name'],
    ]);

    if ($request->hasFile('photo_filename')) {
        $path = $request->photo_filename->store('public/theater_photos');
        $newTheater->photo_filename = basename($path);
        $newTheater->save();
    }

    // Create seats for the theater
    $rows = $validated['rows'];
    $seatsPerRow = $validated['seats_per_row'];

    $letters = range('A', 'Z'); // Array com letras de A a Z
    $rowIndex = 0;

    for ($row = 1; $row <= $rows; $row++) {
        $currentLetter = $letters[$rowIndex];

        for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
            Seat::Create([
                'theater_id' => $newTheater->id,
                'row' => $currentLetter,
                'seat_number' => $seat,
            ]);
        }
        $rowIndex++;
    }


    $url = route('theater.show', ['theater' => $newTheater]);
    $htmlMessage = "Teatro <a href='$url'><u>{$newTheater->name}</u></a> foi criado com sucesso!";
    return redirect()->route('theater.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
}


    public function edit(Theater $theater): View
    {
        return view('theater.edit')->with('theater', $theater);
    }

    public function update(TheaterFormRequest $request, Theater $theater): RedirectResponse
    {
        $theater->update($request->validated());

        if ($request->hasFile('photo_filename')) {
            if ($theater->photo_filename) {
                Storage::delete("public/theater_photos/{$theater->photo_filename}");
            }
            $path = $request->file('photo_filename')->store('public/theater_photos');
            $theater->photo_filename = basename($path);
            $theater->save();
        }

        $url = route('theater.show', ['theater' => $theater]);
        $htmlMessage = "Theater <a href='$url'><u>{$theater->name}</u></a> has been updated successfully!";
        return redirect()->route('theater.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Theater $theater): RedirectResponse
    {
        try {
            $url = route('theater.show', ['theater' => $theater]);
            $totalTheaterScreenings = $theater->screenings()->count();
            if ($totalTheaterScreenings == 0) {
                if ($theater->photo_filename) {
                    Storage::delete("public/theater_photos/{$theater->photo_filename}");
                }
                $theater->delete();
                $alertType = 'success';
                $alertMsg = "Theater {$theater->name} ({$theater->id}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $justification = match (true) {
                    $totalTheaterScreenings == 1 => "There is 1 session for this theater",
                    $totalTheaterScreenings > 1 => "There are $totalTheaterScreenings sessions for this theater",
                };
                $alertMsg = "Theater <a href='$url'><u>{$theater->name}</u></a> cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the theater <a href='$url'><u>{$theater->name}</u></a> because there was an error with the operation!";
        }
        return redirect()->route('theater.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function show(Theater $theater): View
    {
        return view('theater.show')->with('theater', $theater);
    }

}
