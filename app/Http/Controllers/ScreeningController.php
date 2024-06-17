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
use App\Models\Movie;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ScreeningFormRequest;

class ScreeningController extends Controller
{
    use HasFactory;

    public function index(Request $request): View
    {
        $filterByMovieName = $request->query('movie_name');
        $filterByTheater = $request->query('theater_id');
        $filterByDate = $request->query('screeningDate');

        $screeningsQuery = Screening::query();

        if (!empty($filterByTheater)) {
            $screeningsQuery->where('theater_id', $filterByTheater);
        }

        if (!empty($filterByDate)) {
            $screeningsQuery->where('date', $filterByDate);
        }
        if (!empty($filterByMovieName)) {
            $screeningsQuery->whereHas('movie', function ($query) use ($filterByMovieName) {
                $query->where('title', 'like', $filterByMovieName. '%');
            });
        }
        $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
        $allTheaters = [null => 'Any Theater'] + $allTheaters;

        $allScreenings = $screeningsQuery->orderBy('date','desc')->paginate(20)->withQueryString();

        return view('screenings.index', compact('allScreenings', 'allTheaters', 'filterByMovieName', 'filterByTheater', 'filterByDate'));
    }


        public function create(): View
        {
            $screening = new Screening();

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;


            return view('screenings.create', compact('screening', 'allTheaters'));
        }

        public function control(Screening $screening): View
        {

            if (session()->has('screeningIdToControl')){
                session()->put('screeningIdToControl', $screening->id);
            }

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;

            return view('screenings.control', compact('screening', 'allTheaters'));
        }

        public function verifyTicket(Request $request)
        {
            if (!session()->has('screeningIdToControl') || session('screeningIdToControl') == null){
                return redirect()->route('home.show');
            }

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;

            $screening = Screening::find(session('screeningIdToControl'));

            if($request->ticketCode == ""){
                $ticket = 0;
                return view('screenings.control', compact('screening', 'allTheaters', 'ticket'));
            }

            $ticket = Ticket::where('qrcode_url', $request->ticketCode)->first();


            if($ticket == null){
                $ticket = 0;
            }

            return view('screenings.control', compact('screening', 'allTheaters', 'ticket'));
        }

        public function changeControl(Request $request) : View
        {

            if (!session()->has('screeningIdToControl') || session('screeningIdToControl') == null){
                Session::put('screeningIdToControl', $request->screening);
            }else{
                Session::forget('screeningIdToControl');
            }

            $screening = Screening::find($request->screening);

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;

            return view('screenings.control', compact('screening', 'allTheaters'));
        }

        public function acceptTicket(Request $request): RedirectResponse
        {
            $ticket = Ticket::find($request->ticket);
            $ticket->status = "invalid";
            $ticket->update();

            $screening = Screening::find($request->screening);

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;

            $htmlMessage = "O Bilhete Foi Aceite com sucesso!";

            return redirect()->route('screenings.control', ['screening' => $screening])
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }


        public function edit(Screening $screening): View | RedirectResponse
        {


            if ($screening->tickets()->exists()) {
                $htmlMessage = "The session cannot be edited! (has tickets)";
                return redirect()->route('screenings.index')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', $htmlMessage);
            }

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;

            return view('screenings.edit', compact('screening', 'allTheaters'));
        }

        public function destroy(Screening $screening): RedirectResponse
        {

            if ($screening->tickets()->exists()) {
                $htmlMessage = "The session cannot be deleted! (has tickets)";
                return redirect()->route('screenings.index')
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', $htmlMessage);
            }

            $screening->delete();
            $htmlMessage = "Session deleted successfully!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }

        public function store(ScreeningFormRequest $request): RedirectResponse
        {

            $validatedData = $request->validated();

            $data = \DateTime::createFromFormat('d/m/Y', $validatedData['date']);
            $hora = \DateTime::createFromFormat('H:i', $validatedData['time']);

            $filme = Movie::where('title', $validatedData['title'])->first();

            $sala = Theater::where('id', $validatedData['theater_id'])->firstOrFail();

            $dias = $validatedData['numDays'] ?? 1;
            for ($i = 0; $i < $dias; $i++) {
                Screening::create([
                    'movie_id' => $filme->id,
                    'theater_id' => $sala->id,
                    'date' => date('Y-m-d', strtotime("$data + $i days")),
                    'start_time' => $hora,
                ]);
            }

            $htmlMessage = "Operation carried out successfully!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }

        public function update(ScreeningFormRequest $request, Screening $screening): RedirectResponse
        {
            $validatedData = $request->validated();

            $data = \DateTime::createFromFormat('Y-m-d', $validatedData['date']);
            $hora = \DateTime::createFromFormat('H:i', $validatedData['time']);

            $filme = Movie::where('title', $validatedData['title'])->first();

            $sala = Theater::where('id', $validatedData['theater_id'])->firstOrFail();

            $screening->update([
                'movie_id' => $filme->id,
                'theater_id' => $sala->id,
                'date' => $data,
                'start_time' => $hora
            ]);

            $htmlMessage = "Session updated successfully!";
            return redirect()->route('screenings.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
        }


        public function seats($screening): View
        {

            @debug(Gate::allows('viewSeats', $screening));


            if (!Gate::authorize('vi')) {
                return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
            }

            $screening = Screening::find($screening);
            $seats = $screening->theater->seats;

            $screeningDate = Carbon::parse($screening->date);
            $hasScreeningPassed = $screeningDate->isPast();

            $seats->maxRow = $seats->max('row');
            $seats->maxSeatNumber = $seats->max('seat_number');

            foreach($seats as $seat){
                $seat->lugar = $seat->row.$seat->seat_number;
                $seat->ocupado = $screening->tickets->contains('seat_id', $seat->id);
            }

            $allTheaters = Theater::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
            $allTheaters = [null => 'Any Theater'] + $allTheaters;

            return view('screenings.seats', compact('screening', 'seats', 'allTheaters'));
        }
    }
