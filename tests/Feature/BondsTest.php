<?php

namespace Tests\Feature;

use App\Models\Bond;
use App\Services\InterestDatesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BondsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_if_interest_dates_service_returns_valid_array(){
        $bond = Bond::first();
        $id = $bond->id;
        $periods = 12 / intval($bond->payment_frequency);
        $dates = (new InterestDatesService())->calculate_interest_dates($id);
        $this->assertCount($periods, $dates);
    }

    public function test_if_bond_id_not_exist_is_returning_404(){
        // non-existing record
        $id = -1;
        $this->get('/api/bond/'.$id.'/payouts')->assertNotFound();
    }

    public function test_if_bond_id_exists_is_returning_200(){
        // existing record
        $id = Bond::first()->id;
        $this->get('/api/bond/'.$id.'/payouts')->assertOk();
    }
}
