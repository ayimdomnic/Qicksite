<?php

namespace Yab\Quicksite\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Quicksite;
use Yab\Quicksite\Models\Archive;

class QuicksiteFeatureController extends QuicksiteController
{
    public function rollback($entity, $id)
    {
        $modelString = 'Yab\Quicksite\Models\\'.ucfirst($entity);

        if (!class_exists($modelString)) {
            $modelString = 'Yab\Quicksite\Models\\'.ucfirst($entity).'s';
        }
        if (!class_exists($modelString)) {
            $modelString = 'Quicksite\Modules\\'.ucfirst(str_plural($entity)).'.\Models\\'.ucfirst(str_plural($entity));
        }
        if (!class_exists($modelString)) {
            $modelString = 'Quicksite\Modules\\'.ucfirst(str_plural($entity)).'\Models\\'.ucfirst(str_singular($entity));
        }
        if (!class_exists($modelString)) {
            $modelString = 'Quicksite\Modules\\'.ucfirst(str_singular($entity)).'\Models\\'.ucfirst(str_singular($entity));
        }
        if (!class_exists($modelString)) {
            Quicksite::notification('Could not rollback Model not found', 'warning');

            return redirect(URL::previous());
        }

        $model = app($modelString);
        $modelInstance = $model->find($id);

        $archive = Archive::where('entity_id', $id)->where('entity_type', $modelString)->limit(1)->offset(1)->orderBy('id', 'desc')->first();

        if (!$archive) {
            Quicksite::notification('Could not rollback', 'warning');

            return redirect(URL::previous());
        }
        $archiveData = (array) json_decode($archive->entity_data);

        $modelInstance->fill($archiveData);
        $modelInstance->save();

        Quicksite::notification('Rollback was successful', 'success');

        return redirect(URL::previous());
    }

    /**
     * Preview content.
     *
     * @param string $entity
     * @param int    $id
     *
     * @return Response
     */
    public function preview($entity, $id)
    {
        $modelString = 'Ayimdomnic\Quicksite\Models\\'.ucfirst($entity);

        if (!class_exists($modelString)) {
            $modelString = 'Ayimdomnic\Quicksite\Models\\'.ucfirst($entity).'s';
        }

        $model = new $modelString();
        $modelInstance = $model->find($id);

        $data = [
            $entity => $modelInstance,
        ];

        if (request('lang') != config('quicksite.default-language', quicksite::config('quicksite.default-language'))) {
            if ($modelInstance->translation(request('lang'))) {
                $data = [
                    $entity => $modelInstance->translation(request('lang'))->data,
                ];
            }
        }

        $view = 'quicksite-frontend::'.$entity.'.show';

        if (!View::exists($view)) {
            $view = 'quicksite-frontend::'.$entity.'s.show';
        }

        if ($entity === 'page') {
            $view = 'quicksite-frontend::pages.'.$modelInstance->template;
        }

        return view($view, $data);
    }
}
