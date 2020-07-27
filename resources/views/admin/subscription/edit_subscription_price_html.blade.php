@php
    $rowNumber = 1;
@endphp
@foreach($getSubscription[0]->subscriptionPrice as $editKey => $editVal)
@php
    $rowNumber = $editKey + 1;
@endphp
    @if(count($getSubscription[0]->subscriptionPrice) == $rowNumber)
        <input type='hidden' value="{{$rowNumber}}" class='lastRowNumber'>
    @endif
    <div class="subscription_price_html col-12" id="{{'price_html_row_'.(isset($rowNumber)?$rowNumber:1)}}">
        <div class="form-group col-lg col-md-4 col-sm-4">
            <label class="">Price</label>
            <input type='text' name="price[]" class="form-control"  id="{{'price_'.(isset($rowNumber)?$rowNumber:1)}}" value="{{$editVal->price}}">
        </div>
        <div class="form-group col-lg col-md-4 col-sm-4 " >
            <label class="">Currency</label>
            <select  class="form-control currency_opt" name="currency[]"  id="{{'currency_'.(isset($rowNumber)?$rowNumber:1)}}">
                <option value="">Select Currency</option>
                @foreach($subscription_currency as $cKey => $cVal)
                    <option value="{{$cKey}}" {{($editVal->currency == $cKey)?'selected':''}}>{{$cVal}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg col-md-4 col-sm-4" id="{{'period_selection_'.(isset($rowNumber)?$rowNumber:1)}}">
            <label class="">Period</label>
            <select  class="form-control" name="period[]"  id="{{'period_'.(isset($rowNumber)?$rowNumber:1)}}">
                <option value="">Select Period</option>
                @if($editVal->currency == 1 ||$editVal->currency == 3)
                    @foreach($subscription_period_1 as $sp1Key => $sp1Val)
                        <option value="{{$sp1Key}}" {{($editVal->currency == $sp1Key)?'selected':''}}>{{$sp1Val}}</option>
                    @endforeach
                @elseif($editVal->currency == 2 ||$editVal->currency == 4)
                    @foreach($subscription_period_2 as $sp2Key => $sp2Val)
                        <option value="{{$sp2Key}}" {{($editVal->currency == $sp2Key)?'selected':''}}>{{$sp2Val}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        @if($rowNumber == 1)
            <i class="fa fa-plus add_subscription_price" aria-hidden="true" data-row-id="{{(isset($rowNumber)?$rowNumber:1)}}"></i>
        @else
            <i class="fa fa-minus remove_subscription_price" aria-hidden="true" data-row-id="{{(isset($rowNumber)?$rowNumber:1)}}"
               data_subscr_price_id='{{$editVal->id}}'></i>
        @endif
    </div>
@endforeach