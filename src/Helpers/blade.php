<?php

if (!function_exists('menu')) {
    function menu($slug, $view = null)
    {
        return app('quicksiteService')->menu($slug, $view);
    }
}

if (!function_exists('images')) {
    function images($tag = null)
    {
        return app('quicksiteService')->images($tag);
    }
}

if (!function_exists('widget')) {
    function widget($slug)
    {
        return app('quicksiteService')->widget($slug);
    }
}

if (!function_exists('editBtn')) {
    function edit($module, $id = null)
    {
        return app('quicksiteService')->module($module, $id);
    }
}
