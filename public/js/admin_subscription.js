 $( document ).ready(function() {
    var rowNumber = 2;
    var langRowNumber = 2;

     var totalLanguage = $('#totalLanguage').val();
    $('#add_subscription_plan .language option[value=1]').attr('selected','selected');
    $('#add_subscription_plan .language').attr('disabled','disabled');
    $('.hiddenLanguage').val(1);
    $('.defaultLang').change(function(){
        $('.hiddenLanguage').val($(this).val());
    });
    $('#add_subscription_plan .add_subscription_price').click(function(){
          $.ajax({
                type: 'GET',
                url:getsiteurl() + '/admin/subscription/price_html/'+rowNumber,
                success: function (result) {
                        $(result).insertAfter($( ".subscription_price_html" ).last().append());
                        $(".add_subscription_price").last().attr('class', 'fa fa-minus remove_subscription_price');
                        rowNumber++;
                        getPriodList();
                        $( ".remove_subscription_price" ).off('click').on( "click", function() {
                            var rowId = $(this).attr('data-row-id');
                            $('#price_html_row_'+rowId).remove();
                        });
                }
          });
    });
    
    $('#add_subscription_plan .add_subscri_plan_in_another_lang').click(function(){
          $.ajax({
              type: 'GET',
              url:getsiteurl() + '/admin/subscription/add_lang_text_html/'+langRowNumber,
              success: function (result) {
                    $("<div class='seperate_div'><hr></div>").insertAfter($( ".add_subscri_plan_in_another_lang").last().append());
                    $(result).insertAfter($( "#add_subscription_plan .seperate_div" ).last().append());
                    $('#add_subscription_plan #add_plan_lan_text_row_'+langRowNumber+' .language  option[value=1]').remove(); 
                    langRowNumber++;
                    if((langRowNumber - 1) == totalLanguage){
                        $( "#add_subscription_plan .add_subscri_plan_in_another_lang,#add_subscription_plan .remove" ).remove();
                    }
              }
          });
    });
    
    
    
    $("#add_subscription_plan").validate({
        rules: {
                'language[]': {required:true},            
                'title[]': {required:true},            
                'short_desc[]': {required:true},            
                'price[]': {required:true,number: true},            
                'period[]': {required:true},            
                'currency[]': {required:true},            
                'recurring_payment': {required:true},            
                'free_for_gender[]': {required:true}, 
                'like_dislike_qty':{
                    required: "#swipe_with_like_dislike:checked",number: true,
                },
                'who_viewed_me_qty':{
                    required:  "#who_viewed_me:checked",number: true,
                },
                'photo_upload_qty':{
                    required: "#photo_upload:checked",number: true,
                },
                'feature[]': {required:true,minlength: 1 },        
                
        },
        messages: { 
            "feature[]": "Please select at least one feature.",
            'like_dislike_qty':{'required':"Please enter quantity.",'number':'Plase enter only number.'},
            'who_viewed_me_qty':{'required':"Please enter quantity.",'number':'Plase enter only number.'},
            'photo_upload_qty':{'required':"Please enter quantity.",'number':'Plase enter only number.'},
        }, 
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('.delete_subscription').click(function(){
        var subscriptionId = $(this).attr('data-id');
        if(subscriptionId != ''){
                swal({
                    title: "Are you sure you want to delete this subscription?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                if (willDelete) {
                  deleteSubscription(subscriptionId);
                }
             });
        }
    });	
    
    getPriodList();
    
    $('#swipe_with_like_dislike').change(function() {
        if(this.checked) {
            $('.swipe_with_like_dislike_wrap').html(''); 
            $('.swipe_with_like_dislike_wrap').append('<input type="text" class="form-control" placeholder="Quantity" \n\
                                                    name="like_dislike_qty" id="like_dislike_qty"><span class="pl-3">(0=Unlimited)</span>');
        }else{
           $('.swipe_with_like_dislike_wrap').html(''); 
        }
    });
    
     $('#who_viewed_me').change(function() {
        if(this.checked) {
            $('.who_viewed_me_wrap').html('');
            $('.who_viewed_me_wrap').append('<input type="text" class="form-control" placeholder="Quantity" name="who_viewed_me_qty" \n\
                                            id="who_viewed_me_qty"><span class="pl-3">(0=Unlimited)</span>');
        }else{
           $('.who_viewed_me_wrap').html('');
        }
    });
    
     $('#photo_upload').change(function() {
        if(this.checked) {
            $('.photo_upload_wrap').html('');
            $('.photo_upload_wrap').append('<input type="text" class="form-control " placeholder="Quantity" name="photo_upload_qty" \n\
                                            id="photo_upload_qty"><span class="pl-3">(0=Unlimited)</span>');
        }else{
           $('.photo_upload_wrap').html(''); 
        }
    });
    
    $('#edit_subscription_plan .add_subscri_plan_in_another_lang').click(function(){
          $.ajax({
              type: 'GET',
              url:getsiteurl() + '/admin/subscription/add_lang_text_html/'+langRowNumber,
              success: function (result) {
                    $("<div class='seperate_div'><hr></div>").insertAfter($( ".add_subscri_plan_in_another_lang").last().append());
                    $(result).insertAfter($( "#edit_subscription_plan .seperate_div" ).last().append());
                    $('#edit_subscription_plan #add_plan_lan_text_row_'+langRowNumber+' .language  option[value=1]').remove(); 
                    langRowNumber++;
                    if((langRowNumber - 1) == totalLanguage){
                        $( "#edit_subscription_plan .add_subscri_plan_in_another_lang,#add_subscription_plan .remove" ).remove();
                    }
              }
          });
    });
    $("#edit_subscription_plan").validate({
        rules: {
                'language[]': {required:true},            
                'title[]': {required:true},            
                'short_desc[]': {required:true},            
                'price[]': {required:true,number: true},            
                'period[]': {required:true},            
                'currency[]': {required:true},            
                'recurring_payment': {required:true},            
                'free_for_gender[]': {required:true}, 
                'like_dislike_qty':{
                    required: {       
                        depends: function(element) {
                          return $("#swipe_with_like_dislike:checked")
                        }
                    },
                    number: true
                },
                'who_viewed_me_qty':{
                    required: {       
                        depends: function(element) {
                          return $("#who_viewed_me:checked")
                        }
                    },
                    number: true
                },
                'photo_upload_qty':{
                    required: {       
                        depends: function(element) {
                          return $("#photo_upload:checked")
                        }
                    },
                    number: true
                },
                'feature[]': {required:true,minlength: 1 },        
                
        },
        messages: { 
            "feature[]": "Please select at least one feature.",
            'like_dislike_qty':{'required':"Please enter quantity.",'number':'Plase enter only number.'},
            'who_viewed_me_qty':{'required':"Please enter quantity.",'number':'Plase enter only number.'},
            'photo_upload_qty':{'required':"Please enter quantity.",'number':'Plase enter only number.'},
        }, 
        submitHandler: function (form) {
            form.submit();
        }
    });
    
    $('#edit_subscription_plan .add_subscription_price').click(function(){
        var rowNum = 2;
        var rowNum = $('.lastRowNumber').val();
          $.ajax({
                type: 'GET',
                url:getsiteurl() + '/admin/subscription/price_html/'+(parseInt(rowNum) + 1),
                success: function (result) {
                        $(result).insertAfter($( ".subscription_price_html" ).last().append());
                        $(".add_subscription_price").last().attr('class', 'fa fa-minus remove_subscription_price');
                        $('.lastRowNumber').val((parseInt(rowNum) + 1));
                        getPriodList();
                        $( ".remove_subscription_price" ).off('click').on( "click", function() {
                            var rowId = $(this).attr('data-row-id');
                            var data_subscr_price_id = $(this).attr('data_subscr_price_id');
                            if(typeof data_subscr_price_id !== 'undefined'){
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                jQuery.ajax({
                                    url  : getsiteurl() + '/admin/subscription/price/delete',
                                    type : "DELETE",
                                    data: {_token: CSRF_TOKEN,data_subscr_price_id:data_subscr_price_id},
                                    success: function(response) {
                                        if(response.status == 'success'){
                                            $('#price_html_row_'+rowId).remove();
                                        }
                                    }   
                                });
                            }else{
                                $('#price_html_row_'+rowId).remove();
                            }
                        });
                }
          });
    });
});
function getPriodList(){
    $( ".currency_opt" ).on( "change", function() {
        var currency_id = $(this).val();
        var currency_str = $(this).attr('id').split("_"); 
        var rowNum =  currency_str[currency_str.length - 1];
        $.ajax({
            type: 'GET',
            url:getsiteurl() + '/admin/subscription/period/'+rowNum+'/'+currency_id,
            success: function (result) {
                var html = '';
                if(Object.keys(result).length >0){
                    $( "#period_"+rowNum).html('');
                    html += '<option value="">Select Period</option>';
                    for(var i = 1;i <= Object.keys(result).length;i++){
                        html += '<option value="'+i+'">'+result[i]+'</option>';
                    }
                }
                $( "#period_"+rowNum).append(html);
            }
        });
    });
}
function deleteSubscription(subscriptionId){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        jQuery.ajax({
        url  : getsiteurl() + '/admin/subscription/delete',
        type : "DELETE",
        data: {_token: CSRF_TOKEN,subscriptionId:subscriptionId},
        success: function(response) {
            if(response.status == 'success'){
                swal(response.message,"", "success");
                $('#subscription_listing > tbody tr#'+subscriptionId).slideUp('slow');
            }else if(response.status == 'error'){
                swal(response.message,"", "error");
            }
        }
    });
}

    
