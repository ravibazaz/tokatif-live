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
            <strong>Success!</strong> {{Session::get('success')}}</div>
          @endif
          @if(Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Note!</strong> {{Session::get('error')}}</div>
          @endif

          <div class="card">
            <div class="card-header">
               <div class="row">
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
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">

              <form action="{{ url('admin/privacy/add') }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              
                <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Title</label>
                      <input type="text" name="title" value="{{Request::old('title')}}" class="form-control" placeholder="">
                      @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Description</label>
                      <textarea name="description" id="description" rows="6" class="form-control" placeholder=""></textarea>
                      @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
<!-- CKeditor -->
<script type="text/javascript" src="{{url('public/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        CKEDITOR.replace( 'description',{
            allowedContent : true,
            height: '200px',
            extraPlugins: 'uploadimage',
            uploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            filebrowserUploadUrl: '{{url('admin/ck-editor/upload_file')}}',
            filebrowserImageUploadUrl: '{{url('admin/ck-editor/upload_file')}}',
        });
    });
</script>