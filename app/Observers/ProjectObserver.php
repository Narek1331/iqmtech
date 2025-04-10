<?php

namespace App\Observers;

use App\Models\Project;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project->token = JWTAuth::customClaims(
        [
            'user_id'    => $project->user_id,
            'project_id' => $project->id,
        ],
        [
            'exp' => Carbon::now()->addYears(100)->timestamp
        ]
        )
        ->fromUser($project->user);

        $project->save();
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
