<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            RD BLT
        </title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
    </head>
    <body class="container px-4 py-5">
       <div class="row">
           <div class="col col-12 border-bottom mb-1">
                <h2>
                    @yield('breadcrumb')
                </h2>
           </div>
           @include('layout.flash')
           <div class="col col-12 mt-1">
                @yield('content')
           </div>
       </div>
    </body>

    <script src="{{ mix('js/app.js') }}" defer></script>
</html>
