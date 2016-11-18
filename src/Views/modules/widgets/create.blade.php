@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Widgets</h1>
    </div>

    @include('quicksite::modules.widgets.breadcrumbs', ['location' => ['create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.widgets.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('widgets', Config::get('quicksite.forms.widget')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/widgets') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
