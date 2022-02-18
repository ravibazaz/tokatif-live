@php

 $websitedata = getwebsite_data();

 $loggedindata = getLoggedinData();

@endphp 

   

<header>



<section class="logo-part">

    <div id="nav_bg">

    <div class="container-fluid"> 

      <div class="row justify-content-end">

        <div class="col-lg-6 col-md-5 col-sm-6 col-12">

          <a class="navbar-brand float-left d-inline-block" href="{{url('/')}}">

            <img src="{{ asset('storage/app/imagesdoc/'.$websitedata[0]->logo) }}" class="img-fluid"/>

          </a>

          <a class="navbar-brand float-left d-none" href="{{url('/')}}">

            <img src="{{ asset('storage/app/imagesdoc/'.$websitedata[0]->logo) }}" class="img-fluid"/>

          </a>

          <div class="follow-social social-top float-right">

              <ul>

                <li><a target="_blank" href="{{$websitedata[0]->facebook_link}}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                <li><a target="_blank" href="{{$websitedata[0]->linkedin_link}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                <li><a target="_blank" href="{{$websitedata[0]->twitter_link}}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

              </ul>

            </div>
            

          @include('include/header-search')

          

        </div> 

        

        <div class="col-lg-4 col-md-6 col-sm-4 col-12 float-right text-right pr-lg-0">

            

            

            @if(Session::has('id'))

                @if($loggedindata->role!='2') 

                    <a class="log-in" href="{{route('teachers')}}"><i class="fa fa-search" aria-hidden="true"></i> Find a Teacher</a>

                @endif

            @else

                <a class="log-in" href="{{route('teachers')}}"><i class="fa fa-search" aria-hidden="true"></i> Find a Teacher</a>

            @endif

               

          

              

          

          

          @if(Session::has('id'))

            @if($loggedindata->role=='1') 

                <a class="bnt-teach" href="{{route('student-dashboard')}}">Dashboard</a> 

            @else

                <a class="bnt-teach" href="{{route('teacher-dashboard')}}">Dashboard</a>

            @endif 

          

            <a class="log-in" href="{{URL::route('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>

          @else

          <a class="bnt-teach" href="{{route('create-teacher-account')}}">Teach with us</a> 

          <a class="bnt-teach" href="{{route('create-account')}}">Learn with us</a>

         
        </div>
        
        
         <div class="col-lg-2 col-md-1 col-sm-2 col-12 float-right text-right">
         
         
         
            <a class="log-in" href="{{route('login')}}"><i class="fa fa-user-o" aria-hidden="true"></i> Log in</a>

          <a class="log-in" href="{{route('create-account')}}"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</a>

          @endif
         </div>

         

    </div>

    </div>

  </div>

</section>



  <!--<div class="navbar_wrap">

    <section class="top_head">



      <div class="container">



        <div class="row">



          <div class="col-lg-8 col-md-12 col-sm-12">



            <div class="top-top">



              <ul class="list-inline">



                <li class="list-inline-item"><i class="fa fa-phone" aria-hidden="true"></i><a href="#" target="_blank">1-800-123-1234</a></li>



                <li class="list-inline-item"><i class="fa fa-paper-plane" aria-hidden="true"></i> <a href="#" target="_blank">aislingkellynutrition@gmail.com</a></li>

                

                <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i><a href="#" target="_blank">Mon-Sat: 9am to 6pm</a></li> 	   		



              </ul>     



            </div>



                   



          </div>

          <div class="col-lg-4 col-md-12 col-sm-12">



            <div class="social_top">



              <ul class="list-inline">



                <li class="list-inline-item"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i>

</a></li>



                <li class="list-inline-item"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i>

</a></li>

                

                <li class="list-inline-item"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li> 	   		



              </ul>     



            </div>



                   



          </div>



        </div>



      </div>



    </section>

  </div>-->



</header>

