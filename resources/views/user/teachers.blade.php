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







@include('user/teacher-search-bar')





<section class="find-teacher-section">

 <div class="container-fluid">

     <h2>Found Best Teacher for You </h2>

	<div class="row">

	    

       <div class="col-md-12" id="teacherListDiv"> 

        

        @if(count($user)>0)   

            @foreach($user as $val)

            <div class="find-teacher-box mb-4">

                

                <div class="row">

                    

                     <div class="col-lg-9 col-md-9 col-sm-12 col-12">

                        

                        <div class="row">

                           <div class="col-lg-3 col-md-3 col-sm-3 col-12">

                            <a href="{{route('teacher-detail',['id'=>$val->id])}}">

                            <div class="find-profile">

                                @php 

                                    $exists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );

                                @endphp

                             

                                @if($exists && $val->profile_photo!='') 

                                  <img src="{{url('storage/app/user_photo/'.$val->profile_photo)}}" class="img-fluid">

                                @else

                                  <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                                

                            

                            

                                

                            @php $flag = ''; @endphp

                            @if($val->country_living_in!='')

                                @php

                                    $countryFlagData = DB::table('countries')->where('name', '=', $val->country_living_in)->first(); 

                                    $flag = strtolower($countryFlagData->sortname);

                                @endphp

                            @else

                                @php

                                    $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

                                    $flag = strtolower($countryFlagData->sortname);

                                @endphp

                            @endif

                            

                            <span class="find-offline">

                                

                                @if($flag)

                                    <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">

                                @else

                                    <img src="{{ asset('public/frontendassets/images/flage.png') }}" class="img-fluid"> 

                                @endif

                                

                                <!--<img src="{{ asset('public/frontendassets/images/fine-offline.png') }}" class="img-fluid"/>-->

                            </span>

                           </div>

                            </a>

                           </div>

                           <div class="col-lg-9 col-md-9 col-sm-9 col-12">

                             <div class="row">

                               <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-0">

                                <a href="{{route('teacher-detail',['id'=>$val->id])}}">

                                    <h4> {{$val->name}} <span> </span> </h4>

                                    <p>

                                        @php
                                          
                                          $teacherType = '';
                                          if($val->teacher_type=='specialist_teacher')

                                            $teacherType = 'Specialist Teacher';

                                          elseif($val->teacher_type=='community_tutor')

                                            $teacherType = 'Community Tutor';

                                          

                                        @endphp

                    

                                        {{ $teacherType }}

                                        

                                    </p>

                                </a>

                               </div>

                               

                               <div class="col-lg-4 col-md-4 col-sm-4 col-12 pr-0">

                                <ul class="bdg-icon">

                                 <li>

                                 <img src="{{ asset('public/frontendassets/images/bdg1.png') }}" class="img-fluid"/>

                                  <span class="tool-tips">Hover over me</span>

                                 </li>

                                 <li><img src="{{ asset('public/frontendassets/images/bdg2.png') }}" class="img-fluid"/>

                                  <span class="tool-tips">Hover over 2</span>

                                 </li>

                                 <li><img src="{{ asset('public/frontendassets/images/bdg3.png') }}" class="img-fluid"/>

                                 <span class="tool-tips">Hover over 3</span>

                                 </li>

                                </ul> 

                               </div>

                               <div class="col-lg-4 col-md-4 col-sm-4 col-12 pr-0 text-right">

                                @if(session('id'))

                                    @php

                                        $favoriteData = DB::table('favorite_teachers')->where('student_id', '=', session('id')) 

                                                                                    ->where('teacher_id', '=', $val->id)

                                                                                    ->where('deleted_at', '=', null)->count(); 

                                    @endphp

                                <div class="heard-purple">

                                    @if($favoriteData>0)

                                        <img src="{{ asset('public/frontendassets/images/purple-heard.png') }}" class="FavoriteList img-fluid" data-teacherID="{{$val->id}}" data-type="remove" style="cursor: pointer;" /> 

                                    @else

                                        <img src="{{ asset('public/frontendassets/images/heart-red.png') }}" class="FavoriteList img-fluid" data-teacherID="{{$val->id}}" data-type="add" style="cursor: pointer;" />

                                    @endif

                                </div>

                                @endif

                                

                                @php $currentWeek = date("W", strtotime(date('Y-m-d'))); @endphp

                                <a href="{{route('lesson-booking',['id'=>$val->id])}}" class="book-btn">Book</a> 

                               </div>

                             </div>

                              <div class="row mt-3">

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">

                                 <div class="r-box">

                                    @php

                                        $lessonCount = DB::table('lessons')->where('user_id', '=', $val->id)->where('deleted_at', '=', null)->count();

                                    @endphp

                                   <h3>{{$lessonCount}}</h3>

                                   <p>Lessons</p>

                                 </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">

                                 <div class="r-box">

                                    @php

                                        $studentCount = DB::table('booking')->where('teacher_id', '=', $val->id)->distinct('student_id')->count('student_id');

                                    @endphp

                                   <h3>{{$studentCount}}</h3>

                                   <p>Students</p>

                                 </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">

                                 <div class="r-box hourly">

                                    @php

                                    $minLessonsPrice = DB::table('lessons')

                                                        ->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')

                                                        ->whereNull('lessons.deleted_at')

                                                        ->where('lessons.user_id', '=', $val->id)

                                                        ->min('lesson_packages.total'); 

                                    @endphp

                                   <h3>USD {{number_format($minLessonsPrice,2)}} </h3>

                                   <p>Min Booking Price</p>

                                 </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                 <div class="r-box hourly">

                                    @php

                                    $maxLessonsPrice = DB::table('lessons')

                                                        ->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')

                                                        ->whereNull('lessons.deleted_at')

                                                        ->where('lessons.user_id', '=', $val->id)

                                                        ->max('lesson_packages.total'); 

                                    @endphp

                                   <h3>USD {{number_format($maxLessonsPrice,2)}}</h3>

                                   <p>Max Booking Price</p>

                                   <!--<p>Trial</p>-->

                                 </div>

                                </div>

                              </div>

                           </div>                        

                        </div>

                        <hr/>

                        <div class="row"> 

                          <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                            <div class="languages-box">

                               <h3>Teaches</h3>

                                @php

                                  $taughtLanguageArr = json_decode($val->languages_taught, true);  

                                @endphp

                                

                                @if($val->languages_taught!='' && count($taughtLanguageArr)>0)

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

        					</div>

                          </div> 

                          <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                           <div class="languages-box">

                               <h3>Also Speak</h3>

                                @php

                                  $skillLanguageArr = json_decode($val->languages_spoken, true);  

                                @endphp

                                

                                @if($val->languages_spoken !='' && count($skillLanguageArr)>0)

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

        					</div>

                          </div>

                        </div>

                        

                     </div>

                    

                 

                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                        <div class="find-video">

                         @if($val->youtube_link !='')

                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/8iRfiAxPgBc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                         @elseif($val->video !='')

                            <video src="{{url('storage/app/video/'.$val->video)}}" controls width="100%" height="280px"></video>     

                         @else

                         {{$val->about_me}}

                         @endif

                        </div>

                    </div> 

                </div>

            </div>

            @endforeach

        @else

        <div class="find-teacher-box mb-4 text-center">

            No teacher found!!

        </div>

        @endif

        

        

        

       </div>



	</div>

  </div>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



<script src="https://cdn.jsdelivr.net/gh/andreivictor/bootstrap-tooltip-custom-class@1.1.0/bootstrap-v4/tooltip/dist/js/bootstrap-tooltip-custom-class.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/13.1.5/nouislider.js"></script>



<script>

$(".box-video").click(function(){

  $('iframe',this)[0].src += "&amp;autoplay=1";

  $(this).addClass('open');

});

</script>





<script>



document.addEventListener("DOMContentLoaded", function(){

  window.addEventListener('scroll', function() {

      if (window.scrollY > 50) {

        document.getElementById('navbar_top').classList.add('fixed-top');

        // add padding top to show content behind navbar

        navbar_height = document.querySelector('.navbar').offsetHeight;

        document.body.style.paddingTop = navbar_height + 'px';

      } else {

        document.getElementById('navbar_top').classList.remove('fixed-top');

         // remove padding top from body

        document.body.style.paddingTop = '0';

      } 

  });

}); 

// DOMContentLoaded  end

</script>







<script>



var rangeSlider = document.getElementById('slider-range');



noUiSlider.create(rangeSlider, {

    start: [4000],

    range: {

        'min': [1],

        'max': [10000]

    }

});

var rangeSliderValueElement = document.getElementById('slider-range-value');

rangeSlider.noUiSlider.on('update', function (values, handle) {

    rangeSliderValueElement.innerHTML = values[handle];

});

</script>



<script>

//$(document).click(function(e) {

//	if (!$(e.target).is('.card-body')) {

//    	$('.card-body').collapse('hide');	    

//    } 

//});



jQuery('button').click( function(e) {

    jQuery('#headingSix').collapse('hide');

});



</script>









@include('include/footer')









