@include('include/head')
@include('include/header')


<section class="signin-section">
    <div class="container">
        <div class="login-container">
            <div class="card login-form">
            	<div class="card-body">
            		<h3 class="card-title text-center">Forgot your password?</h3>
            		
            		<!--Password must contain one lowercase letter, one number, and be at least 7 characters long.-->
            		
            		<div class="card-text">
            		    
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
                          
            			<form action="{{route('post-forgot-password-data')}}" method="POST">
                        @csrf
            				<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                              <a class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </a>
                            </div>-->
            				<div class="form-group">
            					<label for="exampleInputEmail1">Email</label>
            					<input type="email" name="email" class="form-control form-control-sm">
            					@if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
            				</div>
            				<button type="submit" class="btn btn-primary btn-block submit-btn">Confirm</button>
            			</form>
            		</div>
            	</div>
            </div>     
        </div>
    </div>
</section>



@include('include/footer')




