<div class="subscription_price_html col-12" id="{{'price_html_row_'.(isset($rowNumber)?$rowNumber:1)}}">
    <div class="form-group col-lg col-md-4 col-sm-4">
        <label class="">Price</label>
        <input type='text' name="price[]" class="form-control"  id="{{'price_'.(isset($rowNumber)?$rowNumber:1)}}">
    </div>
    <div class="form-group col-lg col-md-4 col-sm-4">
        <label class="">Period</label>
        <input type='text' name="period[]"   class="form-control" id="{{'period_'.(isset($rowNumber)?$rowNumber:1)}}">
    </div>
    <div class="form-group col-lg col-md-4 col-sm-4">
        <label class="">Currency</label>
        <input type='text' name="currency[]"  class="form-control"  id="{{'currency_'.(isset($rowNumber)?$rowNumber:1)}}">
    </div>
    <i class="fa fa-plus add_subscription_price" aria-hidden="true" data-row-id="{{(isset($rowNumber)?$rowNumber:1)}}"></i>
</div>