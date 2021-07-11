{{-- Available Variables: 
    $branches <- [array]
--}}
<select name="branch" class="form-select" required>
    <option value="" selected>@lang('აირჩიეთ ფილიალი')</option>
    @foreach ($branches as $key => $value)
        <option value="{{ $key }}" @if (old('branch') == $key) selected @endif>{{ $key }}</option>
    @endforeach
</select>
