{{-- resources/views/emails/password.blade.php --}}
 
Click here to reset your password: <a href="{{ url('password/reset/'.$token) }}">{{ url('password/reset/'.$token) }}</a>