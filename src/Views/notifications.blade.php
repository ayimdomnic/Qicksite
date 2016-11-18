
@if (Session::has("notification"))
    quicksiteNotify("{{ Session::get("notification") }}", "{{ Session::get("notificationType") }}");
@endif

@if (Session::has("message"))
    quicksiteNotify("{{ Session::get("message") }}", "alert-info");
@endif

@if (Session::has("errors"))
    @foreach ($errors->all() as $error)
        quicksiteNotify("{{ $error }}", "alert-danger");
    @endforeach
@endif