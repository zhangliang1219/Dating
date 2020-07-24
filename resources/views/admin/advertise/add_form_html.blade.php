<div class="add_ads_form" id='add_ads_form_1'>
    <div class='row'>
        <div class="form-group col-6">
            <label for="lang">Language</label>
            <select  class="form-control language" name="language[]"  id="{{'language_'.(isset($id)?$id:1)}}"  >
                <option value="">Select Language</option>
                @foreach($language as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
                @endforeach
            </select>
            @if ($errors->has('language'))
                <div class="error">{{ $errors->first('language') }}</div>
            @endif
        </div>
        <div class="form-group col-6">
            <label for="title">Title</label>
            <input type="text" name="title_name[]" id="{{'title_name_'.(isset($id)?$id:1)}}"  class="form-control" placeholder="Enter Ad Title">
            @if ($errors->has('title[]'))
                <div class="error">{{ $errors->first('title[]') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label for="ad_type">Ad Type</label>
            <select   class="form-control ad_type" name="ad_type[]"   id="{{'ad_type_'.(isset($id)?$id:1)}}"  >
                <option value="">Select Ad Type</option>
                @foreach($ad_type as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
                @endforeach
            </select>
            @if ($errors->has('ad_type[]'))
                <div class="error">{{ $errors->first('ad_type[]') }}</div>
            @endif
        </div>
        <div class="form-group col-6">
            <label for="ad_status">Ad Status</label>
            <select   class="form-control ad_status" name="ad_status[]"   id="{{'ad_status_'.(isset($id)?$id:1)}}"  >
                <option value="">Select Ad Status</option>
                @foreach($ad_status as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
                @endforeach
            </select>
            @if ($errors->has('ad_status'))
                <div class="error">{{ $errors->first('ad_status') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group col-6">
        <label for="file">Image / Video Upload</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input ads_file ads_file_upload"  name='ads_file[]'  id="{{'ads_file_'.(isset($id)?$id:1)}}">
            <label class="sdsd custom-file-label ads_file_name{{' ads_file_'.(isset($id)?$id:1)}}" 
                   for="ads_file"  data-id="{{'ads_file_'.(isset($id)?$id:1)}}">Choose file</label>
        </div>
        @if ($errors->has('ads_file'))
            <div class="error">{{ $errors->first('ads_file') }}</div>
        @endif
    </div>
</div>
