@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Menus</h1>
    </div>

    @include('quicksite::modules.menus.breadcrumbs', ['location' => ['create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.menus.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('menus', Config::get('quicksite.forms.menu')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/menus') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection

