{{-- Available Variables: 
    $services <- [array]
--}}
<select name="service_type" class="form-select" required>
    <option value="" selected>@lang('აირჩიეთ სერვისი')</option>
    @foreach ($services as $key => $value)
        <option value="{{ $key }}" @if (old('service_type') == $key) selected @endif>{{ $key }}</option>
    @endforeach
</select>
