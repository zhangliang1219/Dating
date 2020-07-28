<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png?'.time()) }}">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.min.css?'.time())}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('css/tempusdominus-bootstrap-4.css?'.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css?'.time()) }}" rel="stylesheet"> 
    <link href="{{ asset('css/bootstrap-datepicker.min.css?'.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/custome.css?'.time()) }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Assistant">
    
@yield('css')
</head>