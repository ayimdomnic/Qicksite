@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Blog</h1>
    </div>

    @include('quicksite::modules.blogs.breadcrumbs', ['location' => ['create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.blog.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('blogs', Config::get('quicksite.forms.blog')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/blog') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
