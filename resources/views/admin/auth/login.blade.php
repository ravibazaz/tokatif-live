@extends('admin.layouts.auth')
<!-- Content Header (Page header) -->
@section('content')
    


<div class="login-box">
 @include('admin.includes.auth_logo')
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
    @if(Session::get('error'))
    <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif
     @if(Session::get('success'))
    <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    <form action="{{URL::route('admin-login')}}" method="post">
      @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
         
        </div>
        @error('username')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="row">
          <div class="col-8">
            <!-- <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> -->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="{{route('admin-forgot-password')}}">I forgot my password</a>
      </p> 
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
  @endsection