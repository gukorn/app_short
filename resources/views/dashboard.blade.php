{{-- resources/views/borrow/index.blade.php --}}
@extends('layouts.iframe')

@section('style')
<style>
    .text-teal { color: #398276; }
    .bg-teal { background-color: #398276; color: white; }
    .bg-teal:hover { background-color: #2d665d; color: white; }
    .bg-teal-light { background-color: #eaf5f2; }

    .top-navbar {
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 24px;
    }
    .top-tabs .tab-item {
        color: #64748b;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .top-tabs .tab-item:hover, .top-tabs .tab-item.active {
        color: #398276;
        background-color: #eaf5f2;
    }
    .hover-teal:hover {
        color: #398276 !important;
    }
    .btn-outline-teal {
        border: 1px solid #398276;
        color: #398276;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-outline-teal:hover {
        background-color: #398276;
        color: white;
    }

    .main-content-wrapper {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    .landing-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(57, 130, 118, 0.04);
        padding: 40px;
        width: 100%;
        max-width: 550px;
        text-align: center;
    }

    .form-label-custom {
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
        font-size: 0.85rem;
        text-align: left;
        display: block;
    }
    .form-control-custom {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .form-control-custom:focus {
        border-color: #398276;
        box-shadow: 0 0 0 3px rgba(57, 130, 118, 0.15);
        outline: none;
    }
    .icon-header-box {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        font-size: 1.5rem;
    }
</style>
@endsection

@section('content')
    <div class="main-content-wrapper">
        <div class="landing-card">

            <h3 class="fw-bold text-dark mb-2">Quick create: Short link</h3>
            <hr class="text-muted opacity-25 mb-4">
            <form action="{{ actionURL('LinksController@store') }}" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label-custom">Enter your destination URL</label>
                    <input type="text" name="url_real" class="form-control form-control-custom validate[required,custom[url]]" placeholder="example: https://www.example.com" required>
                </div>

                <button type="submit"  class="btn bg-teal w-100 py-2.5 fw-medium rounded-3">
                    Create your link <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

        </div>
    </div>
@endsection


