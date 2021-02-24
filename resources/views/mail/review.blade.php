<!-- @if($data['message'])
  <p> Re-review </p>
  <p> Your message from previous review: {{$data['message']}}</p>
@endif
<p> {{ $data['link'] }} </p>
@if($data['password'] == '')
  <p>You can login with your previous account</p>
@else
  <p>You can login using the password: {{$data['password']}} </p>
@endif -->

<p>Hey {{$data['name']}}</p>
@if($data['message'] == '')
    <p>{{$data['userName']}} invited you to review {{$data['client']}} filings for Edgar.</p>
@else
    <p>{{$data['userName']}} invited you to re-review {{$data['client']}} filings for Edgar.</p>
@endif
<p>Filing link: {{ $data['link'] }} </p>
<p>Here is the manual on how to use the iEdgar platform: <a href="{{ asset('manual/Edgarizer-Manual.pdf') }}">Click here to download.</a></p>

<p>In order to login here are the credentials generated for you:</p>
<p>Username: {{$data['email']}}</p>
@if($data['password'] == '')
     <p>Password: Use your previous password</p>
@else
    <p>Password: {{$data['password']}}</p>
@endif
<p>Thank you,</p>
<p>iEdgar staff</p>
