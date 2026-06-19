@yield('style')
@yield('content')
@yield('script')
<script>
    $(function() {
        addEvent("form.needs-validation");
        if ($('[id^="modalshow_"]').length === 0) {
            window.location = "{{ config('app.url') }}";
        }
    });
</script>
