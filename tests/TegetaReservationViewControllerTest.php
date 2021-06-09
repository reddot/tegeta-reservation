<?php

namespace Reddot\TegetaReservation\Tests;

use Carbon\Carbon;

class TegetaReservationViewControllerTest extends TestCase
{
    /** @test */
    public function test_api_branches()
    {
        // 200: Ok
        $this->get(route('reservation.view.branches'))
            ->assertJsonStructure([
                'view',
            ]);
    }

    /** @test */
    public function test_api_services()
    {
        // 200: Ok
        $this->get(route('reservation.view.services', ['branch' => 'ცენტრალური']))
            ->assertJsonStructure([
                'view',
            ]);
    }

    // /** @test */
    public function test_api_dates()
    {
        // 200: Ok
        $this->get(route('reservation.view.dates', [
            'branch' => 'ცენტრალური',
            'service_type' => 'სავალი ნაწილი',
            'year' => Carbon::tomorrow()->format('Y'),
            'month' => Carbon::tomorrow()->format('m'),
        ]))
            ->assertJsonStructure([
                'view',
            ]);
    }

    /** @test */
    public function test_api_dates_n_month()
    {
        // 200: Ok
        $this->get(route('reservation.view.dates-n-month', [
            'branch' => 'ცენტრალური',
            'service_type' => 'სავალი ნაწილი',
            'year' => Carbon::tomorrow()->format('Y'),
            'month' => Carbon::tomorrow()->format('m'),
            'n' => 2,
        ]))
            ->assertJsonStructure([
                'view',
            ]);
    }

    /** @test */
    public function test_api_times()
    {
        // 200: Ok
        ($this->get(route('reservation.view.times', [
            'branch' => 'ცენტრალური',
            'service_type' => 'სავალი ნაწილი',
            'date' => Carbon::tomorrow()->startOfWeek()->addWeek()->format('Y-m-d'),
        ])))
            ->assertJsonStructure([
                'view',
            ]);
    }
}
