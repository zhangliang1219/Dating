@php
    $id = 1;
@endphp
@foreach($getAds as $adKey => $adVal)
@php
    $id = $adKey + 1;
@endphp
<div class="add_ads_form" id='add_ads_form_{{$id}}'>
    <input type="hidden" name="adsId[]" value="{{$adVal->id}}">
    <div class='row'>
        <div class="form-group col-6">
            <label for="lang">Language</label>
            <select  class="form-control language" name="language[]"  id="{{'language_'.(isset($id)?$id:1)}}"  disabled='disabled'>
                <option value="">Select Language</option>
                @foreach($language as $key => $val)
                <option value="{{$key}}" {{$adVal->language_id == $key ?'selected':''}}>{{$val}}</option>
                @endforeach
            </select>
            <input type="hidden" name="language[]"  value="{{$adVal->language_id}}">
            @if ($errors->has('language'))
                <div class="error">{{ $errors->first('language') }}</div>
            @endif
        </div>
        <div class="form-group col-6">
            <label for="title">Title</label>
            <input type="text" name="title_name[]" id="{{'title_name_'.(isset($id)?$id:1)}}"  class="form-control" 
                   placeholder="Enter Ad Title" value="{{$adVal->title}}">
            @if ($errors->has('title'))
                <div class="error">{{ $errors->first('title') }}</div>
            @endif
        </div>
    </div>
    <div class='row'>
        <div class="form-group col-6">
            <label for="ad_category">Ad Category</label>
            <select   class="form-control ad_category" name="ad_category"   id="ad_category" >
                <option value="">Select Ad Category</option>
                @foreach($ad_category as $key => $val)
                <option value="{{$key}}" {{($adVal->ad_category == $key)?'selected':''}}>{{$val}}</option>
                @endforeach
            </select>
            @if ($errors->has('ad_category'))
                <div class="error">{{ $errors->first('ad_category') }}</div>
            @endif
        </div>
        <div class="form-group col-6" style="padding-top: 35px;">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="ad_status" name="ad_status" value="1" {{($adVal->ad_status == 1)?'checked':''}}>
                <label class="custom-control-label" for="ad_status">Ad Status</label>
            </div>
            @if ($errors->has('ad_status'))
                <div class="error">{{ $errors->first('ad_status') }}</div>
            @endif
        </div>
    </div>
    <div class='row'>
        <div class="form-group col-6">
            <label for="file">Image / Video Upload</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input ads_file ads_file_upload"  name='ads_file[]'  id="{{'ads_file_'.(isset($id)?$id:1)}}" 
                       value="{{($adVal->file_name != '')?$adVal->file_name:''}}">
                <label class="custom-file-label ads_file_name{{' ads_file_'.(isset($id)?$id:1)}}" for="ads_file" >
                    {{($adVal->file_name != '')?$adVal->file_name:'Choose file'}}
                </label>
            </div>
            @if ($errors->has('ads_file'))
                <div class="error">{{ $errors->first('ads_file') }}</div>
            @endif
        </div>
        <div class='image_video col-6'>
            @if($adVal->file_type == 'video')
            <video title="ad video" width="200" height="200" controls src="{{url('images/advertise/'.$adVal->file_name)}}">
            </video>
            @else
            <img src="{{url('images/advertise/'.$adVal->file_name)}}" title="ad image">
            @endif
        </div>
        <br>
    </div>
</div>
@if($adKey < count($language)-1 && $id != count($getAds))
    <div class='seperate_div'><hr></div>
@endif
@endforeach
