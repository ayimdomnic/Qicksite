@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Events</h1>
    </div>

    @include('quicksite::modules.events.breadcrumbs', ['location' => ['create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.events.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('events', Config::get('quicksite.forms.event')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/events') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
