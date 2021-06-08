<?php

namespace Reddot\TegetaReservation\Tests;

use Carbon\Carbon;

class TegetaReservationApiControllerTest extends TestCase
{
    /** @test */
    public function test_api_branches()
    {
        // 200: Ok
        $this->get(route('reservation.api.branches'))
            ->assertJsonStructure([
                'branches' => [
                    '*' => [ // Branch Name
                        '*' => [ // Service Name
                            'time_per_slot',
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function test_api_services()
    {
        // 200: Ok
        $this->get(route('reservation.api.services', ['branch' => 'ცენტრალური']))
            ->assertJsonStructure([
                'services' => [
                    '*' => [ // Service Name
                        'time_per_slot',
                    ],
                ],
            ]);

        // 404: Not Found
        $this->get(route('reservation.api.services', ['branch' => '123 არავალიდური სერვის ცენტრი 321']))
            ->assertStatus(404)
            ->assertNotFound();

        // 422: Branch is required
        $this->get(route('reservation.api.services'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['branch']);
    }

    /** @test */
    public function test_api_dates()
    {
        // 200: Ok
        $this->get(route('reservation.api.dates', [
            'branch' => 'ცენტრალური',
            'service_type' => 'სავალი ნაწილი',
            'year' => Carbon::tomorrow()->format('Y'),
            'month' => Carbon::tomorrow()->format('m'),
        ]))
            ->assertJsonStructure([
                'available' => [],
                'not_available' => [],
            ]);

        // 404: Not Found
        $this->get(route('reservation.api.dates', [
            'branch' => '123 არავალიდური სერვის ცენტრი 321',
            'service_type' => 'სავალი ნაწილი',
            'year' => Carbon::tomorrow()->format('Y'),
            'month' => Carbon::tomorrow()->format('m'),
        ]))
            ->assertStatus(404)
            ->assertNotFound();

        // 422: Branch is required
        $this->get(route('reservation.api.dates'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['branch', 'service_type', 'year', 'month']);
    }

    /** @test */
    public function test_api_dates_n_month()
    {
        // 200: Ok
        $this->get(route('reservation.api.dates-n-month', [
            'branch' => 'ცენტრალური',
            'service_type' => 'სავალი ნაწილი',
            'year' => Carbon::tomorrow()->format('Y'),
            'month' => Carbon::tomorrow()->format('m'),
            'n' => 2,
        ]))
            ->assertJsonStructure([
                'available' => [],
                'not_available' => [],
            ]);

        // 404: Not Found
        $this->get(route('reservation.api.dates-n-month', [
            'branch' => '123 არავალიდური სერვის ცენტრი 321',
            'service_type' => 'სავალი ნაწილი',
            'year' => Carbon::tomorrow()->format('Y'),
            'month' => Carbon::tomorrow()->format('m'),
            'n' => 2,
        ]))
            ->assertStatus(404)
            ->assertNotFound();

        // 422: Branch is required
        $this->get(route('reservation.api.dates-n-month'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['branch', 'service_type', 'year', 'month', 'n']);
    }

    /** @test */
    public function test_api_times()
    {
        // 200: Ok
        $this->get(route('reservation.api.times', [
            'branch' => 'ცენტრალური',
            'service_type' => 'სავალი ნაწილი',
            'date' => Carbon::tomorrow()->startOfWeek()->addWeek()->format('Y-m-d'),
        ]))
            ->assertJsonStructure([
                'times' => [
                    'reservation_times' => [],
                    'not_available_datetimes' => [],
                    'available' => [],
                ]
            ]);

        // 404: Not Found
        $this->get(route('reservation.api.times', [
            'branch' => '123 არავალიდური სერვის ცენტრი 321',
            'service_type' => 'სავალი ნაწილი',
            'date' => Carbon::tomorrow()->startOfWeek()->addWeek()->format('Y-m-d'),
        ]))
            ->assertStatus(404)
            ->assertNotFound();

        // 404: Not Found
        $this->get(route('reservation.api.times', [
            'branch' => 'ცენტრალური',
            'service_type' => '123 არავალიდური სერვისი 321',
            'date' => Carbon::tomorrow()->startOfWeek()->addWeek()->format('Y-m-d'),
        ]))
            ->assertStatus(404)
            ->assertNotFound();

        // 422: Branch is required
        $this->get(route('reservation.api.times'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['branch', 'service_type', 'date']);
    }
}
