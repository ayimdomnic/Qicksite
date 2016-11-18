@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $blog->translationData(request('lang')))
            @if (isset($blog->translationData(request('lang'))->is_published))
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('blog/'.$blog->translationData(request('lang'))->url) !!}">Live</a>
            @else
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('quicksite/preview/blog/'.$blog->id.'?lang='.request('lang')) !!}">Preview</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/translation/'.$blog->translation(request('lang'))->id) !!}">Rollback</a>
        @else
            @if ($blog->is_published)
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('blog/'.$blog->url) !!}">Live</a>
            @else
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('quicksite/preview/blog/'.$blog->id) !!}">Preview</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/blog/'.$blog->id) !!}">Rollback</a>
        @endif

        <h1 class="page-header">Blog</h1>
    </div>

    @include('quicksite::modules.blogs.breadcrumbs', ['location' => ['edit']])

    <div class="row raw-margin-bottom-24">
        <ul class="nav nav-tabs">
            @foreach(config('quicksite.languages', quicksite::config('quicksite.languages')) as $short => $language)
                <li role="presentation" @if (request('lang') == $short || is_null(request('lang')) && $short == quicksite::config('quicksite.default-language'))) class="active" @endif><a href="{{ url('quicksite/blog/'.$blog->id.'/edit?lang='.$short) }}">{{ ucfirst($language) }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row">
        {!! Form::model($blog, ['route' => ['quicksite.blog.update', $blog->id], 'method' => 'patch', 'class' => 'edit']) !!}

            <input type="hidden" name="lang" value="{{ request('lang') }}">

            <div class="form-group">
                <label for="Template">Template</label>
                <select class="form-control" id="Template" name="template">
                    @foreach (BlogService::getTemplatesAsOptions() as $template)
                        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $blog->translationData(request('lang')))
                            <option @if($template === $blog->translationData(request('lang'))->template) selected  @endif value="{!! $template !!}">{!! ucfirst(str_replace('-template', '', $template)) !!}</option>
                        @else
                            <option @if($template === $blog->template) selected  @endif value="{!! $template !!}">{!! ucfirst(str_replace('-template', '', $template)) !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en'))
                {!! FormMaker::fromObject($blog->translationData(request('lang')), Config::get('quicksite.forms.blog')) !!}
            @else
                {!! FormMaker::fromObject($blog, Config::get('quicksite.forms.blog')) !!}
            @endif

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/blog') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
