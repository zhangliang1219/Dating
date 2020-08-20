 $( document ).ready(function() {
     $('#dob').datepicker({
        format: 'yyyy/mm/dd',
    });
    
    if($('#ethnicity_other_hidden').val() !== ''){
        $("#ethnicity_other").show();
    }
    if($('#build_other_hidden').val() !== ''){
        $("#build_other").show();
    }
    $('#ethnicity').change(function() {
        if ($(this).val() == "10") {
            $("#ethnicity_other").show();
        } else {
            $("#ethnicity_other").hide();
        }
    });
    
    $('#build').change(function() {
        if ($(this).val() == "4") {
            $("#build_other").show();
        } else {
            $("#build_other").hide();
        }
    });
    
     $("#user_update").validate({
        rules: {
            'first_name': {required:true},         
            'last_name': {required:true},         
            'dob': {required:true},       
            'phoneNumber' : {required:true},   
            'age' : {required:true,min: 18,max:80, number: true},  
            'gender' : {required:true},      
            'email': {required:true,email: true},  
            'wish_to_meet': {required:true}, 
            'height': {required:true}, 
            'weight': {required:true}, 
            'living_arrangement' : {required:true},          
            'city' : {required:true},          
            'state' : {required:true},          
            'country' : {required:true},          
            'favorite_sport' : {required:true},          
            'high_school_attended' : {required:true},          
            'collage' : {required:true},          
            'employment_status' : {required:true},          
            'education' : {required:true},          
            'build' : {required:true},          
            'children' : {required:true},          
            'ethnicity': {required:true},         
            'relationship': {required:true},         
            'describe_perfect_date': {required:true,maxlength: 1000},  
            'ethnicity_other': {
                            required: function(element) {
                                return $("#ethnicity").val() == 10;
                            }
                        },
            'build_other': {
                            required: function(element) {
                                return $("#build").val() == 4;
                            }
                        },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('.delete_user').click(function(){
        var userId = $(this).attr('data-id');
        if(userId != ''){
                swal({
                    title: "Are you sure you want to delete this user?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                if (willDelete) {
                  deleteUser(userId);
                }
             });
        }
    });	
    
    var preferred_min_age = $('#preferred_age_val').attr('data-min');
    var preferred_max_age = $('#preferred_age_val').attr('data-max');
    $("#preferred-age-slider-range").slider({
        range: true,
        min: 18,
        max: 80,
        values: [(preferred_min_age == 0 ?18:preferred_min_age), (preferred_max_age == 0 ?80:preferred_max_age)],
        slide: function( event, ui ) {
            $("#preferred_age_range").val(ui.values[0] + " - " + ui.values[1]);
        }
    });
    $("#preferred_age_range").val($("#preferred-age-slider-range").slider("values", 0)+" - " + $("#preferred-age-slider-range").slider("values", 1 ));
    
    var preferred_min_height = $('#preferred_height_val').attr('data-min');
    var preferred_max_height = $('#preferred_height_val').attr('data-max');
    $("#preferred-height-slider-range").slider({
        range: true,
        min:4.2,
        max:7.5,
        values: [(preferred_min_height == 0 ?4.2:preferred_min_height), (preferred_max_height == 0 ?7.5:preferred_max_height)],
        step:0.1,
        slide: function( event, ui ) {
            $("#preferred_height_range").val(ui.values[0] + " - " +ui.values[1]);
            $("#preferred_height_range_hidden").val(ui.values[0] + " - " +ui.values[1]+ " ft ");
        }
    });
    $("#preferred_height_range").val($("#preferred-height-slider-range").slider("values", 0)+" - " + $("#preferred-height-slider-range").slider("values", 1 ));
    $("#preferred_height_range_hidden").val($("#preferred-height-slider-range").slider("values", 0)+" - " + $("#preferred-height-slider-range").slider("values", 1 )+" ft ");
    
    var preferred_min_weight = $('#preferred_weight_val').attr('data-min');
    var preferred_max_weight = $('#preferred_weight_val').attr('data-max');
    $("#preferred-weight-slider-range").slider({
        range: true,
        min: 20,
        max: 200,
        values: [(preferred_min_weight == 0 ?20:preferred_min_weight), (preferred_max_weight == 0 ?200:preferred_max_weight)],
        step:1,
        slide: function( event, ui ) {
            $("#preferred_weight_range").val(ui.values[0] + " - " + ui.values[1]);
            $("#preferred_weight_range_hidden").val(ui.values[0] + " - " + ui.values[1]+ " kg ");
        }
    });
    $("#preferred_weight_range").val($("#preferred-weight-slider-range").slider("values", 0)+" - " + $("#preferred-weight-slider-range").slider("values", 1 ));
    $("#preferred_weight_range_hidden").val($("#preferred-weight-slider-range").slider("values", 0)+" - " + $("#preferred-weight-slider-range").slider("values", 1 )+" kg ");
});
function deleteUser(userId){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        jQuery.ajax({
        url  : getsiteurl() + '/admin/user/delete',
        type : "DELETE",
        data: {_token: CSRF_TOKEN,userId:userId},
        success: function(response) {
            if(response.status == 'success'){
                swal(response.message,"", "success");
                $('#user_listing > tbody tr#'+userId).slideUp('slow');
            }else if(response.status == 'error'){
                swal(response.message,"", "error");
            }
        }
    });
}