 $( document ).ready(function() {
    $('.edit-user-banner').click(function(){
        $("#user-banner-img").click();
    });
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-header-image').css("background-image", "url(" +  e.target.result + ")");
            }
            reader.readAsDataURL(input.files[0]);
            
            var formData = new FormData();
            formData.append('file', input.files[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : getsiteurl() + '/profile/banner/upload',
                type : 'POST',
                data : formData,
                processData: false,  
                contentType: false, 
                success : function(data) {
                }
            });
        }
    }
    $("#user-banner-img").on('change', function(){
        readURL(this);
    });
    $('#about_me_edit').click(function(){
        $('.profile_about_me_wrap').show();
        $('.profile_about_me_text').hide();
    });
});
