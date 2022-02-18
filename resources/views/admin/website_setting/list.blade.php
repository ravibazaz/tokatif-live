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

                <!--<div class="col-md-5 mb-5">
                  <form action="{{route('admin-teacher-search')}}" method="POST">
                    @csrf
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 amber-border" type="text" placeholder="Search" aria-label="Search" name="q" value={{ app('request')->input('q') }}>
                    <div class="input-group-append">
                      <button class="btn input-group-text amber lighten-3"><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                      <span class="input-group-text amber lighten-3" id="basic-text1"><i class="fas fa-search text-grey"
                          aria-hidden="true"></i></span>
                    </div>
                  </div>
                  </form>
                </div>-->

                <!--<div class="col-md-2 mb-2">
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <a href="" class="btn btn-primary"> Add Customer </a>
                  </div>
                </div>-->


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
                  <th>Logo</th>
                  <th>Social Links</th>
                  <th>Copyright</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($website_setting as $a)
                  
                  @php 
                    $exists = file_exists( storage_path() . '/app/imagesdoc/' . $a->logo );
                  @endphp 
                
                <tr>
                  <td>{{$a->id}}</td>
                  <td>
                    @if($exists && $a->logo!='') 
                    <img class="img-bordered-sm" src={{url('storage/app/imagesdoc/'.$a->logo)}} style="width: 100px;" alt="user image">
                    @else
                    <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="user image">   
                    @endif
                  </td>
                  <td>
                      <b>Facebook:</b> {{$a->facebook_link}} <br>
                      <b>Linkedin:</b> {{$a->linkedin_link}} <br>
                      <b>Twitter:</b> {{$a->twitter_link}} <br>
                      <b>Pininterest:</b> {{$a->pininterest_link}} <br>
                  </td>
                  <td>{{$a->copyright_content}}</td>
                  <td>
                    <a href="{{route('admin-website-setting-edit',['id'=>$a->id])}}" class="actionLink"><i class="fa fa-pencil-square-o"></i></a>
                  </td>
                </tr>
                @endforeach
               
                </tbody>
               
              </table>
              {{ $website_setting->links() }}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
@endsection