<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Shopify Apparel21 Connector</title>
    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/1.4.1/polaris.min.css" />
    @stack('head')
    @include('shopify::partials.app_config')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>