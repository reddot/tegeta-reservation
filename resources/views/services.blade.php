{{-- Available Variables: 
    $services <- [array]
--}}
<select name="service" class="form-select">
    <option value="" selected>@lang('აირჩიეთ სერვისი')</option>
    @foreach ($services as $key => $value)
    <option value="{{ $key }}">{{ $key }}</option>
    @endforeach
</select>
