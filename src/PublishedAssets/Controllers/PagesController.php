<?php

namespace App\Http\Controllers\quicksite;

use App\Http\Controllers\Controller;
use Ayimdomnic\QuickSite\Repositories\PageRepository;

class PagesController extends Controller
{
    /** @var PagesRepository */
    private $pagesRepository;

    public function __construct(PageRepository $pagesRepo)
    {
        $this->pagesRepository = $pagesRepo;
    }

    /**
     * Homepage.
     *
     * @param string $url
     *
     * @return Response
     */
    public function home()
    {
        $page = $this->pagesRepository->findPagesByURL('home');

        $view = view('quicksite-frontend::pages.home');

        if (is_null($page)) {
            return $view;
        }

        return $view->with('page', $page);
    }

    /**
     * Display page list.
     *
     * @return Response
     */
    public function all()
    {
        $pages = $this->pagesRepository->published();

        if (empty($pages)) {
            abort(404);
        }

        return view('quicksite-frontend::pages.all')->with('pages', $pages);
    }

    /**
     * Display the specified Page.
     *
     * @param string $url
     *
     * @return Response
     */
    public function show($url)
    {
        $page = $this->pagesRepository->findPagesByURL($url);

        if (empty($page)) {
            abort(404);
        }

        return view('quicksite-frontend::pages.'.$page->template)->with('page', $page);
    }
}
