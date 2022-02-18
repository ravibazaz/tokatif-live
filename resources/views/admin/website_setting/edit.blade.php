@extends('admin.layouts.default')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{$title}}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          @include('admin.includes.breadcrumb',['breadcrumb'=>$breadcrumb])
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <section class="content">
    <div class="row">
        <div class="col-12">
          
          @if(Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{Session::get('success')}}
          </div>
          @endif
          @if(Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Note!</strong> {{Session::get('error')}}
          </div>
          @endif

          <div class="card">
            <div class="card-header">
               <!-- <div class="row">
                <div class="col-md-12">
                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $message)
                                  <li>{{ $message }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
                </div>
              </div> -->
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">

              <form action="{{ url('admin/website-setting/'.$website_setting->id) }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Website Name</label>
                  <input type="text" name="website" value="{{$website_setting->website}}" class="form-control" placeholder="">
                  @if ($errors->has('website'))
                    <span class="text-danger">{{ $errors->first('website') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Website Logo</label>
                  <input type="hidden" name="earlier_logo" value="{{$website_setting->logo}}" />  
                  <input type="file" name="logo" class="form-control" placeholder="">
                  <img src="{{url('')}}/storage/app/imagesdoc/{{$website_setting->logo}}" width="200" />
                  
                  @if ($errors->has('logo'))
                    <span class="text-danger">{{ $errors->first('logo') }}</span>
                  @endif
                </div>
              </div>



              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Footer Logo</label>
                  <input type="file" name="footer_logo" class="form-control" placeholder="">
                  <input type="hidden" name="earlier_footer_logo" value="{{$website_setting->footer_logo}}" /> 
                  <img src="{{url('')}}/storage/app/imagesdoc/{{$website_setting->footer_logo}}" width="200" />
                  
                  @if ($errors->has('footer_logo'))
                    <span class="text-danger">{{ $errors->first('footer_logo') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Website Favicon</label>
                  <input type="file" name="favicon" class="form-control" placeholder="">
                  <input type="hidden" name="earlier_favicon" value="{{$website_setting->favicon}}" /> 
                  <img src="{{url('')}}/storage/app/{{$website_setting->favicon}}" width="60" />
                  
                  @if ($errors->has('favicon'))
                    <span class="text-danger">{{ $errors->first('favicon') }}</span>
                  @endif
                </div>
              </div>
              
              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Facebook Link</label>
                  <input type="text" class="form-control" name="facebook_link" id="facebook_link" value="{{$website_setting->facebook_link}}" >
                  @if ($errors->has('facebook_link'))
                    <span class="text-danger">{{ $errors->first('facebook_link') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Linkedin Link</label>
                  <input type="text" class="form-control" name="linkedin_link" id="linkedin_link" value="{{$website_setting->linkedin_link}}" >
                  @if ($errors->has('linkedin_link'))
                    <span class="text-danger">{{ $errors->first('linkedin_link') }}</span>
                  @endif
                </div>
              </div>
              
              
              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Twitter Link</label>
                  <input type="text" class="form-control" name="twitter_link" id="twitter_link" value="{{$website_setting->twitter_link}}" >
                  @if ($errors->has('facebook_link'))
                    <span class="text-danger">{{ $errors->first('twitter_link') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Pininterest Link</label>
                  <input type="text" class="form-control" name="pininterest_link" id="pininterest_link" value="{{$website_setting->pininterest_link}}" >
                  @if ($errors->has('pininterest_link'))
                    <span class="text-danger">{{ $errors->first('pininterest_link') }}</span>
                  @endif
                </div>
              </div>
              
              
              
              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Copyright Content</label>
                  <textarea class="form-control" name="copyright_content" id="copyright_content">{{$website_setting->copyright_content}}</textarea>
                  @if ($errors->has('copyright_content'))
                    <span class="text-danger">{{ $errors->first('copyright_content') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Footer Content Below Logo</label>
                  <textarea class="form-control" name="footer_content" id="footer_content">{{$website_setting->footer_content}}</textarea>
                  @if ($errors->has('footer_content'))
                    <span class="text-danger">{{ $errors->first('footer_content') }}</span>
                  @endif
                </div>
              </div>




              
            

              <div class="form-group">
                <br><button type="submit" class="btn btn-primary">Submit</button>
              </div>

              </form>


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
@endsection