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

              <form action="{{ url('admin/howitworks/'.$howitworks->id) }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="inputEmail4">Title</label>
                  <input type="text" name="title" value="{{$howitworks->title}}" class="form-control" placeholder="">
                  @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                  @endif
                </div>
                <div class="form-group col-md-4">
                  <label for="inputEmail4">Description</label>
                  <textarea name="description" class="form-control" placeholder="">{{$howitworks->description}}</textarea>
                  @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                  @endif
                </div>

              </div>



              
              <div class="form-row">

                <div class="form-group col-md-4">
                  <label for="inputEmail4">Image</label>
                  <input type="hidden" name="earlier_img" value="{{$howitworks->image}}" />  
                  <input type="file" name="image" class="form-control" placeholder="">
                  <img src="{{url('')}}/storage/app/howitworks/{{$howitworks->image}}" width="200" style="background-color: #cccccc;"/>
                  
                  @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                  @endif
                </div>
                
                <div class="form-group col-md-4">
                  <label for="inputEmail4">Back Image</label>
                  <input type="hidden" name="earlier_back_image" value="{{$howitworks->back_image}}" />  
                  <input type="file" name="back_image" class="form-control" placeholder="">
                  <img src="{{url('')}}/storage/app/howitworks/{{$howitworks->back_image}}" width="200" />
                  
                  @if ($errors->has('back_image'))
                    <span class="text-danger">{{ $errors->first('back_image') }}</span>
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