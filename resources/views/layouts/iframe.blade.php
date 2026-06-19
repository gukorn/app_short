@yield('style')
<div id="main-wrapper">
@yield('content')
</div>
<script src="{{ assetV('assets/js/app.iframe.js') }}" data-url="{{ config('app.url') }}"></script>
@yield('script')
