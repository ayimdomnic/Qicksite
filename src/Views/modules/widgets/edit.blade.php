@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $widgets->translationData(request('lang')))
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/translation/'.$widgets->translation(request('lang'))->id) !!}">Rollback</a>
        @else
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/widget/'.$widgets->id) !!}">Rollback</a>
        @endif
        <h1 class="page-header">Widgets</h1>
    </div>

    @include('quicksite::modules.widgets.breadcrumbs', ['location' => ['edit']])

    <div class="row raw-margin-bottom-24">
        <ul class="nav nav-tabs">
            @foreach(config('quicksite.languages', quicksite::config('quicksite.languages')) as $short => $language)
                <li role="presentation" @if (request('lang') == $short || is_null(request('lang')) && $short == quicksite::config('quicksite.default-language'))) class="active" @endif><a href="{{ url('quicksite/widgets/'.$widgets->id.'/edit?lang='.$short) }}">{{ ucfirst($language) }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row">
        {!! Form::model($widgets, ['route' => ['quicksite.widgets.update', $widgets->id], 'method' => 'patch', 'class' => 'edit']) !!}

            <input type="hidden" name="lang" value="{{ request('lang') }}">

            @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en'))
                <input type="hidden" name="name" value="{{ $widgets->name }}">
                <input type="hidden" name="slug" value="{{ $widgets->slug }}">
                <div class="form-group">
                    <label class="control-label" for="Content">Content</label>
                    <textarea id="Content" class="form-control redactor" name="content" placeholder="Content" dir="ltr">
                        {{ $widgets->translationData(request('lang'))->content }}
                    </textarea>
                </div>
            @else
                {!! FormMaker::fromObject($widgets, Config::get('quicksite.forms.widget')) !!}
            @endif

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/widgets') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
