@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Success',
            body: {!! json_encode(session('success')) !!}
        });
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Info',
            body: {!! json_encode(session('info')) !!}
        });
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Warning',
            body: {!! json_encode(session('warning')) !!}
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Error',
            body: {!! json_encode(session('error')) !!}
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($errors->all() as $error)
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Error',
                body: {!! json_encode($error) !!}
            });
        @endforeach
    });
</script>
@endif
