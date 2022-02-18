@include('include/head')
@include('include/header')

<section class="banner_sec">
 <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

          <ol class="carousel-indicators">
         
          @for($i=0;$i<count($banner_data);$i++)
         
          <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" @if($i == 0) class="active" @else class="" @endif></li>
             
          @endfor

        </ol>

          <div class="carousel-inner">

   @for($i=0;$i<count($banner_data);$i++)
            <div @if($i == 0) class="carousel-item active" @else class="carousel-item" @endif > <img class="img-fluid" src="{{ asset('storage/app/imagesdoc/'.$banner_data[$i]->image) }}" alt="First slide">
            

              <div class="carousel-caption">

                <div class="container">

                  <div class="row">

                    <div class="col-lg-12 text-left">
                        
                    @php
                    echo($banner_data[$i]->title)
                    @endphp   
                  
                       <form action="">         
                          <div class="input-group mb-4 border rounded-pill p-1">
                            <input type="search" placeholder="Find My Teacher" aria-describedby="button-addon3" class="form-control bg-none border-0">
                            <div class="input-group-append border-0">
                              <button id="button-addon3" type="button" class="btn btn-link text-success"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                        </form>
                    </div>

                </div>

              </div>

            </div>

            </div>
    @endfor

        </div>

     </div>
</section>

<section class="language-section">
  <div class="container">
   <div class="row">
       
    @foreach($languages_data as $key=>$values)   
    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
       <div class="language-box">
         <a href="{{route('teacher-search',['language'=>$values->name])}}"><span><img src="{{ asset('storage/app/language/'.$values->image) }}" class="img-fluid"/></span> 
             {{$values->name}} </a>
       </div>
    </div>
    @endforeach  
       
       
      
       
    </div>
  </div>
</section>

<div class="container">
 <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
   <h3 class="why-title">Why Learn with Tokatif</h3>
   </div>
  </div>
</div>

<section class="why-learn">
  <div class="container">
    <div class="row">
        @foreach($whylearns_data as $key_one=>$values_one) 
        
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
         <div class="why-box">
            <figure><img src="{{ asset('storage/app/whylearn/'.$values_one->image) }}" class="img-fluid"/> 
                <img src="{{ asset('storage/app/whylearn/'.$values_one->hover_image) }}" class="img-fluid img_hover"/></figure>
           <h4>{{$values_one->title}}</h4>
           <p> {{$values_one->description}}</p>
         </div>
      </div>
        @endforeach  
     
    </div>
  </div>
</section>

<div class="container">
 <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <a href="{{route('create-account')}}" class="start-btn">Start  Learning Now</a>
   </div>
  </div>
</div>


   
<section class="why-teach">
  <div class="container">
   <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <h3>Why Teach with Tokatif</h3>
   </div>
  </div>
   <div class="row">
    
    @foreach($whyteches_data as $key_one=>$values_one)   
    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
       <div class="teach-box">
          <div class="bg-icon"><img src="{{ asset('storage/app/whytech/'.$values_one->image) }}" class="img-fluid"/></div>
         <h4>{{$values_one->title}} </h4>
         <p>{{$values_one->description}}</p>
       </div>
    </div>
    @endforeach  

   </div>
   
   <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <a href="{{route('create-teacher-account')}}" class="start-teaching">Start Teaching Now</a>
   </div>
  </div>
  
  </div>

</section>

<section class="how-it-work">
  <div class="container">
   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <h3>How It Works</h3>
   </div>
   </div>
   <div class="row">
       
       
    @foreach($howitworks_data as $key_one=>$values_one)   
    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
       <div class="how-box how-box1" style="background-image:url({{ asset('storage/app/howitworks/'.$values_one->back_image) }});background-repeat: no-repeat;
background-position: bottom center;">
                     
            <figure><img src="{{ asset('storage/app/howitworks/'.$values_one->image) }}" class="img-fluid" ></figure>
            <h4>{{$values_one->title}} </h4>
            <p>{{$values_one->description}}</p>
        </div>
    </div>
    @endforeach
 
            
       
   </div>
 </div>
</section>

<section class="become-fluent">
   <div class="container">
     <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <h3>Become fluent in</h3>
   </div>
   </div>
     <div class="row">
         
         
         
         @foreach($becomefluents_data as $key_one=>$values_one)  
       <div class="col-lg-3 col-md-3 col-sm-4 col-6">
         <div class="fluent-box">
           <figure><img src="{{ asset('storage/app/becomefluent/'.$values_one->image) }}" class="img-fluid"/>
           <a href="{{route('teacher-search',['language'=>$values_one->title])}}">{{$values_one->title}}</a>
           </figure>
                    
         </div>
       </div>
          @endforeach
    
         
         
     </div>
     <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
        <h4>Don’t see the language you’re looking for?</h4>
        <a href="javascript:void(0);" class="start-teaching">Browse All Languages</a>
    </div>
  </div>
  </div>
</section>

@include('include/footer')
