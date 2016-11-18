@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $event->translationData(request('lang')))
            @if (isset($event->translationData(request('lang'))->is_published))
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('events/event/'.$event->id) !!}">Live</a>
            @else
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('quicksite/preview/event/'.$event->id.'?lang='.request('lang')) !!}">Preview</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/translation/'.$event->translation(request('lang'))->id) !!}">Rollback</a>
        @else
            @if ($event->is_published)
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('events/event/'.$event->id) !!}">Live</a>
            @else
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('quicksite/preview/event/'.$event->id) !!}">Preview</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/event/'.$event->id) !!}">Rollback</a>
        @endif
        <h1 class="page-header">Events</h1>
    </div>

    @include('quicksite::modules.events.breadcrumbs', ['location' => ['edit']])

    <div class="row raw-margin-bottom-24">
        <ul class="nav nav-tabs">
            @foreach(config('quicksite.languages', quicksite::config('quicksite.languages')) as $short => $language)
                <li role="presentation" @if (request('lang') == $short || is_null(request('lang')) && $short == quicksite::config('quicksite.default-language'))) class="active" @endif><a href="{{ url('quicksite/events/'.$event->id.'/edit?lang='.$short) }}">{{ ucfirst($language) }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row">
        {!! Form::model($event, ['route' => ['quicksite.events.update', $event->id], 'method' => 'patch', 'class' => 'edit']) !!}

            <div class="form-group">
                <label for="Template">Template</label>
                <select class="form-control" id="Template" name="template">
                    @foreach (EventService::getTemplatesAsOptions() as $template)
                        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $event->translationData(request('lang')))
                            <option @if($template === $event->translationData(request('lang'))->template) selected  @endif value="{!! $template !!}">{!! ucfirst(str_replace('-template', '', $template)) !!}</option>
                        @else
                            <option @if($template === $event->template) selected  @endif value="{!! $template !!}">{!! ucfirst(str_replace('-template', '', $template)) !!}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="lang" value="{{ request('lang') }}">

            @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en'))
                {!! FormMaker::fromObject($event->translationData(request('lang')), Config::get('quicksite.forms.event')) !!}
            @else
                {!! FormMaker::fromObject($event, Config::get('quicksite.forms.event')) !!}
            @endif

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/events') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
