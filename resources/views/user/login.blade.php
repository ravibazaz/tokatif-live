@include('include/head')
@include('include/header')


<section class="signin-section">
<div class="container">
   <div class="container login-container">
            <div class="row">

                <div class="col-md-6 login-form-1 m-auto">
                    
                      @if(Session::get('success'))
                      <div class="alert alert-success alert-dismissible fade show">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> {{Session::get('success')}}</div>
                      @endif
                      @if(Session::get('error'))
                      <div class="alert alert-danger alert-dismissible fade show">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Note!</strong> {{Session::get('error')}}</div>
                      @endif
              
                    <h3>Log In</h3>
                       
                       <form action="{{route('post-login-data')}}" method="POST">
                       @csrf
                        <div class="form-group">
                            <label>Email Id / Phone Number</label>
                            <input type="text" name="username" class="form-control" placeholder="Your Email / Phone Number *" value="" />
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Your Password *" value="" />
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                                          
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                        </form>
                        
                        
                        <div class="form-group">
                            <a href="{{route('forgot-password')}}" class="btnForgetPwd">Forgot Your Password?</a>
                        </div> 
                        <div class="form-group you-dont">
                            Don't have an account! <a href="{{route('create-account')}}" class="btnForgetPwd">Sign Up Here </a>
                        </div> 
                         
                         
                </div>
            </div>
        </div>
    </div>
</section>




@include('include/footer')

