@include('include/head')

@if(session('id')!='' && session('role')=='1')
    @include('include/student-dashboard-header')
@elseif(session('id')!='' && session('role')=='2')
    @include('include/teacher-dashboard-header')
@else
    @include('include/header')
@endif

@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp

<section class="article-list article-details-page">
<div class="container">
  <div class="row">
     <div class="col-lg-8 col-md-8 col-sm-12 col-12">
       <div class="aricle-box">
            @php 
                $exists = file_exists( storage_path() . '/app/article/' . $community->photo );
            @endphp
            
            @if($exists && $community->photo!='') 
                <img src="{{url('storage/app/article/'.$community->photo)}}" class="img-fluid">
            @else
                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
            @endif
            
            <!--<img src="{{asset('public/frontendassets/images/details-banner.png')}}" class="img-fluid">-->
            
                @php
                $addedByData = DB::table('registrations')->where('id', '=', $community->added_by)->first(); 
                $addedByName = $addedByData->name;
                  
                  if($addedByData->teacher_type!='' && $addedByData->teacher_type=='specialist_teacher')
                    $teacherType = 'Specialist Teacher';
                  elseif($addedByData->teacher_type!='' && $addedByData->teacher_type=='community_tutor')
                    $teacherType = 'Community Tutor';
                  else
                    $teacherType = '';
                    
                @endphp
                
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    @php
                      $taughtLanguageArr = json_decode($addedByData->languages_taught, true);  
                    @endphp
                    
                    
                    <ul class="community-list">
                        @if(count($taughtLanguageArr)>0)
                            @foreach($taughtLanguageArr as $key=>$value)
                                <li> 
                                    <a href="javascript:void(0);">   
                                    {{ $value['language'] }} <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"/> 
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        
                        <li><a href="javascript:void(0);"> {{date("F d, Y", strtotime($community->created_at))}} </a></li>
                    </ul>
                    
                    <!--<ul class="community-list">
                        <li><a href="#">Japanese <img src="{{asset('public/frontendassets/images/meter3.png')}}" class="img-fluid"></a></li>
                        <li><a href="#"> Sep 1, 2020</a></li>
                    </ul>-->
                  </div>
                </div>
                
              <h4>{{$community->title}}</h4>        
              <div class="my-lessons my-teacher-00 mt-3">
                <div class="row align-items-center">
                    <div class="col-lg-1 col-md-2 col-sm-12 col-12 pr-0">
                        @php 
                            $addedByPhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedByData->profile_photo );
                        @endphp
                     
                        @if($addedByPhotoExists && $addedByData->profile_photo!='') 
                          <img src="{{url('storage/app/user_photo/'.$addedByData->profile_photo)}}" class="img-fluid">
                        @else
                          <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                        @endif
                        
                     <!--<img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">-->
                    </div>
                    <div class="col-lg-11 col-md-10 col-sm-12 col-12 p-0">
                       <h4>{{$addedByName}}</h4>
                       <h5>{{$teacherType}}</h5>
                    </div> 
                 </div>
                 <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                 <ul class="community-list">
                   <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                   <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                   <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                </ul>
                  </div>
                </div>
                
         		</div>
                
             <p>{{$community->description}}</p>

            </div>
            
            
    @if(Session::has('id'))
    <div class="comment-box">
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
        
        <form action="{{route('post-article-comments')}}" method="POST">
            @csrf
            <input type="hidden" name="community_id" value="{{$community->id}}"/>
           <div class="row">
             <div class="col-lg-1 col-md-2 col-sm-4 col-12">
               <img src="{{Asset('public/assets/dist/img/transparent.png')}}" class="img-fluid"/>
             </div>
             <div class="col-lg-11 col-md-10 col-sm-8 col-12">
               <div class="form-group">
                <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3" placeholder="Comments"></textarea>
                @if ($errors->has('comment'))
                    <span class="text-danger">{{ $errors->first('comment') }}</span>
                @endif
              </div>
              <button type="submit" class="btn btn-submit">post</button>
             </div>
           </div>
        </form>
    </div>
    @endif
    

       <div class="comment">
        <div class="my-lessons my-teacher-00 mt-3">
         
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12"><h3>Comments {{$comment_count}} </h3></div>
                 <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-right">
                    <!--<div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       Sort By New
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>-->
                 </div>
            </div>
            
            @if(count($comments)>0)   
                @foreach($comments as $cVal)
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-12 pr-0">
                        @php
                            $commentedByData = DB::table('registrations')->where('id', '=', $cVal->user_id)->first(); 
                            $commentedByName = $commentedByData->name;

                            $exists = file_exists( storage_path() . '/app/user_photo/' . $commentedByData->profile_photo );
                        @endphp
                        
                        @if($exists && $commentedByData->profile_photo!='') 
                            <img src="{{url('storage/app/user_photo/'.$commentedByData->profile_photo)}}" class="img-fluid">
                        @else
                            <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                        @endif
                        
                        <!--<img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">-->
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 p-0">
                       <h4>{{$commentedByName}} <small>{{date("d-M-Y H:i:sa", strtotime($cVal->created_at))}}</small></h4>
                       <p>{{$cVal->comments}}</p>
                          
                        <!--<ul class="community-list">
                            <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                            <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                            <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                        </ul>-->
                        
                    </div> 
                 </div>
                @endforeach
            @endif
                 
                 
                 <!--<div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-12 pr-0">
                     <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 p-0">
                       <h4>JP McMenamin <small>15 Min Ago</small></h4>
                       <p>For me, the benefit of reading is to learn Spanish sentence structure. 
                          And it is easier to tell if verbs are conjugated in past or future tense. 
                          One can buy ebooks in Spanish, and with a downloaded Spanish dictionary, 
                          click on words to get the definition. Very easy and useful.</p>
                          
                      <ul class="community-list">
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                    </ul>
                        
                    </div> 
                 </div>
                 
                 <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-12 pr-0">
                     <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 p-0">
                       <h4>JP McMenamin <small>15 Min Ago</small></h4>
                       <p>For me, the benefit of reading is to learn Spanish sentence structure. 
                          And it is easier to tell if verbs are conjugated in past or future tense. 
                          One can buy ebooks in Spanish, and with a downloaded Spanish dictionary, 
                          click on words to get the definition. Very easy and useful.</p>
                          
                      <ul class="community-list">
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                    </ul>
                        
                    </div> 
                 </div>
                 
                 <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-12 pr-0">
                     <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 p-0">
                       <h4>JP McMenamin <small>15 Min Ago</small></h4>
                       <p>For me, the benefit of reading is to learn Spanish sentence structure. 
                          And it is easier to tell if verbs are conjugated in past or future tense. 
                          One can buy ebooks in Spanish, and with a downloaded Spanish dictionary, 
                          click on words to get the definition. Very easy and useful.</p>
                          
                      <ul class="community-list">
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                    </ul>
                        
                    </div> 
                 </div>
                 
                 <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-12 pr-0">
                     <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 p-0">
                       <h4>JP McMenamin <small>15 Min Ago</small></h4>
                       <p>For me, the benefit of reading is to learn Spanish sentence structure. 
                          And it is easier to tell if verbs are conjugated in past or future tense. 
                          One can buy ebooks in Spanish, and with a downloaded Spanish dictionary, 
                          click on words to get the definition. Very easy and useful.</p>
                          
                      <ul class="community-list">
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                       <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                    </ul>
                        
                    </div> 
                 </div>-->
                 
                
        </div>

       </div>
           
     </div>
     <div class="col-lg-4 col-md-4 col-sm-12 col-12">
     
       <div class="profile-box">
           <div class="row align-items-center"> 
             <div class="col-lg-12 col-12">
               <div class="img-profile">
                @php 
                    $addedByPhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedByData->profile_photo );
                @endphp
             
                @if($addedByPhotoExists && $addedByData->profile_photo!='') 
                  <img src="{{url('storage/app/user_photo/'.$addedByData->profile_photo)}}" class="img-fluid">
                @else
                  <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                @endif
                
                    <!--<img src="{{asset('public/frontendassets/images/teacher-profileimg.jpg')}}" class="img-fluid">-->
                    
                @php $flag = ''; @endphp
                @if($addedByData->country_living_in!='')
                    @php
                        $countryFlagData = DB::table('countries')->where('name', '=', $addedByData->country_living_in)->first(); 
                        $flag = strtolower($countryFlagData->sortname);
                    @endphp
                @else
                    @php
                        $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 
                        $flag = strtolower($countryFlagData->sortname);
                    @endphp
                @endif
                <div class="flag-img">
                    @if($flag)
                        <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">
                    @else
                        <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 
                    @endif
                    <!--<img src="{{asset('public/frontendassets/images/fine-offline.png')}}">-->
                </div>
               </div>   
             </div>
           </div>
           
           <div class="row">
           <div class="col-lg-12 text-center details-teacher">
            <h3>{{$addedByName}}</h3>
            <p>{{$teacherType}}</p>
            <h5><i class="fa fa-star" aria-hidden="true"></i> 5.0</h5>
           </div> 
           </div>
            <hr>
            <div class="row">
              <div class="col-lg-12 col-12">
               <div class="languages-box">
               <h3>Teaches</h3>
                @php
                  $taughtLanguageArr = json_decode($addedByData->languages_taught, true);  
                @endphp
                
                @if(count($taughtLanguageArr)>0)
                <ul>
                   
                    @foreach($taughtLanguageArr as $key=>$value)
                        <li> 
                            <a href="javascript:void(0);">   
                            {{ $value['language'] }} <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"/> 
                            </a>
                        </li>
                    @endforeach
                
                </ul>
                @endif
                
                
               <!--<ul>
                 <li><a href="#">English <img src="{{asset('public/frontendassets/images/meter1.png')}}" class="img-fluid"></a></li>
                 <li><a href="#">German <img src="{{asset('public/frontendassets/images/meter2.png')}}" class="img-fluid"></a></li>
                 <li><a href="#">Japanese <img src="{{asset('public/frontendassets/images/meter3.png')}}" class="img-fluid"></a></li>
                 <li><a href="#">Chinese <img src="{{asset('public/frontendassets/images/meter4.png')}}" class="img-fluid"></a></li>
               </ul>-->
               </div>
               <hr>
             </div> 
          </div>
          
          <div class="row">
              <div class="col-lg-12 col-12">
               <div class="languages-box">
               <h3>Also Speak</h3>
                @php
                  $skillLanguageArr = json_decode($addedByData->languages_spoken, true);  //dd($skillLanguageArr); 
                @endphp
                
                @if(count($skillLanguageArr)>0)
                <ul>
                   
                    @foreach($skillLanguageArr as $key=>$val)
                        @php
                          if($val['level']=='Native')
                            $l_img = 'meter4.png';
                          elseif($val['level']=='Beginner')
                            $l_img = 'meter4.png';
                          elseif($val['level']=='Elementary')
                            $l_img = 'meter3.png';
                          elseif($val['level']=='Intermediate')
                            $l_img = 'meter2.png';
                          elseif($val['level']=='Upper Intermediate')
                            $l_img = 'meter1.png';
                          elseif($val['level']=='Advanced')
                            $l_img = 'meter1.png';
                          elseif($val['level']=='Proficient')
                            $l_img = 'meter1.png';
                          elseif($val['level']=='')
                            $l_img = 'meter4.png';
                        @endphp
                        <li> 
                            <a href="javascript:void(0);">   
                            {{ $val['language'] }} <img src="{{ asset('public/frontendassets/images/'.$l_img) }}" class="img-fluid"/> 
                            </a>
                        </li>
                    @endforeach
                   
                </ul>
                @endif
                
                
               <!--<ul>
                 <li><a href="#">Arabic <img src="{{asset('public/frontendassets/images/meter1.png')}}" class="img-fluid"></a></li>
                 <li><a href="#">Hindi <img src="{{asset('public/frontendassets/images/meter2.png')}}" class="img-fluid"></a></li>
               </ul>-->
               </div>
               <hr>
             </div> 
             
          </div>
          
        <!--<div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
             <div class="r-box">
               <h3>USD 20.00 </h3>
               <p>Hourly Rate From</p>
             </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
             <div class="r-box">
               <h3>USD 10.00 </h3>
               <p>Trial</p>
             </div>
            </div>
        </div>-->
                      
          
        <a href="{{route('lesson-booking',['id'=>$addedByData->id])}}" class="btn-availability"> Book Now </a>  
          
        </div>
        
        @if(count($lastPosts)>0)   
            @foreach($lastPosts as $pValue)
            <div class="aricle-box mt-4">
                
                @php 
                    $pExists = file_exists( storage_path() . '/app/article/' . $pValue->photo );
                @endphp
                
                @if($pExists && $pValue->photo!='') 
                    <img src="{{url('storage/app/article/'.$pValue->photo)}}" class="img-fluid">
                @else
                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                @endif
                    
                <!--<img src="{{asset('public/frontendassets/images/aritical2.png')}}" class="img-fluid">-->
              <h4>{{$pValue->title}}</h4>
              <p>{{$pValue->description}}</p>             
              <div class="my-lessons my-teacher-00 mt-3">
                @php
                $addedBy_P_Data = DB::table('registrations')->where('id', '=', $pValue->added_by)->first(); 
                $addedByPName = $addedBy_P_Data->name;
                  
                  if($addedBy_P_Data->teacher_type!='' && $addedBy_P_Data->teacher_type=='specialist_teacher')
                    $teacherTypeP = 'Specialist Teacher';
                  elseif($addedBy_P_Data->teacher_type!='' && $addedBy_P_Data->teacher_type=='community_tutor')
                    $teacherTypeP = 'Community Tutor';
                  else
                    $teacherTypeP = '';
                  
                @endphp
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">
                        @php 
                            $addedBy_P_PhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedBy_P_Data->profile_photo );
                        @endphp
                     
                        @if($addedBy_P_PhotoExists && $addedBy_P_Data->profile_photo!='') 
                          <img src="{{url('storage/app/user_photo/'.$addedBy_P_Data->profile_photo)}}" class="img-fluid">
                        @else
                          <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                        @endif
                        
                     <!--<img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">-->
                     </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                       <h4>{{$addedByPName}}</h4>
                       <h5>{{$teacherTypeP}}</h5>
                    </div> 
                    <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">
                      <h3>{{date("F d, Y", strtotime($pValue->created_at))}}</h3>
                    </div> 
                 </div>
                 <hr>
                 <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    @php
                      $taughtLanguagePArr = json_decode($addedBy_P_Data->languages_taught, true);  
                    @endphp
                 <ul class="community-list">
                    @if($addedBy_P_Data->languages_taught!='' && count($taughtLanguagePArr)>0)
                    @foreach($taughtLanguagePArr as $key=>$value)
                        <li> 
                            <a href="javascript:void(0);">   
                            {{ $value['language'] }} <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"/> 
                            </a>
                        </li>
                    @endforeach
                    @endif
                   <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                   <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                </ul>
                  </div>
                </div>
                
         		</div>
           </div>
            @endforeach
        @endif
      
        <!--<div class="aricle-box mt-4">
             <img src="{{asset('public/frontendassets/images/aritical2.png')}}" class="img-fluid">
              <h4>Bachelor of Arts in Counseling Skills</h4>
              <p>Must not include personal contact information or external advertisements</p>             
              <div class="my-lessons my-teacher-00 mt-3">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">
                     <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">
                     </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                       <h4>Mr. Zhang </h4>
                       <h5>Community Tutor</h5>
                    </div> 
                    <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">
                      <h3>Sep 1, 2020</h3>
                    </div> 
                 </div>
                 <hr>
                 <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                 <ul class="community-list">
                   <li><a href="#">Japanese <img src="{{asset('public/frontendassets/images/meter3.png')}}" class="img-fluid"></a></li>
                   <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>
                   <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 
                </ul>
                  </div>
                </div>
                
         		</div>
           </div>   -->  
           
     </div>
   </div>
  </div>
</section>


@include('include/footer')
