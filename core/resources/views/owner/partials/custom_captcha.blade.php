@php
	$captcha = loadCustomCaptcha('46', '100%');
@endphp
@if($captcha)
    <div class="form-group">
        <div>
            @php echo $captcha @endphp
        </div>
        <div class="mt-4">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control" required>
        </div>
    </div>
@endif
