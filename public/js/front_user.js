 $( document ).ready(function() {
     $("#register_form").validate({
        rules: {
            'first_name': {required:true},         
            'last_name': {required:true},         
            'dob': {required:true},         
            'email': {required:true,email: true},         
            'password': {required:true},      
            'gender' : {required:true},   
            'password_confirmation': {required:true,equalTo: "#password"},         
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#general_info_form").validate({
        rules: {
            'wish_to_meet': {required:true}, 
            'phoneNumber' : {required:true},          
            'ethnicity': {required:true},         
            'relationship': {required:true},         
            'describe_perfect_date': {maxlength: 1000},         
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
    $('#dob').datepicker({
        format: 'yyyy/mm/dd',
    });
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
    
});
