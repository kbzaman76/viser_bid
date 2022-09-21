@php
	$captcha = loadCustomCaptcha('46', '100%');
@endphp
@if($captcha)
    <div class="form-group mb-3">
        <label>@lang('Captcha Code')</label>
        @php echo $captcha @endphp
        <div class="mt-4">
            <input type="text" name="captcha" class="form-control">
        </div>
    </div>
@endif
