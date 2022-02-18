@include('include/head')

@if(session('id')!='' && session('role')=='1')
    @include('include/student-dashboard-header')
@elseif(session('id')!='' && session('role')=='2')
    @include('include/teacher-dashboard-header')
@else
    @include('include/header')
@endif

@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp



<section class="lesson-contain">
<div class="container">
    
    @if(Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{Session::get('success')}}</div>
    @endif
    @if(Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Note!</strong> {{Session::get('error')}}</div>
    @endif
    
        
  <div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-12">

        <form id="regForm" action="{{ route('post-new-lesson-date') }}" method="POST" enctype="multipart/form-data" > 
            {{ csrf_field() }}
            
            <input type="hidden" class="form-control" name="id" value="{{$getLoggedIndata->id}}" />
            <input type="hidden" class="form-control" name="role" value="{{$getLoggedIndata->role}}" />
            <input type="hidden" class="form-control" name="booking_id" value="{{$booking->id}}" />
        <h1>Lesson Reschedule</h1>    
        <!-- Circles which indicates the steps of the form: -->
        <div class="total-line" style="text-align:center;margin-top:20px; position: relative;">
          <span class="step"></span>
          <span class="step"></span>
        </div>
        
        
            
        <div class="tab">
         <h3>Schedule lesson</h3>       
         <div class="reschedule-lesson">
            <div class="calender-Schedule">
  
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <label>Form select</label>
                    <div class="input-group">
                        @php $tomorrow = date("Y-m-d", strtotime('tomorrow')); @endphp
                        <input type="date" name="new_booking_date" min="{{$tomorrow}}" class="form-control"> 
                        <!--<div class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>-->
                    </div>
                  </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                             <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Time</label>
                                <select class="form-control" name="new_booking_time" id="exampleFormControlSelect1">
                                    <?php 
                                        $start = strtotime('00:00');
                                        $end   = strtotime('23:30');
                                        for ($i=$start; $i<=$end; $i = $i + 30*60){
                                           echo '<option value="'.date('H:i',$i).'">'.date('H:i',$i).'</option>';
                                        }
                                    ?>
                                </select>
                             </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
         </div>
        </div>
        
        <div class="tab invitation-jack">
         <p>Send lesson invitation to</p>
          <img src="{{ asset('public/frontendassets/images/lesson-reschedule.png') }}" class="img-fluid"/>
            <h4>{{$name}}</h4>
            <p>{{$lesson_name}}<br/>
            {{$lesson_category}}<br/>
            {{$lesson_tag}}<br/>
            {{$language_taught}}</p>
            
          <button type="submit" class="btn-invitation">Send</button>  
        </div>
        
        <div style="overflow:auto;" id="prv_nxt_div"> 
          <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
          </div>
        </div>
        
        

		</form>
     </div>
   </div>
  </div>
</section>




@include('include/footer')


<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) { //alert("p:: "+n);
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
  
  if(n==1){
      document.getElementById("prv_nxt_div").style.visibility = "hidden";
  }
  
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>
