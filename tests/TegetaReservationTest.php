<?php

namespace Reddot\TegetaReservation\Tests;

use Carbon\Carbon;
use Reddot\TegetaReservation\Facades\ReservationService;

class TegetaReservationTest extends TestCase
{
    /** @test */
    public function test_config()
    {
        $config = config('tegeta-reservation');
        $this->assertIsArray($config);

        $code = config('tegeta-reservation.code');
        $this->assertIsString($code);

        $url = config('tegeta-reservation.url');
        $this->assertIsString($url);
    }

    /** @test */
    public function test_api_1_reservation_information()
    {
        $reservationInformation = ReservationService::reservationInformation();

        $this->assertIsArray($reservationInformation);
    }

    /** @test */
    public function test_api_2_reservation_information()
    {
        $reservationInformation = ReservationService::reservationInformationFiltered('ცენტრალური', 'სავალი ნაწილი', (Carbon::tomorrow()->format('Y-m-d')));

        $this->assertIsArray($reservationInformation);
        $this->assertArrayHasKey('ცენტრალური', $reservationInformation);
        $this->assertArrayHasKey('სავალი ნაწილი', $reservationInformation['ცენტრალური']);

        $this->assertArrayHasKey('reservation_times', $reservationInformation['ცენტრალური']['სავალი ნაწილი']);
        $this->assertArrayHasKey('not_available_datetimes', $reservationInformation['ცენტრალური']['სავალი ნაწილი']);

        $this->assertIsArray($reservationInformation['ცენტრალური']['სავალი ნაწილი']['reservation_times']);
        $this->assertIsArray($reservationInformation['ცენტრალური']['სავალი ნაწილი']['not_available_datetimes']);
    }

    /** @test */
    public function test_api_3_reservation_information_month()
    {
        $reservationInformationMonth = ReservationService::reservationInformationMonth('ცენტრალური', 'სავალი ნაწილი', Carbon::tomorrow()->format('Y'), Carbon::tomorrow()->format('m'));

        $this->assertIsArray($reservationInformationMonth);
        $this->assertArrayHasKey('ცენტრალური', $reservationInformationMonth);
        $this->assertArrayHasKey('available_datetimes', $reservationInformationMonth['ცენტრალური']);
        $this->assertArrayHasKey('not_available_datetimes', $reservationInformationMonth['ცენტრალური']);

        $this->assertIsArray($reservationInformationMonth);
        $this->assertArrayHasKey('ცენტრალური', $reservationInformationMonth);
        $this->assertArrayHasKey('available_datetimes', $reservationInformationMonth['ცენტრალური']);
        $this->assertArrayHasKey('not_available_datetimes', $reservationInformationMonth['ცენტრალური']);

        $this->assertIsArray($reservationInformationMonth['ცენტრალური']['available_datetimes']);
        $this->assertIsArray($reservationInformationMonth['ცენტრალური']['not_available_datetimes']);
    }
}