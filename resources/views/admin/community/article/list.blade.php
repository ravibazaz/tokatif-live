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
                    <!--<a href="{{route('admin-article-add')}}" class="btn btn-primary"> Add  </a>-->
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
                  <th width="10%">Id</th>
                  <th width="15%">Title</th>
                  <th width="20%">Description</th>
                  <th width="10%">Added By</th>
                  <th width="20%">Image</th>
                  <th width="10%">Status</th>
                  <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($article as $a)
                  @php 
                    $exists = file_exists( storage_path() . '/app/article/' . $a->photo );
                    
                    $addedByData = DB::table('registrations')->where('id', $a->added_by)->first();
                  @endphp 
                    
                <tr>
                  <td>{{$a->id}}</td>
                  <td>{{$a->title}}</td> 
                  <td>{{$a->description}}</td>
                  <td>{{$addedByData->name}}</td>
                  <td>
                    @if($exists && $a->photo!='') 
                    <img class="img-bordered-sm" src={{url('storage/app/article/'.$a->photo)}} style="width: 100px;" alt="photo">
                    @else
                    <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="photo">   
                    @endif
                  </td>
                  <td>
                    @if($a->status=='1') 
                        @php $status = 'Approved'; @endphp
                    @elseif($a->status=='2') 
                        @php $status = 'New'; @endphp
                    @else
                        @php $status = 'Rejected'; @endphp
                    @endif
                    
                    {{$status}}
                  </td>
                  <td>
                    <!--<a href="{{route('admin-article-edit',['id'=>$a->id])}}" class="actionLink"><i class="fa fa-pencil-square-o"></i></a>-->
                    @if($a->status=='2') 
                    <a href="{{ route('admin-article-approve',['id'=>$a->id]) }}" onclick="return confirm('Do you want to approve this article?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> 
                    <a href="{{ route('admin-article-reject',['id'=>$a->id]) }}" onclick="return confirm('Do you want to reject this article?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Reject"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a> 
                    @endif
                    <a href="{{ route('admin-article-delete',['id'=>$a->id]) }}" onclick="return confirm('Are you sure?')" class="actionLink"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a> 
                  </td>
                </tr>
                @endforeach
               
                </tbody>
               
              </table>
              {{ $article->links() }}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
@endsection