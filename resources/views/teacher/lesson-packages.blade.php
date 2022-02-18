@include('include/head')

@include('include/teacher-dashboard-header')



@php

 $getLoggedIndata = getLoggedinData();

@endphp



<section class="lesson-package">

<div class="container">

  <div class="row">

  <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      @include('include/teacher-left-sidebar')
     </div>

   <div class="col-lg-9 col-md-9 col-sm-12 col-12">

        <ul class="nav nav-tabs" id="myTab" role="tablist">

          <li class="nav-item">

            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active Package</a>

          </li>

          <li class="nav-item">

            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inactive Package</a> 

          </li>

        </ul>

        <div class="tab-content" id="myTabContent">

          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            @if(count($active_packages)>0)

                @foreach($active_packages as $val)

                <div class="my-lesson-list">

                   <div class="row align-items-center">

                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">

                        <ul class="lesson-list-box">

                          <li><span class="upcoming-text">{{$val->name}}</span></li>

                          <li> {{$val->language_taught}} <br> Language</li>

                          <li> {{$val->time}} <br> Duration</li>

                        </ul>

                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">

                        <div class="row align-items-center lesson-list-right">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                         <!--<img src="images/profile-upload.png" class="img-fluid">-->

                        </div>

                       

                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">

                           <h4>Price: {{$val->total}} USD </h4>

                           <p>{{$val->package}}</p>

                        </div>  

         

                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->

                        </div>

                        

                    </div>

                      </div>

                   </div>

                </div>

                @endforeach

            @else

                <div class="my-lesson-list">

                   <div class="row align-items-center">

                      <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                        <ul class="lesson-list-box">

                          <li><span class="upcoming-text">No data found!!</span></li>

                        </ul>

                      </div>

                   </div>

                </div>

            @endif

            

        

          </div>

          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

              

            @if(count($inactive_packages)>0)

                @foreach($inactive_packages as $val)

                <div class="my-lesson-list">

                   <div class="row align-items-center">

                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">

                        <ul class="lesson-list-box">

                          <li><span class="upcoming-text">{{$val->name}}</span></li>

                          <li> {{$val->language_taught}} <br> Language</li>

                          <li> {{$val->time}} <br> Duration</li>

                        </ul>

                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">

                        <div class="row align-items-center lesson-list-right">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                         <!--<img src="images/profile-upload.png" class="img-fluid">-->

                        </div>

                       

                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">

                           <h4>Price: {{$val->total}} USD </h4>

                           <p>{{$val->package}}</p>

                        </div>  

         

                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->

                        </div>

                        

                    </div>

                      </div>

                   </div>

                </div>

                @endforeach

            @else

                <div class="my-lesson-list">

                   <div class="row align-items-center">

                      <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                        <ul class="lesson-list-box">

                          <li><span class="upcoming-text">No data found!!</span></li>

                        </ul>

                      </div>

                   </div>

                </div>

            @endif

            

            <!--<div class="my-lesson-list">

               <div class="row align-items-center">

                  <div class="col-lg-8 col-md-8 col-sm-8 col-12">

                    <ul class="lesson-list-box">

                      <li><h4> 15 </h4> Nov</li>

                      <li> 03:00 AM <br> <span class="upcoming-text">Upcoming In 32 Days</span></li>

                      <li> Chinese <br> Language</li>

                      <li> 30 minutes <br> Duration</li>

                    </ul>

                  </div>

                  <div class="col-lg-4 col-md-4 col-sm-4 col-12">

                    <div class="row align-items-center lesson-list-right">

                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                     <img src="images/profile-upload.png" class="img-fluid"></div>

                   

                    <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">

                       <h4>Mr. Zhang</h4>

                       <p>473 Lessons</p>

                    </div>  

     

                    <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                     <a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

                    </div>

                    

                </div>

                  </div>

               </div>

            </div> --> 

          </div> 

        </div>

   

    </div>

   </div>

  </div>

</section>





@include('include/footer')



















