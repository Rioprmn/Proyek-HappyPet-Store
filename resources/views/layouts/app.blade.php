<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HappyPet Store</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    


</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

</body>
</html>
