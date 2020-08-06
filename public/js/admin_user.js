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
            'describe_perfect_date': {maxlength: 1000},  
//            'wish_to_meet': {required:true},         
//            'ethnicity': {required:true},         
//            'relationship': {required:true},
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