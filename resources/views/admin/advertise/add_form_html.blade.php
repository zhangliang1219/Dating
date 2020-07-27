<div class="add_ads_form" id='add_ads_form_1'>
    <div class='row'>
        <div class="form-group col-6">
            <label for="lang">Language</label>
            <select  class="form-control language defaultLang" name="language[]"  id="{{'language_'.(isset($id)?$id:1)}}"  >
                <option value="">Select Language</option>
                @foreach($language as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
                @endforeach
            </select>
            <input type="hidden" name="language[]"  value="" class="hiddenLanguage">
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
    @if(!isset($id))
    <div class="row">
        <div class="form-group col-6">
            <label for="ad_category">Ad Start Date</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
              </div>
              <input type="text" class="form-control ad_start_date" name="ad_start_date"   id="ad_start_date"  >
            </div>
            <label id="ad_start_date-error" class="error" for="ad_start_date"></label>
        </div>
        <div class="form-group col-6">
            <label for="ad_category">Ad Expiration Date</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
              </div>
              <input type="text" class="form-control ad_expiration_date" name="ad_expiration_date"   id="ad_expiration_date"  >
            </div>
            <label id="ad_expiration_date-error" class="error" for="ad_expiration_date"></label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label for="ad_category">Ad Category</label>
            <select   class="form-control ad_category" name="ad_category"   id="ad_category"  >
                <option value="">Select Ad Category</option>
                @foreach($ad_category as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
                @endforeach
            </select>
            @if ($errors->has('ad_category'))
                <div class="error">{{ $errors->first('ad_category') }}</div>
            @endif
        </div>
        <div class="form-group col-6" style="padding-top: 35px;">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="ad_status" name="ad_status" value="1">
                <label class="custom-control-label" for="ad_status">Ad Status</label>
            </div>
            @if ($errors->has('ad_status'))
                <div class="error">{{ $errors->first('ad_status') }}</div>
            @endif
        </div>
    </div>
    @endif
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
