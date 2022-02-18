
@include('include/head')
@include('include/student-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
@endphp


<section class="rate-lesson ration-system">
<div class="container-fluid">
      @if(Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{Session::get('success')}}
      </div>
      @endif
      @if(Session::get('error'))
      <div class="alert alert-danger alert-dismissible fade show">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Note!</strong> {{Session::get('error')}}
      </div>
      @endif
      
      
  <div class="row">

    <div class="col-lg-6 col-md-12 col-sm-12 col-12 m-auto">
        
       <form action="{{ url('feedback/'.Request::segment(2)) }}" method="POST" enctype="multipart/form-data" > 
        
        {{ csrf_field() }}
        <input type="hidden" class="form-control" name="id" value="{{$getLoggedIndata->id}}" />
        <input type="hidden" class="form-control" name="role" value="{{$getLoggedIndata->role}}" />
        <input type="hidden" class="form-control" name="booking_id" value="{{Request::segment(2)}}" /> 
                        
       <div class="audio-video text-center">
        <h3>Rate Your Lesson</h3>
        <p>Gill-Tuseday, January30,2018 12:00</p>
         <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-6 col-12 audio-section">
                <h5><i class="fa fa-volume-up" aria-hidden="true"></i></h5>
                <h3>Audio Quality</h3>
                <h4>Shared with Verbling to ensure quality <br/> (Required) </h4>
                <div class="rating justify-content-md-center">
			     
                  <input type="radio" id="rating1" name="rating" value="1">
                  <label id="1" title="Poor" class="fa fa-star" for="rating1"></label>
                  
                  <input type="radio" id="rating2" name="rating" value="2">
                        <label id="2" title="Average" class="fa fa-star" for="rating2"></label>
                
                  
                  <input type="radio" id="rating3" name="rating" value="3">
                  <label id="3" title="Average" class="fa fa-star" for="rating3"></label>
                     
                  
                  <input type="radio" id="rating4" name="rating" value="4">
                  <label id="4" title="Good" class="fa fa-star" for="rating4"></label>
                  
                  
                  <input type="radio" id="rating5" name="rating" value="5">
                  <label id="5" title="Awesome" class="fa fa-star" for="rating5"></label>
                
                </div>
                <input type="hidden" name="audio_quality_rating" id="audio_quality_rating" value="" />
                
                @if ($errors->has('audio_quality_rating'))
                    <span class="text-danger">{{ $errors->first('audio_quality_rating') }}</span>
                @endif
           </div>
           <div class="col-lg-6 col-md-6 col-sm-6 col-12 audio-section video-icon">
                <h5><i class="fa fa-video-camera" aria-hidden="true"></i></h5>
                <h3>Video Quality</h3>
               <h4>Shared with Verbling to ensure quality <br/> (Required) </h4>
			    <div class="rating justify-content-md-center">
			    
                  <input type="radio" id="rating6" name="rating" value="1">
                  <label id="6" title="Poor" class="fa fa-star" for="rating1"></label>
                  
                  <input type="radio" id="rating7" name="rating" value="2">
                        <label id="7" title="Average" class="fa fa-star" for="rating2"></label>
                
                  
                  <input type="radio" id="rating8" name="rating" value="3">
                  <label id="8" title="Average" class="fa fa-star" for="rating3"></label>
                     
                  
                  <input type="radio" id="rating9" name="rating" value="4">
                  <label id="9" title="Good" class="fa fa-star" for="rating4"></label>
                  
                  
                  <input type="radio" id="rating10" name="rating" value="5">
                  <label id="10" title="Awesome" class="fa fa-star" for="rating5"></label>
                
                </div>
                
                <input type="hidden" name="video_quality_rating" id="video_quality_rating" value="" /> 
                
                @if ($errors->has('video_quality_rating'))
                    <span class="text-danger">{{ $errors->first('video_quality_rating') }}</span>
                @endif
                
           </div>
        </div> 
       <div class="row"> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
        <!--<button type="submit" class="btn btn-primary text-right">Done</button>-->
         </div>
        </div>
       </div> 
       <!--audio-video-end-->
       
       <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-12 audio-section text-center">
                <div class="teacher-reviewimg"><img src="{{ asset('public/frontendassets/images/teacher-review-img.png') }}" class="img-fluid"/></div>
                <h3>Teacher Rating</h3>
                <p>Anonymous Your name will not be shown.(Required)</p>
			    <div class="rating justify-content-md-center">
			    
                  <input type="radio" id="rating11" name="rating" value="1">
                  <label id="11" title="Poor" class="fa fa-star" for="rating1"></label>
                  
                  <input type="radio" id="rating12" name="rating" value="2">
                  <label id="12" title="Average" class="fa fa-star" for="rating2"></label>
                                 
                  <input type="radio" id="rating13" name="rating" value="3">
                  <label id="13" title="Average" class="fa fa-star" for="rating3"></label>
                                      
                  <input type="radio" id="rating14" name="rating" value="4">
                  <label id="14" title="Good" class="fa fa-star" for="rating4"></label>                 
                  
                  <input type="radio" id="rating15" name="rating" value="5">
                  <label id="15" title="Awesome" class="fa fa-star" for="rating5"></label>
                
                </div>
                <input type="hidden" name="teacher_rating" id="teacher_rating" value="" />  
                
                @if ($errors->has('teacher_rating'))
                    <span class="text-danger">{{ $errors->first('teacher_rating') }}</span>
                @endif
           </div>
        </div>
        
       <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-12 type-text">
         
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Write a Review</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="review" rows="3" placeholder="public shared on teacher's profile with your name."></textarea>
            @if ($errors->has('review'))
                <span class="text-danger">{{ $errors->first('review') }}</span>
            @endif
          </div>

         </div>
       </div>
       
       <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-12 type-text">
         
          <div class="form-group private-feedback">
            <label for="exampleFormControlTextarea1">Private Feedback</label>
             <p>Shared with verbling to ensure quality (Required)</p>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="private_feedback" rows="3" placeholder="public Shared on teacher's profile with your name."></textarea>
            @if ($errors->has('private_feedback'))
                <span class="text-danger">{{ $errors->first('private_feedback') }}</span>
            @endif
          </div>
          
          
          
         
         </div>
       </div>
       
       <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-12 type-text">       
          <div class="form-group private-feedback">
            <label for="exampleFormControlTextarea1">Comment</label>
             <p>Public,Shared on teacher's profile with your name.(Optional)</p>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="comments" rows="3" placeholder="public Shared on teacher's profile with your name."></textarea>
            @if ($errors->has('comments'))
                <span class="text-danger">{{ $errors->first('comments') }}</span>
            @endif
          </div> 
         </div>
       </div>
       
        <div class="row"> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                <!--<button type="submit" class="btn btn-primary text-right">Continue</button>-->
            </div>
        </div>
        
        <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-12 type-text">       
            <div class="badges-section rating-badges">
                <h3>Badges</h3>
                @if ($errors->has('badges'))
                    <span class="text-danger">{{ $errors->first('badges') }}</span>
                @endif
                <ul class="budges-icon">
                    <li>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck1" name="badges[]" value="Specialises in Teaching Beginners">
                        <img src="{{ asset('public/frontendassets/images/budges_1.png') }}" class="img-fluid">
                        <p>Specialises in Teaching Beginners</p>
                        <span>20</span>
                    </div>
                   </li>
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck2" name="badges[]" value="Works well with Intermediate Students">
                <img src="{{ asset('public/frontendassets/images/budges_2.png') }}" class="img-fluid">
                <p>Works well with Intermediate Students</p>
                <span>20</span>
            </div>
           </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck3" name="badges[]" value="Challenges Advanced Students">
                <img src="{{ asset('public/frontendassets/images/budges_3.png') }}" class="img-fluid">
                <p>Challenges Advanced Students</p>
                <span>20</span>
            </div>
           </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck4" name="badges[]" value="Awesome Conversationalist">
                <img src="{{ asset('public/frontendassets/images/budges_4.png') }}" class="img-fluid">
                <p>Awesome Conversationalist</p>
                <span>50</span>
            </div>
           </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck5" name="badges[]" value="Great With Kids">
                <img src="{{ asset('public/frontendassets/images/budges_5.png') }}" class="img-fluid">
                <p>Great With Kids</p>
                <span>100</span>
            </div>
           </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck6" name="badges[]" value="Business Expert">
                <img src="{{ asset('public/frontendassets/images/budges_6.png') }}" class="img-fluid">
                <p>Business Expert</p>
                <span>100</span>
            </div>
           </li>
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck7" name="badges[]" value="Exam Preparation">
                <img src="{{ asset('public/frontendassets/images/budges_7.png') }}" class="img-fluid">
                <p>Exam Preparation</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck8" name="badges[]" value="Structured Lessons">
                <img src="{{ asset('public/frontendassets/images/budges_8.png') }}" class="img-fluid">
                <p>Structured Lessons</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck9" name="badges[]" value="Pronunciation and Accent Training">
                <img src="{{ asset('public/frontendassets/images/budges_9.png') }}" class="img-fluid">
                <p>Pronunciation and Accent Training</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck10" name="badges[]" value="Grammar Guru">
                <img src="{{ asset('public/frontendassets/images/budges_10.png') }}" class="img-fluid">
                <p>Grammar Guru</p>
                <span>50</span>
            </div>
          </li>
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck11" name="badges[]" value="Cultural Insights">
                <img src="{{ asset('public/frontendassets/images/budges_11.png') }}" class="img-fluid" >
                <p>Cultural Insights</p>
                <span>50</span>
            </div>
          </li>  
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck12" name="badges[]" value="Excellent Materials">
                <img src="{{ asset('public/frontendassets/images/budges_12.png') }}" class="img-fluid">
                <p>Excellent Materials</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck13" name="badges[]" value="Fun and Engaging">
                <img src="{{ asset('public/frontendassets/images/budges_13.png') }}" class="img-fluid">
                <p>Fun and Engaging</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck14" name="badges[]" value="Patient">
                <img src="{{ asset('public/frontendassets/images/budges_14.png') }}" class="img-fluid">
                <p>Patient</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck15" name="badges[]" value="Motivational">
                <img src="{{ asset('public/frontendassets/images/budges_15.png') }}" class="img-fluid">
                <p>Motivational</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck16" name="badges[]" value="Well-prepared">
                <img src="{{ asset('public/frontendassets/images/budges_16.png') }}" class="img-fluid">
                <p>Well-prepared</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck17" name="badges[]" value="Methodical">
                <img src="{{ asset('public/frontendassets/images/budges_17.png') }}" class="img-fluid">
                <p>Methodical</p>
                <span>50</span>
            </div>
          </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck18" name="badges[]" value="Punctual">
                <img src="{{ asset('public/frontendassets/images/budges_18.png') }}" class="img-fluid">
                <p>Punctual</p>
                <span>50</span>
            </div>
          </li>
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck19" name="badges[]" value="Tech Savvy">
                <img src="{{ asset('public/frontendassets/images/budges_19.png') }}" class="img-fluid">
                <p>Tech Savvy</p>
                <span>50</span>
            </div>
           </li> 
                    <li>
            <div class="form-check">
                <input type="checkbox" class="form-check-input badgesCheckbox" id="exampleCheck20" name="badges[]" value="Keeps Me Accountable">
                <img src="{{ asset('public/frontendassets/images/budges_20.png') }}" class="img-fluid">
                <p>Keeps Me Accountable</p>
                <span>50</span>
            </div>
          </li>  
                </ul>
            </div> 
        </div>
       </div>
       
        <div class="row"> 
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right mt-3">
                <button type="submit" class="btn btn-primary text-right">Submit</button>
            </div>
        </div>
        
     </form>
    </div>    
   </div>
  </div>
</section>

@include('include/footer')

