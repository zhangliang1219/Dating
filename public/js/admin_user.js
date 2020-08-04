 $( document ).ready(function() {
     $('#dob,#describe_perfect_date').datepicker({
        format: 'yyyy/mm/dd',
    });
    
    $("#user_update").validate({
        rules: {
            'first_name': {required:true},         
            'last_name': {required:true},         
            'dob': {required:true},       
            'phoneNumber' : {required:true},   
            'age' : {required:true},  
            'gender' : {required:true},      
            'email': {required:true,email: true},              
            'wish_to_meet': {required:true},         
            'ethnicity': {required:true},         
            'relationship': {required:true},         
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