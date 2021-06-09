# Publish Files

-   config:
    `php artisan vendor:publish --tag=tegeta-reservation-config`
-   views:
    `php artisan vendor:publish --tag=tegeta-reservation-views`

# Routes:
| Method   | url                           | Controller                                                                      |
| -------  | ----------------------------- | ------------------------------------------------------------------------------- |
| GET/HEAD | `reservation/api/branches`      | `ReservationApiController@branches`   |
| GET/HEAD | `reservation/api/dates`         | `ReservationApiController@dates`      |
| GET/HEAD | `reservation/api/dates-n-month` | `ReservationApiController@datesNMonth`|
| GET/HEAD | `reservation/api/services`      | `ReservationApiController@services`   |
| GET/HEAD | `reservation/api/times`         | `ReservationApiController@times`      |
| POST     | `reservation/api/reserve`       | `ReservationApiController@reserve`    |

| Method   | url                           | Controller                                                                      |
| -------  | ----------------------------- | ------------------------------------------------------------------------------- |
| GET/HEAD | `reservation/view/branches`      | `ReservationViewController@branches`    |
| GET/HEAD | `reservation/view/dates`         | `ReservationViewController@dates`       |
| GET/HEAD | `reservation/view/dates-n-month` | `ReservationViewController@datesNMonth` |
| GET/HEAD | `reservation/view/services`      | `ReservationViewController@services`    |
| GET/HEAD | `reservation/view/times`         | `ReservationViewController@times`       |
| POST     | `reservation/view/reserve`       | `ReservationViewController@reserve`     |
