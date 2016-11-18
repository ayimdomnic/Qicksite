<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Spatie\LaravelAnalytics\LaravelAnalyticsFacade as LaravelAnalytics;

class DashboardController extends quicksiteController
{
    public function main()
    {
        if (is_null(env('ANALYTICS_SITE_ID'))) {
            return view('quicksite::dashboard.empty');
        }

        foreach (LaravelAnalytics::getVisitorsAndPageViews(7) as $view) {
            $visitStats['date'][] = $view['date']->format('Y-m-d');
            $visitStats['visitors'][] = $view['visitors'];
            $visitStats['pageViews'][] = $view['pageViews'];
        }

        return view('quicksite::dashboard.analytics', compact('visitStats', 'oneYear'));
    }
}
