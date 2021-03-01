<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>{{ config('app.name', 'Test') }}</title>
        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div id="app">
            <div id="main-container">
                <div id="welcome" class="no-select">
                    <h1><p class="big-bold">Welcome to Short Url App</p></h1>
                </div>
            </div>
        </div>
        <script type="application/javascript" src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
