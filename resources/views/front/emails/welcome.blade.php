<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
    <p>
        Hello {{$user->name}},
    </p>
<p>Welcome to the {{env('APP_NAME', 'Dating Site')}}. Please verify your email address by clicking the following link:</p>
<p><a href="{{route('confirm-account',$user->id)}}" title="confirmation">{{route('confirm-account',$user->id)}}</a></p>
{{env('APP_NAME', 'Dating Site')}}<br>
</body>

</html>


