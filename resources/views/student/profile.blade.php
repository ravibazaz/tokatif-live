@include('include/head')

@include('include/student-dashboard-header')



@php

 $getLoggedIndata = getLoggedinData();

 $getVisitorCountry = getVisitorCountry();

@endphp





@php $flag = ''; @endphp

@if($getLoggedIndata->country_living_in!='')

    @php

        $countryFlagData = DB::table('countries')->where('name', '=', $getLoggedIndata->country_living_in)->first(); 

        $flag = strtolower($countryFlagData->sortname);

    @endphp

@else

    @php

        $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

        $flag = strtolower($countryFlagData->sortname);

    @endphp

@endif



<section class="teacher-contain">

<div class="container">

  <div class="row">

    <div class="col-lg-4 col-md-4 col-sm-12 col-12">

      <div class="student-left-sidebar studentleft-tobg">

        <div class="profile-box">

           <div class="row">

             <div class="col">

               <div class="img-profile">

                   @php 

                        $exists = file_exists( storage_path() . '/app/user_photo/' . $getLoggedIndata->profile_photo );

                    @endphp

                    

                    @if($exists && $getLoggedIndata->profile_photo!='') 

                        <img src="{{url('storage/app/user_photo/'.$getLoggedIndata->profile_photo)}}" class="img-fluid">

                    @else

                        <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                    @endif

                    

                    <!--<img src="{{ asset('public/frontendassets/images/profile-pic.png') }}" class="img-fluid"/>-->

                 <div class="flag-img">

                     @if($flag)

                        <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">

                     @else

                        <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 

                     @endif

                 </div>

               </div>   

             </div>

             

           </div>

           

           <div class="row">

           <div class="col">

             <h3>{{$getLoggedIndata->name}}</h3>

                <h6 style="font-size:10px;">

                    <!-- <img src="{{ asset('public/frontendassets/images/avilable.png') }}"/>-->  

                    <img src="{{ asset('public/frontendassets/images/offline.png') }}"/> Offline (Visited 2days ago)

                </h6>

             </div> 

           <div class="col"><a href="{{route('student-profile-edit')}}">Edit Profile</a></div>

           </div>

           

           <div class="row">

           <div class="col-lg-12">

             <ul>

               <li>Age <span>{{$age}} Years</span></li>

               <li>From <span>{{$getLoggedIndata->country_of_origin}}</span></li>

               <li>Living in  <span>{{$getLoggedIndata->country_living_in}} ({{date('d-M-Y h:i a')}})</span></li>

               <li>User ID <span>{{$getLoggedIndata->id}}</span></li>

             </ul>

           </div> 

           </div>

           

           </div>

           

         <div class="my-lessons my-teacher-00 s-profile mt-4">

            <div class="row">

            <div class="col-12"><h2>My Teachers</h2></div>

          </div>

            

            @foreach($myTeachers as $val)

                @php 

                    $teacherData = DB::table('registrations')->where('id', $val->teacher_id)->first();

                    $exists = file_exists( storage_path() . '/app/user_photo/' . $teacherData->profile_photo );

                    

                    if($teacherData->teacher_type=='specialist_teacher')

                        $teacherType = 'Specialist Teacher';

                    elseif($teacherData->teacher_type=='community_tutor')

                        $teacherType = 'Community Tutor';

                @endphp

            <div class="row mt-4">

                <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                  <div class="small-pic">

                    @if($exists && $teacherData->profile_photo!='') 

                        <img src="{{url('storage/app/user_photo/'.$teacherData->profile_photo)}}" class="img-fluid">

                    @else

                        <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                    @endif

                </div>

                </div>

               

                <div class="col-lg-5 col-md-5 col-sm-12 col-12">

                   <h4>{{$teacherData->name}} <span></h4>

                   <h5>{{$teacherType}}</h5>

                   <span> <i class="fa fa-star" aria-hidden="true"></i> 5.0</span>

                </div>  

 

                <div class="col-lg-4 col-md-4 col-sm-12 col-12">

                    <a href="{{route('lesson-booking',['id'=>$val->teacher_id])}}" class="btn-book">Book</a>

                </div>

                

            </div>

            @endforeach

            

            

          </div>

            

           

        </div>

     </div>

     

     <div class="col-lg-8 col-md-6 col-sm-12 col-12">

        <div class="languages-section mb-4">

          <div class="row">

            <div class="col-12">

            <h2>Introduction</h2>

             <p> {{$getLoggedIndata->about_me}} </p>

            </div>

            

          </div>

          <div class="languages-box">

            <div class="row">

              <div class="col-lg-12 col-12">

               <h3>Languages I know</h3>
                
                @if($getLoggedIndata->languages_spoken!='')
                    @php
                      $skillLanguageArr = json_decode($getLoggedIndata->languages_spoken, true);  //dd($skillLanguageArr); 
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
    
                       
    
                     <!--<li><a href="#">English <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"/></a></li>
    
                     <li><a href="#">German <img src="{{ asset('public/frontendassets/images/meter2.png') }}" class="img-fluid"/></a></li>
    
                     <li><a href="#">Japanese <img src="{{ asset('public/frontendassets/images/meter3.png') }}" class="img-fluid"/></a></li>
    
                     <li><a href="#">Chinese <img src="{{ asset('public/frontendassets/images/meter4.png') }}" class="img-fluid"/></a></li>-->
    
                    </ul>
    
                    @endif
                
                @endif

               </div>

             </div> 

             <hr>

            <div class="row">

              <div class="col-lg-12 col-12">

               <h3>Languages I'm learning</h3>

                @if($getLoggedIndata->languages_taught!='')
                
                    @php
                      $taughtLanguageArr = json_decode($getLoggedIndata->languages_taught, true);  //dd($taughtLanguageArr); 
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
                    
                @endif

               </div>

             </div> 

          </div>

        </div>        

                  

                  

        <div class="my-lessons lesson-feedback mt-4">

            <div class="row"><div class="col"><h2>Lesson Feedback</h2></div></div>

             <div class="row">

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-left">Completed Lessons</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center">No of Badges</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-right">Reviews</div>

             </div>

             

             <div class="row">

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-left">{{$completedLessonCount}}</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center">49</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-right">100</div>

             </div>

             

          </div> 

        

        <div class="my-lessons lesson-feedback mt-4">

            <div class="row"><div class="col"><h2>Community Activity</h2></div></div>

             <div class="row">

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-left">Article Post</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center">Forum</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-right">Comments</div>

             </div>

             

             <div class="row">

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-left">{{$postedArticleCount}}</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center">{{$postedForumCount}}</div>

               <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-right">100</div>

             </div>

             

          </div>  

                

     </div>

   </div>

  </div>

</section>



@include('include/footer')







