<?php

namespace Reddot\TegetaReservation\Tests;

class TegetaReservationApiControllerTest extends TestCase
{
    /** @test */
    public function test_api_branches()
    {
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
        $this->get(route('reservation.api.services', ['branch' => 'ცენტრალური']))
            ->assertJsonStructure([
                'services' => [
                    '*' => [ // Service Name
                        'time_per_slot',
                    ],
                ],
            ]);
    }
}
