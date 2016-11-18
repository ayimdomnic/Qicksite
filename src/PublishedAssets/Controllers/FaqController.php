<?php

namespace App\Http\Controllers\quicksite;

use App\Http\Controllers\Controller;
use Ayimdomnic\QuickSite\Repositories\FAQRepository;

class FaqController extends Controller
{
    /** @var FAQRepository */
    private $faqRepository;

    public function __construct(FAQRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Display all Faq entries.
     *
     * @param int $id
     *
     * @return Response
     */
    public function all()
    {
        $faqs = $this->faqRepository->published();

        if (empty($faqs)) {
            abort(404);
        }

        return view('quicksite-frontend::faqs.all')->with('faqs', $faqs);
    }
}
