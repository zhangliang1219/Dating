<div class="subscription_price_html col-12" id="{{'price_html_row_'.(isset($rowNumber)?$rowNumber:1)}}">
    <div class="form-group col-lg col-md-4 col-sm-4">
        <label class="">Price</label>
        <input type='text' name="price[]" class="form-control"  id="{{'price_'.(isset($rowNumber)?$rowNumber:1)}}">
    </div>
    <div class="form-group col-lg col-md-4 col-sm-4 " >
        <label class="">Currency</label>
        <select  class="form-control currency_opt" name="currency[]"  id="{{'currency_'.(isset($rowNumber)?$rowNumber:1)}}">
            <option value="">Select Currency</option>
            @foreach($subscription_currency as $cKey => $cVal)
                <option value="{{$cKey}}">{{$cVal}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg col-md-4 col-sm-4" id="{{'period_selection_'.(isset($rowNumber)?$rowNumber:1)}}">
        <label class="">Period</label>
        <select  class="form-control" name="period[]"  id="{{'period_'.(isset($rowNumber)?$rowNumber:1)}}">
            <option value="">Select Period</option>
        </select>
    </div>
    <i class="fa fa-plus add_subscription_price" aria-hidden="true" data-row-id="{{(isset($rowNumber)?$rowNumber:1)}}"></i>
</div>