 $( document ).ready(function() {
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