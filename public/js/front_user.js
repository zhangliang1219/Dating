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
        errorElement : 'small',
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
