<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="{{ asset('/images/favicons/browserconfig.xml') }}">
        <meta name="theme-color" content="#2a095f">
        <meta name="description" content="Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://fortnitestatstracker.xyz">
        <meta property="og:title" content="Find your Fortnite stats now!">
        <meta property="og:description" content="Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day!">
        <meta property="og:image" content="{{ asset('images/favicons/android-chrome-256x256.png') }}">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="https://fortnitestatstracker.xyz">
        <meta name="twitter:title" content="Find your Fortnite stats now!">
        <meta name="twitter:description" content="Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day!">
        <meta name="twitter:image" content="{{ asset('images/favicons/android-chrome-256x256.png') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Staatliches&display=swap" rel="stylesheet">

        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/images/favicons/site.json') }}">
        <link rel="mask-icon" href="{{ asset('/images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/566002e451.js" crossorigin="anonymous"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-J0WXGSPS89"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-J0WXGSPS89');
        </script>
    </head>
    <body class="font-fortnite antialiased">
        @inertia
    </body>
</html>
