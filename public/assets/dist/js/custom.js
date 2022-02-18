
jQuery(document).ready( function () {

    var BASE_URL = '{!! url() !!}';

    // User Phones
    $("#append").click( function(e) { 
        e.preventDefault();  
        $(".pDiv").append('<div class="form-group col-md-3"><label for="inputEmail4">&nbsp;&nbsp;</label>\
                            <input type="text" name="phones[]" class="form-control">\
                            <input type="button" class="form-control remove_this btn btn-danger" value="Remove">\
                            </div>'); 

        return false;
    });

    jQuery(document).on('click', '.remove_this', function() {
        jQuery(this).parent().remove();
        return false;
    });


    // Customer Contact Phones
    $("#ccAppend").click( function(e) { 
        e.preventDefault();  
        $(".customerDiv").append('<div class="form-group col-md-4"><label for="inputEmail4">&nbsp;&nbsp;</label>\
                            <input type="text" name="customer_contact_phones[]" class="form-control">\
                            <input type="button" class="form-control remove_phn btn btn-danger" value="Remove">\
                            </div>'); 

        return false;
    });

    jQuery(document).on('click', '.remove_phn', function() {
        jQuery(this).parent().remove();
        return false; 
    });



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    // Main Task Helpers
    var boxesWrap = $('#boxes-wrap');
    var boxRow = boxesWrap.children(":first");
    var boxRowTemplate = boxRow.clone();
    boxRow.find('button.remove-helper-row').remove();

    var inputCount = 1; 

    $('#hAppend').click(function () {
        var newRow = boxRowTemplate.clone();
        inputCount++;
        //newRow.find('input.name').attr('placeholder', 'Input '+inputCount);
        //boxesWrap.append(newRow);
        $(".helperDiv").append(newRow);
    });  
      
    $('#boxes-wrap').on('click', 'button.remove-helper-row', function () {
        $(this).parent().remove();
    });

    
    




    // Task Helpers
    var taskBoxesWrap = $('#task-boxes-wrap');
    var taskBoxRow = taskBoxesWrap.children(":first");
    var taskBoxRowTemplate = taskBoxRow.clone();
    taskBoxRow.find('button.remove-task-helper-row').remove();

    var tInputCount = 1; 

    $('#taskHelperAppend').click(function () {
        var newRow = taskBoxRowTemplate.clone();
        tInputCount++;
        $(".taskHelperDiv").append(newRow);
    });  
      
    $('#task-boxes-wrap').on('click', 'button.remove-task-helper-row', function () {
        $(this).parent().remove();
    });






    // Sub Task Helpers
    var subTaskBoxesWrap = $('#subTask-boxes-wrap');
    var subTaskBoxRow = subTaskBoxesWrap.children(":first");
    var subTaskBoxRowTemplate = subTaskBoxRow.clone();
    subTaskBoxRow.find('button.remove-subTask-helper-row').remove();

    var sInputCount = 1;  

    $('#subTaskHelperAppend').click(function () {
        var newRow = subTaskBoxRowTemplate.clone();
        sInputCount++;
        $(".subTaskHelperDiv").append(newRow);
    });  
      
    $('#subTask-boxes-wrap').on('click', 'button.remove-subTask-helper-row', function () {
        $(this).parent().remove();
    });






    


    /*$("input[type=submit]").click(function(e) {
        e.preventDefault();
        $(this).next("[name=phone[]]")
        .val(
            $.map($(".pDiv :text"), function(el) {
                return el.value
            }).join(",\n")
        )
    });*/

});


$('#role_type').on('change', function() {
    var role_type = $(this).find(":selected").val();
    //alert(role_id);
    if(role_type==7){
        //$("#customer_type").prop("disabled", false); 
        $("#c_div").show(); 
    }else{
        //$("#customer_type").prop("disabled", true);
        $("#c_div").hide();   
    }
});





















