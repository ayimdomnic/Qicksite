@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header text-center">Help</h1>

            <h2>Published Assets</h2>
            <p>quicksite publishes views and controllers within your application. This allows you to control everything you want. You will find the controllers in: <code>app/Http/Controllers/quicksite</code> and the views in: <code>resources/themes</code>. There is also the quicksite config which is added to your app's config directory.</p>
            <p>quicksite will also be able to generate cutom modules which you can find in the following directory: <code>quicksite/modules</code></p>
            <p>To generate these files simple run:</p>
            <pre>php artisan vendor:publish</pre>

            <h2>Multilingual</h2>
            <p>quicksite is fully multilingual all you need to do is set the languages in your <code>config/quicksite.php</code> file and then in your app just set the <code>locale</code> and poof! you have multi-language support.</p>

            <h2>API Endpoints</h2>
            <p>quicksite comes with a very basic API. It provides access to all published public facing data. You can define details in your quicksite API middleware.</p>

            <p>Out of the box quicksite API requires use of the <code>api-token</code> set in the config of your app.</p>

            <p>All requests should have the following added to the url: <code>?token={config.quicksite.apiToken}</code></p>

            <pre>/quicksite/api/blog
/quicksite/api/blog/{id}
/quicksite/api/events
/quicksite/api/events/{id}
/quicksite/api/faqs
/quicksite/api/faqs/{id}
/quicksite/api/files
/quicksite/api/files/{id}
/quicksite/api/images
/quicksite/api/images/{id}
/quicksite/api/pages
/quicksite/api/pages/{id}
/quicksite/api/widgets
/quicksite/api/widgets/{id}</pre>

            <h2>Console Commands</h2>
            <p>quicksite comes with a few console commands to handle things like module building and publishing</p>
            <p>You can also build simple modules which will run inside quicksite. Simply provide a table name you wish to manage and allow quicksite to build a CRUD structure that works inside quicksite's module directory.</p>
            <p>You need to add the following line in the autoload PSR-4 group to your composer file to ensure that all modules will work correctly:</p>
            <pre>"quicksite\\Modules\\": "quicksite/modules/",</pre>

            <h3>Modules</h3>
            <p>The commmand for generating custom modules for quicksite is:</p>
            <pre>php artisan module:crud {name} {--schema="id:increments,name:string"}</pre>
            <pre>php artisan module:make {name}</pre>
            <p>The migration option will generate a migration file that can be found in the module. You will then need to run the module migrate to get the module to run its migration course.</p>

            <h3>Publish</h3>
            <p>quicksite also lets you publish assets that belong to a module. So in the chance you wish to build your own modules for future projects you can easily publish specific assets to any applications you build.</p>
            <pre>php artisan module:publish {module}</pre>

            <h2>Front-End Code</h2>
            <p>quicksite automatically builds you a sample of the controllers, and views for your application's pages, blog, faqs, etc. You can run the following services as method calls or use the blade directives listed below:</p>

            <pre>quicksite::widget('slug') // Renders the widget</pre>
            <pre>quicksite::menu('slug', 'custom-view-path') // Renders the menu</pre>
            <pre>quicksite::images('tag') // Outputs an array of images with matching tags if no tag defined all images are returned</pre>

            <h2>Custom Templates</h2>
            <p>By default the homepage has its own template but you can add any by following these details: To create custom templates for different purposes simply make a view in the <code>resources/themes/{theme}/{module}</code> directory that looks similar to: <code>xxxx-template.blade.php</code>. This means you still have full control of blade templating but your pages can easily swap out views.</p>

            <h2>Custom Blade Components</h2>
            <p>By default the quicksite has the default theme. You can override this in the <code>config/quicksite.php</code> file. The theme has the namespace of: <code>quicksite-frontend::</code>, and has some Blade directives such as:</p>

            <pre>&#64;theme('path') // includes file within the theme path</pre>
            <pre>&#64;menu('slug') // menu rendering</pre>
            <pre>&#64;widget('slug') // widget contents</pre>
            <pre>&#64;images('tag') // images</pre>
            <pre>&#64;edit('module', 'id') // a link to edit a module or item on the front-end of the site</pre>

            <p>You can generate new themes and publish thier public assets. Consult the <a target="_blank" href="http://quicksite.info/themes">documentation</a> for more information about themes etc.</p>
    </div>

@stop