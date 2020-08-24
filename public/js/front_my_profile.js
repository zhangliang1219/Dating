 $( document ).ready(function() {

    $( "body" ).one( "click", "#profile_next", function() {
        var searchArrayId =  $.parseJSON($('#serachIdArray').val());
        var currentProfileId =  parseInt($(this).attr('data-id'));
        var nextId = searchArrayId[($.inArray(currentProfileId, searchArrayId) + 1) % searchArrayId.length];
        getLikeDislikeStatus();
        var url = getsiteurl() + '/user/profile/'+nextId;
        $.ajax({
            url : getsiteurl() + '/slide/user/profile/'+nextId,
            type : 'GET',
            success : function(data) {
                window.history.replaceState("", "",url);
                $('body').html(data);
                if(nextId == searchArrayId[searchArrayId.length-1]){
                    $('#profile_next').hide();
                }
            }
        });
    });
    
    $( "body" ).one( "click", "#profile_prev", function() {
        var searchArrayId =  $.parseJSON($('#serachIdArray').val());
        var currentProfileId =  parseInt($(this).attr('data-id'));
        var prevId = searchArrayId[($.inArray(currentProfileId, searchArrayId) - 1) % searchArrayId.length];
        getLikeDislikeStatus();
        var url = getsiteurl() + '/user/profile/'+prevId;
        $.ajax({
            url : getsiteurl() + '/slide/user/profile/'+prevId,
            type : 'GET',
            success : function(data) {
                window.history.replaceState("", "", url);
                $('body').html(data);
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
    
    window.setInterval(function(){ 
        getLikeDislikeStatus();
    },3000);
    
});
var getLikeDislikeStatus = function() {
    var currLoc = $(location).attr('href'); 
    var parts = currLoc.split("/");
    var profile_id = parts[parts.length-1];
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url : getsiteurl() + '/profile/like/dislike/status',
        type : 'POST',
        data : {profileId:profile_id},
        success : function(data) {
//            console.log(data);
            $('.profileStatusBtn').hide();
            if(data.add == 1){
                $('.profileAdd').show();
            }
            if(data.like == 1){
                $('.profileLike').show();
            }
            if(data.message == 1){
                $('.profiilemessage').show();
            }
            if(data.dislike == 1){
                $('.profileDislike').show();
            }
        }
    });
}

