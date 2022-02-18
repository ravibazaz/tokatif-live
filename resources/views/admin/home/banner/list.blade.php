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
          

          <div class="card">
            <div class="card-header">
               <div class="row">
                <div class="col-md-5 mb-5">
                   <div class="input-group md-form form-sm form-2 pl-0">
                    <h3 class="card-title">{{$title}}</h3>
                  </div>
                </div>

                <div class="col-md-5 mb-5">
                  
                </div>

                <div class="col-md-2 mb-2">
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <a href="{{route('admin-home-banner-add')}}" class="btn btn-primary"> Add Banner </a>
                  </div>
                </div>


              </div>
            </div>
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
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $a)
                  @php 
                    $exists = file_exists( storage_path() . '/app/home_banner/' . $a->image );
                  @endphp 
                    
                <tr>
                  <td>{{$a->id}}</td>
                  <td>
                    @if($exists && $a->image!='') 
                    <img class="img-bordered-sm" src={{url('storage/app/home_banner/'.$a->image)}} style="width: 100px;" alt="user image">
                    @else
                    <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="user image">   
                    @endif
                  </td>
                  <td>
                    <a href="{{route('admin-home-banner-edit',['id'=>$a->id])}}" class="actionLink"><i class="fa fa-pencil-square-o"></i></a>
                    <a href="{{ route('admin-home-banner-delete',['id'=>$a->id]) }}" onclick="return confirm('Are you sure?')" class="actionLink"><i class="fa fa-trash"></i></a> 
                  </td>
                </tr>
                @endforeach
               
                </tbody>
               
              </table>
              {{ $banners->links() }}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
@endsection