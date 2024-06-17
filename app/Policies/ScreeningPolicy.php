<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Screening;
use Carbon\Carbon;

class ScreeningPolicy
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

    public function viewSeats(?User $user, Screening $screening): bool
    {
        $today = Carbon::today();
        $twoWeeksFromNow = Carbon::today()->addDays(15);

        return true;
    }
}
