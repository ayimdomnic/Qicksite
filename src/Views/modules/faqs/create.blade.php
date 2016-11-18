@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">FAQs</h1>
    </div>

    @include('quicksite::modules.faqs.breadcrumbs', ['location' => ['create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.faqs.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('faqs', Config::get('quicksite.forms.faqs')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/faqs') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
