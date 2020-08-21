 $( document ).ready(function() {

    $( "body" ).on( "click", "#profile_next", function() {
        var searchArrayId =  $.parseJSON($('#serachIdArray').val());
        var currentProfileId =  parseInt($(this).attr('data-id'));
        var nextId = searchArrayId[($.inArray(currentProfileId, searchArrayId) + 1) % searchArrayId.length];
        var url = getsiteurl() + '/user/profile/'+nextId;
        $.ajax({
            url : getsiteurl() + '/slide/user/profile/'+nextId,
            type : 'GET',
            success : function(data) {
                window.history.replaceState("", "",url);
                console.log(data);
                $('.profile_detail').html(data);
                if(nextId == searchArrayId[searchArrayId.length-1]){
                    $('#profile_next').hide();
                }
            }
        });
    });
    
    $( "body" ).on( "click", "#profile_prev", function() {
        var searchArrayId =  $.parseJSON($('#serachIdArray').val());
        var currentProfileId =  parseInt($(this).attr('data-id'));
        var prevId = searchArrayId[($.inArray(currentProfileId, searchArrayId) - 1) % searchArrayId.length];
        var url = getsiteurl() + '/user/profile/'+prevId;
        $.ajax({
            url : getsiteurl() + '/slide/user/profile/'+prevId,
            type : 'GET',
            success : function(data) {
                window.history.replaceState("", "", url);
                $('.profile_detail').html(data);
                if(prevId == searchArrayId[0]){
                    $('#profile_prev').hide();
                }
            }
        });
    });
    
    $( "body" ).on( "click", ".profileLike,.profileDislike,.profileAdd", function() {
        var userId =  parseInt($(this).attr('data-user-id'));
        var profileId =  parseInt($(this).attr('data-profile-id'));
        var type =  $(this).attr('data-type');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url :  getsiteurl() + '/user/profile/like_dislike',
            type : 'POST',
            data : {userId:userId,profileId:profileId,type:type},
            success : function(data) {
//                $((type == 'like'?'.profileLike':'.profileDislike')).prop('disabled', true);
//                $((type == 'like'?'.profileDislike':'.profileLike')).prop('disabled', false);
//                $((type == 'add'?'.profileAdd':'.profileDislike')).prop('disabled', true);
//                $((type == 'add'?'.profileDislike':'.profileAdd')).prop('disabled', false);
                if(data == 'match'){
                    $('.profileAdd').hide();
                    $('.profileDislike').hide();
                    $('.message').show();
                }if(data == 'like'){
                    $('.profileLike').hide();
                    $('.profileDislike').show();
                }
            }
        });
    });
});

