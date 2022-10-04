<?php

namespace App\Listeners;

use LdapRecord\Laravel\Events\Import\Imported;
use App\Models\Team;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignTeam
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Imported  $event
     * @return void
     */
    public function handle(Imported $event)
    {
        $user = $event->eloquent;

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[1]."'s Team",
            'personal_team' => true,
        ]));
    }
}
