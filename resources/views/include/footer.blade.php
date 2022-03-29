@php
 $websitedata = getwebsite_data();
 $getLoggedIndata = getLoggedinData();
@endphp



<footer>

<section class="top_foot">

  <div class="container">

    <div class="row">

      <div class="col-lg-9 col-md-9 col-sm-12 col-12">

       <div class="call-to-action">

          <div class="cta-bg bg-primary-color">

              @if(Session::get('success_n'))

              <div class="alert alert-success alert-dismissible fade show">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                <strong>Success!</strong> {{Session::get('success_n')}}</div>

              @endif

              @if(Session::get('error_n'))

              <div class="alert alert-danger alert-dismissible fade show">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                <strong>Note!</strong> {{Session::get('error_n')}}</div>

              @endif

              <div class="row">

                  <div class="col-lg-6 col-12">

                      <div class="contact-info">

                          <div class="cta-contact-icon">

                              <i class="fa fa-envelope" aria-hidden="true"></i>

                          </div>

                          <div class="cta-contact-content">

                              <div class="cta-contact-text">Signup for newsletter</div>

                          </div>

                      </div>

                  </div>

                  <div class="col-lg-6 col-12">

                      <div class="newsletter-form mrt-md-40">

                          <form action="{{ route('newsletter-email') }}" method="POST"> 

                          {{ csrf_field() }}

                              <div class="form-group clearfix">

                                  <input type="email" name="newsletter_email" value="{{Request::old('newsletter_email')}}" placeholder="Email address" required>

                                  @if ($errors->has('newsletter_email'))

                                    <span class="text-danger">{{ $errors->first('newsletter_email') }}</span>

                                  @endif

                                  <button type="submit" class="newsletter-btn">Submit</button>

                              </div>

                          </form>

                      </div>

                  </div>

              </div>

          </div>

          </div>

           </div>

    </div>

    @php

        $websitedata = getwebsite_data();



    @endphp   

    <div class="foor_wrap wow bounceInUp">



      <div class="row">

      <div class="col-lg-3 col-md-6 col-sm-8 col-12"> 

      <a href="{{url('/')}}"><img src="https://staging.tokatif.com/public/frontendassets/images/footerlogo.png" class="img-fluid"/></a>

       <p>{{$websitedata[0]->footer_content}}</p>

          

            <div class="follow-social">
                <ul>
                    <li><a target="_blank" href="{{$websitedata[0]->facebook_link}}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="{{$websitedata[0]->linkedin_link}}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    <li><a target="_blank" href="{{$websitedata[0]->twitter_link}}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            
            <p>Email: team@tokatif.com <br>
                Location: Perth, Western Australia
            </p>
             

      </div>



        <div class="col-lg-3 col-md-6 col-sm-4 col-12">



          <div class="phone_nav">



            <h2>Language or subject</h2>



            <ul>

                <li><a href="{{route('teacher-search',['language'=>'English'])}}" > English</a></li>

                <li><a href="{{route('teacher-search',['language'=>'Chinese'])}}" > Chinese (Mandarin)</a></li>

                <li><a href="{{route('teacher-search',['language'=>'Korean'])}}" > Korean</a></li>

                <li><a href="{{route('teacher-search',['language'=>'Japanese'])}}" > Japanese</a></li>      

                <li><a href="{{route('teacher-search',['language'=>'French'])}}" > French</a></li>

                <li><a href="{{route('teacher-search',['language'=>'Italian'])}}" > Italian</a></li>

                <li><a href="{{route('teacher-search',['language'=>'German'])}}" > German</a></li>

                <li><a href="{{route('teacher-search',['language'=>'Spanish'])}}" > Spanish</a></li>

            </ul>

          </div> 







        </div>



       <div class="col-lg-2 col-md-6 col-sm-4 col-12">

          <!--<div class="phone_nav">

            <h2>More</h2>

            <ul>

            <li><a href="#">Tokatif Apps</a></li>

            <li><a href="#">Buy a Gift Card</a></li>

            <li><a href="#">Refer a Friend and</a></li>

            <li><a href="#">Get $10 Affili</a></li>

            </ul>

        </div>-->

        </div>



          



        <div class="col-lg-2 col-md-6 col-sm-4 col-12">

          <div class="phone_nav">

            <h2>Link</h2>

            <ul>
                <li><a href="{{route('community')}}">Community</a></li>
                <li><a href="{{route('support')}}">Support</a></li>

                <li><a href="{{route('privacy-policy')}}">Privacy Policy </a></li>
                <li><a href="{{route('terms')}}">Terms of Use</a></li>
            </ul>

        </div>

        </div>



       <div class="col-lg-2 col-md-6 col-sm-4 col-12">

         <form class="Language-dollar">

          <div class="form-group">

            <select id="inputState" class="form-control">

              <option selected>English</option>

              <option>English</option>

              <option>English</option>

              <option>English</option>

            </select>

          </div>

          <div class="form-group">

            <select id="inputState" class="form-control">

              <option selected>USD $</option>

              <option>USD $</option>

              <option>USD $</option>

              <option>USD $</option>

              <option>USD $</option>

            </select>

          </div>

          <form>

        </div>



      </div>



    </div>

  </div>

</section>

      

      <input type="hidden" id="base_url" value="{{url('')}}">



<section class="cwrite_sec">



  <div class="container text-center">

    <p> {{$websitedata[0]->copyright_content}}</a></p>

    

  </div>



</section>



</footer>





<!-- jQuery first, then Popper.js, then Bootstrap JS --> 

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script> 



<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 



<script type="text/javascript" src="{{asset('public/frontendassets/js/bootstrap.min.js')}}"></script> 





<!--Sticky--> 

<script type="text/javascript" src="{{asset('public/frontendassets/sticky/jquery.stickit.js')}}"></script>





<!--Owl Carousel Assets--> 

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>





<!-- Animation Assets -->

<script src="{{asset('public/frontendassets/js/wow.min.js')}}"></script>

<script src="{{asset('public/frontendassets/js/custom.js')}}"></script>





<!--<script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>-->

<!--<script src="{{asset('public/assets/dist/js/app.js')}}"></script>-->





<!-- sweetalert js -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">





<!-- doughnut-chart js -->

<script src="https://canvasjs.com/assets/script/canvasjs.stock.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



<!-- stripe js -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>





<script src="{{asset('public/frontendassets/js/master.js')}}"></script>





<!-- datatable js -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>







<?php

/*$chatDefault = '';

$chatDefaultID = '';



if(session('id')!=''){

    $chatDefault = DB::table('registrations')->where('id', '<>', session('id'))->where('deleted_at', '=', null)->first();

    $chatDefaultID = $chatDefault->id;

}*/



?>



<script>

var APP_URL = {!! json_encode(url('/')) !!}



$(document).ready( function (){

    

    $('#myTable').DataTable({

        dom: 'Bfrtip',

        buttons: [

            'csv', 'excel', 'pdf', 'print'

            //'copy', 'csv', 'excel', 'pdf', 'print'

        ]

    });

});





/*CKEDITOR.replace( 'editor1' );*/



// make a function to scroll down auto

function scrollToBottomFunc() { console.log("auto scroll.....");

    $('.message-wrapper').animate({

        scrollTop: $('.message-wrapper').get(0).scrollHeight

    }, 50);



}

    

    



    var receiver_id = '';

    //var my_id = "{{ Auth::id() }}";

    var my_id = "{{ session('id') }}";

    var urlSegment = "{{ Request::segment(1) }}";

    

    $(document).ready(function () { 

        

        console.log("loggedin ID: "+my_id);

        

        if(my_id!='' && urlSegment!=''){

            if(urlSegment=='messages'){

                //alert(urlSegment);

            }

        }

        

        // ajax setup form csrf token

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });



        // Enable pusher logging - don't include this in production

        Pusher.logToConsole = true;



        var pusher = new Pusher('43b01b9eacaaaf81c105', {

          cluster: 'ap2',

          //forceTLS: true

        });



        var channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function (data) {

            // alert(JSON.stringify(data));

            if (my_id == data.from) {

                $('#' + data.to).click();

            } else if (my_id == data.to) {

                if (receiver_id == data.from) {

                    // if receiver is selected, reload the selected user ...

                    $('#' + data.from).click();

                } else {

                    // if receiver is not seleted, add notification for that user

                    var pending = parseInt($('#' + data.from).find('.not-seen').html());



                    if (pending) {

                        $('#' + data.from).find('.not-seen').html(pending + 1);

                    } else {

                        $('#' + data.from).append('<span class="not-seen">1</span>');

                    }

                }

            }

        });



        //$('.user').click(function () {

        $(document).on('click', '.user', function (e) {

            $('.user').removeClass('active');

            $(this).addClass('active');

            $(this).find('.pending').remove();



            receiver_id = $(this).attr('id'); 

            $.ajax({

                type: "get",

                url: APP_URL+'/message/'+receiver_id,

                //url: "message/" + receiver_id, // need to create this route

                data: "",

                cache: false,

                success: function (data) {

                    $('#chatMessages').html(data);

                    scrollToBottomFunc();

                }

            });

        });

        

        $(document).on('keyup', '.chatUserSearch', function (e) {

            var searchName = $(this).val();

            console.log("searchName: "+searchName);

            

            if(searchName!=''){

                $.ajax({

                    type: "get",

                    url: APP_URL+'/search-chat-user/'+searchName,

                    data: "",

                    cache: false,

                    success: function (data) {

                        $('#chatUsers').html(data);

                    }

                });

            }else{

                location.reload();

            }

            

        });    



        $(document).on('keyup', '.chat-box-tray input', function (e) {

            var message = $(this).val();



            // check if enter key is pressed and message is not null also receiver is selected

            if (e.keyCode == 13 && message != '' && receiver_id != '') {

                $(this).val(''); // while pressed enter text box will be empty



                var datastr = "receiver_id=" + receiver_id + "&message=" + message;

                $.ajax({

                    type: "post",

                    url: APP_URL+'/message',

                    //url: "message", // need to create this post route

                    data: datastr,

                    cache: false,

                    success: function (data) {

                        $.ajax({

                            type: "get",

                            url: "message/" + receiver_id, // need to create this route

                            data: "",

                            cache: false,

                            success: function (cdata) {

                                $('#messages').html(cdata);

                                scrollToBottomFunc();

                            }

                        });

                    },

                    error: function (jqXHR, status, err) {

                    },

                    complete: function () {

                        scrollToBottomFunc();

                    }

                })

            }

        });

        

        $(document).on('click', '.sendChatMsg', function (e) {

            var message = $('#chat_textbox').val();



            // check if enter key is pressed and message is not null also receiver is selected

            if (e.keyCode == 13 && message != '' && receiver_id != '') {

                $('#chat_textbox').val(''); // while pressed enter text box will be empty



                var datastr = "receiver_id=" + receiver_id + "&message=" + message;

                $.ajax({

                    type: "post",

                    url: APP_URL+'/message',

                    //url: "message", // need to create this post route

                    data: datastr,

                    cache: false,

                    success: function (data) {

                        $.ajax({

                            type: "get",

                            url: "message/" + receiver_id, // need to create this route

                            data: "",

                            cache: false,

                            success: function (cdata) {

                                $('#messages').html(cdata);

                                scrollToBottomFunc();

                            }

                        });

                    },

                    error: function (jqXHR, status, err) {

                    },

                    complete: function () {

                        scrollToBottomFunc();

                    }

                })

            }

        });

        

        // Send Attachment

        $(document).on('change','.chat_file',function(event){ 



            var fd = new FormData();

            var files = $('#file')[0].files;

            

            // Check file selected or not

            if(files.length > 0 ){

               fd.append('file',files[0]); 

               

               $.ajax({

                  url: APP_URL+'/chat-file/'+receiver_id,

                  type: 'POST',

                  data: fd,

                  contentType: false,

                  processData: false,

                  success: function(response){

                     if(response != 0){

                        $.ajax({

                            type: "get",

                            url: "message/" + receiver_id, // need to create this route

                            data: "",

                            cache: false,

                            success: function (cdata) {

                                $('#messages').html(cdata);

                                scrollToBottomFunc();

                            }

                        });

                     }else{

                        alert('file not uploaded');

                     }

                  },

               });

            }else{

               alert("Please select a file.");

            }

        });

        

    });



    

</script>





<script>

// ------------step-wizard-------------

$(document).ready(function () {

    $('.nav-tabs > li a[title]').tooltip();

    

    //Wizard

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {



        var target = $(e.target);

    

        if (target.parent().hasClass('disabled')) {

            return false;

        }

    });



    $(".next-step").click(function (e) {



        var active = $('.wizard .nav-tabs li.active');

        active.next().removeClass('disabled');

        nextTab(active);



    });

    $(".prev-step").click(function (e) {



        var active = $('.wizard .nav-tabs li.active');

        prevTab(active);



    });

});



function nextTab(elem) {

    $(elem).next().find('a[data-toggle="tab"]').click();

}

function prevTab(elem) {

    $(elem).prev().find('a[data-toggle="tab"]').click();

}





$('.nav-tabs').on('click', 'li', function() {

    $('.nav-tabs li.active').removeClass('active');

    $(this).addClass('active');

});





</script>



<script>



/*$("input[type='checkbox']").change(function(){

    if($(this).is(":checked")){

        $(this).parent().addClass("redBackground"); 

    }else{

        $(this).parent().removeClass("redBackground");  

    }

});*/







$('.ncheck:button').click(function(){

    var checked = !$(this).data('checked');

    $('input:checkbox').prop('checked', checked);

    $(this).val(checked ? 'Unsubscribe From All' : 'Subscribe All' )

    $(this).data('checked', checked);

});







// Header search ====================================================================

$('.teacherSearchApplyBtn').on("click", function() {

    var selectedFilter = $(this).attr('data-filter');  

    //alert(selectedFilter);

    

    if(selectedFilter=='country'){

        var checkboxValues = [];

        $('input[name=searchCountryName]:checked').map(function() {

            checkboxValues.push($(this).val());

        });

    

        var searchData = checkboxValues;

    }

    

    if(selectedFilter=='language'){ 

        var checkboxValues = [];

        $('input[name=searchLanguageName]:checked').map(function() {

            checkboxValues.push($(this).val());

        });

    

        var searchData = checkboxValues;

    }

    

    if(selectedFilter=='price'){ 

        var lessonPrice =  $("#slider-range-value").text();   

        var searchData = lessonPrice;

    }

    

    if(selectedFilter=='teacherType'){ 

        var teacher_type = $('input[name="teacher_type_search"]:checked').val(); 

        var searchData = teacher_type;

    }

    

    if(selectedFilter=='lessonType'){ 

        var checkboxValues = [];

        $('input[name=searchLessonType]:checked').map(function() {

            checkboxValues.push($(this).val());

        });

    

        var searchData = checkboxValues;

    }

    

    if(selectedFilter=='nativeSpeaker'){ 

        var speaker_type = $('input[name="speaker_type_search"]:checked').val(); 

        var searchData = speaker_type;

    }

    

    if(selectedFilter=='instantTutoring'){ 

        var instant_tutoring = $('input[name="instant_tutoring_search"]:checked').val(); 

        var searchData = instant_tutoring;

    }

    

    if(selectedFilter=='focusAreas'){ 

        var checkboxValues = [];

        $('input[name=searchfocusAreas]:checked').map(function() {

            checkboxValues.push("'"+$(this).val()+"'"); 

        });

    

        var searchData = checkboxValues;

    }

    

    if(selectedFilter=='availability'){ 

        var dayName = $(this).attr('data-DayName'); 

    }

    

    if(selectedFilter!=''){

        var dataString = {

                            search:searchData,

                            type:selectedFilter

                        };

        

        $.ajax({

            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

            url:"{{ route('post-teacher-search') }}",

            type: "POST",

            data: dataString,

            beforeSend: function() {

                var loader = APP_URL+'/public/frontendassets/images/loader.gif'; 

                $("#teacherListDiv").html("<img src='"+loader+"' style='margin-top: -400px;' />"); 

            },

            success: function(data){ //console.log(data);

                $('#teacherListDiv').html('');

                $('#teacherListDiv').html(data);

            }

        });            

    }

    

    //if (!$(e.target).is('.panel-body')) {

    	$('.collapse').collapse('hide');	    

    //}

    

});



$('#header_search_teacher').on("keyup", function() {

    var search = this.value;

    console.log(search);

    

    var dataString = {

                        search:search, 

                        type:'name'

                    };

    //if(search!=''){

        $.ajax({

            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

            url:"{{ route('post-teacher-search') }}",

            type: "POST",

            data: dataString,

            beforeSend: function() {

                var loader = APP_URL+'/public/frontendassets/images/loader.gif'; 

                $("#teacherListDiv").html("<img src='"+loader+"' style='' />"); 

            },

            success: function(data){ //console.log(data);

                $('#teacherListDiv').html('');

                $('#teacherListDiv').html(data);

            }

        });

    //}

});





// Student add credit ==========================================================



$(document).on('click','.slot-box',function(){  
    $('.slot-box').removeClass('active');
    $(this).addClass("active");

    $(this).find('input[type=radio]').prop("checked", true);

    var radioValue = $("input[name='creditAmount']:checked").val();     //alert("zz: "+radioValue);
    
    //$('#old_price').val(radioValue);
    $('#credit_amount').val(radioValue);
    $('#creditvalue').val(radioValue);
    $('#creditAmtSpan').text(radioValue); 
    $('.creditAmtDiv').text('USD '+radioValue); 
});







/*$('.searchCountryNameClass').on("click", function() {

    var checkboxValues = [];

    $('input[name=searchCountryName]:checked').map(function() {

        checkboxValues.push($(this).val());

    });

    //console.log(checkboxValues);

    

    var dataString = {

                        search:checkboxValues,

                        type:'country'

                    };

    

    $.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url:"{{ route('post-teacher-search') }}",

        type: "POST",

        data: dataString,

        beforeSend: function() {

            var loader = APP_URL+'/public/frontendassets/images/loader.gif'; 

            $("#teacherListDiv").html("<img src='"+loader+"' style='' />"); 

        },

        success: function(data){ //console.log(data);

            $('#teacherListDiv').html('');

            $('#teacherListDiv').html(data);

        }

    });

    

});*/









// Add More Languages Spoken ========================================================

var langBoxesWrap = $('#reg-boxes-wrap');

var langBoxRow = langBoxesWrap.children(":first");

var langBoxRowTemplate = langBoxRow.clone();

langBoxRow.find('button.remove-reg-lang-row').remove();



var rInputCount = 1; 



$('#langAppend').click(function () {

    var newRow = langBoxRowTemplate.clone();

    rInputCount++;

    $(".regLangDiv").append(newRow);

});  

  

$('#reg-boxes-wrap').on('click', 'div.remove-reg-lang-row', function () {

    var numberOfSpans = $('#reg-boxes-wrap').children('div').length; 

    if(numberOfSpans>1){

        $(this).parent().parent().remove();

    }

});







// Add More Languages Taught ========================================================

var taughtBoxesWrap = $('#taught-boxes-wrap');

//var taughtBoxRow = taughtBoxesWrap.children(":first");

var taughtBoxRow = taughtBoxesWrap.children().slice(0,2);

var taughtBoxRowTemplate = taughtBoxRow.clone();

taughtBoxRow.find('button.remove-taught-lang-row').remove();



var tInputCount = 1; 



$('#taughtAppend').click(function () {

    var newRow = taughtBoxRowTemplate.clone();

    tInputCount++;

    $(".taughtLangDiv").append(newRow);

});  

  

$('#taught-boxes-wrap').on('click', 'div.remove-taught-lang-row', function () { 

    var numberOfSpans = $('#taught-boxes-wrap').children('div').length; 

    if(numberOfSpans>1){

        $(this).parent().parent().remove();

    }

});





// Add More Education ===============================================================

var eduBoxesWrap = $('#edu-boxes-wrap');

var eduBoxRow = eduBoxesWrap.children(":first");

var eduBoxRowTemplate = eduBoxRow.clone();

eduBoxRow.find('button.remove-edu-row').remove();



var eduInputCount = 1; 



$('#eduAppend').click(function () {

    var newRow = eduBoxRowTemplate.clone();

    eduInputCount++;

    $(".educationDiv").append(newRow);

});  

  

$('#edu-boxes-wrap').on('click', 'div.remove-edu-row', function () {

    var numberOfSpans = $('#edu-boxes-wrap').children('div').length; 

    if(numberOfSpans>1){

        $(this).parent().remove();

    }

});







// Add More Work Experience =========================================================

var wExpBoxesWrap = $('#wExp-boxes-wrap');

var wExpBoxRow = wExpBoxesWrap.children(":first");

var wExpBoxRowTemplate = wExpBoxRow.clone();

wExpBoxRow.find('button.remove-wExp-row').remove();



var wExpInputCount = 1; 



$('#wExpAppend').click(function () {

    var newRow = wExpBoxRowTemplate.clone();

    wExpInputCount++;

    $(".wExpDiv").append(newRow);

});  

  

$('#wExp-boxes-wrap').on('click', 'div.remove-wExp-row', function () {

    var numberOfSpans = $('#wExp-boxes-wrap').children('div').length; 

    if(numberOfSpans>1){

        $(this).parent().remove();

    }

});









// Add More Certificates ============================================================

var certBoxesWrap = $('#cert-boxes-wrap');

var certBoxRow = certBoxesWrap.children(":first");

var certBoxRowTemplate = certBoxRow.clone();

certBoxRow.find('button.remove-cert-row').remove();



var certInputCount = 1; 



$('#certAppend').click(function () {

    var newRow = certBoxRowTemplate.clone();

    certInputCount++;

    $(".certDiv").append(newRow);

});  

  

$('#cert-boxes-wrap').on('click', 'div.remove-cert-row', function () {

    var numberOfSpans = $('#cert-boxes-wrap').children('div').length; 

    if(numberOfSpans>1){

        $(this).parent().remove();

    }

});





</script>



<style>

#image-preview {

	margin-top:20px;

}

#image-preview .image-view {

    display: inline-block;

	position:relative;

	margin-right: 13px;

	margin-bottom: 13px;

}

#image-preview .image-view img {

    max-width: 100px;

    max-height: 100px;

}

#image-preview .overlay {

    position: absolute;

    width: 100%;

    height: 100%;

    top: 0;

    right: 0;

    z-index: 2;

    background: rgba(255,255,255,0.5);

}



.canvasjs-chart-credit{

    display: none;

}

</style>



<style>

    .message-wrapper {

        border: 1px solid #dddddd;

        overflow-y: auto;

    }



    .message-wrapper {

        padding: 10px;

        /*height: 536px;

        background: #eeeeee;*/

    }

    

    .bookingPopup {

        cursor:pointer;

    }

</style>









<script>

$('#upload-photo').change(function() {

    var url = window.URL.createObjectURL(this.files[0]);



    $("#frame").html('');

    $("#frame").append('<img src="'+window.URL.createObjectURL(this.files[0])+'" width="100px" height="100px"/>');

});



$('#upload-photo-1').change(function() {

    var url = window.URL.createObjectURL(this.files[0]);



    $("#a_frame").html('');

    $("#a_frame").append('<img src="'+window.URL.createObjectURL(this.files[0])+'" width="100px" height="100px"/>');

});



$('#t-upload-photo').change(function() {

    var url = window.URL.createObjectURL(this.files[0]);



    $("#image-preview").html('');

    $("#image-preview").append('<img src="'+window.URL.createObjectURL(this.files[0])+'" width="100px" height="100px"/>');

});





$(document).on('click','.teacherType',function(){  

    $('.teacherType').removeClass('community-tutors-bg');

    $(this).addClass("community-tutors-bg");

    

    var searchType = $(this).attr('data-searchType');       

    $('#teacherTyp').val(searchType);

});









// Edit profile js

$('#my_profile_photo').change(function() {  

    var url = window.URL.createObjectURL(this.files[0]);



    $("#view_uploaded_photo").html('');

    $("#view_uploaded_photo").append('<img src="'+window.URL.createObjectURL(this.files[0])+'" class="img-fluid"/>');

});





// Add community photo js

$('#community_photo').change(function() {  

    var url = window.URL.createObjectURL(this.files[0]);



    $("#community_photo_frame").html('');

    $("#community_photo_frame").append('<img src="'+window.URL.createObjectURL(this.files[0])+'" class="img-fluid"/>');

});







// Teacher Add lesson Page =====================================================================================

    $('select[name="lesson_category"]').on('change', function() { //console.log('Base URL:: '+APP_URL);

        var category = $(this).val(); //console.log(category); 

        if(category) {

            $.ajax({

                url: APP_URL+'/add-lesson/ajax/'+encodeURI(category),

                type: "GET",

                dataType: "json",

                success:function(data) { console.log(data);

                    $('select[name="lesson_tag[]"]').empty();

                    $.each(data, function(key, value) {

                        if(key===null){key='';} 

                        if(value===null){value='Tag not found!';}

                        $('select[name="lesson_tag[]"]').append('<option value="'+ key +'">'+ value +'</option>');

                    });

                }

            });

        }else{

            $('select[name="lesson_tag[]"]').empty();

        }

    });

    

    

    $('#student_languages_level_from').change(function() {

        var student_languages_level_from = $(this).val();

        //alert(student_languages_level_from);

        

        $("#student_languages_level_to").val("");

        $("#student_languages_level_to option").attr("disabled", false);

        $("#student_languages_level_to option").css("background-color",""); 

        

        if(student_languages_level_from=='A2'){

            $('#student_languages_level_to option[value="A1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A1"]').attr('style', 'background-color:#c7c7c7;');

        }else if(student_languages_level_from=='B1'){

            $('#student_languages_level_to option[value="A1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A1"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="A2"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A2"]').attr('style', 'background-color:#c7c7c7;');

        }else if(student_languages_level_from=='B2'){

            $('#student_languages_level_to option[value="A1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A1"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="A2"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A2"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="B1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="B1"]').attr('style', 'background-color:#c7c7c7;');

        }else if(student_languages_level_from=='C1'){

            $('#student_languages_level_to option[value="A1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A1"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="A2"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A2"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="B1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="B1"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="B2"]').attr("disabled", true);

            $('#student_languages_level_to option[value="B2"]').attr('style', 'background-color:#c7c7c7;');

        }else if(student_languages_level_from=='C2'){

            $('#student_languages_level_to option[value="A1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A1"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="A2"]').attr("disabled", true);

            $('#student_languages_level_to option[value="A2"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="B1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="B1"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="B2"]').attr("disabled", true);

            $('#student_languages_level_to option[value="B2"]').attr('style', 'background-color:#c7c7c7;');

            

            $('#student_languages_level_to option[value="C1"]').attr("disabled", true);

            $('#student_languages_level_to option[value="C1"]').attr('style', 'background-color:#c7c7c7;');

        }else{

            

        }

        

        

    });

    

    

    

    // Lession Booking ===============================================================================================

    $('.lesson-box-select').click(function(e) {  

        $(this).addClass("active");

        $(this).find('input[type=radio]').prop("checked", true);

        

        var selectedLessonId = $(this).attr('data-lessonId'); 

        //alert("selected LessonId:: "+selectedLessonId); 

        

        $.ajax({

                url: APP_URL+'/lesson-packages',

                type: 'POST',

                data: {

                    lesson_id: selectedLessonId

                },

                success: function (response) {

                    $('#lesson_packages_table').append(response);

                }

            });

    });

    

    $('.communication-row').click(function(e) {  

        $('.communication-row').removeClass("active");

        $(this).addClass("active");

        $(this).find('input[type=radio]').prop("checked", true);

        

        var accID = $("input[name='communication_tool']:checked").val();   //alert(accID);

        

        if(accID){

            $(".getBookingData").prop("disabled", false);

            

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            $.ajax({

                url: APP_URL+'/fetch-communication-tool-account-id/'+encodeURI(accID),

                type: 'GET',

                success: function (response) {

                    $('#communication_account_id').val(response); 

                    $('#payment_communication_tool').val(accID);

                    $('#payment_communication_account_id').val(response);

                }

            });

        }

        

    });

    

    

    // Calendar Availability ===========================================================================================

    $('.bookingPopup').click(function(e) {     

        

        var selectedDate = $(this).attr('data-Date');  

        $('#selected_date').val(selectedDate);

        

        var selectedDay = $(this).attr('data-Day'); 

        $('#selected_dayBtn').val(selectedDay);

        

        var selectedDateBtn = $(this).attr('data-DateBtn'); 

        $('#selected_dateBtn').val(selectedDateBtn);

        

        

        if(selectedDate) { //alert(selectedDate); 

            $.ajax({

                url: APP_URL+'/time-slot/'+encodeURI(selectedDate),

                type: "GET",

                success:function(data) {  //console.log(data);

                    $('#addTeacherAvailability').modal("show");

                    $('#timesDiv').html(data).show();

                    $("#availabilityButton").html( '<button type="button" data-BtnType="weekly" class="apply_availability confirm-btn apply-weekly btn btn-big btn-main"><span>APPLY TO ALL '+selectedDay+'s</span></button>&nbsp;&nbsp;<button type="button" data-BtnType="one_day" class="apply_availability confirm-btn apply-today btn btn-big btn-main"><span>APPLY TO '+selectedDateBtn+' ONLY</span></button>' );

                }

            });

        }

        

        

        

    });

    

    

    $('#from_time').change(function() {

      var from_time = $(this).val();

      

      $('#to_time').val('');

      

      var myArray = {id1: '00:00', id2: '00:30', id3: '01:00', id4: '01:30', id5: '02:00', id6: '02:30', id7: '03:00',

                  id8: '03:30', id9: '04:00', id10: '04:30', id11: '05:00', id12: '05:30', id13: '06:00', id14: '06:30',

                  id15: '07:00', id16: '07:30', id17: '08:00', id18: '08:30', id19: '09:00', id20: '09:30',

                  id21: '10:00', id22: '10:30', id23: '11:00', id24: '11:30', id25: '12:00', id26: '12:30',

                  id27: '13:00', id28: '13:30', id29: '14:00', id30: '14:30', id31: '15:00', id32: '15:30',

                  id33: '16:00', id34: '16:30', id35: '17:00', id36: '17:30', id37: '18:00', id38: '18:30',

                  id39: '19:00', id40: '19:30', id41: '20:00', id42: '20:30', id43: '21:00', id44: '21:30',

                  id45: '22:00', id46: '22:30', id47: '23:00', id47: '23:30'};



      for (var key in myArray) {

        $("#to_time option[value='"+myArray[key]+"']").removeAttr("disabled");

        $("#to_time option[value='"+myArray[key]+"']").css('background-color', '#ffffff');

        if(myArray[key]<=from_time){

          //console.log("key " + key + " has value " + myArray[key]);

          $("#to_time option[value='"+myArray[key]+"']").attr("disabled","disabled");

          $("#to_time option[value='"+myArray[key]+"']").css('background-color', '#d8d8d8');

        }

      }



    });

    

    

    

    

    $(document).on('click','.apply_availability',function(e){ 

        

        var selectedDate = $('#selected_date').val();

        var applyBtnType = $(this).attr('data-BtnType'); 

        

        var fromTime=[]; 

        $('select[name="from_time[]"] option:selected').each(function() {

          fromTime.push($(this).val());

        });

        

        var toTime=[]; 

        $('select[name="to_time[]"] option:selected').each(function() {

          toTime.push($(this).val());

        });

        

        

        $.ajax({

                url: APP_URL+'/add-teacher-time-slot',

                type: 'POST',

                data: {

                    applyBtnType: applyBtnType,

                    date: selectedDate,

                    from_time: fromTime,

                    to_time: toTime,

                },

                success: function (response) {

                    $('#addTeacherAvailability').modal('toggle');

                    

                    swal({

                          title: "Success",

                          text: "Slot has been saved successfully.",

                          type: "success",

                          confirmButtonClass: 'btn-success',

                          confirmButtonText: 'Ok!'

                        },function(){

                            window.location.reload();

                        });

                }

            });

    });

    

    

    

    

    

    // Book a Slot =============================================================

    

    $(document).on('click','.ping-bg',function(e){ 

        

        var date = $(this).attr('data-date'); 

        var time = $(this).attr('data-time'); 

        

        $('.ping-bg').removeClass('light-bg'); 

        $(this).addClass("light-bg");

         

        

        //alert(date+' >> '+time);

        

        $("#booking_date").val(date);

        $("#booking_time").val(time);

        

    });

    

    

    

    

    // Add More Time Slot ======================================================

    

    $(document).on('click','#timeSlotAppend',function(e){ 

        var timeSlot = $('#newTimeSlot');

        var timeSlotRow = timeSlot.children(":first");

        var timeSlotRowTemplate = timeSlotRow.clone();

        timeSlotRow.find('button.remove-time-row').remove();

        

        var timeInputCount = 1; 

        

        $('#timeSlotAppend').click(function () {

            var newRow = timeSlotRowTemplate.clone();

            timeInputCount++;

            $(".timeSlotDiv").append(newRow);

        });

    });   

      

      

    $('#newTimeSlot').on('click', 'div.remove-time-row', function () {

        var numberOfSpans = $('#newTimeSlot').children('div').length; 

        if(numberOfSpans>1){

            $(this).parent().remove();

        }

    });

    

    

    //var selected = $('.category').val();

    //console.log(selected);

    

    

    // Booking Data ============================================================

    $(document).on('click','.getLessonPackageType',function(e){ 

        var lesson_id = $('input[name="lesson_id"]:checked').val();

        var lesson_package_id = $('input[name="lesson_package_id"]:checked').val(); 

        

        $("#booking_lesson_id").val(lesson_id);

        $("#booking_lesson_package_id").val(lesson_package_id);

        

        if(lesson_package_id){

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            $.ajax({

                url: APP_URL+'/fetch-package-price/'+encodeURI(lesson_package_id),

                type: 'GET',

                success: function (response) {

                    $('#booking_amount').val(response);

                }

            });

        }

        

    });   

    

    



</script>



<?php

$user_role = session('role');

$user_id = session('id');

$url_segment = Request::segment(1);



$janData = '';

$febData = '';

$marchData = '';

$aprilData = '';

$mayData = '';

$juneData = '';

$julyData = '';

$augData = '';

$septData = '';

$octData = '';

$novData = '';

$decData = '';



$chartUpcomingLessons = '';

$chartPreviousLessons = '';

$chartWaitingLessons = '';

$chartCompletedLessons = '';

$chartCancelledLessons = '';

$chartTodayLessons = '';



if($url_segment=='student-dashboard' && $user_role=='1'){

    $chartUpcomingLessons = DB::table('booking')->where('student_id', '=', session('id'))->where('booking_date', '>', date('Y-m-d'))->count();

    $chartPreviousLessons = DB::table('booking')->where('student_id', '=', session('id'))->where('booking_date', '<', date('Y-m-d'))->count();

    $chartWaitingLessons = DB::table('booking')->where('student_id', '=', session('id'))->where('status', '=', '0')->count();

    $chartCompletedLessons = DB::table('booking')->where('student_id', '=', session('id'))->where('status', '=', '3')->count();

    $chartCancelledLessons = DB::table('booking')->where('student_id', '=', session('id'))->where('status', '=', '2')->count(); 

    $chartTodayLessons = DB::table('booking')->where('student_id', '=', session('id'))->where('booking_date', '=', date('Y-m-d'))->count();

    

    $dataPoints = array( 

    	array("label"=>"Upcoming", "symbol" => "Upcoming","y"=> $chartUpcomingLessons),

    	array("label"=>"Waiting", "symbol" => "Waiting","y"=> $chartWaitingLessons),

    	array("label"=>"Completed", "symbol" => "Completed","y"=> $chartCompletedLessons),

    	array("label"=>"Cancelled", "symbol" => "Cancelled","y"=> $chartCancelledLessons),

    	array("label"=>"Previous", "symbol" => "Previous","y"=> $chartPreviousLessons), 

    	array("label"=>"Today", "symbol" => "Today","y"=> $chartTodayLessons), 

    );

}



if($url_segment=='teacher-dashboard' && $user_role=='2'){

    $chartUpcomingLessons = DB::table('booking')->where('teacher_id', '=', session('id'))->where('booking_date', '>', date('Y-m-d'))->count();

    $chartPreviousLessons = DB::table('booking')->where('teacher_id', '=', session('id'))->where('booking_date', '<', date('Y-m-d'))->count();

    $chartWaitingLessons = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '0')->count();

    $chartCompletedLessons = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')->count();

    $chartCancelledLessons = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '2')->count(); 

    $chartTodayLessons = DB::table('booking')->where('teacher_id', '=', session('id'))->where('booking_date', '=', date('Y-m-d'))->count();

    

    $dataPoints = array( 

    	array("label"=>"Upcoming", "symbol" => "Upcoming","y"=> $chartUpcomingLessons),

    	array("label"=>"Waiting", "symbol" => "Waiting","y"=> $chartWaitingLessons),

    	array("label"=>"Completed", "symbol" => "Completed","y"=> $chartCompletedLessons),

    	array("label"=>"Cancelled", "symbol" => "Cancelled","y"=> $chartCancelledLessons),

    	array("label"=>"Previous", "symbol" => "Previous","y"=> $chartPreviousLessons), 

    	array("label"=>"Today", "symbol" => "Today","y"=> $chartTodayLessons), 

    );

    

    

    

    // Line chart data (Earnings per month for 12months)

    $janData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '01')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $febData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '02')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

    

    $marchData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '03')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $aprilData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '04')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $mayData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '05')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $juneData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '06')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');



    $julyData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '07')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $augData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '08')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $septData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '09')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $octData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '10')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $novData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '11')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');

                                    

    $decData = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '1')

                                    ->whereMonth('created_at', '12')

                                    ->whereYear('created_at', date('Y'))->sum('booking_amount');







    // Line chart data (Hours taught per month for 12months)

    $jan_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '01')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $jan_HT = 0;

    if(count($jan_HT_Data)>0) {

      foreach($jan_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $jan_HT += $minutes;

      }

    }



    





    $feb_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '02')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $feb_HT = 0;

    if(count($feb_HT_Data)>0) {

      foreach($feb_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $feb_HT += $minutes;

      }

    }





    $march_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '03')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $march_HT = 0;

    if(count($march_HT_Data)>0) {

      foreach($march_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $march_HT += $minutes;

      }

    }







    $april_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '04')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $april_HT = 0;

    if(count($april_HT_Data)>0) {

      foreach($april_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $april_HT += $minutes;

      }

    }









    $may_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '05')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $may_HT = 0;

    if(count($may_HT_Data)>0) {

      foreach($may_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $may_HT += $minutes;

      }

    }









    $june_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '06')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $june_HT = 0;

    if(count($june_HT_Data)>0) {

      foreach($june_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $june_HT += $minutes;

      }

    }









    $july_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '07')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

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

      }

    }







    $aug_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '08')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $aug_HT = 0;

    if(count($aug_HT_Data)>0) {

      foreach($aug_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $aug_HT += $minutes;

      }

    }





    $sept_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '09')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $sept_HT = 0;

    if(count($sept_HT_Data)>0) {

      foreach($sept_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $sept_HT += $minutes;

      }

    }









    $oct_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '10')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $oct_HT = 0;

    if(count($oct_HT_Data)>0) {

      foreach($oct_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $oct_HT += $minutes;

      }

    }









    $nov_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '11')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $nov_HT = 0;

    if(count($nov_HT_Data)>0) {

      foreach($nov_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $nov_HT += $minutes;

      }

    }









    $dec_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')

                                    ->whereMonth('lesson_completed_at', '11')

                                    ->whereYear('lesson_completed_at', date('Y'))->get();

    $dec_HT = 0;

    if(count($dec_HT_Data)>0) {

      foreach($dec_HT_Data as $val){

          $start = $val->lesson_started_at;

          $end = $val->lesson_completed_at;



          $seconds = strtotime($end) - strtotime($start);



          $days    = floor($seconds / 86400);

          $hours   = floor(($seconds - ($days * 86400)) / 3600);

          $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

          $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));



          $dec_HT += $minutes;

      }

    }





}



 

?>

<script>

window.onload = function() {  

var userRole = '<?=$user_role?>';

var urlSegment = '<?=Request::segment(1)?>';



//alert('userRole '+userRole); alert('urlSegment '+urlSegment); 



if(urlSegment=='student-dashboard' && userRole=='1'){



    google.charts.load("current", {packages:["corechart"]});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        

        var data = google.visualization.arrayToDataTable([

          ['Task', 'Booking'],

          ['Upcoming', <?=@$chartUpcomingLessons?>],

          ['Waiting', <?=@$chartWaitingLessons?>],

          ['Completed', <?=@$chartCompletedLessons?>],

          ['Cancelled', <?=@$chartCancelledLessons?>],

          ['Previous', <?=@$chartPreviousLessons?>],

          ['Today', <?=@$chartTodayLessons?>]

        ]);

        



        var options = {

          title: 'Total Booking',

          pieHole: 0.4,

        };



        var chart = new google.visualization.PieChart(document.getElementById('chartContainer'));

        chart.draw(data, options);

      }

}





if(urlSegment=='teacher-dashboard' && userRole=='2'){

    

    google.charts.load("current", {packages:["corechart"]});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        

        /*alert("Upcoming:"+Upcoming);

        alert("Waiting:"+Waiting);

        alert("Completed:"+Completed);

        alert("Cancelled:"+Cancelled);

        alert("Previous:"+Previous);

        alert("Today:"+Today);*/



        var data = google.visualization.arrayToDataTable([

          ['Task', 'Booking'],

          ['Upcoming', <?=@$chartUpcomingLessons?>],

          ['Waiting', <?=@$chartWaitingLessons?>],

          ['Completed', <?=@$chartCompletedLessons?>],

          ['Cancelled', <?=@$chartCancelledLessons?>],

          ['Previous', <?=@$chartPreviousLessons?>],

          ['Today', <?=@$chartTodayLessons?>]

        ]);

        



        var options = {

          title: 'Total Booking',

          pieHole: 0.4,

        };



        var chart = new google.visualization.PieChart(document.getElementById('teacherChartContainer'));

        chart.draw(data, options);

      }

      

      

      

      // Line chart ============================================================

      google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawLineChart);

      

      var d = new Date();

      var n = d.getFullYear();

    

      function drawLineChart() {

        var data = google.visualization.arrayToDataTable([

          ['Month', 'Earning'],

          [new Date(n, 0),  <?=@$janData?>],

          [new Date(n, 1),  <?=@$febData?>],

          [new Date(n, 2),  <?=@$marchData?>],

          [new Date(n, 3),  <?=@$aprilData?>],

          [new Date(n, 4),  <?=@$mayData?>],

          [new Date(n, 5),  <?=@$juneData?>],

          [new Date(n, 6),  <?=@$julyData?>],

          [new Date(n, 7),  <?=@$augData?>],

          [new Date(n, 8),  <?=@$septData?>],

          [new Date(n, 9),  <?=@$octData?>],

          [new Date(n, 10), <?=@$novData?>],

          [new Date(n, 11), <?=@$decData?>]

        ]);

    

        var options = {

          title: 'Earning For 12Months',

          curveType: 'function',

          legend: { position: 'bottom' }

        };

    

        var chart = new google.visualization.LineChart(document.getElementById('lineChartContainer'));

    

        chart.draw(data, options);

      }





      // Line chart 2 ============================================================

      google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawLineChart_2);



      var d = new Date();

      var n = d.getFullYear();



      function drawLineChart_2() {

        var data = google.visualization.arrayToDataTable([

          ['Month', 'Hours'],

          [new Date(n, 0),  <?=@$jan_HT?>],

          [new Date(n, 1),  <?=@$feb_HT?>],

          [new Date(n, 2),  <?=@$march_HT?>],

          [new Date(n, 3),  <?=@$april_HT?>],

          [new Date(n, 4),  <?=@$may_HT?>],

          [new Date(n, 5),  <?=@$june_HT?>],

          [new Date(n, 6),  <?=@$july_HT?>],

          [new Date(n, 7),  <?=@$aug_HT?>],

          [new Date(n, 8),  <?=@$sept_HT?>],

          [new Date(n, 9),  <?=@$oct_HT?>],

          [new Date(n, 10), <?=@$nov_HT?>],

          [new Date(n, 11), <?=@$dec_HT?>]

        ]);

    

        var options = {

          title: 'Minutes Taught For 12Months',

          curveType: 'function',

          legend: { position: 'bottom' }

        };

    

        var chart = new google.visualization.LineChart(document.getElementById('lineChartContainer_2'));

    

        chart.draw(data, options);

      }

      

}



 

}

</script>









<script type="text/javascript">

$(function() {

    

    if(urlSegment!='teacher-settings'){

        var $form = $(".require-validation");

        console.log("stripe::");

        var class_name = $('#paymentForm').attr('class');

        console.log("stripe form class::"+class_name);

        //$('form.require-validation').bind('submit', function(e) {

        /*$form.bind('submit', function(e) {

                var $form         = $(".require-validation"),

                inputSelector = ['input[type=email]', 'input[type=password]',

                                 'input[type=text]', 'input[type=file]',

                                 'textarea'].join(', '),

                $inputs       = $form.find('.required').find(inputSelector),

                $errorMessage = $form.find('div.error'),

                valid         = true;

                $errorMessage.addClass('hide');

          

                $('.has-error').removeClass('has-error');

                $inputs.each(function(i, el) {

                  var $input = $(el);

                  if ($input.val() === '') {

                    $input.parent().addClass('has-error');

                    $errorMessage.removeClass('hide');

                    e.preventDefault();

                  }

                });

           

                if (!$form.data('cc-on-file')) {

                  e.preventDefault();

                  Stripe.setPublishableKey($form.data('stripe-publishable-key'));

                  Stripe.createToken({

                    number: $('.card-number').val(),

                    cvc: $('.card-cvc').val(),

                    exp_month: $('.card-expiry-month').val(),

                    exp_year: $('.card-expiry-year').val()

                  }, stripeResponseHandler);

                }

          

          });*/

  

        /*function stripeResponseHandler(status, response) {

            if (response.error) {

                $('.error')

                    .removeClass('hide')

                    .find('.alert')

                    .text(response.error.message);

            } else {

                // token contains id, last4, and card type 

                var token = response['id'];

                   

                $form.find('input[type=text]').empty();

                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

                $form.get(0).submit();

            }

        }*/

    }

    

    

   

});

</script>



<script>

// Submit Payment Data =============================================================

$(document).on('click','.payment-data-modal',function(e){ 

    

    var lesson_id = $('#booking_lesson_id').val();

    var lesson_package_id = $('#booking_lesson_package_id').val();

    var booking_date = $('#booking_date').val();

    var booking_time = $('#booking_time').val();

    var booking_amount = $('#booking_amount').val();

    var booking_cardholder_name = $('#cardholder_name').val();

    var booking_card_no = $('#card_no').val();

    var booking_expiry_month = $('#expiry_month').val();

    var booking_expiry_year = $('#expiry_year').val();

    var booking_cvv = $('#cvv').val();

    var booking_saveinformation = $('#saveinformation').val();

    

    var userRole = '<?=$user_role?>';

    

    if(userRole!='' && userRole=='1'){

        var wallet_amt = '<?php echo @$getLoggedIndata->student_wallet_amount; ?>'; 

        

        

        if(parseFloat(wallet_amt) >= parseFloat(booking_amount)){ 

            var post_url = "{{ route('booking-data') }}"; 

        }else{      

            var post_url = "{{ route('stripe-post') }}";   

        }

        

        //alert("post url:: "+post_url);

        //alert("wallet_amt:: "+wallet_amt);

        //alert("booking_amount:: "+booking_amount);

        

        

        $('#paymentDataModal').modal("show");

    

        $('#payment_lesson_id').val(lesson_id);

        $('#payment_lesson_package_id').val(lesson_package_id);

        $('#payment_booking_date').val(booking_date);

        $('#payment_booking_time').val(booking_time);

        $('#payment_booking_amount').val(booking_amount);

        $('#payment_cardholder_name').val(booking_cardholder_name);

        $('#payment_card_no').val(booking_card_no);

        $('#payment_expiry_month').val(booking_expiry_month);

        $('#payment_expiry_year').val(booking_expiry_year);

        $('#payment_cvv').val(booking_cvv);

        $('#payment_saveinformation').val(booking_saveinformation);

        

        $('#paymentForm').attr('action', post_url);

        

        if(parseFloat(wallet_amt) >= parseFloat(booking_amount)){ 

            $('#paymentForm').attr('data-stripe-publishable-key',''); 

            $('#paymentForm').attr('data-cc-on-file',''); 

            $('#bookingBtn').removeClass('stripePay');

            $('#paymentForm').removeClass('require-validation');

        }

    

    }



    

    

});





function stripeResponseHandler(status, response) {

    if (response.error) {

        $('.error')

            .removeClass('hide')

            .find('.alert')

            .text(response.error.message);

    } else {

        // token contains id, last4, and card type 

        var token = response['id'];

        

        var $form = $(".require-validation");

        

        $form.find('input[type=text]').empty();

        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

        $form.get(0).submit();

    }

}

        

        

$(document).on('click','.stripePay',function(e){ 

    

    var card_number = $('.card-number').val();

    var card_cvc = $('.card-cvc').val();

    var card_expiry_month = $('card-expiry-month').val();

    var card_expiry_year = $('.card-expiry-year').val();

    

    if(card_number=='' || card_cvc=='' || card_expiry_month=='' || card_expiry_year==''){

        $('#paymentDataModal').modal("toggle");

        swal("Note!", "Please fill the card details!", "warning");  

    }else{

        

        var $form = $(".require-validation");

        

        $form.bind('submit', function(e) {

            var $form         = $(".require-validation"),

            inputSelector = ['input[type=email]', 'input[type=password]',

                             'input[type=text]', 'input[type=file]',

                             'textarea'].join(', '),

            $inputs       = $form.find('.required').find(inputSelector),

            $errorMessage = $form.find('div.error'),

            valid         = true;

            $errorMessage.addClass('hide');

      

            $('.has-error').removeClass('has-error');

            $inputs.each(function(i, el) {

              var $input = $(el);

              if ($input.val() === '') {

                $input.parent().addClass('has-error');

                $errorMessage.removeClass('hide');

                e.preventDefault();

              }

            });

            

            if (!$form.data('cc-on-file')) {

              e.preventDefault();

              Stripe.setPublishableKey($form.data('stripe-publishable-key'));

              Stripe.createToken({

                number: $('.card-number').val(),

                cvc: $('.card-cvc').val(),

                exp_month: $('.card-expiry-month').val(),

                exp_year: $('.card-expiry-year').val()

              }, stripeResponseHandler);

            }

            

        });   

            

        

   

        

        

    }

    

});





$(document).on('click','.getLessonType',function(event){ 

    var lesson_id = $('input[name="lesson_id"]:checked').val(); //alert("zz "+lesson_id);

    

    $(".getLessonPackageType").prop("disabled", false);

    

    if(typeof lesson_id === "undefined"){

        event.preventDefault();

        swal("Note!", "Please select a lesson type!", "warning"); 

        

        $(".getLessonPackageType").prop("disabled", true);

        $( ".lesson-back" ).trigger( "click" );

    }

});



$(document).on('click','.getLessonPackageType',function(event){ 

    var lesson_package_id = $('input[name="lesson_package_id"]:checked').val(); //alert("qq "+lesson_package_id);

    

    $(".getBookingDtTime").prop("disabled", false);

    

    if(typeof lesson_package_id === "undefined"){

        event.preventDefault();

        swal("Note!", "Please select a lesson package!", "warning"); 

        

        $(".getBookingDtTime").prop("disabled", true);

        $( ".package-back" ).trigger( "click" );

    }

});



$(document).on('click','.getBookingDtTime',function(event){ 

    var booking_date = $('#booking_date').val();

    var booking_time = $('#booking_time').val();

    //alert("dt: "+booking_date); 

    $(".getBookingData").prop("disabled", false);

    

    if(booking_date == "" && booking_time == ""){ //alert("time: "+booking_time);

        event.preventDefault();

        swal("Note!", "Please select a slot!", "warning"); 

        

        $(".getBookingData").prop("disabled", true);

        $( ".communication-back" ).trigger( "click" );

    }

});





$(document).on('click','.getBookingData',function(event){ 

    var communication_tool = $('input[name="communication_tool"]:checked').val();

    var communication_account_id = $('#communication_account_id').val();

    //alert("dt: "+communication_tool); 

    $(".getBookingData").prop("disabled", false);

    

    if(typeof communication_tool === "undefined" || communication_account_id == ""){ //alert("time: "+booking_time);

        event.preventDefault();

        swal("Note!", "Please select a communication tool!", "warning"); 

        

        $(".getBookingData").prop("disabled", true);

        $( ".payment-back" ).trigger( "click" );

    }

});



</script>



<script>

$(document).on('click','.FavoriteList',function(event){

    var teacherID = $(this).attr('data-teacherID'); 

    var type = $(this).attr('data-type'); 

    

    //alert(type);

    

    if(type=='add'){

        var displayText = "Do you want to add the teacher in your favourite list?";

        var confirmBtnTxt = "Yes, add it!";

        var successMsg = "Teacher has been added to your favorite list.";

    }else{

        var displayText = "Do you want to remove the teacher from your favourite list?";

        var confirmBtnTxt = "Yes, remove it!";

        var successMsg = "Teacher has been removed from your favorite list.";

    }

    

    if(teacherID!=''){

        swal({

            title: "Are you sure?",

            text: displayText,

            type: "warning",

            showCancelButton: true,

            confirmButtonColor: "#DD6B55",

            confirmButtonText: confirmBtnTxt,

            cancelButtonText: "Cancel",

            closeOnConfirm: false,

            closeOnCancel: false

        },

        function (isConfirm) {

            if (isConfirm) { 

                

                swal({

                    title: "success",

                    text: successMsg,

                    confirmButtonText: "ok",

                    allowOutsideClick: "true"

                }, function () { 

                    

                    $.ajax({

                        url: APP_URL+'/favorite-teacher',

                        type: 'POST',

                        data: {

                            teacher_id: teacherID,

                            action: type,

                        },

                        success: function (response) { //alert(response);

                            window.location.reload();

                        }

                    });

                    

                })

            

            } else {

                swal("Cancelled", "Ok :)", "success");



            }

        });

    }

});







$(document).on('click','.lessonDetailModal',function(e){ 

        

    var LessonID = $(this).attr('data-LessonID'); 

    

    $.ajax({

            url: APP_URL+'/fetch-lesson-detail',

            type: 'POST',

            data: {

                lesson_id: LessonID,

            },

            success: function (response) {

                $('#lesson_details').modal('toggle');

                $('#LessonData').html(response);

            }

        });

});





// Teacher Lesson Availability Settings

$(document).on('click','.teacherAutoAcceptStatus',function(e){ 

    var btnValue = $(this).attr('aria-pressed'); 

    //alert(btnValue);

    

    $('#teacher_auto_accept_status').val(btnValue); 

    

});







$(document).on('change','.badgesCheckbox',function(e){ 

    var badgeName = $(this).val();

    

    if(this.checked) {

        //alert(badgeName);

    }

});





// Lesson invitation js ========================================================

$('#i_student_id').on('change', function (e) { 
    var studentName = $( "#i_student_id option:selected" ).text();
    $("#StudentName").html(studentName);  
    
    var studentID = $(this).val();
});
$('#language_taught').on('change', function (e) { 
    var language = $(this).val();
    $("#LanguageName").html(language); 
});
$(document).on('click','.durationClass',function(e){ //alert("aa");
    var duration = $(this).attr('data-duration'); 
    $("#LessonDuration").html(duration); 
    
    var price = $(this).attr('data-price');  
    $("#LessonPrice").html(price); 
    $("#old_price").val(price);  //alert("price:: "+price); 
});
$('#i_inputDate').on('change', function (e) { 
    var date = $(this).val();
    $("#LessonDate").html(date); 
});

$(document).on('click change','.invitationType',function(e){ 
    //var invitationType = $(this).val();
    var invitationType = $("input[name='type']:checked").val();   
    var studentID = $('#i_student_id').val();
    var packageID = $('input[name="package_id"]:checked').val();
    
    //console.log(studentID+' :: '+invitationType);
    if(studentID!='' && invitationType=='package'){
        $(".OfferPriceDivClass").hide(); 
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: APP_URL+'/fetch-student-purchased-packages/'+encodeURI(studentID)+'/'+encodeURI(invitationType),
            type: 'GET',
            success: function (response) { 
                $("#fetchAllPackages").html(response); 
            }
        });
        
        if(packageID!=''){
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-timing/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) { 
                    $("#from_time").val(response);
                    var myString = response.substr(response.indexOf(":") + 1);
                    var h = response.split(':')[0];
                    var m = response.split(':')[1];
                    if(m=='00'){
                        var newToTime = h+':'+'30';
                    }else{
                        var hour = (h+1);
                        var newToTime = hour+':'+'00'; 
                    }
                    $("#to_time").val(newToTime);
                    console.log("time:: "+response+" new >> "+newToTime); 
                }
            });
        
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-date/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) { 
                    $("#i_inputDate").val(response); 
                    $("#LessonDate").text(response); 
                }
            });
        
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-communication-tool/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) {  
                    if(response=='zoom'){
                        $("#exampleRadios6").prop('checked', true); 
                    }else{
                        $("#exampleRadios5").prop('checked', true); 
                    }
                    
                    $("#exampleRadiosSingle").prop('checked', true); 
                    
                    //$("input[name=communication_tool][value='+response+']").prop("checked",true);
                }
            });
        
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-communication-tool-id/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) {  
                    $("#communication_tool_id").val(response); 
                }
            });
        
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-amount/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) {  
                    $("#old_price").val(response);
                    $("#offer_price").val(response);
                    $("#LessonPrice").text(response); 
                }
            });
        
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-language/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) {  
                    $("#language_taught").val(response); 
                    $("#LanguageName").text(response); 
                }
            });
        
            $.ajax({
                url: APP_URL+'/fetch-student-purchased-lesson/'+encodeURI(studentID)+'/'+encodeURI(packageID),
                type: 'GET',
                success: function (response) {  
                    $("#i_lesson_id").val(response); 
                    //$("#LessonName").text(response); 
                }
            });
        
            $('.LanguagesDivClass').hide();
            $('.LessonDivClass').hide(); 
            //$('.OfferPriceDivClass').hide();
        }
        
    }else{
        
        if(studentID!='' && invitationType=='lesson'){
            $(".OfferPriceDivClass").show(); 
        	$("#i_inputDate").val(""); 
        	$("#from_time").val("");
        	$("#to_time").val("");
        	$("#communication_tool_id").val("");
        	//$("#old_price").val("");
        	$("#offer_price").val(""); 
        	$("#language_taught").val(""); 
        	$("#i_lesson_id").val(""); 
        }
    }
    
    
    
    
    
});

$('#i_lesson_id').on('change', function (e) {
    //alert("zzzzzzzzzzzz");
    var lessonID = $(this).val();   //alert(lessonID); 
    if(lessonID){
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: APP_URL+'/fetch-lesson-packages/'+encodeURI(lessonID),
            type: 'GET',
            success: function (response) { 
                $("#fetchAllPackages").html(response); 
            }
        });
        
        var lessonName = $( "#i_lesson_id option:selected" ).text();
        $("#LessonName").html(lessonName); 
            
        
        /*$.ajax({
            url: APP_URL+'/fetch-communication-tool/'+encodeURI(lessonID),
            type: 'GET',
            success: function (response) { fetchAllPackages
                $("input[name=communication_tool][value='+response+']").prop("checked",true);
            }
        });
        $.ajax({
            url: APP_URL+'/fetch-communication-tool-id/'+encodeURI(studentID),
            type: 'GET',
            success: function (response) {
                $('#communication_tool_id').val(response); 
            }
        });*/
    }
});






</script>



<script>



function rate5(){ 

 document.getElementById("5").style.color = "orange"; 

     document.getElementById("4").style.color = "orange";

   document.getElementById("3").style.color = "orange";

   document.getElementById("2").style.color = "orange"; 

  document.getElementById("1").style.color = "orange";

  }

  

  function rate10(){ 

 document.getElementById("10").style.color = "orange"; 

     document.getElementById("9").style.color = "orange";

   document.getElementById("8").style.color = "orange";

   document.getElementById("7").style.color = "orange"; 

  document.getElementById("6").style.color = "orange";

  }

  

    function rate15(){ 

 document.getElementById("15").style.color = "orange"; 

     document.getElementById("14").style.color = "orange";

   document.getElementById("13").style.color = "orange";

   document.getElementById("12").style.color = "orange"; 

  document.getElementById("11").style.color = "orange";

  }

  

 

function rate4(){

   document.getElementById("5").style.color = "#9e9e9e"; 

     document.getElementById("4").style.color = "orange";

   document.getElementById("3").style.color = "orange";

   document.getElementById("2").style.color = "orange"; 

  document.getElementById("1").style.color = "orange";

}

function rate9(){

   document.getElementById("10").style.color = "#9e9e9e"; 

     document.getElementById("9").style.color = "orange";

   document.getElementById("8").style.color = "orange";

   document.getElementById("7").style.color = "orange"; 

  document.getElementById("6").style.color = "orange";

}

function rate14(){

   document.getElementById("15").style.color = "#9e9e9e"; 

     document.getElementById("14").style.color = "orange";

   document.getElementById("13").style.color = "orange";

   document.getElementById("12").style.color = "orange"; 

  document.getElementById("11").style.color = "orange";

}





function rate3(){

   document.getElementById("5").style.color = "#9e9e9e"; 

     document.getElementById("4").style.color = "#9e9e9e";

   document.getElementById("3").style.color = "orange";

   document.getElementById("2").style.color = "orange"; 

  document.getElementById("1").style.color = "orange";

}



function rate8(){

   document.getElementById("10").style.color = "#9e9e9e"; 

     document.getElementById("9").style.color = "#9e9e9e";

   document.getElementById("8").style.color = "orange";

   document.getElementById("7").style.color = "orange"; 

  document.getElementById("6").style.color = "orange";

}

function rate13(){

   document.getElementById("15").style.color = "#9e9e9e"; 

     document.getElementById("14").style.color = "#9e9e9e";

   document.getElementById("13").style.color = "orange";

   document.getElementById("127").style.color = "orange"; 

  document.getElementById("11").style.color = "orange";

}





function rate2(){

   document.getElementById("5").style.color = "#9e9e9e"; 

     document.getElementById("4").style.color = "#9e9e9e";

   document.getElementById("3").style.color = "#9e9e9e";

   document.getElementById("2").style.color = "orange"; 

  document.getElementById("1").style.color = "orange";

}

function rate7(){

   document.getElementById("10").style.color = "#9e9e9e"; 

     document.getElementById("9").style.color = "#9e9e9e";

   document.getElementById("8").style.color = "#9e9e9e";

   document.getElementById("7").style.color = "orange"; 

  document.getElementById("6").style.color = "orange";

}

function rate12(){

   document.getElementById("15").style.color = "#9e9e9e"; 

     document.getElementById("14").style.color = "#9e9e9e";

   document.getElementById("13").style.color = "#9e9e9e";

   document.getElementById("12").style.color = "orange"; 

  document.getElementById("11").style.color = "orange";

}





function rate1(){

   document.getElementById("5").style.color = "#9e9e9e"; 

     document.getElementById("4").style.color = "#9e9e9e";

   document.getElementById("3").style.color = "#9e9e9e";

   document.getElementById("2").style.color = "#9e9e9e";

  document.getElementById("1").style.color = "orange";

}

function rate6(){

   document.getElementById("10").style.color = "#9e9e9e"; 

     document.getElementById("9").style.color = "#9e9e9e";

   document.getElementById("8").style.color = "#9e9e9e";

   document.getElementById("7").style.color = "#9e9e9e";

  document.getElementById("6").style.color = "orange";

}

function rate11(){

   document.getElementById("15").style.color = "#9e9e9e"; 

   document.getElementById("14").style.color = "#9e9e9e";

   document.getElementById("13").style.color = "#9e9e9e";

   document.getElementById("12").style.color = "#9e9e9e";

   document.getElementById("11").style.color = "orange";

}



document.getElementById("5").onclick = function(){

  rate5();

  document.getElementById("audio_quality_rating").value = 5;

}

document.getElementById("4").onclick = function(){

  rate4();

  document.getElementById("audio_quality_rating").value = 4;

}

document.getElementById("3").onclick = function(){

  rate3();

  document.getElementById("audio_quality_rating").value = 3;

}

document.getElementById("2").onclick = function(){

  rate2();

  document.getElementById("audio_quality_rating").value = 2;

}

document.getElementById("1").onclick = function(){

  rate1();

  document.getElementById("audio_quality_rating").value = 1;

}

document.getElementById("6").onclick = function(){

  rate6();

  document.getElementById("video_quality_rating").value = 1;

}

document.getElementById("7").onclick = function(){

  rate7();

  document.getElementById("video_quality_rating").value = 2;

}

document.getElementById("8").onclick = function(){

  rate8();

  document.getElementById("video_quality_rating").value = 3;

}

document.getElementById("9").onclick = function(){

  rate9();

  document.getElementById("video_quality_rating").value = 4;

}

document.getElementById("10").onclick = function(){

  rate10();

  document.getElementById("video_quality_rating").value = 5;

}

document.getElementById("11").onclick = function(){

  rate11();

  document.getElementById("teacher_rating").value = 1;

}

document.getElementById("12").onclick = function(){

  rate12();

  document.getElementById("teacher_rating").value = 2;

}

document.getElementById("13").onclick = function(){

  rate13();

  document.getElementById("teacher_rating").value = 3;

}

document.getElementById("14").onclick = function(){

  rate14();

  document.getElementById("teacher_rating").value = 4;

}

document.getElementById("15").onclick = function(){

  rate15();

  document.getElementById("teacher_rating").value = 5;

}









</script>









<!-- Modal -->

<div class="modal fade add-education-form" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Add Education</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <form>

         <div class="list-box tab-section">

                                                     

            <div class="form-row">

            <div class="form-group col-md-6">

              <label for="">From</label>

              <input type="number" name="" min="1900" max="<?=date('Y')?>" step="1" class="form-control" placeholder="Year">

            </div>

            <div class="form-group col-md-6">

              <label for="">To</label>

              <input type="number" name="" min="1900" max="<?=date('Y')?>" step="1" class="form-control" placeholder="Year">

            </div>

          </div>

            <div class="form-row">

            <div class="form-group col-md-6 calender-icon">

              <label for="">Date Of Birth</label>

              <input type="input" class="form-control" id="inputDate2">

              <i class="fa fa-calendar" aria-hidden="true"></i>

            </div>

            <div class="form-group col-md-6">

              <label for="">Major / Topic</label>

               <input type="text" class="form-control" id="" placeholder="Enter Topic">

            </div>

          </div>

          

          <div class="form-row">

            <div class="form-group col-md-12">

                <label for="inputAddress">Degree</label>

                <input type="text" class="form-control" id="" placeholder="Rie Oh">

              </div>

          </div>

          

          <div class="form-row">

            <div class="form-group col-md-12">

                <label for="inputAddress">Description (Optional)</label>

                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Please Select an Option" rows="3"></textarea>

              </div>

          </div>

           

              

          <div class="form-row">

            <div class="form-group col-md-12 upload-custom">

               <label for="upload-photo">Click or Drage here to upload Photo</label>

			   <input type="file" name="photo" id="upload-photo"/>

               <p><small>Scanned and in color  |  JPG or PNG format  |  Maximum 5 MB  |  Visible to italki staff only</small></p>

              </div>

          </div>

          

        </div>

        

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

        <button type="button" class="btn btn-primary">Submit</button>

      </div>

    </div>

  </div>

</div>



</body>



</html>

