<?php

namespace Ayimdomnic\QuickSite\Controllers;

use Config;
use CryptoService;
use Illuminate\Http\Request;
use quicksite;
use Redirect;
use Response;
use Storage;
use Ayimdomnic\QuickSite\Models\File;
use Ayimdomnic\QuickSite\Repositories\FileRepository;
use Ayimdomnic\QuickSite\Requests\FileRequest;
use Ayimdomnic\QuickSite\Services\FileService;
use Ayimdomnic\QuickSite\Services\quicksiteResponseService;
use Ayimdomnic\QuickSite\Services\ValidationService;

class FilesController extends quicksiteController
{
    /** @var FilesRepository */
    private $fileRepository;

    public function __construct(FileRepository $fileRepo)
    {
        $this->fileRepository = $fileRepo;
    }

    /**
     * Display a listing of the Files.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
    {
        $result = $this->fileRepository->paginated();

        return view('quicksite::modules.files.index')
            ->with('files', $result)
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

        $result = $this->fileRepository->search($input);

        return view('quicksite::modules.files.index')
            ->with('files', $result[0]->get())
            ->with('pagination', $result[2])
            ->with('term', $result[1]);
    }

    /**
     * Show the form for creating a new Files.
     *
     * @return Response
     */
    public function create()
    {
        return view('quicksite::modules.files.create');
    }

    /**
     * Store a newly created Files in storage.
     *
     * @param FileRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validation = ValidationService::check(File::$rules);

        if (!$validation['errors']) {
            $file = $this->fileRepository->store($request->all());
        } else {
            return $validation['redirect'];
        }

        quicksite::notification('File saved successfully.', 'success');

        return redirect(route('quicksite.files.index'));
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
            'location' => [],
        ]);

        if (!$validation['errors']) {
            $file = $request->file('location');
            $fileSaved = FileService::saveFile($file, 'files/');
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
     * Remove a file.
     *
     * @param string $id
     *
     * @return Response
     */
    public function remove($id)
    {
        try {
            Storage::delete($id);

            $response = quicksiteResponseService::apiResponse('success', 'success!');
        } catch (Exception $e) {
            $response = quicksiteResponseService::apiResponse('error', $e->getMessage());
        }

        return $response;
    }

    /**
     * Show the form for editing the specified Files.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $files = $this->fileRepository->findFilesById($id);

        if (empty($files)) {
            quicksite::notification('File not found', 'warning');

            return redirect(route('quicksite.files.index'));
        }

        return view('quicksite::modules.files.edit')->with('files', $files);
    }

    /**
     * Update the specified Files in storage.
     *
     * @param int         $id
     * @param FileRequest $request
     *
     * @return Response
     */
    public function update($id, FileRequest $request)
    {
        $files = $this->fileRepository->findFilesById($id);

        if (empty($files)) {
            quicksite::notification('File not found', 'warning');

            return redirect(route('quicksite.files.index'));
        }

        $files = $this->fileRepository->update($files, $request->all());

        quicksite::notification('File updated successfully.', 'success');

        return Redirect::back();
    }

    /**
     * Remove the specified Files from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $files = $this->fileRepository->findFilesById($id);

        if (empty($files)) {
            quicksite::notification('File not found', 'warning');

            return redirect(route('quicksite.files.index'));
        }

        Storage::delete($files->location);
        $files->delete();

        quicksite::notification('File deleted successfully.', 'success');

        return redirect(route('quicksite.files.index'));
    }

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

        $files = $this->fileRepository->apiPrepared();

        return quicksiteResponseService::apiResponse('success', $files);
    }
}
