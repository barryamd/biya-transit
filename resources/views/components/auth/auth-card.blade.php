<div class="login-box">
    {{--
    <div class="login-logo">
        {{ $logo }}
    </div>
    --}}
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            {{ $logo }}
        </div>
        <div class="card-body login-card-body">
            {{ $slot }}
        </div>
    </div>
</div>
