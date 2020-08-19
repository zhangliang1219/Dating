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
            'height': {required:true}, 
            'weight': {required:true}, 
            'living_arrangement' : {required:true},          
            'city' : {required:true},          
            'state' : {required:true},          
            'country' : {required:true},          
            'favorite_sport' : {required:true},          
            'high_school_attended' : {required:true},          
            'collage' : {required:true},          
            'employment_status' : {required:true},          
            'education' : {required:true},          
            'build' : {required:true},          
            'children' : {required:true},          
            'ethnicity': {required:true},         
            'relationship': {required:true},         
            'describe_perfect_date': {required:true,maxlength: 1000},         
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
        errorElement : 'small',
        submitHandler: function (form) {
            form.submit();
        }
    });
    
    $("#docVerification").validate({
        rules: {
            'doc_upload[]': {required:true,extension: "TIFF|JPEG|GIF|PDF|PNG|JPG"}, 
        },
        errorElement : 'small',
        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#doc_upload").change(function(e){
        var fileName =  e.target.files[0].name;
        $('#doc_upload_label').text(fileName);
    });
    $('#profile_photos').click(function(){
        $('#profilePhotosModal').modal('show');  
    });
    
    $("#photo_upload").on('change', function(e){
        profilePhotosURL(this);
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
                $('#photos_gallery_save').show();
                var fileName = input.files[0].name;
                $('#photo_upload_label').text(fileName);
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
    
    $(".gallery_photo_remove").on('click', function(){
        var rowId = $(this).attr('data-count-id');
         $.ajax({
            url : getsiteurl() + '/profile/gallery/photos/delete/'+$(this).attr('data-id'),
            type : 'GET',
            success : function() {
                $('#photo_box_'+rowId).remove();
            }
        });
    });
    
    $(".photo_gallery_privacy").one('change', function(){
        var rowId = $(this).attr('data-count-id');
         $.ajax({
            url : getsiteurl() + '/gallery/photos/privacy/update/'+$(this).attr('data-id')+'/'+($(this).is(':checked')?1:2),
            type : 'GET',
            success : function(data) {
                $(this).prop( "checked", true );
            }
        });
    });
    
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
    });
    
    $("#age-slider-range").slider({
        range: true,
        min: 18,
        max: 80,
        values: [ 18, 80 ],
        slide: function( event, ui ) {
            $("#age_range").val(ui.values[0] + " - " + ui.values[1]);
        }
    });
    $("#age_range").val($("#age-slider-range").slider("values", 0)+" - " + $("#age-slider-range").slider("values", 1 ));
    
    $("#height-slider-range").slider({
        range: true,
        min:4.2,
        max:7.5,
        values: [4.2,7.5],
        step:0.1,
        slide: function( event, ui ) {
            $("#height_range").val(ui.values[0] + " - " +ui.values[1]);
            $("#height_range_hidden").val(ui.values[0] + " - " +ui.values[1]+ " ft ");
        }
    });
    $("#height_range").val($("#height-slider-range").slider("values", 0)+" - " + $("#height-slider-range").slider("values", 1 ));
    $("#height_range_hidden").val($("#height-slider-range").slider("values", 0)+" - " + $("#height-slider-range").slider("values", 1 )+" ft ");
    
    $("#weight-slider-range").slider({
        range: true,
        min: 20,
        max: 200,
        values: [20,200],
        step:1,
        slide: function( event, ui ) {
            $("#weight_range").val(ui.values[0] + " - " + ui.values[1]);
            $("#weight_range_hidden").val(ui.values[0] + " - " + ui.values[1]+ " kg ");
        }
    });
    $("#weight_range").val($("#weight-slider-range").slider("values", 0)+" - " + $("#weight-slider-range").slider("values", 1 ));
    $("#weight_range_hidden").val($("#weight-slider-range").slider("values", 0)+" - " + $("#weight-slider-range").slider("values", 1 )+" kg ");
    
    $("#preferred-age-slider-range").slider({
        range: true,
        min: 18,
        max: 80,
        values: [ 18, 80 ],
        slide: function( event, ui ) {
            $("#preferred_age_range").val(ui.values[0] + " - " + ui.values[1]);
        }
    });
    $("#preferred_age_range").val($("#preferred-age-slider-range").slider("values", 0)+" - " + $("#preferred-age-slider-range").slider("values", 1 ));
    
    $("#preferred-height-slider-range").slider({
        range: true,
        min:4.2,
        max:7.5,
        values: [4.2,7.5],
        step:0.1,
        slide: function( event, ui ) {
            $("#preferred_height_range").val(ui.values[0] + " - " +ui.values[1]);
            $("#preferred_height_range_hidden").val(ui.values[0] + " - " +ui.values[1]+ " ft ");
        }
    });
    $("#preferred_height_range").val($("#preferred-height-slider-range").slider("values", 0)+" - " + $("#preferred-height-slider-range").slider("values", 1 ));
    $("#preferred_height_range_hidden").val($("#preferred-height-slider-range").slider("values", 0)+" - " + $("#preferred-height-slider-range").slider("values", 1 )+" ft ");
    
    $("#preferred-weight-slider-range").slider({
        range: true,
        min: 20,
        max: 200,
        values: [20,200],
        step:1,
        slide: function( event, ui ) {
            $("#preferred_weight_range").val(ui.values[0] + " - " + ui.values[1]);
            $("#preferred_weight_range_hidden").val(ui.values[0] + " - " + ui.values[1]+ " kg ");
        }
    });
    $("#preferred_weight_range").val($("#preferred-weight-slider-range").slider("values", 0)+" - " + $("#preferred-weight-slider-range").slider("values", 1 ));
    $("#preferred_weight_range_hidden").val($("#preferred-weight-slider-range").slider("values", 0)+" - " + $("#preferred-weight-slider-range").slider("values", 1 )+" kg ");
});

