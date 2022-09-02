@include('include/head')

@if(session('id')!='' && session('role')=='1')
    @include('include/student-dashboard-header')
@elseif(session('id')!='' && session('role')=='2')
    @include('include/teacher-dashboard-header')
@else
    @include('include/header')
@endif

@php 
$getVisitorCountry = getVisitorCountry();
@endphp



<section class="teacher-contain teacher-profile-details">
<div class="container">
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      <div class="student-left-sidebar">
        <div class="profile-box">
           <div class="row align-items-center">
            <div class="col-lg-3 col-12">
                @if(session('id'))
                    @php
                        $favoriteData = DB::table('favorite_teachers')->where('student_id', '=', session('id')) 
                                                                    ->where('teacher_id', '=', $user->id)
                                                                    ->where('deleted_at', '=', null)->count(); 
                    @endphp
                <div class="heard-purple">
                    @if($favoriteData>0)
                        <img src="{{ asset('public/frontendassets/images/purple-heard.png') }}" class="FavoriteList img-fluid" data-teacherID="{{$user->id}}" data-type="remove" style="cursor: pointer;" /> 
                    @else
                        <img src="{{ asset('public/frontendassets/images/heart-red.png') }}" class="FavoriteList img-fluid" data-teacherID="{{$user}}" data-type="add" style="cursor: pointer;" />
                    @endif
                </div>
                @endif
             
            </div>
             <div class="col-lg-6 col-12">
               <div class="img-profile">
                    @php 
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $user->profile_photo );
                    @endphp
                 
                    @if($exists && $user->profile_photo!='') 
                      <img src="{{url('storage/app/user_photo/'.$user->profile_photo)}}" class="img-fluid">
                    @else
                      <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                    @endif
                    <!--<img src="{{ asset('public/frontendassets/images/teacher-profileimg.jpg') }}" class="img-fluid"/>-->
                    
                    
                    
                    
                    @php $flag = ''; @endphp
                    @if($user->country_living_in!='')
                        @php
                            $countryFlagData = DB::table('countries')->where('name', '=', $user->country_living_in)->first(); 
                            $flag = strtolower($countryFlagData->sortname);
                        @endphp
                    @else
                        @php
                            $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 
                            $flag = (isset($countryFlagData->sortname)) ? strtolower($countryFlagData->sortname) : "";
                        @endphp
                    @endif
                    
                    <div class="flag-img">
                        @if($flag)
                            <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" />
                        @else
                            <img src="{{ asset('public/frontendassets/images/flage.png') }}" /> 
                        @endif
                        
                        <!--<img src="{{ asset('public/frontendassets/images/fine-offline.png') }}"/>-->
                    </div>
               </div>   
             </div>
             <div class="col-lg-3 col-12">
             <!--<img src="{{ asset('public/frontendassets/images/teacher_details.png') }}" class="img-fluid"/>-->
            </div>
           </div>
           
           <div class="row">
           <div class="col-lg-12 text-center details-teacher">
            <h3>{{$user->name}}</h3>
            
            @php
              if($user->teacher_type=='specialist_teacher')
                $teacherType = 'Specialist Teacher';
              elseif($user->teacher_type=='community_tutor')
                $teacherType = 'Community Tutor';
              
            @endphp

            <p>{{$teacherType ?? ''}}</p> 
            <h5><i class="fa fa-star" aria-hidden="true"></i> 5.0</h5>
            <h4><img src="{{ asset('public/frontendassets/images/offline.png') }}"/> Offline (Visited 2days ago)</h4>
           </div> 
           </div>
           
           <div class="row">
           <div class="col-lg-12">
             <ul class="teacher-cuntry">
               <li>User ID <span>{{$user->id}}</span></li>
               <li>From <span>{{$user->country_of_origin}}</span></li>
               <li>Living in  
               <span>{{$user->country_living_in}} <br> ({{date('d-M-Y h:i a')}})</span></li>
             </ul>
           </div> 
           </div>
            <hr>
            <div class="row">
              <div class="col-lg-12 col-12">
               <div class="languages-box">
               <h3>Teaches</h3>
                @php
                  $taughtLanguageArr = json_decode($user->languages_taught, true);  
                @endphp
                
                @if($user->languages_taught!='' && count($taughtLanguageArr)>0)
                <ul>
                   
                    @foreach($taughtLanguageArr as $key=>$value)
                        <li> 
                            <a href="javascript:void(0);">   
                            {{ $value['language'] }} <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"/> 
                            </a>
                        </li>
                    @endforeach
                
                </ul>
                @else
                <ul><li> N/A </li></ul>
                @endif
                
               <!--<ul>
                 <li><a href="#">English <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"></a></li>
                 <li><a href="#">German <img src="{{ asset('public/frontendassets/images/meter2.png') }}" class="img-fluid"></a></li>
                 <li><a href="#">Japanese <img src="{{ asset('public/frontendassets/images/meter3.png') }}" class="img-fluid"></a></li>
                 <li><a href="#">Chinese <img src="{{ asset('public/frontendassets/images/meter4.png') }}" class="img-fluid"></a></li>
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
                  $skillLanguageArr = json_decode($user->languages_spoken, true);  
                @endphp
                            
                @if($user->languages_spoken !='' && count($skillLanguageArr)>0)
                <ul>
                    @foreach($skillLanguageArr as $key=>$value)
                        @php
                          if($value['level']=='Native')
                            $l_img = 'meter4.png';
                          elseif($value['level']=='Beginner')
                            $l_img = 'meter4.png';
                          elseif($value['level']=='Elementary')
                            $l_img = 'meter3.png';
                          elseif($value['level']=='Intermediate')
                            $l_img = 'meter2.png';
                          elseif($value['level']=='Upper Intermediate')
                            $l_img = 'meter1.png';
                          elseif($value['level']=='Advanced')
                            $l_img = 'meter1.png';
                          elseif($value['level']=='Proficient')
                            $l_img = 'meter1.png';
                          elseif($value['level']=='')
                            $l_img = 'meter4.png';
                        @endphp
                        <li> 
                            <a href="javascript:void(0);">   
                            {{ $value['language'] }} <img src="{{ asset('public/frontendassets/images/'.$l_img) }}" class="img-fluid"/> 
                            </a>
                        </li>
                    @endforeach
                 
                </ul>
                @else
                N/A
                @endif
                
                
               <!--<ul>
                 <li><a href="#">Arabic <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"></a></li>
                 <li><a href="#">Hindi <img src="{{ asset('public/frontendassets/images/meter2.png') }}" class="img-fluid"></a></li>
               </ul>-->
               </div>
               <hr>
             </div> 
             
          </div>
          
          <div class="row">
              <div class="col-lg-4 col-12">
               <div class="lesson-total">
               <h3>{{$lessonCount}}</h3>
               <p>Lessons</p>
               </div>
             </div> 
             <div class="col-lg-4 col-12">
               <div class="lesson-total">
               <h3>{{$studentCount}}</h3>
               <p>Students</p>
               </div>
             </div>
             <div class="col-lg-4 col-12">
               <div class="lesson-total">
               <h3>{{$total_badges_count}}</h3>
               <p>Badges</p>
               </div>
             </div>
             
          </div>
          
           </div>
        </div>
        
        <div class="teacher-testimonial-review">
        @php 
            $numberOfReviews = 0;
            $totalStars = 0;
            $average = 0;
            
            foreach($review_rating as $key=>$value) {
                $numberOfReviews++;
                $totalStars += $value->rating;
            }
            
            if($numberOfReviews>0){
                $average = $totalStars/$numberOfReviews;
            }

        @endphp
        
        
                  
        <h3>Reviews</h3>
           <ul class="review-star">
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
            <li>{{number_format($average,1)}} Average</li>
           </ul>
            <div class="pt-3 pb-5">
              <div id="client-testimonial-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                  
                  
                  
                  @for($i=0;$i<count($review_rating);$i++)
                  <div @if($i == 0) class="carousel-item text-left active" @else class="carousel-item text-left" @endif>
                    
                    @php
                        $given_by = $review_rating[$i]->given_by;
                        
                        $studentData = DB::table('registrations')->where('id', $given_by)->latest('created_at')->first(); 
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                    
                    @foreach($review_rating as $key=>$value) 
                    <div class="my-lessons my-teacher-00 mt-3">
                        <div class="row mt-4">
                            <div class="col-lg-3 col-md-5 col-sm-12 col-12">
                                @if($exists && $studentData->profile_photo!='') 
                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                                @else
                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                @endif
                            </div>
                            <div class="col-lg-9 col-md-7 col-sm-12 col-12 p-0">
                               <h4> {{$studentData->name}}  <span><i class="fa fa-star" aria-hidden="true"></i> {{number_format($review_rating[$i]->rating, 1)}} </span></h4>
                               <h5> {{date('M d, Y',strtotime($review_rating[$i]->created_at))}} </h5> 
                               <p> {{$review_rating[$i]->review}} </p>
                               <!--<p><i class="fa fa-circle" aria-hidden="true"></i> Offline (Visited 2days ago)</p>-->
                            </div>  
                        </div>
                    </div>  
                    @endforeach  
                    
                    
                     
                  </div>
                  @endfor
                  
                  
                  
                </div>
                <ol class="carousel-indicators">
                  @for($i=0;$i<count($review_rating);$i++)
                  <li data-target="#client-testimonial-carousel" data-slide-to="{{$i}}"  @if($i == 0) class="active" @else class="" @endif></li>
                  @endfor
                  <!--<li data-target="#client-testimonial-carousel" data-slide-to="1"></li>
                  <li data-target="#client-testimonial-carousel" data-slide-to="2"></li>-->
                </ol>
              </div>
            </div>
      
        </div>  
     </div>
     
     <div class="col-lg-6 col-md-6 col-sm-12 col-12">
     
       <div class="languages-section mb-4">
          <div class="row">
            <div class="col-12 text-center">
                
                @if($user->youtube_link !='')
                    <iframe width="100%" height="315" src="{{ str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $user->youtube_link) }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="mb-4"></iframe>
                @elseif($user->video !='')
                    <video src="{{url('storage/app/video/'.$user->video)}}" controls width="98%" height="280px"></video>     
                @else
                    
                @endif
             
              <!--<iframe width="100%" height="315" src="https://www.youtube.com/embed/DLKSVdAZDZU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="mb-4"></iframe>-->
              
            <h2 class="mt-4">About Me</h2>
            <p>{!! $user->about_me !!}</p>

            <h2 class="mt-4">About My Lessons</h2>
            <p>{!! $user->about_my_lessons !!}</p>
            </div>
          </div>
          
        </div>
       
       
       <div class="information-section information-basic">
          <div class="education-part Lesson lesson-profiledetails">
            <div class="form-row part-title align-items-center">
                <div class="form-group col-md-4"><h3>Lessons</h3></div>
                <!--<div class="form-group col-md-4 text-right">
                  <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Structured lesson </a>
                
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>
                </div>
                <div class="form-group col-md-4 text-right">
                  <div class="dropdown show">
                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reading, Writing, +1
                  </a>
                
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                  </div>
                </div>-->
            </div>  
            
            @foreach($lessons as $val)      
            
            <div class="form-row Approved-row align-items-center">
                <div class="form-group col-md-8">
                    <p>{{$val->name}}</p>
                    <p>{{$val->lesson_category}} | {{$val->language_taught}}</p> 
                    <ul class="reading-corses">
                     <li><a href="javascript:void(0);">{{$val->lesson_tag}}</a></li> 
                    </ul>
                </div>
                         
                <div class="form-group col-md-4 text-right">
                   <a href="javascript:void(0);" class="uploaded">USD {{number_format($val->individual_lesson,2)}} </a>
                   <p class="mt-2"><small>{{$val->student_languages_level_from}} to {{$val->student_languages_level_to}}</small></p>
                   <a href="{{route('lesson-booking',['id'=>$user->id])}}" class="uploaded" > Book </a>
                </div>     
			</div>
			@endforeach
                   
                        
          </div>         
        </div>  
                     
        <div class="information-section resume-certificate">             
          <div class="education-part">
       
            <div class="form-row part-title align-items-center">
                <div class="form-group col-md-6"><h3>Resume</h3></div>
                 <div class="form-group col-md-6 text-right">
                    <div class="form-group text-right">
                    <div class="dropdown show">
                      <a class="btn btn-secondary" href="javascript:vid(0);"> Work Experience </a> 
                    </div>
                    </div>
                 </div>
            </div>
                  
                  
            @php
              $workExperienceArr = json_decode($user->experience, true);  
            @endphp  
            
            @if($user->experience!='' && count($workExperienceArr)>0)
                @foreach($workExperienceArr as $key=>$value)
                <div class="form-row Approved-row align-items-center">
                    <div class="form-group col-md-3">
                     <h4>{{ $value['experience_year'] }}</h4>
                    </div>
                
                    <div class="form-group col-md-9">
                        <p><strong>{{ $value['designation'] }}</strong><br>
        			    {{ $value['organization'] }}</p>
                    </div>   
                </div>
                @endforeach
            @endif
            
            
            <div class="form-row part-title align-items-center">
                <div class="form-group col-md-6"><h3></h3></div>
                 <div class="form-group col-md-6 text-right">
                    <div class="form-group text-right">
                    <div class="dropdown show">
                      <a class="btn btn-secondary" href="javascript:vid(0);"> Certificates </a> 
                    </div>
                    </div>
                </div>
            </div>
            
            @php
              $certificateArr = json_decode($user->certificate, true);  
            @endphp  
            
            @if($user->certificate!='' && count($certificateArr)>0)
                @foreach($certificateArr as $key=>$value)
                <div class="form-row Approved-row align-items-center">
                    <div class="form-group col-md-3">
                     <h4>{{ $value['certificate_year'] }}</h4>
                    </div>
                
                    <div class="form-group col-md-9">
                        <p><strong>{{ $value['certificate_designation'] }}</strong><br>
        			    {{ $value['certificate_organization'] }}</p>
                    </div>   
                </div>
                @endforeach
            @endif
            
            
          </div>
       </div>  
       
       <div class="badges-section">
            <h3>Badges</h3>
            
            @if(count($badges)>0)
            <ul class="budges-icon">
            
            @if(in_array("Specialises in Teaching Beginners", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_1.png') }}" class="img-fluid"/>
                <p>Specialises in Teaching Beginners</p>
                <span>1</span>
            </li>
            @endif
            
            @if(in_array("Works well with Intermediate Students", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_2.png') }}" class="img-fluid"/>
                <p>Works well with Intermediate Students</p>
                <span>1</span>
            </li>
            @endif
            
            @if(in_array("Challenges Advanced Students", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_3.png') }}" class="img-fluid"/>
                <p>Challenges Advanced Students</p>
                <span>20</span>
            </li> 
            @endif
            
            @if(in_array("Awesome Conversationalist", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_4.png') }}" class="img-fluid"/>
                <p>Awesome Conversationalist</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Great With Kids", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_5.png') }}" class="img-fluid"/>
                <p>Great With Kids</p>
                <span>100</span>
            </li> 
            @endif
            
            @if(in_array("Business Expert", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_6.png') }}" class="img-fluid"/>
                <p>Business Expert</p>
                <span>100</span>
            </li>
            @endif
            
            @if(in_array("Exam Preparation", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_7.png') }}" class="img-fluid"/>
                <p>Exam Preparation</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Structured Lessons", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_8.png') }}" class="img-fluid"/>
                <p>Structured Lessons</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Pronunciation and Accent Training", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_9.png') }}" class="img-fluid"/>
                <p>Pronunciation and Accent Training</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Grammar Guru", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_10.png') }}" class="img-fluid"/>
                <p>Grammar Guru</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Cultural Insights", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_11.png') }}" class="img-fluid"/>
                <p>Cultural Insights</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Excellent Materials", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_12.png') }}" class="img-fluid"/>
                <p>Excellent Materials</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Fun and Engaging", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_13.png') }}" class="img-fluid"/>
                <p>Fun and Engaging</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Patient", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_14.png') }}" class="img-fluid"/>
                <p>Patient</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Motivational", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_15.png') }}" class="img-fluid"/>
                <p>Motivational</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Well-prepared", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_16.png') }}" class="img-fluid"/>
                <p>Well-prepared</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Methodical", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_17.png') }}" class="img-fluid"/>
                <p>Methodical</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Punctual", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_18.png') }}" class="img-fluid"/>
                <p>Punctual</p>
                <span>50</span>
            </li>
            @endif
            
            @if(in_array("Tech Savvy", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_19.png') }}" class="img-fluid"/>
                <p>Tech Savvy</p>
                <span>50</span>
            </li> 
            @endif
            
            @if(in_array("Keeps Me Accountable", $badges))
            <li>
                <img src="{{ asset('public/frontendassets/images/budges_20.png') }}" class="img-fluid"/>
                <p>Keeps Me Accountable</p>
                <span>50</span>
            </li>  
            @endif
         </ul>
            @else
            
            @endif
        </div>
                                   
     </div>
      
     <div class="col-lg-3 col-md-3 col-sm-12 col-12">
          
     <div class="book-free blance-box trial-check">
         
        @foreach($lessons as $val) 
        <div class="row align-items-center">
         <div class="col-lg-10 col-md-10 col-sm-10 col-12">
          <h4>{{$val->name}}</h4>
          <small>{{$val->lesson_category}}</small>
          <h3>USD {{number_format($val->individual_lesson,2)}}</h3>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-12">
            <div class="custom-control custom-checkbox">
              <!--<input type="checkbox" class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1"></label>-->
            </div>
           </div>
        </div>
        <hr>
        @endforeach
        
        @if(count($lessons)>0)    
        <a href="{{route('lesson-booking',['id'=>Request::segment(2)])}}" class="btn-availability"> Book Now </a>
        @endif
          
        </div>
        
        <!--<div class="availabilliy-calender mt-4">
            <h3>September-2020</h3>
            <p>All times listed are in your local timezone</p>
        
            <table width="100%" cellspacing="0" cellpadding="0" border="1">
            <tbody>
              <tr>
                <td>&nbsp;</td>
                <td>Sun</td>
                <td>Mon</td>
                <td>Tue</td>
                <td>Wed</td>
                <td>Thu</td>
                <td>Fri</td>
                <td>Sat</td>
              </tr>
              <tr>
                <td>
                 <h4>Morning</h4>
                 <p>06:00-12:00</p>    
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="light-color-purple">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="light-color-purple">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><h4>Afternoon</h4><p>12:00-18:00</p></td>
                <td>&nbsp;</td>
                <td class="deep-color-purple">&nbsp;</td>
                <td class="dark-color-purple">&nbsp;</td>
                <td>&nbsp;</td>
                <td class="deep-color-purple">&nbsp;</td>
                <td class="dark-color-purple">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><h4>Evening</h4><p>12:00-18:00</p></td>
                <td class="dark-color-purple">&nbsp;</td>
                <td class="dark-color-purple">&nbsp;</td>
                <td class="deep-color-purple">&nbsp;</td>
                <td class="dark-color-purple">&nbsp;</td>
                <td class="dark-color-purple">&nbsp;</td>
                <td class="deep-color-purple">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><h4>Late Night</h4><p>00:00-06:00</p></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </tbody>
        </table>

            <a href="#" class="btn-availability"> Check Full Availability </a>
        </div>-->
      
     </div>
   </div>
  </div>
</section>


@include('include/footer')
