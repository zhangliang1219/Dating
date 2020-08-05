@extends('layouts.final')
@php
    $gender = trans('sentence.gender');
    $preferred_age = config('constant.preferred_age');
    $height = config('constant.height');
    $weight = config('constant.weight');
@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            <h5>{{ session('success') }}</h5>
                        </div>
                    @endif
                    <form class="form-horizontal" method="post" action="{{route('viewSearchProfile')}}" name="search_profile" id="search_profile" >
                        @csrf
                        <div class="card-body">
                            <div class="form-group col-4">
                                    <select name="gender" class="form-control">
                                        <option value="">{{ trans('sentence.gender_label')}}</option>
                                        @foreach($gender as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group col-4">
                                <select name="age" class="form-control">
                                    <option value="">{{ trans('sentence.age')}}</option>
                                    @foreach($preferred_age as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group col-4">
                                <select name="country" class="form-control" >
                                    <option value="">{{ trans('sentence.country')}}</option>
                                    @foreach($country as $key => $val)
                                        <option value="{{$val->id}}">{{$val->country_name}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group col-4">
                                <select name="height" class="form-control" >
                                    <option value="">{{ trans('sentence.height')}}</option>
                                    @foreach($height as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group col-4">
                                <select name="weight" class="form-control" >
                                    <option value="">{{ trans('sentence.weight')}}</option>
                                    @foreach($weight as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('sentence.find_your_partner')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/front_contact_us.js') }}"></script>
@endsection