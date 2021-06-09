# Publish Files

-   config:
    `php artisan vendor:publish --tag=tegeta-reservation-config`
-   views:
    `php artisan vendor:publish --tag=tegeta-reservation-views`

# Routes:
| Method   | url                           | Controller                                                                      |
| -------  | ----------------------------- | ------------------------------------------------------------------------------- |
| GET/HEAD | `reservation/api/branches`      | `Reddot\TegetaReservation\Http\Controllers\ReservationApiController@branches`   |
| GET/HEAD | `reservation/api/dates`         | `Reddot\TegetaReservation\Http\Controllers\ReservationApiController@dates`      |
| GET/HEAD | `reservation/api/dates-n-month` | `Reddot\TegetaReservation\Http\Controllers\ReservationApiController@datesNMonth`|
| GET/HEAD | `reservation/api/services`      | `Reddot\TegetaReservation\Http\Controllers\ReservationApiController@services`   |
| GET/HEAD | `reservation/api/times`         | `Reddot\TegetaReservation\Http\Controllers\ReservationApiController@times`      |
| POST     | `reservation/api/reserve`       | `Reddot\TegetaReservation\Http\Controllers\ReservationApiController@reserve`    |

| Method   | url                           | Controller                                                                      |
| -------  | ----------------------------- | ------------------------------------------------------------------------------- |
| GET/HEAD | `reservation/view/branches`      | `Reddot\TegetaReservation\Http\Controllers\ReservationViewController@branches`    |
| GET/HEAD | `reservation/view/dates`         | `Reddot\TegetaReservation\Http\Controllers\ReservationViewController@dates`       |
| GET/HEAD | `reservation/view/dates-n-month` | `Reddot\TegetaReservation\Http\Controllers\ReservationViewController@datesNMonth` |
| GET/HEAD | `reservation/view/services`      | `Reddot\TegetaReservation\Http\Controllers\ReservationViewController@services`    |
| GET/HEAD | `reservation/view/times`         | `Reddot\TegetaReservation\Http\Controllers\ReservationViewController@times`       |
| POST     | `reservation/view/reserve`       | `Reddot\TegetaReservation\Http\Controllers\ReservationViewController@reserve`     |
