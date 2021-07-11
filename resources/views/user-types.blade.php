<select name="user_type" class="form-select" required>
    <option value="" selected disabled>@lang('აირჩიეთ მომხმარებლის ტიპი')</option>
    @foreach (ReservationService::getUserTypes() as $item)
        <option value="{{ $item['input_name'] }}" 
            @if ($item['input_name'] == 'company') data-show-company-id="true" @endif
            @if (old('user_type') == $item['input_name']) selected @endif>
            @lang($item['view_name'])
        </option>
    @endforeach
</select>
