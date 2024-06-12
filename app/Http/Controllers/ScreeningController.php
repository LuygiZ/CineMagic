<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use App\Models\Screening;
use App\Models\Theater;

class ScreeningController extends Controller
{
    use HasFactory;

        public function index(Request $request): View
        {
            $filterByMovieName = $request->query('movie_name');
            $filterByTheater = $request->query('theater_id');
            $filterByDate = $request->query('screeningDate');

            $screeningsQuery = Screening::query();

            if ($filterByMovieName !== null) {
                $screeningsQuery->join('movies', 'screenings.movie_id', '=', 'movies.id')
                                ->where('movies.title', 'like', '%' . $filterByMovieName . '%');
            }

            if ($filterByTheater !== null) {
                $screeningsQuery->where('theater_id', $filterByTheater);
            }

            if($filterByDate !== null){
                $screeningsQuery->where('date', $filterByDate);
            }

            if ($filterByDate !== null) {
                $screeningsQuery->where('date', $filterByDate);
            }
            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Qualquer Sala'] + $allTheaters;

            $allScreenings = $screeningsQuery
                ->paginate(20)
                ->withQueryString();

            return view('screenings.index', compact('allScreenings', 'allTheaters', 'filterByMovieName', 'filterByTheater', 'filterByDate'));
        }

        public function create(): View
        {
            $screening = new Screening();

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Qualquer Sala'] + $allTheaters;


            return view('screenings.create', compact('screening', 'allTheaters'));
        }

        public function edit(Screening $screening)
        {

            if ($screening->tickets()->exists()) {
                $htmlMessage = "A sessão não pode ser editada! (possui bilhetes)";
                return redirect()->route('screenings.index')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', $htmlMessage);
            }

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Qualquer Sala'] + $allTheaters;


            return view('screenings.edit', compact('screening', 'allTheaters'));
        }

        public function destroy(Screening $screening): RedirectResponse
        {

            if ($screening->tickets()->exists()) {
                $htmlMessage = "A sessão não pode ser apagada! (possui bilhetes)";
                return redirect()->route('screenings.index')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', $htmlMessage);
            }

            $screening->delete();
            $htmlMessage = "Sessão apagada com sucesso!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }

        public function store(): RedirectResponse
        {

            $htmlMessage = "Operação realizada com sucesso!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }

        public function update(Screening $screening): RedirectResponse
        {
           // $validatedData = $request->validated();

            $url = route('screenings.edit', ['screening' => $screening]);
            $htmlMessage = "Sessão atualizada com sucesso!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }

        public function seats($screening): View
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

            return view('screenings.seats', compact('screening', 'seats'));
        }

    }
