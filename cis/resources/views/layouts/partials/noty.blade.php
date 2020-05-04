
@if(Session::has('flash_notification.message'))
@php
    $level = Session::get('flash_notification.level');
    if ($level == 'info') {
        $level = 'information';
    }
@endphp
<script src="{{ asset('assets/plugins/noty.min.js') }}"></script>
<script>
    noty({
        type: '{{ $level }}',
        layout: 'topCenter',
        text: '{{ Session::get('flash_notification.message') }}',
        timeout: 3000
    });
</script>
@endif
