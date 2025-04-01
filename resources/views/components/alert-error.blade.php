@if (session('error'))
    <div class="service__alert service__alert--error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" class="service__alert-close">&times;</button>
    </div>
@endif
