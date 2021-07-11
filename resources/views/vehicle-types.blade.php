<select name="vehicle_type" class="form-select">
    <option value="" selected disabled>@lang('აირჩიეთ ავტომობილის ტიპი')</option>
    @foreach (ReservationService::getVehicleTypes() as $item)
        <option value="{{ $item['input_name'] }}"
            @if (old('vehicle_type') == $item['input_name']) selected @endif>
            @lang($item['view_name'])
        </option>
    @endforeach
</select>
