<?php

namespace Reddot\TegetaReservation\Tests;

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
        $this->get(route('reservation.api.services', ['branch' => '123 არავალიდური სერვისი 321']))
            ->assertStatus(404)
            ->assertNotFound();

        // 422: Branch is required
        $this->get(route('reservation.api.services'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['branch']);
    }
}
