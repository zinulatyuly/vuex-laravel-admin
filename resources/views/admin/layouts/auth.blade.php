<!DOCTYPE html>
<html lang="ru">

<head>
    @include('admin.partials.head')
</head>

<body class="page-header-fixed">
<div id="app">
    <div style="margin-top: 10%;"></div>

    <div class="container-fluid">
        @yield('content')
    </div>

    <div class="scroll-to-top"
         style="display: none;">
        <i class="fa fa-arrow-up"></i>
    </div>
</div>

    @include('admin.partials.javascripts')

</body>
</html>