{{-- Available Variables: 
    $times <- [array]
        $times['available'] <- array
        $times['reservation_times'] <- array
        $times['not_available_datetimes']  <- array 
--}}
<select name="time" class="form-select">
    <option value="" selected disabled>@lang('აირჩიეთ დრო')</option>
    @foreach ($times['available'] as $timeSlot)
        <option value="{{ $timeSlot }}">{{ $timeSlot }}</option>
    @endforeach
</select>
