<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;
use App\Models\Screening;
use Carbon\Carbon;

class MoviePolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type == "A" || $user?->type == "E") {
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }

    public function view(?User $user, Movie $movie): bool
    {
        $today = Carbon::today();
        $twoWeeksFromNow = Carbon::today()->addDays(15);

        $upcomingScreenings = Screening::where('movie_id', $movie->id)
            ->whereBetween('date', [$today, $twoWeeksFromNow])
            ->exists();

        return $upcomingScreenings;  //true se houver alguma sessao nos proximos 15 dias
    }

}
