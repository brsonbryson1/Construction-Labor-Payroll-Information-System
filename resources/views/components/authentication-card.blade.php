{{-- 
    This component is the white container that holds the logo and the form.
    It uses the custom 'auth-card' class (defined in resources/css/app.css) 
    to apply the deep shadow and rounded corners required to match the design.
--}}
<div class="auth-card">
    
    {{-- This div holds the logo slot (the header content we put in login.blade.php) --}}
    <div>
        {{ $logo }}
    </div>

    {{-- This div holds the main content slot (the validation errors and the form itself) --}}
    <div class="w-full">
        {{ $slot }}
    </div>
</div>