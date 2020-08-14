<div id="editBasicGeneralInfo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h4 class="modal-title">{{ trans('sentence.edit')}} {{ trans('sentence.basic_general_information')}}</h4>
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
                            <label for="preferred_age" >{{trans('sentence.preferred_age')}}</label>
                            <select name="preferred_age[]" class="form-control select2" multiple="multiple">
                                @foreach($preferred_age as $key => $val)
                                <option value="{{$key}}"  {{(old('preferred_age') == $key || ($user->preferred_age != ''&& in_array($key, explode(",",$user->preferred_age))))?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="preferred_height" >{{trans('sentence.preferred_height')}}</label>
                            <select name="preferred_height[]" class="form-control select2" multiple="multiple">
                                @foreach($height as $key => $val)
                                <option value="{{$key}}" {{(old('preferred_height') == $key || ($user->preferred_height != ''&& in_array($key, explode(",",$user->preferred_height))))?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="preferred_weight" >{{trans('sentence.preferred_weight')}}</label>
                            <select name="preferred_weight[]" class="form-control select2" multiple="multiple">
                                @foreach($weight as $key => $val)
                                <option value="{{$key}}" {{(old('preferred_weight') == $key ||($user->preferred_weight != ''&& in_array($key, explode(",",$user->preferred_weight))))?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="phoneNumber">{{ trans('sentence.phone_number')}}
                                @if(in_array(1,$userPrivacySetting))
                                    <input type="checkbox" class="phone_number_privacy user_info_privacy" name="user_info_privacy[1]" value="1" {{in_array(1,$userInfoPrivacy)?'checked':''}}>  
                                @endif
                            </label>
                            <input type="text" class="form-control" id="phoneNumber" placeholder="{{ trans('sentence.enter').' '.trans('sentence.phone_number')}}" 
                                   name="phoneNumber" value="{{old('phoneNumber')!=''?old('phoneNumber'):$user->phone}}">
                        </div>
                        @error('phoneNumber')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="form-group col-6">
                            <label for="relationship" >Relationship
                                @if(in_array(2,$userPrivacySetting))
                                    <input type="checkbox" class="relationship_privacy user_info_privacy" name="user_info_privacy[2]" value="1"  {{in_array(2,$userInfoPrivacy)?'checked':''}}>
                                @endif</label>
                            <select name="relationship" class="form-control">
                                <option value="">Select Relationship</option>
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
                            <label for="height" >Height
                                @if(in_array(3,$userPrivacySetting))
                                    <input type="checkbox" class="height_privacy user_info_privacy" name="user_info_privacy[3]" value="1"  {{in_array(3,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="height" class="form-control">
                                <option value="">Select Height</option>
                                @foreach($height as $key => $val)
                                    <option value="{{$key}}" {{old('height') == $key|| $user->height == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="form-group col-6">
                            <label for="weight" >Weight
                                @if(in_array(4,$userPrivacySetting))
                                    <input type="checkbox" class="weight_privacy user_info_privacy" name="user_info_privacy[4]" value="1"  {{in_array(4,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="weight" class="form-control">
                                <option value="">Select Weight</option>
                                @foreach($weight as $key => $val)
                                    <option value="{{$key}}" {{old('weight') == $key|| $user->weight == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="living_arrangement" >Living Arrangement
                                @if(in_array(5,$userPrivacySetting))
                                    <input type="checkbox" class="living_arrangement_privacy user_info_privacy" name="user_info_privacy[5]" value="1"  {{in_array(5,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="living_arrangement" class="form-control">
                                <option value="">Select Living Arrangement</option>
                                @foreach($living_arrangement as $key => $val)
                                    <option value="{{$key}}" {{old('living_arrangement') == $key ||  $user->living_arrangement == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="city" >City
                                @if(in_array(6,$userPrivacySetting))
                                    <input type="checkbox" class="city_arrangement_privacy user_info_privacy" name="user_info_privacy[6]" value="1"  {{in_array(6,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <input type="text" value="{{isset($user->city)?$user->city:old('city')}}" id="city" name="city" class="form-control"  placeholder="Enter City">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="state" >State/Province
                            @if(in_array(7,$userPrivacySetting))
                                <input type="checkbox" class="state_arrangement_privacy user_info_privacy" name="user_info_privacy[7]" value="1"  {{in_array(7,$userInfoPrivacy)?'checked':''}}>
                            @endif
                            </label>
                            <input type="text" value="{{isset($user->state)?$user->state:old('state')}}" id="state" name="state" class="form-control"   placeholder="Enter State">
                        </div>
                        <div class="form-group col-6">
                            <label for="country" >Country
                                @if(in_array(8,$userPrivacySetting))
                                    <input type="checkbox" class="country_arrangement_privacy user_info_privacy" name="user_info_privacy[8]" value="1"  {{in_array(8,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($country as $key => $val)
                                    <option value="{{$val->id}}" {{old('country') == $val->id || $user->country == $val->id?'selected':''}}>{{$val->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="favorite_sport" >Favorite Sport
                                @if(in_array(9,$userPrivacySetting))
                                    <input type="checkbox" class="favorite_sport_privacy user_info_privacy" name="user_info_privacy[9]" value="1"  {{in_array(9,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <input type="text" value="{{isset($user->favorite_sport)?$user->favorite_sport:old('favorite_sport')}}" name="favorite_sport" class="form-control"   placeholder="Enter Favorite Sport">
                        </div>
                        <div class="form-group col-6">
                            <label for="high_school_attended" >High School Attended 
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
                            <label for="collage" >College/University Attended
                            @if(in_array(11,$userPrivacySetting))
                                <input type="checkbox" class="college_privacy user_info_privacy" name="user_info_privacy[11]" value="1"  {{in_array(11,$userInfoPrivacy)?'checked':''}}>
                            @endif
                        </label>
                        <input type="text" value="{{isset($user->collage)?$user->collage:old('collage')}}" name="collage" class="form-control"  
                                 placeholder="Enter College">
                        </div>
                        <div class="form-group col-6">
                            <label for="employment_status" >Employment Status
                                @if(in_array(12,$userPrivacySetting))
                                    <input type="checkbox" class="employment_status_privacy user_info_privacy" name="user_info_privacy[12]" value="1"  {{in_array(12,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="employment_status" class="form-control">
                                <option value="">Enter Employee</option>
                                @foreach($employment_status as $key => $val)
                                    <option value="{{$key}}" {{old('employment_status') == $key || $user->employment_status == $key?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="education" >Education
                                @if(in_array(13,$userPrivacySetting))
                                    <input type="checkbox" class="education_privacy user_info_privacy" name="user_info_privacy[13]" value="1"  {{in_array(13,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="education" class="form-control">
                                <option value="">Select Education</option>
                                @foreach($education as $key => $val)
                                    <option value="{{$key}}" {{old('education') == $key ||$user->education == $key ?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="children" >Do you have Children?
                                @if(in_array(14,$userPrivacySetting))
                                    <input type="checkbox" class="children_privacy user_info_privacy" name="user_info_privacy[14]" value="1"  {{in_array(14,$userInfoPrivacy)?'checked':''}}>
                                @endif
                            </label>
                            <select name="children" class="form-control">
                                <option value="">Enter Children</option>
                                @foreach($children as $key => $val)
                                    <option value="{{$key}}" {{old('children') == $key ||$user->children == $key ?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="describe_perfect_date" >{{trans('sentence.describe_perfect_date')}}
                                @if(in_array(15,$userPrivacySetting))
                                    <input type="checkbox" class="describe_perfect_date_privacy user_info_privacy" name="user_info_privacy[15]" value="1">
                                @endif
                            </label>
                            <textarea  row="2" col="2" name="describe_perfect_date" class="form-control"
                                    placeholder="{{ trans('sentence.enter').' '.trans('sentence.describe_perfect_date')}}" id="describe_perfect_date"> {{isset($user->describe_perfect_date)?($user->describe_perfect_date):old('describe_perfect_date')}}</textarea>

                        </div>
                    </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="ethnicity" >Ethnicity
                                    @if(in_array(16,$userPrivacySetting))
                                        <input type="checkbox" class="ethnicity_privacy user_info_privacy" name="user_info_privacy[16]" value="1"  {{in_array(16,$userInfoPrivacy)?'checked':''}}>
                                    @endif
                                </label>
                                <select name="ethnicity" class="form-control" id="ethnicity">
                                    <option value="">Select Ethnicity</option>
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
                                        <option value="{{$key}}" {{old('build') == $key?'selected':''}}>{{$val}}</option>
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
<!--                                <button type="cancel" class="btn btn-secondary">
                                    {{trans('sentence.cancel')}}
                                </button>-->
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>