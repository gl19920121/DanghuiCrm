<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }}-@yield('title')</title>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/my.css') }}">

        <script src="{{ mix('js/app.js') }}"></script>
    </head>

    <body class="@if(Route::currentRouteName() === 'login') login-bg-{{ $bgNum }} @else main-bg @endif">
        @includeWhen(Route::currentRouteName() !== 'login', 'layouts._header')
        <div class="container">
            @includeWhen(Route::currentRouteName() !== 'login', 'shared._messages')
            @yield('content')
            @includeWhen(Route::currentRouteName() !== 'login', 'layouts._footer')
        </div>

        <script src="{{ mix('js/my.js') }}"></script>
        <script type="text/javascript">
          $(function () {
            @if (count($errors) > 0)
                $('#errModal').modal();
            @else
                $('#msgModal').modal();
            @endif
          });
        </script>
    </body>
</html>
