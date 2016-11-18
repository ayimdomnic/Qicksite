<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Ayimdomnic\QuickSite\Models\Link;
use Ayimdomnic\QuickSite\Repositories\LinkRepository;
use Ayimdomnic\QuickSite\Requests\LinksRequest;
use Ayimdomnic\QuickSite\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use quicksite;

class LinksController extends quicksiteController
{
    /** @var LinkRepository */
    private $linksRepository;

    public function __construct(LinkRepository $linksRepo)
    {
        $this->linksRepository = $linksRepo;
    }

    /**
     * Display a listing of the Links.
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->linksRepository->paginated();

        return view('quicksite::modules.links.index')
            ->with('links', $result)
            ->with('pagination', $result->render());
    }

    /**
     * Show the form for creating a new Links.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $menu = $request->get('m');

        return view('quicksite::modules.links.create')->with('menu_id', $menu);
    }

    /**
     * Store a newly created Links in storage.
     *
     * @param LinksRequest $request
     *
     * @return Response
     */
    public function store(LinksRequest $request)
    {
        try {
            $validation = ValidationService::check(Link::$rules);

            if (!$validation['errors']) {
                $links = $this->linksRepository->store($request->all());
                quicksite::notification('Link saved successfully.', 'success');

                if (!$links) {
                    quicksite::notification('Link could not be saved.', 'danger');
                }
            } else {
                return $validation['redirect'];
            }
        } catch (Exception $e) {
            quicksite::notification($e->getMessage() ?: 'Link could not be saved.', 'danger');
        }

        return redirect(URL::to('quicksite/menus/'.$request->get('menu_id').'/edit'));
    }

    /**
     * Show the form for editing the specified Links.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $links = $this->linksRepository->findLinksById($id);

        if (empty($links)) {
            quicksite::notification('Link not found', 'warning');

            return redirect(route('quicksite.links.index'));
        }

        return view('quicksite::modules.links.edit')->with('links', $links);
    }

    /**
     * Update the specified Links in storage.
     *
     * @param int          $id
     * @param LinksRequest $request
     *
     * @return Response
     */
    public function update($id, LinksRequest $request)
    {
        try {
            $links = $this->linksRepository->findLinksById($id);

            if (empty($links)) {
                quicksite::notification('Link not found', 'warning');

                return redirect(route('quicksite.links.index'));
            }

            $links = $this->linksRepository->update($links, $request->all());
            quicksite::notification('Link updated successfully.', 'success');

            if (!$links) {
                quicksite::notification('Link could not be updated.', 'danger');
            }
        } catch (Exception $e) {
            quicksite::notification($e->getMessage() ?: 'Links could not be updated.', 'danger');
        }

        return redirect(route('quicksite.links.edit', [$id]));
    }

    /**
     * Remove the specified Links from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $links = $this->linksRepository->findLinksById($id);
        $menu = $links->menu_id;

        if (empty($links)) {
            quicksite::notification('Link not found', 'warning');

            return redirect(route('quicksite.links.index'));
        }

        $links->delete();

        quicksite::notification('Link deleted successfully.', 'success');

        return redirect(URL::to('quicksite/menus/'.$menu.'/edit'));
    }
}
