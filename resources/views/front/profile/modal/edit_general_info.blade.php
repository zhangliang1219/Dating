<div id="editBasicGeneralInfo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h4 class="modal-title">{{ trans('sentence.basic_general_information')}}</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('editProfile',Auth::user()->id)}}" id="editProfile" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="wish_to_meet" >{{trans('sentence.wish_to_meet')}}</label>
                            <select name="wish_to_meet" class="gender form-control">
                                <option value=""></option>
                                @foreach($gender as $key => $val)
                                <option value="{{$key}}"  {{(old('wish_to_meet') == $key || $user->wish_to_meet == $key)?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            @error('wish_to_meet')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <div class=" ">
                                <label for="preferred_age" >{{trans('sentence.preferred_age')}}</label>
                                <input type="text" id="preferred_age_range" readonly class="search_range" name="preferred_age"  >
                            </div>
                            <div id="preferred-age-slider-range"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <div class=" ">
                                <label for="preferred_height" >{{trans('sentence.preferred_height')}}</label>
                                <input type="text" id="preferred_height_range" readonly class="search_range" name="preferred_height"  style="display: none;">
                                <input type="text" id="preferred_height_range_hidden" class="search_range" name="preferred_height_range_hidden"  >
                            </div>
                            <div id="preferred-height-slider-range"></div>
                        </div>
                        <div class="form-group col-6">
                            <div class=" ">
                                <label for="preferred_weight" >{{trans('sentence.preferred_weight')}}</label>
                                <input type="text" id="preferred_weight_range" readonly class="search_range" name="preferred_weight"  style="display: none;">
                                <input type="text" id="preferred_weight_range_hidden" class="search_range" name="preferred_weight_range_hidden"  >
                            </div>
                            <div id="preferred-weight-slider-range"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="height" >{{trans('sentence.height')}}
                                @if(in_array(3,$userPrivacySetting))
                                    <input type="checkbox" class="height_privacy user_info_privacy" name="user_info_privacy[3]" value="1"  {{in_array(3,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="height" class="form-control">
                                <option value=""></option>
                                @foreach($height as $key => $val)
                                    <option value="{{$key}}" {{old('height') == $key|| $user->height == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="form-group col-6">
                            <label for="weight" >{{trans('sentence.weight')}}(kg)
                                @if(in_array(4,$userPrivacySetting))
                                    <input type="checkbox" class="weight_privacy user_info_privacy" name="user_info_privacy[4]" value="1"  {{in_array(4,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <input type="text" value="{{isset($user->weight)?$user->weight:old('weight')}}" name="weight" class="form-control" placeholder="{{ trans('sentence.enter').' '.trans('sentence.weight')}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="living_arrangement" >{{trans('sentence.living_arrangement')}}
                                @if(in_array(5,$userPrivacySetting))
                                    <input type="checkbox" class="living_arrangement_privacy user_info_privacy" name="user_info_privacy[5]" value="1"  
                                           {{in_array(5,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="living_arrangement" class="form-control">
                                <option value=""></option>
                                @foreach($living_arrangement as $key => $val)
                                    <option value="{{$key}}" {{old('living_arrangement') == $key ||  $user->living_arrangement == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="city" >{{trans('sentence.city')}}
                                @if(in_array(6,$userPrivacySetting))
                                    <input type="checkbox" class="city_arrangement_privacy user_info_privacy" name="user_info_privacy[6]" value="1"  {{in_array(6,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <input type="text" value="{{isset($user->city)?$user->city:old('city')}}" id="city" name="city" class="form-control" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="state" >{{trans('sentence.state')}}
                            @if(in_array(7,$userPrivacySetting))
                                <input type="checkbox" class="state_arrangement_privacy user_info_privacy" name="user_info_privacy[7]" value="1"  {{in_array(7,$userInfoPrivacy)?'checked':''}}>
                            @endif
                            </label>
                            <input type="text" value="{{isset($user->state)?$user->state:old('state')}}" id="state" name="state" class="form-control"   placeholder="Enter State">
                        </div>
                        <div class="form-group col-6">
                            <label for="country" >{{trans('sentence.country')}}
                                @if(in_array(8,$userPrivacySetting))
                                    <input type="checkbox" class="country_arrangement_privacy user_info_privacy" name="user_info_privacy[8]" value="1"  {{in_array(8,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="country" class="form-control">
                                <option value=""></option>
                                @foreach($country as $key => $val)
                                    <option value="{{$val->id}}" {{old('country') == $val->id || $user->country == $val->id?'selected':''}}>{{$val->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="favorite_sport" >{{trans('sentence.favorite_sport')}}
                                @if(in_array(9,$userPrivacySetting))
                                    <input type="checkbox" class="favorite_sport_privacy user_info_privacy" name="user_info_privacy[9]" value="1"  {{in_array(9,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <input type="text" value="{{isset($user->favorite_sport)?$user->favorite_sport:old('favorite_sport')}}" name="favorite_sport" class="form-control"   placeholder="Enter Favorite Sport">
                        </div>
                        <div class="form-group col-6">
                            <label for="high_school_attended" >{{trans('sentence.high_school_attended')}}
                                @if(in_array(10,$userPrivacySetting))
                                    <input type="checkbox" class="high_school_privacy user_info_privacy" name="user_info_privacy[10]" value="1"  {{in_array(10,$userInfoPrivacy)?'checked':''}}>
                               @endif
                            </label>
                            <input type="text"  name="high_school_attended" class="form-control" value="{{isset($user->high_school_attended)?$user->high_school_attended:old('high_school_attended')}}"
                                     placeholder="Enter High School Attended ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="collage" >{{trans('sentence.college')}}
                            @if(in_array(11,$userPrivacySetting))
                                <input type="checkbox" class="college_privacy user_info_privacy" name="user_info_privacy[11]" value="1"  {{in_array(11,$userInfoPrivacy)?'checked':''}}>
                            @endif
                        </label>
                        <input type="text" value="{{isset($user->collage)?$user->collage:old('collage')}}" name="collage" class="form-control"  
                                 placeholder="Enter College">
                        </div>
                        <div class="form-group col-6">
                            <label for="employment_status" >{{trans('sentence.employee')}}
                                @if(in_array(12,$userPrivacySetting))
                                    <input type="checkbox" class="employment_status_privacy user_info_privacy" name="user_info_privacy[12]" value="1"  {{in_array(12,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="employment_status" class="form-control">
                                <option value=""> </option>
                                @foreach($employment_status as $key => $val)
                                    <option value="{{$key}}" {{old('employment_status') == $key || $user->employment_status == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="education" >{{trans('sentence.education')}}
                                @if(in_array(13,$userPrivacySetting))
                                    <input type="checkbox" class="education_privacy user_info_privacy" name="user_info_privacy[13]" value="1"  {{in_array(13,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="education" class="form-control">
                                <option value=""> </option>
                                @foreach($education as $key => $val)
                                    <option value="{{$key}}" {{old('education') == $key ||$user->education == $key ?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="children" >{{trans('sentence.children')}}
                                @if(in_array(14,$userPrivacySetting))
                                    <input type="checkbox" class="children_privacy user_info_privacy" name="user_info_privacy[14]" value="1"  {{in_array(14,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="children" class="form-control">
                                <option value=""> </option>
                                @foreach($children as $key => $val)
                                    <option value="{{$key}}" {{old('children') == $key ||$user->children == $key ?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="describe_perfect_date" >{{trans('sentence.describe_perfect_date')}}
                                @if(in_array(15,$userPrivacySetting))
                                    <input type="checkbox" class="describe_perfect_date_privacy user_info_privacy" name="user_info_privacy[15]" value="1">
                                @endif
                            </label>
                            <textarea  row="4" col="2" name="describe_perfect_date" class="form-control"
                                    placeholder="{{ trans('sentence.enter').' '.trans('sentence.describe_perfect_date')}}" id="describe_perfect_date">{{isset($user->describe_perfect_date)?($user->describe_perfect_date):old('describe_perfect_date')}}</textarea>

                        </div>
                        <div class="form-group col-6">
                            <label for="relationship" >{{trans('sentence.relationship')}}
                                @if(in_array(2,$userPrivacySetting))
                                    <input type="checkbox" class="relationship_privacy user_info_privacy" name="user_info_privacy[2]" value="1"  {{in_array(2,$userInfoPrivacy)?'checked':''}}>
                                @endif</label>
                            <select name="relationship" class="form-control">
                                <option value=""> </option>
                                @foreach($relationship as $key => $val)
                                    <option value="{{$key}}" {{old('relationship') == $key || $user->relationship == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('relationship'))
                                <div class="error">{{ $errors->first('relationship') }}</div>
                            @endif
                        </div>
                    </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="ethnicity" >{{trans('sentence.ethnicity')}}
                                    @if(in_array(16,$userPrivacySetting))
                                        <input type="checkbox" class="ethnicity_privacy user_info_privacy" name="user_info_privacy[16]" value="1"  {{in_array(16,$userInfoPrivacy)?'checked':''}}>
                                    @endif
                                </label>
                                <select name="ethnicity" class="form-control" id="ethnicity">
                                    <option value=""></option>
                                    @foreach($ethnicity as $key => $val)
                                    <option value="{{$key}}" {{old('ethnicity') == $key || $user->ethnicity == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ethnicity'))
                                    <div class="error">{{ $errors->first('ethnicity') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label for="build" >{{trans('sentence.build')}}
                                @if(in_array(17,$userPrivacySetting))
                                    <input type="checkbox" class="build_privacy user_info_privacy" name="user_info_privacy[17]" value="1">
                                @endif
                                </label>
                                <select name="build" class="build form-control" id="build">
                                    <option value=""></option>
                                    @foreach($build as $key => $val)
                                        <option value="{{$key}}" {{old('build') == $key|| $user->build == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="form-group col-6">
                                <input type="text" class="form-control" name="ethnicity_other" id="ethnicity_other" style="display: none;" value="{{$user->ethnicity_other}}">
                                <input type="hidden" class="form-control" name="ethnicity_other_hidden" id="ethnicity_other_hidden"  value="{{$user->ethnicity_other}}">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" class="form-control" name="build_other" id="build_other" style="display: none;" value="{{$user->build_other}}">
                                <input type="hidden" class="form-control" name="build_other_hidden" id="build_other_hidden"  value="{{$user->build_other}}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('sentence.save')}}
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="location.href='{{url('/profile')}}'">
                                    {{trans('sentence.cancel')}}
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>