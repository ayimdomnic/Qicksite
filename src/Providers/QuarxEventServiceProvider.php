<?php

namespace Ayimdomnic\QuickSite\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class quicksiteEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.saved: Ayimdomnic\QuickSite\Models\Blog' => [
            'Ayimdomnic\QuickSite\Models\Blog@afterSaved',
        ],
        'eloquent.saved: Ayimdomnic\QuickSite\Models\Page' => [
            'Ayimdomnic\QuickSite\Models\Page@afterSaved',
        ],
        'eloquent.saved: Ayimdomnic\QuickSite\Models\Event' => [
            'Ayimdomnic\QuickSite\Models\Event@afterSaved',
        ],
        'eloquent.saved: Ayimdomnic\QuickSite\Models\FAQ' => [
            'Ayimdomnic\QuickSite\Models\Event@afterSaved',
        ],
        'eloquent.saved: Ayimdomnic\QuickSite\Models\Translation' => [
            'Ayimdomnic\QuickSite\Models\Event@afterSaved',
        ],
        'eloquent.saved: Ayimdomnic\QuickSite\Models\Widget' => [
            'Ayimdomnic\QuickSite\Models\Event@afterSaved',
        ],

        'eloquent.deleting: Ayimdomnic\QuickSite\Models\Blog' => [
            'Ayimdomnic\QuickSite\Models\Blog@beingDeleted',
        ],
        'eloquent.deleting: Ayimdomnic\QuickSite\Models\Page' => [
            'Ayimdomnic\QuickSite\Models\Page@beingDeleted',
        ],
        'eloquent.deleting: Ayimdomnic\QuickSite\Models\Event' => [
            'Ayimdomnic\QuickSite\Models\Event@beingDeleted',
        ],
        'eloquent.deleting: Ayimdomnic\QuickSite\Models\FAQ' => [
            'Ayimdomnic\QuickSite\Models\Event@beingDeleted',
        ],
        'eloquent.deleting: Ayimdomnic\QuickSite\Models\Translation' => [
            'Ayimdomnic\QuickSite\Models\Event@beingDeleted',
        ],
        'eloquent.deleting: Ayimdomnic\QuickSite\Models\Widget' => [
            'Ayimdomnic\QuickSite\Models\Event@beingDeleted',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
