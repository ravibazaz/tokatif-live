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
                  <form action="{{route('admin-teacher-search')}}" method="POST">
                    @csrf
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 amber-border" type="text" placeholder="Search" aria-label="Search" name="q" value={{ app('request')->input('q') }}>
                    <div class="input-group-append">
                      <button class="btn input-group-text amber lighten-3"><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                      <!-- <span class="input-group-text amber lighten-3" id="basic-text1"><i class="fas fa-search text-grey"
                          aria-hidden="true"></i></span> -->
                    </div>
                  </div>
                  </form>
                </div>

                <div class="col-md-2 mb-2">
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <!--<a href="" class="btn btn-primary"> Add </a>-->
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
                  <th>Teacher Type</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone </th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teachers as $a)
                <tr>
                  <td>{{$a->id}}</td>
                  <td>{{$a->teacher_type}}</td>
                  <td>{{$a->name}}</td>
                  <td>{{$a->email}}</td>
                  <td>{{$a->phone_number}}</td>
                  <td>{{$a->address}}</td>
                  <td>
                     @if($a->status=='0')
                     <a href="{{ route('admin-teacher-approve',['id'=>$a->id]) }}" onclick="return confirm('Are you sure?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> 
                     @endif
                     
                    <a href="{{route('admin-teacher-details',['id'=>$a->id]) }}" class="actionLink" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin-teacher-delete',['id'=>$a->id]) }}" onclick="return confirm('Are you sure?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a> 
                  </td>
                </tr>
                @endforeach
               
                </tbody>
               
              </table>
              {{ $teachers->links() }}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
@endsection