<div class="single-user-profile" id='profile_details_{{$userInfo->id}}'>
    <div class="slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @if(count($userPhoto)>0)
                    @foreach($userPhoto as $val)
                    <div class="swiper-slide">
                        <img src="{{ asset('images/profile_gallery_photo/'.$val->photo_name) }}" alt="">
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="swiper-buttons">
                <div class="btn-swiper-prev">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </div>
                <div class="btn-swiper-next">
                    <ion-icon name="chevron-forward-outline"></ion-icon>
                </div>
            </div>
        </div>
        <div class="btn-swiper-next" tabindex="-1" id='profile_prev' data-id='{{$userInfo->id}}' 
             style='display:{{(session::has('searchProfileIdArray') && (session('searchProfileIdArray')[0]) == $userInfo->id ?'none':'block' )}}'>
            <img src="{{asset('images/prev.png')}}">
        </div>
    </div>
    <div class="user-details">
        <div class="user-header">
            <h2>{{$userInfo->name}} {{($userInfo->age != '')?' , '.$userInfo->age:''}}</h2>
            <!--<h4>23 kilometers away</h4>-->
            <h5>{{$userInfo->state}} , {{($userInfo->countryData)?$userInfo->countryData->country_name:''}}</h5>
        </div>
        <div class="desc">
            {{isset($userInfo->userInfoData->about_me)&&$userInfo->userInfoData->about_me != ''?$userInfo->userInfoData->about_me:''}}
        </div>
        <div class="btn-swiper-next" tabindex="-1" id='profile_next'  data-id='{{$userInfo->id}}'
             style='display:{{(session::has('searchProfileIdArray') && (session('searchProfileIdArray')[count(session('searchProfileIdArray'))-1]) == $userInfo->id ?'none':'block' )}}'>
            <img src="{{asset('images/next.png')}}">
        </div>
        
        <div class="action">
           @php
                $likeDislikeStatus = (new App\Http\Controllers\ProfileController)->likeDislikeStatus(Auth::user()->id,$userInfo->id);
           @endphp
           <button type="button" class="btn btn-theme profileAdd" data-user-id='{{Auth::user()->id}}' 
                    data-profile-id='{{$userInfo->id}}' data-type="add"  
                style="display:{{(($likeDislikeStatus && $likeDislikeStatus->user_like == 1)
                            && ($likeDislikeStatus->user_id != Auth::user()->id)&&
                                ($likeDislikeStatus->user_like !=1 && $likeDislikeStatus->profile_user_like !=1))?'show':'none'}}">Add</button>
                    
            <button type="button" class="btn btn-theme profileLike" data-user-id='{{Auth::user()->id}}' 
                    data-profile-id='{{$userInfo->id}}' data-type="like" 
                    style="display:{{(!isset($likeDislikeStatus))?'show':'none'}}">Like</button>
                    
            <button type="button" class="btn btn-theme profileDislike" data-user-id='{{Auth::user()->id}}' 
                data-profile-id='{{$userInfo->id}}' data-type="dislike" 
                style="display:{{((($likeDislikeStatus && $likeDislikeStatus->user_like == 1) 
                                || !isset($likeDislikeStatus)) && ($likeDislikeStatus->user_like !=1 && $likeDislikeStatus->profile_user_like !=1))?'show':'none'}}">Dislike</button>

            <button type="button" class="btn btn-theme message" data-user-id='{{Auth::user()->id}}' 
                    data-profile-id='{{$userInfo->id}}' data-type="message" 
                    style="display:{{(isset($likeDislikeStatus) && $likeDislikeStatus->user_like == 1 && $likeDislikeStatus->profile_user_like == 1)
                                ?'show':'none'}}">Message</button>
        </div>
    </div>
</div>