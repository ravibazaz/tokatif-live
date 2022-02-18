@include('include/head')
@include('include/header')


<section class="signin-section">
    <div class="container">
        <div class="login-container">
            <div class="card login-form">
            	<div class="card-body">
            		<h3 class="card-title text-center">Reset your password</h3>
            		
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
                          
                          
            			<form action="{{ url('reset-password/'.$q) }}" method="POST"> 
                            @csrf
            				<input type="hidden" name="u_id" value="{{$id}}" />
                            <input type="hidden" name="u_token" value="{{$q}}" />
            				<div class="form-group">
            					<label for="">New Password</label>
            					<input type="password" name="npassword" value="{{Request::old('npassword')}}" class="form-control form-control-sm">
            					@if ($errors->has('npassword'))
                                    <span class="text-danger">{{ $errors->first('npassword') }}</span>
                                @endif
            				</div>
            				<div class="form-group">
            					<label for="">Retype Password</label>
            					<input type="password" name="rpassword" value="{{Request::old('rpassword')}}" class="form-control form-control-sm">
            					@if ($errors->has('rpassword'))
                                    <span class="text-danger">{{ $errors->first('rpassword') }}</span>
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

