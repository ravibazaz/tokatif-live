@extends('admin.layouts.default')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{$title}}</h1>
        </div>
        <div class="col-sm-6">
           @include('admin.includes.breadcrumb',['breadcrumb'=>$breadcrumb])
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">

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
        </div>
      </div>

      <div class="card-header">
        <h3 class="card-title">{{$student->name}} </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="row">
              <!--<div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Role</span>
                    <span class="info-box-number text-center text-muted mb-0"> </span>
                  </div>
                </div>
              </div>-->
              <!-- <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Customer Type</span>
                    <span class="info-box-number text-center text-muted mb-0"></span>
                  </div>
                </div>
              </div> -->
              <!-- <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Estimated project duration</span>
                    <span class="info-box-number text-center text-muted mb-0">20 <span>
                  </div>
                </div>
              </div> -->
            </div>
            <div class="row">
              <div class="col-12">
                <h4>Recent Activity</h4>
                  <div class="post">
                    <div class="user-block">
                      @php 
                      $exists = file_exists( storage_path() . '/app/user_photo/' . $student->profile_photo );
                      @endphp

                      @if($exists && $student->profile_photo!='') 
                      <img class="img-circle img-bordered-sm" src={{url('storage/app/user_photo/'.$student->profile_photo)}} alt="user image">
                      @else
                      <img class="img-circle img-bordered-sm" src={{Asset("public/assets/dist/img/transparent.png")}} alt="user image">   
                      @endif
                      <span class="username">
                        <a href="javascript:void(0);"> {{$student->name}} </a>
                      </span>
                      <span class="description">Creation Date - {{date("jS F, Y", strtotime($student->created_at))}} </span>
                    </div>
                    <!-- /.user-block -->
                    <p> 
                        Video Conferencing Platform: {{$student->video_conferencing_platform}} <br>
                        Account ID: {{$student->user_account_id}} <br>
                        Country Of Origin: {{$student->country_of_origin}} <br>
                        Country Living In: {{$student->country_living_in}} <br>
                        DOB : {{date("jS F, Y", strtotime($student->dob))}} <br>
                        Gender : {{$student->gender}} <br>
                        

                        
                        About Me : {{$student->about_me}} <br>
                        
                        About My Lessons : {{$student->about_my_lessons}} <br>
                        
                        
                        
                    </p>

                    <hr>


                    <!-- <p>
                      <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                    </p> -->
                  </div>

                  
              </div>
            </div>
          </div>
         <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                @php 
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $student->profile_photo );
                @endphp
                      
                <div class="user-">
                    @if($exists && $student->profile_photo!='') 
                    <img class="img-bordered-sm" src={{url('storage/app/user_photo/'.$student->profile_photo)}} style="width: 100px;" alt="user image">
                    @else
                    <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="user image">   
                    @endif
                </div>
            <h3 class="text-primary">{{$student->name}} </h3>
            
            <br>
            <div class="text-muted">
              
              <p class="text-sm">Phone number
                <b class="d-block"> {{$student->phone_number}} </b>
              </p>
               <p class="text-sm">Email
                <b class="d-block">{{$student->email}}</b>
              </p>
               <p class="text-sm">Address
                <b class="d-block">{{$student->address}}</b>
              </p>
              
              
            </div>

            <div class="text-center mt-5 mb-3">
            
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
    
@endsection