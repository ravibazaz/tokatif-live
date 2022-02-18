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
        <h3 class="card-title">{{$teacher->name}} </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
            <div class="row">
              <div class="col-lg-12 col-12">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">Role</span>
                    <span class="info-box-number text-center text-muted mb-0">{{$teacher_type}}</span>
                  </div>
                </div>
              </div>
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
              <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="leftdetails-profile">
                <h4>Recent Activity</h4>
                  <div class="post">
                    <div class="user-block">
                      @php 
                      $exists = file_exists( storage_path() . '/app/user_photo/' . $teacher->profile_photo );
                      @endphp

                      @if($exists && $teacher->profile_photo!='') 
                      <img class="img-circle img-bordered-sm" src={{url('storage/app/user_photo/'.$teacher->profile_photo)}} alt="user image">
                      @else
                      <img class="img-circle img-bordered-sm" src={{Asset("public/assets/dist/img/transparent.png")}} alt="user image">   
                      @endif
                      <span class="username">
                        <a href="javascript:void(0);"> {{$teacher->name}} </a>
                      </span>
                      <span class="description">Creation Date - {{date("jS F, Y", strtotime($teacher->created_at))}} </span>
                    </div>
                    <!-- /.user-block -->
                    <p> 
                     <div class="Video-conferencing"><b> Video Conferencing Platform:</b> {{$teacher->video_conferencing_platform}} </div>
                     <div class="account-id"> <b>Account ID:</b> {{$teacher->user_account_id}} </div>
                     <div class="country-origin"> <b>Country Of Origin:</b> {{$teacher->country_of_origin}} </div>
                     <div class="country-Living"><b> Country Living In:</b> {{$teacher->country_living_in}} </div>
                     <div class="teacher-dob">  <b>DOB :</b> {{date("jS F, Y", strtotime($teacher->dob))}} </div>
                     <div class="teacher-Gender"> <b>Gender :</b> {{$teacher->gender}} </div>
                     <div class="teacher-language">   
                        @php
                            $languagesSpokenArr = json_decode($teacher->languages_spoken, true);
                            $language = '';
                        @endphp
                        
                        @if($languagesSpokenArr)
                            @foreach($languagesSpokenArr as $val)
                              @php  
                                $language .= $val['language'].','; 
                              @endphp
                            @endforeach
                        
                        <b>Languages Spoken :</b>  {{ rtrim($language, ',') }}  </div>
                        @endif 
                        
                      <div class="teacher-languagestaught">   
                        @php
                            $languagesTaughtArr = json_decode($teacher->languages_taught, true);
                            $languageT = '';
                        @endphp
                        
                        @if($languagesTaughtArr)
                            @foreach($languagesTaughtArr as $val)
                              @php  
                                $languageT .= $val['language'].','; 
                              @endphp
                            @endforeach
                        
                        <b>Languages Taught :</b>  {{ rtrim($languageT, ',') }}  </div> 
                        
                        @endif 
                        
                        <div class="teacher-about">
                        <b>About Me :</b> {{$teacher->about_me}} </div>
                        
                       <div class="teacher-lessons"> 
                        <b>About My Lessons :</b> {{$teacher->about_my_lessons}} </div>
                        
                        
                        
                    </p>

                    <hr>


                    <!-- <p>
                      <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                    </p> -->
                  </div> 
                  </div>
              </div>
              
              <div class="col-lg-6 col-md-6 col-sm-12 order-1 order-md-2 col-12">
                <div class="rightdetails-profile">
              <div class="user-">
                @if($exists && $teacher->profile_photo!='') 
                <img class="img-bordered-sm" src={{url('storage/app/user_photo/'.$teacher->profile_photo)}} style="width: 100px;" alt="user image">
                @else
                <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="user image">   
                @endif
                <h3 class="text-primary">{{$teacher->name}} </h3>
                <p class="text-muted">{{$teacher_type}}</p>
              </div>
            
              <br>
              <div class="text-muted">
              
              <p class="text-sm">Phone: 
                <b> {{$teacher->phone_number}} </b>
              </p>
               <p class="text-sm">Email: 
                <b>{{$teacher->email}}</b>
              </p>
               <p class="text-sm">Address: 
                <b>{{$teacher->address}}</b>
              </p>
              
              
              <div class="user-">
               <div class="row">
                 <div class="col-lg-6">
                <p class="text-sm">Scanned Id Proof</p>
                @php 
                    $scannedIdProofExists = file_exists( storage_path() . '/app/photoID/' . $teacher->scanned_id_proof );
                @endphp
                
                @if($scannedIdProofExists && $teacher->scanned_id_proof!='') 
                <img class="img-bordered-sm" src={{url('storage/app/photoID/'.$teacher->scanned_id_proof)}} style="width: 100px;" alt="user image">
                @else
                <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="user image">   
                @endif
                <a href="#" class="download-arrow">Download Now <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                </div>
                 <div class="col-lg-6">
                  <p class="text-sm">Applicant With Scanned Id Proof</p>
                @php 
                    $applicantWithScannedIdProofExists = file_exists( storage_path() . '/app/applicant_with_photoID_proof/' . $teacher->applicant_with_scanned_id_proof );
                @endphp
                
                @if($applicantWithScannedIdProofExists && $teacher->scanned_id_proof!='') 
                <img class="img-bordered-sm" src={{url('storage/app/applicant_with_photoID_proof/'.$teacher->applicant_with_scanned_id_proof)}} style="width: 100px;" alt="user image">
                @else
                <img class="img-bordered-sm" src={{url('storage/app/noimage.jpg')}} style="width: 100px;" alt="user image">   
                @endif
                <a href="#" class="download-arrow">Download Now <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                 </div>
                </div>
              </div>
              
              <br>
              
              <div class="user-">
                
              </div>
              
            </div>

            </div>
          </div>
            </div>
          </div>
         
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
    
@endsection