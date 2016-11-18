<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Illuminate\Http\Request;
use quicksite;
use URL;
use Ayimdomnic\QuickSite\Models\FAQ;
use Ayimdomnic\QuickSite\Repositories\FAQRepository;
use Ayimdomnic\QuickSite\Requests\FAQRequest;
use Ayimdomnic\QuickSite\Services\ValidationService;

class FAQController extends quicksiteController
{
    /** @var FAQRepository */
    private $faqRepository;

    public function __construct(FAQRepository $faqRepo)
    {
        $this->faqRepository = $faqRepo;
    }

    /**
     * Display a listing of the FAQ.
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->faqRepository->paginated();

        return view('quicksite::modules.faqs.index')
            ->with('faqs', $result)
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

        $result = $this->faqRepository->search($input);

        return view('quicksite::modules.faqs.index')
            ->with('faqs', $result[0]->get())
            ->with('pagination', $result[2])
            ->with('term', $result[1]);
    }

    /**
     * Show the form for creating a new FAQ.
     *
     * @return Response
     */
    public function create()
    {
        return view('quicksite::modules.faqs.create');
    }

    /**
     * Store a newly created FAQ in storage.
     *
     * @param FAQRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = ValidationService::check(FAQ::$rules);

        if (!$validation['errors']) {
            $faq = $this->faqRepository->store($request->all());
            quicksite::notification('FAQ saved successfully.', 'success');
        } else {
            return $validation['redirect'];
        }

        if (!$faq) {
            quicksite::notification('FAQ could not be saved.', 'warning');
        }

        return redirect(route('quicksite.faqs.edit', [$faq->id]));
    }

    /**
     * Show the form for editing the specified FAQ.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $faq = $this->faqRepository->findFAQById($id);

        if (empty($faq)) {
            quicksite::notification('FAQ not found', 'warning');

            return redirect(route('quicksite.faqs.index'));
        }

        return view('quicksite::modules.faqs.edit')->with('faq', $faq);
    }

    /**
     * Update the specified FAQ in storage.
     *
     * @param int        $id
     * @param FAQRequest $request
     *
     * @return Response
     */
    public function update($id, FAQRequest $request)
    {
        $faq = $this->faqRepository->findFAQById($id);

        if (empty($faq)) {
            quicksite::notification('FAQ not found', 'warning');

            return redirect(route('quicksite.faqs.index'));
        }

        $faq = $this->faqRepository->update($faq, $request->all());
        quicksite::notification('FAQ updated successfully.', 'success');

        if (!$faq) {
            quicksite::notification('FAQ could not be saved.', 'warning');
        }

        return redirect(URL::previous());
    }

    /**
     * Remove the specified FAQ from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $faq = $this->faqRepository->findFAQById($id);

        if (empty($faq)) {
            quicksite::notification('FAQ not found', 'warning');

            return redirect(route('quicksite.faqs.index'));
        }

        $faq->delete();

        quicksite::notification('FAQ deleted successfully.', 'success');

        return redirect(route('quicksite.faqs.index'));
    }
}
