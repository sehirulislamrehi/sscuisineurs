@component('mail::message')

<div style="margin-bottom: 15px">
    <h2 style="text-align: center">New message</h2>
</div>

<div style="margin-bottom: 15px">
    <h2 style="text-align: left; margin:0">Name</h2>
    <p>{{ $message['name'] }}</p>
</div>

<div style="margin-bottom: 15px">
    <h2 style="text-align: left; margin:0">Email</h2>
    <p>{{ $message['email'] }}</p>
</div>

<div style="margin-bottom: 15px">
    <h2 style="text-align: left; margin:0">Phone</h2>
    <p>{{ $message['phone'] }}</p>
</div>

<div style="margin-bottom: 15px">
    <h2 style="text-align: left; margin:0">Message</h2>
    <p>{{ $message['message'] }}</p>
</div>

@endcomponent
