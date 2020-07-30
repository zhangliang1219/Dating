 $( document ).ready(function() {
     $("#register_form").validate({
        rules: {
            'first_name': {required:true},         
            'last_name': {required:true},         
            'dob': {required:true},         
            'email': {required:true,email: true},         
            'password': {required:true},         
            'password_confirmation': {required:true,equalTo: "#password"},         
            'wish_to_meet': {required:true},         
            'ethnicity': {required:true},         
            'relationship': {required:true},         
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#dob,#describe_perfect_date').datepicker({
        format: 'yyyy/mm/dd',
    });
});
