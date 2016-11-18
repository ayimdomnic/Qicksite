@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en') && $faq->translationData(request('lang')))
            @if (isset($faq->translationData(request('lang'))->is_published))
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('faqs') !!}">Live</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/translation/'.$faq->translation(request('lang'))->id) !!}">Rollback</a>
        @else
            @if ($faq->is_published)
                <a class="btn btn-default pull-right raw-margin-left-8" href="{!! URL::to('faqs') !!}">Live</a>
            @endif
            <a class="btn btn-warning pull-right raw-margin-left-8" href="{!! URL::to('quicksite/rollback/faq/'.$faq->id) !!}">Rollback</a>
        @endif

        <h1 class="page-header">FAQs</h1>
    </div>

    @include('quicksite::modules.faqs.breadcrumbs', ['location' => ['edit']])

    <div class="row raw-margin-bottom-24">
        <ul class="nav nav-tabs">
            @foreach(config('quicksite.languages', quicksite::config('quicksite.languages')) as $short => $language)
                <li role="presentation" @if (request('lang') == $short || is_null(request('lang')) && $short == quicksite::config('quicksite.default-language'))) class="active" @endif><a href="{{ url('quicksite/faqs/'.$faq->id.'/edit?lang='.$short) }}">{{ ucfirst($language) }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row">
        {!! Form::model($faq, ['route' => ['quicksite.faqs.update', $faq->id], 'method' => 'patch', 'class' => 'edit']) !!}

            <input type="hidden" name="lang" value="{{ request('lang') }}">

            @if (! is_null(request('lang')) && request('lang') !== config('quicksite.default-language', 'en'))
                {!! FormMaker::fromObject($faq->translationData(request('lang')), Config::get('quicksite.forms.faqs')) !!}
            @else
                {!! FormMaker::fromObject($faq, Config::get('quicksite.forms.faqs')) !!}
            @endif

            <div class="form-group text-right">
                <a href="{!! URL::to('quicksite/faqs') !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>

@endsection
