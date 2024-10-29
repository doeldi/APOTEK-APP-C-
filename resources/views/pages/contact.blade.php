@extends('layouts.layout')

@section('content')
    <section class="contact" id="contact">
        <div class="center-text">
            <h2>Contact<span> Me </span></h2>
        </div>
        <div id="alertContainer" class="alert-container"></div>
        <div class="contact-form">
            <form id="contactForm" action="https://formspree.io/f/xpzvvdjz" method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <textarea name="message" cols="30" rows="10" placeholder="Write Message Here" required></textarea>
                <input type="submit" name="submit" value="Send Message" class="send-btn">
            </form>
        </div>
    </section>
@endsection
