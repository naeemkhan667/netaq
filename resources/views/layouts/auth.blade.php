<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventory Management') }}</title>

    <!-- Scripts -->

    <script src="https://use.fontawesome.com/7e850a5a48.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <!--Custom Scripts and Css-->

    <link href="{{ asset('/sbadmin/css/styles.css') }}" rel="stylesheet" />

</head>

<body class="sb-nav-fixed bg-primary">
    @yield('navbar')


    @yield('sidebar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">
                    @yield('top-sub-heading')
                </h1>
                @yield('contents')
            </div>
        </main>

        @yield('footer')
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('/sbadmin/js/datatables-simple-demo.js') }}"></script>
</body>

</html>
