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
    var filePrivacyData = new Array();
    var fileCount = $('.photo_gallery_count').val();
    var filePrivacyCount = $('.photo_gallery_count').val();
    var profilePhotosURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.photo_gallery tr').append('<td class="photo_box" id="photo_box_'+filePrivacyCount+'"><img src='+ e.target.result+' alt="photo" >\n\
                                                <i class="fa fa-trash gallery_photo_remove" aria-hidden="true" data-count-id="'+filePrivacyCount+'" data-id="0"></i>\n\
                                                <input type="checkbox" class="photo_gallery_privacy" name="upload_photos['+filePrivacyCount+']" value="1" \n\
                                                data-count-id="'+filePrivacyCount+'" data-id="0"></td>');
                filePrivacyData[filePrivacyCount] = 2;
                $(".photo_gallery_privacy").one('change', function(){
                    if ($(this).is(':checked')){
                        filePrivacyData[$(this).attr('data-count-id')] = 1;
                    }else{
                        filePrivacyData[$(this).attr('data-count-id')] = 2;
                    }
                });
                filePrivacyCount ++;
            }
            $(".gallery_photo_remove").one('click', function(){
                $('#photo_box_'+$(this).attr('data-count-id')).remove();
                filePrivacyData.splice($(this).attr('data-count-id'),1);
                fileData.splice($(this).attr('data-count-id'), 1);
            });
            
            reader.readAsDataURL(input.files[0]);
            fileData[fileCount] = input.files[0];
            fileCount ++;
        }
    }
//    $(".gallery_photo_remove").on('click', function(){
//         
//    });
    $('#photos_gallery_save').on('click',function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        
        fileData.forEach(function(file, i) {
            formData.append('fileData_'+i, file);
            formData.append('filePrivacy_'+i, filePrivacyData[i]);
            formData.append('totalCount',filePrivacyData.length);
        });
        $.ajax({
                url : getsiteurl() + '/profile/gallery/photos/upload',
                type : 'POST',
                data :formData,
                contentType: false,
                processData: false,
                success : function(data) {
                    location.reload();
                }
            });
    })
    
    $("#photo_upload").on('change', function(){
        profilePhotosURL(this);
    });
});

