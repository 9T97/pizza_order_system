@extends('user.layouts.master')

@section('title', 'Contact Us')

@section('content')

    <div class="container">
        <a href="{{ route('user#userContactList') }}" class="text-dark"><i class="fa-solid fa-arrow-left-long me-2"></i>Back</a>
        <div class="text-center">
            <h3 class="text-primary">Contact Us</h3>
        </div>
        <div class=" d-flex align-items-center justify-content-center">
            <div class="bg-white col-md-4">
                <form action="{{ route('user#sendContact') }}" method="post">
                    @csrf
                    <div class="p-4 rounded shadow-md">
                        <div>
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Your Email" required>
                        </div class="mt-3">
                        <div class="mt-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="mt-3 mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" cols="20" rows="6" class="form-control"
                                    placeholder="message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Submit Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
