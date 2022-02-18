@include('include/head')
@include('include/teacher-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp

<section class="teacher-contain">
<div class="container">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      @include('include/teacher-left-sidebar')
     </div>
     
     <div class="col-lg-6 col-md-6 col-sm-12 col-12">
       <div class="row align-items-center">
         <div class="col-lg-4 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Current Balance</p>
           <h4>${{number_format($getLoggedIndata->teacher_wallet_amount,2)}} USD</h4>
           
          </div>
         </div>
         <div class="col-lg-8 col-md-8 col-sm-8 col-12 pr-0">
          <div class="blance-box">
            <!--<p> Total Booking </p>-->
            <!--<div style="width: 100%; height: 40px; position: absolute; top: 47.5%; left: 8px; margin-top: -20px; line-height:19px; text-align: center; z-index: 999999999999999">
                {{$totalBooking}} <Br /> Total
            </div>-->
            <div id="teacherChartContainer"></div> 
          </div>
         </div>
       </div>
       <div class="row mt-4">
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Average Rating</p>
           <h4><i class="fa fa-star" aria-hidden="true"></i> {{$average_rating}} </h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> +{{$average_rating}} Rating </a>
          </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Total Badges</p>
           <h4>{{$totalBadges}}</h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> +{{$totalBadges}} Badges</a>
          </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Total Lessons</p>
           <h4>{{$lessonCount}}</h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> +{{$lessonCount}} Lessons</a>
          </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Total Students</p>
           <h4>{{$studentCount}}</h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>+{{$studentCount}} Students</a>
          </div>
         </div>
       </div>
       <div class="row mt-4">
         <div class="col-lg-12 col-12">
            <div id="lineChartContainer" style="height: 150px; width: 100%;"></div>
         </div> 
       </div>

       <div class="row mt-4">
         <div class="col-lg-12 col-12">
            <div id="lineChartContainer_2" style="height: 150px; width: 100%;"></div> 
         </div> 
       </div>

       <!-- <div class="row mt-4">
         <div class="col-lg-12 col-12">
          <?php
          $july_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')
                                    ->whereMonth('lesson_completed_at', '07')
                                    ->whereYear('lesson_completed_at', date('Y'))->get(); 

          //echo "<pre>"; print_r($july_HT_Data);
          $july_HT = 0;
          if(count($july_HT_Data)>0) {
            foreach($july_HT_Data as $val){
                $start = $val->lesson_started_at;
                $end = $val->lesson_completed_at;

                $seconds = strtotime($end) - strtotime($start);

                $days    = floor($seconds / 86400);
                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                

                $july_HT += $minutes;

                echo "min:: ".$minutes."<br>";
            }
          }

          if($july_HT > 1){
            $july_HT = floor($july_HT / 60);
          }
          echo $july_HT;
          ?>
        </div>
      </div> -->
       
     </div>
     
     

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
       <!--<div class="student-left-sidebar"></div>-->
      <div class="profile-box right-pic-profile">
           <div class="row">
             <div class="col-12">
               <div class="img-profile">
                    @php 
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $getLoggedIndata->profile_photo );
                    @endphp
                    
                    @if($exists && $getLoggedIndata->profile_photo!='') 
                        <img src="{{url('storage/app/user_photo/'.$getLoggedIndata->profile_photo)}}" class="img-fluid">
                    @else
                        <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                    @endif
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
               <div class="col-lg-12">
                   <h3>{{$getLoggedIndata->name}} </h3> <!--<div class="flag flag-us"></div>-->  
               </div> 
           </div>
           
           <div class="row">
           <div class="col-lg-12">
             <ul>
               <li>User ID <span>{{$getLoggedIndata->id}} </span> </li>
               <li>From <span>{{$getLoggedIndata->country_of_origin}}</span></li>
               <li>Living in  <span>{{$getLoggedIndata->country_living_in}} <br> ({{date('d-M-Y h:i a')}})</span> </li>
             </ul>
           </div> 
           </div>
           
           </div>  
        <div class="my-lessons my-teacher-00 recommended-teacher mt-4 upcoming-lessons">
            @if(count($booking)>0)
            <div class="row">
                <div class="col"><h2>Upcoming Lessons </h2></div>
            </div>
            
            @foreach($booking as $val)
                @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                @endphp
            <div class="row mt-4 align-items-center">
                <div class="col-lg-4 col-md-3 col-sm-12 col-12 pr-0">
                 <div class="duration-box">
                   <h6><span>{{$lessonPackageData->package}}</span></h6>
                 </div>
                </div>
               
                <div class="col-lg-7 col-md-7 col-sm-12 col-12 pr-0">
                   <h5>{{$lessonData->name}}</h5>
                   <p>{{$lessonData->language_taught}} - {{$lessonPackageData->time}}</p> 
                   <h4>{{$studentData->name}}</h4>
                </div>  
 
                <!--<div class="col-lg-1 col-md-2 col-sm-12 col-12 p-0">
                 <a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>-->
                
            </div>  
            @endforeach
            @endif
            
            
          </div>
     </div>

   </div>
  </div>
</section>

@include('include/footer')
