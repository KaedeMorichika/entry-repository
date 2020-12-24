<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <link rel="stylesheet" href="css/general.css">
    <title>@yield('title')</title>
</head>
<body>
    @yield('header')
    <h1>@yield('title')</h1>
    @yield('content')
</body>
</html>