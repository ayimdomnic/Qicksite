<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Illuminate\Http\Request;
use quicksite;
use Response;
use URL;
use Ayimdomnic\QuickSite\Models\Page;
use Ayimdomnic\QuickSite\Repositories\PageRepository;
use Ayimdomnic\QuickSite\Requests\PagesRequest;
use Ayimdomnic\QuickSite\Services\ValidationService;

class PagesController extends quicksiteController
{
    /** @var PageRepository */
    private $pagesRepository;

    public function __construct(PageRepository $pagesRepo)
    {
        $this->pagesRepository = $pagesRepo;
    }

    /**
     * Display a listing of the Pages.
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->pagesRepository->paginated();

        return view('quicksite::modules.pages.index')
            ->with('pages', $result)
            ->with('pagination', $result->render());
    }

    /**
     * Search.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function search(Request $request)
    {
        $input = $request->all();

        $result = $this->pagesRepository->search($input);

        return view('quicksite::modules.pages.index')
            ->with('pages', $result[0]->get())
            ->with('pagination', $result[2])
            ->with('term', $result[1]);
    }

    /**
     * Show the form for creating a new Pages.
     *
     * @return Response
     */
    public function create()
    {
        return view('quicksite::modules.pages.create');
    }

    /**
     * Store a newly created Pages in storage.
     *
     * @param PagesRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = ValidationService::check(Page::$rules);

        if (!$validation['errors']) {
            $pages = $this->pagesRepository->store($request->all());
            quicksite::notification('Page saved successfully.', 'success');
        } else {
            return $validation['redirect'];
        }

        if (!$pages) {
            quicksite::notification('Page could not be saved.', 'warning');
        }

        return redirect(route('quicksite.pages.edit', [$pages->id]));
    }

    /**
     * Show the form for editing the specified Pages.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pagesRepository->findPagesById($id);

        if (empty($page)) {
            quicksite::notification('Page not found', 'warning');

            return redirect(route('quicksite.pages.index'));
        }

        return view('quicksite::modules.pages.edit')->with('page', $page);
    }

    /**
     * Update the specified Pages in storage.
     *
     * @param int          $id
     * @param PagesRequest $request
     *
     * @return Response
     */
    public function update($id, PagesRequest $request)
    {
        $pages = $this->pagesRepository->findPagesById($id);

        if (empty($pages)) {
            quicksite::notification('Page not found', 'warning');

            return redirect(route('quicksite.pages.index'));
        }

        $pages = $this->pagesRepository->update($pages, $request->all());
        quicksite::notification('Page updated successfully.', 'success');

        if (!$pages) {
            quicksite::notification('Page could not be saved.', 'warning');
        }

        return redirect(URL::previous());
    }

    /**
     * Remove the specified Pages from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pages = $this->pagesRepository->findPagesById($id);

        if (empty($pages)) {
            quicksite::notification('Page not found', 'warning');

            return redirect(route('quicksite.pages.index'));
        }

        $pages->delete();

        quicksite::notification('Page deleted successfully.', 'success');

        return redirect(route('quicksite.pages.index'));
    }
}
