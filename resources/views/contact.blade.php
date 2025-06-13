@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact Us</h1>
    
    {{-- <form method="POST" action="{{ route('contact.submit') }}">
        @csrf --}}
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
    </form>
</div>
@endsection
