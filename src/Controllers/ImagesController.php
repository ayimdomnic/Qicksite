<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Ayimdomnic\QuickSite\Models\Image;
use Ayimdomnic\QuickSite\Repositories\ImageRepository;
use Ayimdomnic\QuickSite\Requests\ImagesRequest;
use Ayimdomnic\QuickSite\Services\quicksiteResponseService;
use Ayimdomnic\QuickSite\Services\ValidationService;
use Config;
use CryptoService;
use FileService;
use Illuminate\Http\Request;
use quicksite;
use Storage;

class ImagesController extends quicksiteController
{
    /** @var ImageRepository */
    private $imagesRepository;

    public function __construct(ImageRepository $imagesRepo)
    {
        $this->imagesRepository = $imagesRepo;
    }

    /**
     * Display a listing of the Images.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $result = $this->imagesRepository->paginated();

        return view('quicksite::modules.images.index')
            ->with('images', $result)
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

        $result = $this->imagesRepository->search($input);

        return view('quicksite::modules.images.index')
            ->with('images', $result[0]->get())
            ->with('pagination', $result[2])
            ->with('term', $result[1]);
    }

    /**
     * Show the form for creating a new Images.
     *
     * @return Response
     */
    public function create()
    {
        return view('quicksite::modules.images.create');
    }

    /**
     * Store a newly created Images in storage.
     *
     * @param ImagesRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $validation = ValidationService::check(['location' => 'required']);
            if (!$validation['errors']) {
                foreach ($request->input('location') as $image) {
                    $imageSaved = $this->imagesRepository->store([
                        'location'     => $image,
                        'is_published' => $request->input('is_published'),
                        'tags'         => $request->input('tags'),
                    ]);
                }

                quicksite::notification('Image saved successfully.', 'success');

                if (!$imageSaved) {
                    quicksite::notification('Image was not saved.', 'danger');
                }
            } else {
                quicksite::notification('Image could not be saved', 'danger');

                return $validation['redirect'];
            }
        } catch (Exception $e) {
            quicksite::notification($e->getMessage() ?: 'Image could not be saved.', 'danger');
        }

        return redirect(route('quicksite.images.index'));
    }

    /**
     * Store a newly created Files in storage.
     *
     * @param FileRequest $request
     *
     * @return Response
     */
    public function upload(Request $request)
    {
        $validation = ValidationService::check([
            'location' => ['required'],
        ]);

        if (!$validation['errors']) {
            $file = $request->file('location');
            $fileSaved = FileService::saveFile($file, 'images/');
            $fileSaved['name'] = CryptoService::encrypt($fileSaved['name']);
            $fileSaved['mime'] = $file->getClientMimeType();
            $fileSaved['size'] = $file->getClientSize();
            $response = quicksiteResponseService::apiResponse('success', $fileSaved);
        } else {
            $response = quicksiteResponseService::apiErrorResponse($validation['errors'], $validation['inputs']);
        }

        return $response;
    }

    /**
     * Show the form for editing the specified Images.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $images = $this->imagesRepository->findImagesById($id);

        if (empty($images)) {
            quicksite::notification('Image not found', 'warning');

            return redirect(route('quicksite.images.index'));
        }

        return view('quicksite::modules.images.edit')->with('images', $images);
    }

    /**
     * Update the specified Images in storage.
     *
     * @param int           $id
     * @param ImagesRequest $request
     *
     * @return Response
     */
    public function update($id, ImagesRequest $request)
    {
        try {
            $images = $this->imagesRepository->findImagesById($id);

            quicksite::notification('Image updated successfully.', 'success');

            if (empty($images)) {
                quicksite::notification('Image not found', 'warning');

                return redirect(route('quicksite.images.index'));
            }

            $images = $this->imagesRepository->update($images, $request->all());

            if (!$images) {
                quicksite::notification('Image could not be updated', 'danger');
            }
        } catch (Exception $e) {
            quicksite::notification($e->getMessage() ?: 'Image could not be saved.', 'danger');
        }

        return redirect(route('quicksite.images.edit', $id));
    }

    /**
     * Remove the specified Images from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $image = $this->imagesRepository->findImagesById($id);

        if (is_file(storage_path($image->location))) {
            @Storage::delete($image->location);
        }

        if (empty($image)) {
            quicksite::notification('Image not found', 'warning');

            return redirect(route('quicksite.images.index'));
        }

        $image->delete();

        quicksite::notification('Image deleted successfully.', 'success');

        return redirect(route('quicksite.images.index'));
    }

    /*
    |--------------------------------------------------------------------------
    | Api
    |--------------------------------------------------------------------------
    */

    /**
     * Display the specified Images.
     *
     * @return Response
     */
    public function apiList(Request $request)
    {
        if (Config::get('quicksite.api-key') != $request->header('quicksite')) {
            return quicksiteResponseService::apiResponse('error', []);
        }

        $images = $this->imagesRepository->apiPrepared();

        return quicksiteResponseService::apiResponse('success', $images);
    }

    /**
     * Store a newly created Images in storage.
     *
     * @param ImagesRequest $request
     *
     * @return Response
     */
    public function apiStore(Request $request)
    {
        $image = $this->imagesRepository->apiStore($request->all());

        return quicksiteResponseService::apiResponse('success', $image);
    }
}
