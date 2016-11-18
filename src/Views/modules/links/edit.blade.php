@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Links</h1>
    </div>

    @include('quicksite::modules.links.breadcrumbs', ['location' => [['Menu' => URL::to('quicksite/menus/'.$links->menu_id.'/edit')], 'links', 'edit']])

    <div class="row">
        {!! Form::model($links, ['route' => ['quicksite.links.update', $links->id], 'method' => 'patch', 'class' => 'edit']) !!}

            {!! FormMaker::fromObject($links, Config::get('quicksite.forms.link')) !!}

            <div class="form-group" style="display: none;">
                <label for="Page_id">Page</label>
                <select class="form-control" id="Page_id" name="page_id">
                    @foreach (PageService::getPagesAsOptions() as $key => $value)
                        <option @if($value === $links->page_id) selected  @endif value="{!! $value !!}">{!! $key !!}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(quicksite::asset('js/links-module.js', 'application/javascript')) !!}

@stop
