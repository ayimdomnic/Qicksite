@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Menus</h1>
    </div>

    @include('quicksite::modules.menus.breadcrumbs', ['location' => ['edit']])

    <div class="row">
        {!! Form::model($menu, ['route' => ['quicksite.menus.update', $menu->id], 'method' => 'patch', 'class' => 'edit']) !!}

            {!! FormMaker::fromObject($menu, Config::get('quicksite.forms.menu')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/menus') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

    <div class="row">
        <div class="col-12">
            <a class="btn btn-info pull-right" href="{!! URL::to('quicksite/links/create?m='.$menu->id) !!}">Add Link</a>
            <h1>Links</h1>
            @include('quicksite::modules.links.index')
        </div>
    </div>

@endsection

