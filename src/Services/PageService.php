<?php

namespace Ayimdomnic\Quicksite\Services;

use Ayimdomnic\Quicksite\Repositories\PageRepository;
use Illuminate\Support\Facades\Config;

class PageService
{
    public function __construct()
    {
        $this->pageRepo = new PageRepository();
    }

    public function getPagesAsOptions()
    {
        $pages = [];
        $publishedPages = $this->pageRepo->all();
        foreach ($publishedPages as $page) {
            $pages[$page->title] = $page->id;
        }

        return $pages;
    }

    public function getTemplatesAsOptions()
    {
        $availableTemplates = ['show'];
        $templates = glob(base_path('resources/themes/'.Config::get('quicksite.frontend-theme').'/pages/*'));
        foreach ($templates as $template) {
            $template = str_replace(base_path('resources/themes/'.Config::get('quicksite.frontend-theme').'/pages/'), '', $template);
            if (stristr($template, 'template')) {
                $template = str_replace('-template.blade.php', '', $template);
                if (!stristr($template, '.php')) {
                    $availableTemplates[] = $template.'-template';
                }
            }
        }

        return $availableTemplates;
    }

    public function pageName($id)
    {
        $page = $this->pageRepo->findPagesById($id);

        return $page->title;
    }
}
