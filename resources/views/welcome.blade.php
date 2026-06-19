@extends('layouts.landing')
@section('content')
    <div class="main-content-wrapper">
        <div class="landing-card">

            <div class="icon-header-box bg-teal-light text-teal">
                <i class="bi bi-chat-left-text-fill"></i>
            </div>

            <h3 class="fw-bold text-dark mb-2">Quick create: Short link</h3>
            <hr class="text-muted opacity-25 mb-4">
            <form>
                <div class="mb-3">
                    <label class="form-label-custom">Enter your destination URL</label>
                    <input type="text" class="form-control form-control-custom" placeholder="example: https://www.example.com">
                </div>


                <a href="{{ actionURL('Auth\LoginController@showLoginForm') }}"  class="btn bg-teal w-100 py-2.5 fw-medium rounded-3">
                    Create your link <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </form>

        </div>
    </div>
@endsection
