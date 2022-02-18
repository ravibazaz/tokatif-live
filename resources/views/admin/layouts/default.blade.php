<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('admin.includes.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    @include('admin.includes.header')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('admin.includes.sidebar')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    @include('admin.includes.footer')
  </footer>

  {{-- <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar --> --}}
</div>
<!-- ./wrapper -->

@include('admin.includes.lib')
@yield('script')
<script>
var baseUrl = "{!! url('/admin')!!}"
</script>
</body>
</html>
