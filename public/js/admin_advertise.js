 $( document ).ready(function() {
   fileUpload();
    var languageCount = 1;
    var ads_form_last_id = 1;
    var totalLanguage = $('#totalLanguage').val();
    $('#add_ads #add_ads_form_1 .language option[value=1]').attr('selected','selected');
    $('#add_ads #add_ads_form_1 .language').attr('readonly','readonly');

    $('#add_ads .add_in_another_lang').click(function(){
        $.ajax({
            type: 'GET',
            url:getsiteurl() + '/admin/advertise/add/form/'+ads_form_last_id,
            success: function (result) {
                $("<div class='seperate_div'><hr></div>").insertAfter($( "#add_ads #add_ads_form_"+ads_form_last_id ).last().append());
                $(result).insertAfter($( "#add_ads .seperate_div" ).last().append());
                ads_form_last_id++;
                $( "#add_ads .add_ads_form:last" ).attr("id","add_ads_form_"+ads_form_last_id);
                $('#add_ads #add_ads_form_'+ads_form_last_id+' .language  option[value=1]').remove(); 
                languageCount++;
                if(languageCount == totalLanguage){
                    $( "#add_ads .add_in_another_lang" ).remove();
                }
                fileUpload();   
            }
        });
    });
    
    $("#add_ads").validate({
        rules: {
                'title_name[]': {required:true},            
                'ad_type[]': {required:true},            
                'language[]': {required:true},            
                'ad_status[]': {required:true},            
                'ads_file[]': {required:true,accept: "image/*, video/*"},            
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $("#edit_ads").validate({
        rules: {
                'title_name[]': {required:true},            
                'ad_type[]': {required:true},            
                'language[]': {required:true},            
                'ad_status[]': {required:true},            
                'ads_file[]': {accept: "image/*, video/*"},            
        },
        submitHandler: function (form) {
            var error = 0;
            $(".ads_file_name").each(function(){
                if($(this).text() === 'Choose file'){
                    $('<label id="'+$(this).attr('data-id')+'-error" class="error" > \n\
                            This field is required.</label>').insertAfter($('#'+$(this).attr('data-id')).append());
                    error ++;
                }
            });
            if(error == 0){
                form.submit();
            }
        }
    });
    
    $('#edit_ads .add_in_another_lang').click(function(){
        $.ajax({
            type: 'GET',
            url:getsiteurl() + '/admin/advertise/add/form/'+ads_form_last_id,
            success: function (result) {
                $("<div class='seperate_div'><hr></div>").insertAfter($( "#edit_ads #add_ads_form_"+ads_form_last_id ).last().append());
                $(result).insertAfter($( "#edit_ads .seperate_div" ).last().append());
                ads_form_last_id++;
                $( "#edit_ads .add_ads_form:last" ).attr("id","add_ads_form_"+ads_form_last_id);
                $('#edit_ads #add_ads_form_'+ads_form_last_id+' .language  option[value=1]').remove(); 
                languageCount++;
                if(languageCount == totalLanguage){
                    $( "#edit_ads .add_in_another_lang" ).remove();
                }
                fileUpload();   
            }
        });
    });
    $('.delete_advertise').click(function(){
        var advertiseId = $(this).attr('data-id');
        if(advertiseId != ''){
                swal({
                    title: "Are you sure you want to delete this advertise?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                if (willDelete) {
                  deleteAdvertise(advertiseId);
                }
             });
        }
    });	
    
});
function deleteAdvertise(advertiseId){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        jQuery.ajax({
        url  : getsiteurl() + '/admin/advertise/delete',
        type : "DELETE",
        data: {_token: CSRF_TOKEN,advertiseId:advertiseId},
        success: function(response) {
            if(response.status == 'success'){
                swal(response.message,"", "success");
                $('#advertise_listing > tbody tr#'+advertiseId).slideUp('slow');
            }else if(response.status == 'error'){
                swal(response.message,"", "error");
            }
        }
    });
}
function fileUpload(){
    $('#add_ads .ads_file_upload').change(function(e){
        var fileName = e.target.files[0].name;
        $('.'+$(this).attr('id')).text(fileName);
    });
    
    $('#edit_ads .ads_file_upload').change(function(e){
        var fileName = e.target.files[0].name;
        $('.'+$(this).attr('id')).text(fileName);
    });
}
