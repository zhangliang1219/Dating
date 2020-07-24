<div class="add_plan_lan_text" id="{{'add_plan_lan_text_row_'.(isset($langRowNumber)?$langRowNumber:1)}}">
    <div class="row">
        <div class="form-group col-lg col-md-6 col-sm-6">
            <label for="lang">Language</label>
            <select  class="form-control language" name="language[]" id="{{'language_'.(isset($langRowNumber)?$langRowNumber:1)}}">
                <option value="">Select Language</option>
                @foreach($language as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
                @endforeach
            </select>
            @if ($errors->has('language[]'))
                <div class="error">{{ $errors->first('language[]') }}</div>
            @endif
        </div>
        <div class="form-group col-lg col-md-6 col-sm-6">
            <label class="">Title</label>
            <input type='text' name="title[]"  class="form-control" id="{{'title_'.(isset($langRowNumber)?$langRowNumber:1)}}">
            @if ($errors->has('title[]'))
                <div class="error">{{ $errors->first('title[]') }}</div>
            @endif
         </div>
    </div>
    <div class="row">
        <div class="form-group col-lg col-md-6 col-sm-6">
            <label class="">Short Description </label>
            <textarea class="form-control" rows="4" placeholder="Enter Short Description..." name="short_desc[]"  id="{{'short_desc_'.(isset($langRowNumber)?$langRowNumber:1)}}"></textarea>
            @if ($errors->has('short_desc[]'))
                <div class="error">{{ $errors->first('short_desc[]') }}</div>
            @endif
        </div>
    </div>
</div>