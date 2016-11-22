<ul class="nav nav-sidebar">
    <li class="@if (Request::is('quicksite/dashboard')) active @endif">
        <a href="{!! url('quicksite/dashboard') !!}"><span class="fa fa-dashboard"></span> Dashboard</a>
    </li>

    @if (in_array('images', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/images') || Request::is('quicksite/images/*')) active @endif">
            <a href="{!! url('quicksite/images') !!}"><span class="fa fa-image"></span> Images</a>
        </li>
    @endif

    @if (in_array('files', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/files') || Request::is('quicksite/files/*')) active @endif">
            <a href="{!! url('quicksite/files') !!}"><span class="fa fa-file"></span> Files</a>
        </li>
    @endif

    @if (in_array('blog', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/blog') || Request::is('quicksite/blog/*')) active @endif">
            <a href="{!! url('quicksite/blog') !!}"><span class="fa fa-pencil"></span> Blog</a>
        </li>
    @endif

    @if (in_array('menus', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/menus') || Request::is('quicksite/menus/*') || Request::is('quicksite/links') || Request::is('quicksite/links/*')) active @endif">
            <a href="{!! url('quicksite/menus') !!}"><span class="fa fa-link"></span> Menus</a>
        </li>
    @endif

    @if (in_array('pages', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/pages') || Request::is('quicksite/pages/*')) active @endif">
            <a href="{!! url('quicksite/pages') !!}"><span class="fa fa-file-text-o"></span> Pages</a>
        </li>
    @endif

    @if (in_array('widgets', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/widgets') || Request::is('quicksite/widgets/*')) active @endif">
            <a href="{!! url('quicksite/widgets') !!}"><span class="fa fa-gear"></span> Widgets</a>
        </li>
    @endif

    @if (in_array('faqs', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/faqs') || Request::is('quicksite/faqs/*')) active @endif">
            <a href="{!! url('quicksite/faqs') !!}"><span class="fa fa-question"></span> FAQs</a>
        </li>
    @endif

    @if (in_array('events', Config::get('quicksite.active-core-modules', quicksite::defaultModules())))
        <li class="@if (Request::is('quicksite/events') || Request::is('quicksite/events/*')) active @endif">
            <a href="{!! url('quicksite/events') !!}"><span class="fa fa-calendar"></span> Events</a>
        </li>
    @endif

    {!! ModuleService::menus() !!}
    {!! QuickSite::packageMenus() !!}

    @if (Route::get('user/settings'))
        <li class="@if (Request::is('user/settings') || Request::is('user/password')) active @endif">
            <a href="{!! url('user/settings') !!}"><span class="fa fa-gear"></span> Settings</a>
        </li>
    @endif

    <li class="@if (Request::is('quicksite/help')) active @endif">
        <a href="{!! url('quicksite/help') !!}"><span class="fa fa-info-circle"></span> Help</a>
    </li>

    @if (Route::get('admin/users')) <li class="sidebar-header"><span>Admin</span></li> @endif

    @if (Route::get('admin/users'))
        <li class="@if (Request::is('admin/users') || Request::is('admin/users/*')) active @endif">
            <a href="{!! url('admin/users') !!}"><span class="fa fa-users"></span> Users</a>
        </li>
    @endif
    @if (Route::get('admin/roles'))
        <li class="@if (Request::is('admin/roles') || Request::is('admin/roles/*')) active @endif">
            <a href="{!! url('admin/roles') !!}"><span class="fa fa-lock"></span> Roles</a>
        </li>
    @endif
</ul>