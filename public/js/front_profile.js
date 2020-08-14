 $( document ).ready(function() {
    $('.edit-user-banner').click(function(){
        $("#user-banner-img").click();
    });
    var profileBannerURL = function(input) {
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
        profileBannerURL(this);
    });
    
    $('#editUserProfile').click(function(){
        $("#user-profile-img").click();
    });
    var profileURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profile_img').attr("src", e.target.result);
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
                url : getsiteurl() + '/profile/image/upload',
                type : 'POST',
                data : formData,
                processData: false,  
                contentType: false, 
                success : function(data) {
                }
            });
        }
    }
    $("#user-profile-img").on('change', function(){
        profileURL(this);
    });
    $('#about_me_edit').click(function(){
        $('.profile_about_me_wrap').show();
        $('.profile_about_me_text').hide();
    });
    $('.general_info_edit').click(function(){
        $('#editBasicGeneralInfo').modal('show');  
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
    $("#editProfile").validate({
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
    $('#profile_photos').click(function(){
        $('#profilePhotosModal').modal('show');  
    });
    
    var formData = new FormData();
    var fileData = new Array();
    var fileCount = 0;
    var profilePhotosURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.photo_gallary tr').append('<td class="photo_box"><img src='+ e.target.result+' alt="photo" >\n\
                                                <i class="fa fa-trash" aria-hidden="true"></i>\n\
                                                <input type="checkbox" class="" name="upload_photos[]" value="1" }></td>');
            }
            reader.readAsDataURL(input.files[0]);
            fileData[fileCount] = input.files[0];
            fileCount ++;
            console.log(fileData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
//            $.ajax({
//                url : getsiteurl() + '/profile/banner/upload',
//                type : 'POST',
//                data : formData,
//                processData: false,  
//                contentType: false, 
//                success : function(data) {
//                }
//            });
        }
    }
    $("#photo_upload").on('change', function(){
        profilePhotosURL(this);
    });
});

