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





<section class="support-list">

  <div class="container">

    <div class="row">
    
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        @if(session('id')!='' && session('role')=='2')
            @include('include/teacher-left-sidebar')
        @endif
     </div>

      <div class="col-lg-9 col-md-9 col-sm-12 col-12 m-auto">

          

        @foreach($support as $val)

            

            @php 

                $exists = file_exists( storage_path() . '/app/support/' . $val->image ); 

            @endphp



        <div class="g__space"> 

          <!--<a href="/en/collections/2415332-help-for-users" class="paper ">-->

          <div class="collection o__ltr paper">

            <div class="collection__photo">

			 @if($exists && $val->image!='') 

                <img src="{{url('storage/app/support/'.$val->image)}}" class="img-fluid"> 

             @else

                <img src="{{ asset('public/frontendassets/images/help.png') }}" class="img-fluid">   

             @endif

            </div>

            <div class="collection_meta" dir="ltr">

              <h2 class="t__h3 c__primary">{{$val->title}}</h2>

              <p class="paper__preview">{{$val->description}}</p>

              <div class="avatar">

                <div class="avatar__photo avatars__images o__ltr">  

                <img src="{{url('storage/app/fabicon.ico')}}" alt="Stacy avatar" class="avatar__image"> </div>

                <div class="avatar__info">

                  <div> <span class="c__darker"> Written by </span> <br>

                     <span class="c__darker"> Admin </span> </div>

                </div>

              </div>

            </div> 

          </div>

          <!--</a> -->

        </div>

        @endforeach

          

          

              

      </div>

    </div>

  </div>

</section>





@include('include/footer')









