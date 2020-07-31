@extends('layouts.final')

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
                    <form class="form-horizontal" method="post" action="{{route('contactUsStore')}}" name="contact_us" id="contact_us" >
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="full_name" type="text" class="form-control" name="full_name" 
                                       value="{{ old('full_name') }}" placeholder="{{trans('sentence.full_name')}}">
                                @if ($errors->has('full_name'))
                                        <div class="error">{{ $errors->first('full_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"  placeholder="{{trans('sentence.email')}}">
                                @if ($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control" name="subject"  placeholder="{{trans('sentence.subject')}}">
                                @if ($errors->has('subject'))
                                        <div class="error">{{ $errors->first('subject') }}</div>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control" name="phone_number"  placeholder="{{trans('sentence.phone_number')}}">
                                @if ($errors->has('phone_number'))
                                        <div class="error">{{ $errors->first('phone_number') }}</div>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-md-6">
                                <textarea row="2" col="2" class="form-control" placeholder="{{trans('sentence.message')}}" name="message"></textarea>
                                @if ($errors->has('message'))
                                        <div class="error">{{ $errors->first('message') }}</div>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('sentence.send_now')}}
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