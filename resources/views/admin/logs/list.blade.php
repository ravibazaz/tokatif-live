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
                <div class="col-md-6 mb-6">
                   <div class="input-group md-form form-sm form-2 pl-0">
                    <h3 class="card-title">{{$title}}</h3>
                  </div>
                 </div>
                <div class="col-md-6 mb-6">
                  <form >
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 amber-border" type="text" placeholder="Search" aria-label="Search" name="q" value={{ app('request')->input('q') }}>
                    <div class="input-group-append">
                      <span class="input-group-text amber lighten-3" id="basic-text1"><i class="fas fa-search text-grey"
                          aria-hidden="true"></i></span>
                    </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            @if(Session::get('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::get('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>User Type</th> 
                  <th>Log Type</th> 
                  <th>Name</th>
                  <th>Log Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $a)

                <tr style="color: {{$a['row_color']}};">
                  <td>{{$a['type']}}</td>
                  <td>{{$a['logType']}}</td>
                  <td>{{$a['name']}}</td>
                  <td>{{date('d-M-Y H:i:s', strtotime($a['created_at']))}}</td>
                </tr>
                @endforeach
               
                </tbody>
               
              </table>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
@endsection