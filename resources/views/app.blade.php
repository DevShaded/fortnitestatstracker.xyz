<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="keywords" content="Fortnite, Fortnite Stats Tracker, Stats Tracker, Stats, Tracker"/>
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="{{ asset('/favicons/browserconfig.xml') }}">
        <meta name="theme-color" content="#2a095f">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Staatliches&display=swap" rel="stylesheet">

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/favicons/site.json') }}">
        <link rel="mask-icon" href="{{ asset('/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/566002e451.js" crossorigin="anonymous"></script>

        @if(config('app.env') === 'production')
            <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=G-J0WXGSPS89"></script>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());

                    gtag('config', 'G-J0WXGSPS89');
                </script>

                <!-- Google AdSense -->
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7348431632024620"
                        crossorigin="anonymous"></script>
        @endif
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="bg-dark-purple font-fortnite antialiased">
        @inertia
    </body>
</html>
