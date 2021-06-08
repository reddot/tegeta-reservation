<?php

namespace Reddot\TegetaReservation\Tests;

use Carbon\Carbon;
use Reddot\TegetaReservation\Facades\ReservationService;

class TegetaReservationApiControllerTest extends TestCase
{
    /** @test */
    function test_api_branches()
    {
        $this->get(route('reservation.api.branches'))
            ->assertJsonStructure([
                'branches' => [
                    '*' => [ // Branch Name
                        '*' => [ // Service Name
                            'time_per_slot',
                        ],
                    ]
                ]
            ]);
    }

    /** @test */
    function test_api_services()
    {
        $this->get(route('reservation.api.services', ['branch' => 'ცენტრალური']))
            ->assertJsonStructure([
                'services' => [ 
                    '*' => [ // Service Name
                        'time_per_slot',
                    ]
                ]
            ]);
    }
}
