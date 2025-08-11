<?php

namespace App\Observers;

use App\Models\MnoResponse;

class MnoResponseObserver
{
    /**
     * Handle the MnoResponse "created" event.
     */
    public function created(MnoResponse $mnoResponse): void
    {
        //
    }

    /**
     * Handle the MnoResponse "updated" event.
     */
    public function updated(MnoResponse $mnoResponse): void
    {
        //
    }

    /**
     * Handle the MnoResponse "deleted" event.
     */
    public function deleted(MnoResponse $mnoResponse): void
    {
        //
    }

    /**
     * Handle the MnoResponse "restored" event.
     */
    public function restored(MnoResponse $mnoResponse): void
    {
        //
    }

    /**
     * Handle the MnoResponse "force deleted" event.
     */
    public function forceDeleted(MnoResponse $mnoResponse): void
    {
        //
    }
}
