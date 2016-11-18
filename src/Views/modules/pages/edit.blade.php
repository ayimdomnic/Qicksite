@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $page->translationData(request('lang')))
            @if (isset($page->translationData(request('lang'))->is_published))
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('page/'.$page->translationData(request('lang'))->url) !!}">Live</a>
            @else
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('quicksite/preview/page/'.$page->id.'?lang='.request('lang')) !!}">Preview</a>
            @endif
             <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/translation/'.$page->translation(request('lang'))->id) !!}">Rollback</a>
        @else
            @if ($page->is_published)
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('page/'.$page->url) !!}">Live</a>
            @else
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('quicksite/preview/page/'.$page->id) !!}">Preview</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/page/'.$page->id) !!}">Rollback</a>
        @endif

        <h1 class="page-header">Pages</h1>
    </div>

    @include('quicksite::modules.pages.breadcrumbs', ['location' => ['edit']])

    <div class="row raw-margin-bottom-24">
        <ul class="nav nav-tabs">
            @foreach(config('quicksite.languages', quicksite::config('quicksite.languages')) as $short => $language)
                <li role="presentation" @if (request('lang') == $short || is_null(request('lang')) && $short == quicksite::config('quicksite.default-language'))) class="active" @endif><a href="{{ url('quicksite/pages/'.$page->id.'/edit?lang='.$short) }}">{{ ucfirst($language) }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row">
        {!! Form::model($page, ['route' => ['quicksite.pages.update', $page->id], 'method' => 'patch', 'class' => 'edit']) !!}

            <input type="hidden" name="lang" value="{{ request('lang') }}">

            <div class="form-group">
                <label for="Template">Template</label>
                <select class="form-control" id="Template" name="template">
                    @foreach (PageService::getTemplatesAsOptions() as $template)

                        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $page->translationData(request('lang')))
                            <option @if($template === $page->translationData(request('lang'))->template) selected  @endif value="{!! $template !!}">{!! ucfirst(str_replace('-template', '', $template)) !!}</option>
                        @else
                            <option @if($template === $page->template) selected  @endif value="{!! $template !!}">{!! ucfirst(str_replace('-template', '', $template)) !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en'))
                {!! FormMaker::fromObject($page->translationData(request('lang')), Config::get('quicksite.forms.page')) !!}
            @else
                {!! FormMaker::fromObject($page, Config::get('quicksite.forms.page')) !!}
            @endif

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/pages') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
