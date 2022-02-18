<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.includes.head')
</head>
<body class="hold-transition login-page">

    <!-- Content Header (Page header) -->
   @yield('content')
  

@include('admin.includes.lib')
</body>
</html>
