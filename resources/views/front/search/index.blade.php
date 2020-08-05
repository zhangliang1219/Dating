@extends('layouts.final')
@php
    $gender = trans('sentence.gender');
    $preferred_age = config('constant.preferred_age');
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
                    @if(count($searchProfile)>0)
                        <p class="mt-1">Showing {{ $searchProfile->firstItem() }} to {{ $searchProfile->lastItem() }} of total {{$searchProfile->total()}} entries</p>
                    @endif
                    <div class="row">
                        @if(count($searchProfile)>0)
                            @foreach($searchProfile as $val)
                                <div class="col-4">
                                    {{$val->name}}<br>
                                    {{$val->state.','.$val->country}}
                                </div>
                            @endforeach
                        @else
                             <h3>No Data Found</h3>
                        @endif
                    </div>
                    @if($searchProfile && !empty($searchProfile))
                        <div class="pt-4">{!! $searchProfile->appends(\Request::except('page'))->render() !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
