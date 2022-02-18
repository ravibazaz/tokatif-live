
<!-- jQuery -->
<script src={{asset("public/assets/plugins/jquery/jquery.min.js")}}></script>
<!-- jQuery UI 1.11.4 -->
<script src={{asset("public/assets/plugins/jquery-ui/jquery-ui.min.js")}}></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src={{asset("public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>

@if(Request::segment(2) =='dashboard')
<!-- ChartJS -->
<script src={{asset("public/assets/plugins/chart.js/Chart.min.js")}}></script>
<!-- Sparkline -->
<script src={{asset("public/assets/plugins/sparklines/sparkline.js")}}></script>
<!-- JQVMap -->
<script src={{asset("public/assets/plugins/jqvmap/jquery.vmap.min.js")}}></script>
<script src={{asset("public/assets/plugins/jqvmap/maps/jquery.vmap.usa.js")}}></script>
<!-- jQuery Knob Chart -->
<script src={{asset("public/assets/plugins/jquery-knob/jquery.knob.min.js")}}></script>
@endif 

<!-- daterangepicker -->
<script src={{asset("public/assets/plugins/moment/moment.min.js")}}></script>
<script src={{asset("public/assets/plugins/daterangepicker/daterangepicker.js")}}></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src={{asset("public/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
<!-- Summernote -->
<script src={{asset("public/assets/plugins/summernote/summernote-bs4.min.js")}}></script>
<!-- overlayScrollbars -->
<script src={{asset("public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}></script>
<script src={{asset("public/assets/plugins/ekko-lightbox/ekko-lightbox.min.js")}}></script>
<!-- AdminLTE App -->
<script src={{asset("public/assets/dist/js/adminlte.js")}}></script>

@if(Request::segment(2) =='dashboard')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src={{asset("public/assets/dist/js/pages/dashboard.js")}}></script>
@endif 


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


@if(Request::segment(2) !='calender' && Request::segment(2) !='task')
<!-- AdminLTE for demo purposes -->
<script src={{asset("public/assets/dist/js/demo.js")}}></script>

<script src={{asset("public/assets/dist/js/custom.js")}}></script>



@endif



<script>
$(function(){

    $(".datepicker").datepicker({
      changeMonth: true, 
      changeYear: true, 
      dateFormat: 'yy-mm-dd',
      minDate: '0',
      constrainInput: false
    });

    $(document).ready(function(){  //alert('{{ Request::segment(2) }}');
      
      var dateToday = new Date();
      $('.start_date').datepicker({
          dateFormat: "yy-mm-dd",
          minDate: dateToday,
          changeMonth: true,
          changeYear: true,
          onSelect: function(selected) {
              $('.end_date').datepicker("option", "minDate",  $(".start_date").datepicker('getDate') )
          }
      });

      $('.end_date').datepicker({
          dateFormat: "yy-mm-dd",
          minDate: dateToday,
          changeMonth: true,
          changeYear: true
      });

       

    });


    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
});


$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

</script>

 


<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}



</script>



<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>


<script>

$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
                        header: {
                          left: 'prev,next today',
                          center: 'title',
                          right: 'month,basicWeek,basicDay'
                        },
                        navLinks: true, // can click day/week names to navigate views
                        editable: true,
                        eventLimit: true,
                            //events: "all_events.php",
                            events: APP_URL+'/admin/calender/all-projects',
                            displayEventTime: false,
                            eventRender: function (event, element, view) { 
                                if (event.allDay === 'true') {
                                    event.allDay = true;
                                } else {
                                    event.allDay = false;
                                }
                            }

                    });
});


function displayMessage(message) 
{
      $(".response").html("<div align='center' style='padding:20px;font-size:18px;color:#3539EA' class='success'>"+message

+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 2000);
}

</script>


<style>

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>



<style type="text/css">

.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
#target {
  width: 345px;
}


#map { 
    position: absolute;
    left: 16px;
    top: 500px;
    bottom: 0px;
    height: 200px;
    width: 1040px;
}

</style>




