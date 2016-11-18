@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Images</h1>
    </div>

    @include('quicksite::modules.images.breadcrumbs', ['location' => ['edit']])

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="thumbnail ">
                <img src="{!! FileService::filePreview($images->location) !!}" />
            </div>
        </div>
    </div>

    <div class="row">
        {!! Form::model($images, ['route' => ['quicksite.images.update', $images->id], 'method' => 'patch', 'files' => true, 'class' => 'edit']) !!}

            {!! FormMaker::fromObject($images, Config::get('quicksite.forms.images-edit')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/images') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
