@extends('quicksite::layouts.dashboard')

@section('content')
    <div class="row">
        <h1 class="page-header">Pages</h1>
    </div>

    @include('quicksite::modules.pages.breadcrumbs', ['location' => ['create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.pages.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('pages', Config::get('quicksite.forms.page')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/pages') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection
