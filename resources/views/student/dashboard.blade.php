@include('include/head')

@include('include/student-dashboard-header')



@php

 $getLoggedIndata = getLoggedinData();

 $getVisitorCountry = getVisitorCountry();

@endphp



<section class="teacher-contain">

<div class="container">

  <div class="row">

    

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

     <div class="col-lg-3 col-md-3 col-sm-12 col-12">

      <div class="student-left-sidebar">

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

                    <!--<img src="{{ asset('public/frontendassets/images/profile-pic.png') }}" class="img-fluid"/>  -->

                    

                 <div class="flag-img">

                     @if($flag)

                        <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">

                     @else

                        <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 

                     @endif

                 </div>

               </div>   

             </div>

             <div class="col"><a href="{{route('student-profile-edit')}}">Edit Profile</a></div>

           </div>

           

           <div class="row">

           <div class="col-lg-12"><h3>{{$getLoggedIndata->name}}</h3></div> 

           </div>

           

           <div class="row">

           <div class="col-lg-12">

             <ul>

               <li>User ID <span>{{$getLoggedIndata->id}}</span></li>

               <li>From <span>{{$getLoggedIndata->country_of_origin}}</span></li>

               <li>Living in  <span>{{$getLoggedIndata->country_living_in}} <br> ({{date('d-M-Y h:i a')}})</span></li>

             </ul>

           </div> 

           </div>

           

           </div>

           

        <div class="total-lessons">

          <div id="chartContainer"></div>

        </div>   

        

        <!--

        <div class="total-lessons">

            <h3>Total Lessons</h3>

            <div class="row">

                <div style="width: 100%; height: 40px; position: absolute; top:38.5%; left: 0; margin-top: -20px; line-height:19px; text-align: center; z-index: 999999999999999">

                    {{$chartTotalLessons}} <Br /> Total

                </div>

                <div id="chartContainer"></div>

            </div>

        </div> 

        <div class="download-app">

          <div class="row align-items-center"> 

           <div class="col-lg-4 col-md-5 col-sm-4 col-4">

             <img src="{{ asset('public/frontendassets/images/yellow-bg.png') }}" class="img-fluid"/>

           </div>

           <div class="col-lg-8 col-md-7 col-sm-8 col-8">

               <h4>Download the</h4>

               <h5>Tokatif Mobile App</h5>

           </div>

           </div>

        </div>-->

           

        </div>

     </div>

     

     

     <div class="col-lg-6 col-md-6 col-sm-12 col-12">

      

        <div class="languages-section mb-4">

          <div class="row">

            <div class="col"><h2>Languages</h2></div>

            <div class="col"><a href="{{route('student-profile-edit')}}" class="update-font">Update <i class="fa fa-pencil" aria-hidden="true"></i></a></div>

          </div>

          <div class="languages-box">

            <div class="row">

              <div class="col-lg-12 col-12">

               <h3> Languages I know </h3>

                

                

                @if($getLoggedIndata->languages_spoken!='')

                

                    @php

                      $skillLanguageArr = json_decode($getLoggedIndata->languages_spoken, true);  //dd($skillLanguageArr); 

                    @endphp

                @if(count($skillLanguageArr)>0 && $getLoggedIndata->languages_spoken!='')

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

                @if(count($taughtLanguageArr)>0 && $getLoggedIndata->languages_taught!='')

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

        <div class="my-lessons">

            <div class="row">

            <div class="col"><h2>My Lessons</h2></div>

            <div class="col"><a href="{{route('my-lesson')}}" class="update-font">Explore All <i class="fa fa-pencil" aria-hidden="true"></i></a></div>

          </div>

            @foreach($myLessons as $val)

                @php

                    $class="";

                    $iClass="";
                    $status = "";

                    if($val->status=='0'){

                        $status = 'Waiting';

                        $iClass="fa-hourglass-end";

                        $class="Unscheduled";

                    }

                    if($val->status=='1'){

                        $status = 'Booked';

                        $iClass="fa fa-arrow-circle-down";

                        $class="upcom";

                    }

                    if($val->status=='2'){

                        $status = 'Cancelled';

                        $iClass="fa fa-arrow-circle-down";

                        $class="cancel";

                    }

                @endphp

            <div class="row mt-4">

                <div class="col-lg-7 col-md-7 col-sm-12 col-12">

                   <h4>{{date("jS F, Y", strtotime($val->booking_date))}} - {{date('h:ia', strtotime($val->booking_time))}}</h4> 

                   <h5>{{$val->language_taught}}  |  {{$val->time}}</h5> 

                </div>  

                

                <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                    <h5 class="{{$class}}"><i class="fa {{$iClass}}" aria-hidden="true"></i> {{$status}} </h5> 

                    @if($val->booking_date > date('Y-m-d'))

                        @php

                            $datetime1 = new DateTime(date('Y-m-d'));

                            $datetime2 = new DateTime($val->booking_date);

                            $difference = $datetime1->diff($datetime2);

                            $days = $difference->d.' days'; 

                        @endphp

                    <p>in {{$days}}</p>

                    @else

                        @php

                            $datetime1 = new DateTime($val->booking_date);

                            $datetime2 = new DateTime(date('Y-m-d'));

                            $difference = $datetime1->diff($datetime2);

                            $days = $difference->d.' days'; 

                        @endphp

                    <p>before {{$days}}</p>

                    @endif

                </div>

                

                <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                    @php 

                        $teacherData = DB::table('registrations')->where('id', $val->teacher_id)->first();

                        $exists = file_exists( storage_path() . '/app/user_photo/' . $teacherData->profile_photo );

                    @endphp

                    <span class="upcoming-img">

                        @if($exists && $teacherData->profile_photo!='') 

                            <img src="{{url('storage/app/user_photo/'.$teacherData->profile_photo)}}" class="img-fluid">

                        @else

                            <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                        @endif

                    </span>

                </div>

                

            </div>

            @endforeach

            

            

          </div>          

        <div class="my-lessons my-teacher-00 mt-4">

            <div class="row">

                <div class="col"><h2>My Teachers </h2></div> 

                <div class="col"><a href="{{route('teachers')}}" class="update-font">Explore All <i class="fa fa-pencil" aria-hidden="true"></i></a></div>

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

                <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                    <span class="upcoming-img">

                        @if($exists && $teacherData->profile_photo!='') 

                            <img src="{{url('storage/app/user_photo/'.$teacherData->profile_photo)}}" class="img-fluid">

                        @else

                            <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                        @endif

                    </span>

                </div>

               

                <div class="col-lg-7 col-md-7 col-sm-12 col-12">

                   <h4>{{$teacherData->name}} <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span></h4>

                   <h5>{{$teacherType}}</h5>

                   <p><i class="fa fa-circle" aria-hidden="true"></i> Offline (Visited 2days ago)</p>

                </div>  

 

                <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                    <a href="{{route('lesson-booking',['id'=>$val->teacher_id])}}" class="btn-book">Book</a>

                </div>

                

            </div> 

            @endforeach

            

            

          </div> 

          

       <div class="my-lessons my-teacher-00 mt-4">

            <div class="row">

                <div class="col"><h2>Community Updates</h2></div>

                <div class="col text-right"><div class="dropdown">

                    <span class="btn btn-secondary"> Articles </span>

                </div></div>

            </div>

          

            @foreach($communities as $val)

                @php 

                    $postedByData = DB::table('registrations')->where('id', $val->added_by)->first();

                    $exists = file_exists( storage_path() . '/app/user_photo/' . $postedByData->profile_photo );

                    

                    if($postedByData->teacher_type=='specialist_teacher')

                        $teacherType = 'Specialist Teacher';

                    elseif($postedByData->teacher_type=='community_tutor')

                        $teacherType = 'Community Tutor';

                @endphp

            <div class="row mt-4 mb-3">

                <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                    <span class="upcoming-img">

                        @php 

                            $postedByPhotoExists = file_exists( storage_path() . '/app/user_photo/' . $postedByData->profile_photo );

                        @endphp

                     

                        @if($postedByPhotoExists && $postedByData->profile_photo!='') 

                          <img src="{{url('storage/app/user_photo/'.$postedByData->profile_photo)}}" class="img-fluid">

                        @else

                          <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                        @endif

                    </span>

                </div>

               

                <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                   <h4>{{$postedByData->name}} <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span></h4>

                   <h5>{{$teacherType}}</h5>

                </div>  

 

                <div class="col-lg-4 col-md-34 col-sm-12 col-12">

                   <h4>{{date("j M Y", strtotime($val->created_at))}} - {{date('h:iA', strtotime($val->created_at))}}</h4> 

                </div>

                

                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">

                 <h4>{{$val->title}}</h4>

                 <p>{{$val->description}}</p>

                <ul class="community-list"> 

                    @php

                        $commentCount = DB::table('community_comments')->where('community_id', '=', $val->id)->count(); 

                    @endphp

                    <li><a href="javascript:void(0);"><i class="fa fa-commenting-o" aria-hidden="true"></i> {{$commentCount}} </a></li>

                    

                   <!--<li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>

                   <li><a href="#"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 1,005</a></li>

                   <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 4</a></li>-->

                </ul>    

               </div> 

            </div> 

            @endforeach

            

            

          </div>     

          

          

     </div>

     

     <div class="col-lg-3 col-md-3 col-sm-12 col-12">

      <div class="book-free">

        <span class="gift-item"><img src="{{ asset('public/frontendassets/images/book-gift.png') }}" class="img-fluid"/></span>

         <h3>Book Discounted Trial Lessons</h3>

         <p>You have 3 discounted trial lessons left!</p>

        </div>

      <div class="book-free blance-box mt-4">

        <div class="row">

         <div class="col-lg-8 col-md-9 col-sm-9 col-12">

          <h3>Tokatif Tokens</h3>

          <!--<p>USD 10.00</p>-->

          </div>

          <div class="col-lg-4 col-md-3 col-sm-3 col-12">

            <a href="{{route('add-credit')}}">Add <i class="fa fa-plus-circle" aria-hidden="true"></i></a>

           </div>

          </div>

        </div> 

        <div class="my-lessons my-teacher-00 recommended-teacher mt-4">

            <div class="row">

                <div class="col"><h2>Recommended Teachers</h2></div>

            </div>

          

            @foreach($recommendedTeachers as $val)

                @php 

                    $recommendedTeacherLessonCount = DB::table('lessons')->where('deleted_at', '=', null)->where(['user_id'=>$val->id])->count(); 

                

                    $tExists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );

                    

                    if($val->teacher_type=='specialist_teacher')

                        $teacherType = 'Specialist Teacher';

                    elseif($val->teacher_type=='community_tutor')

                        $teacherType = 'Community Tutor';

                @endphp

            <div class="row mt-4">

                <div class="col-lg-3 col-md-3 col-sm-12 col-3"> 

                    <span class="upcoming-img">

                        @if($tExists && $val->profile_photo!='') 

                          <img src="{{url('storage/app/user_photo/'.$val->profile_photo)}}" class="img-fluid">

                        @else

                          <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                        @endif

                    </span>

                </div>

               

                <div class="col-lg-7 col-md-7 col-sm-12 col-7">

                   <h4>{{$val->name}} <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span></h4>

                   <h5>{{$teacherType}}</h5>

                   <p>{{$recommendedTeacherLessonCount}} Lessons</p>

                </div>  

 

                <div class="col-lg-2 col-md-2 col-sm-12 col-2">

                 <a href="{{route('teacher-detail',['id'=>$val->id])}}" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

                </div>

                

            </div> 

            @endforeach

        </div>  

        

         

     </div>

   </div>

  </div>

</section>



@include('include/footer')

