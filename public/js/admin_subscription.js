 $( document ).ready(function() {
    var rowNumber = 2;
    var langRowNumber = 2;

     var totalLanguage = $('#totalLanguage').val();
    $('#add_subscription_plan .language option[value=1]').attr('selected','selected');
    $('#add_subscription_plan .language').attr('readonly','readonly');
    
    $('#add_subscription_plan .add_subscription_price').click(function(){
          $.ajax({
              type: 'GET',
              url:getsiteurl() + '/admin/subscription/price_html/'+rowNumber,
              success: function (result) {
                    $(result).insertAfter($( ".subscription_price_html" ).last().append());
                    $(".add_subscription_price").last().attr('class', 'fa fa-minus remove_subscription_price');
                    rowNumber++;
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
                'price[]': {required:true},            
                'period[]': {required:true},            
                'currency[]': {required:true},            
                'recurring_payment': {required:true},            
                'free_for_gender[]': {required:true},            
                'feature[]': {required:true,minlength: 1 },            
        },
        messages: { 
            "feature[]": "Please select at least one feature."
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
});

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

    
