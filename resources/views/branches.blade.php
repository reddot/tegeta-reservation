{{-- Available Variables: 
    $branches <- [array]
--}}
<select name="branches" class="form-select">
    <option value="" selected>@lang('აირჩიეთ ფილიალი')</option>
    @foreach ($branches as $key => $value)
    <option value="{{ $key }}">{{ $key }}</option>
    @endforeach
</select>
