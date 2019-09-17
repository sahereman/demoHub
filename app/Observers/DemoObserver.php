<?php

namespace App\Observers;

use App\Models\Demo;

class DemoObserver
{
    /**
     * Handle the demo "created" event.
     *
     * @param  \App\Models\Demo  $demo
     * @return void
     */
    public function created(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "updated" event.
     *
     * @param  \App\Models\Demo  $demo
     * @return void
     */
    public function updated(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "deleted" event.
     *
     * @param  \App\Models\Demo  $demo
     * @return void
     */
    public function deleted(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "restored" event.
     *
     * @param  \App\Models\Demo  $demo
     * @return void
     */
    public function restored(Demo $demo)
    {
        //
    }

    /**
     * Handle the demo "force deleted" event.
     *
     * @param  \App\Models\Demo  $demo
     * @return void
     */
    public function forceDeleted(Demo $demo)
    {
        //
    }
}
