 $( document ).ready(function() {
     $("#contact_us").validate({
        rules: {
            'full_name': {required:true},         
            'email': {required:true,email: true},         
            'subject': {required:true},         
            'phone_number': {required:true},         
            'message': {required:true},           
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
     
});
