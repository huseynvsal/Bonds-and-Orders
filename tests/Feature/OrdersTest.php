<?php

namespace Tests\Feature;

use App\Interfaces\InterestDatesInterface;
use App\Models\Bond;
use App\Models\Order;
use App\Services\InterestDatesService;
use App\Services\InterestPaymentsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    protected $interestDates;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->app->bind(InterestDatesInterface::class, InterestDatesService::class);

        $this->interestDates = $this->app->make(InterestDatesService::class);
    }

    public function test_if_bond_id_not_exist_is_returning_404(){
        // non-existing record
        $id = -1;
        $this->post('/api/bond/'.$id.'/order')->assertNotFound();
    }

    public function test_if_bond_id_exists_but_validation_fails_because_fields_are_required(){
        // existing record
        $id = Bond::first()->id;
        $this->post('/api/bond/'.$id.'/order')->assertInvalid();
    }

    public function test_order_date_is_required(){
        $id = Bond::first()->id;
        $response = $this->post('/api/bond/'.$id.'/order', [
            'order_date' => ''
        ]);
        $response->assertSessionHasErrors('order_date');
    }

    public function test_order_date_should_be_after_issue_date(){
        $bond = Bond::first();
        $id = $bond->id;
        // 5 days before the issue_date
        $order_date = Carbon::parse($bond->issue_date)->subDays(5);

        $response = $this->post('/api/bond/'.$id.'/order', [
            'order_date' => $order_date
        ]);
        $response->assertSessionHasErrors('order_date');
    }

    public function test_order_date_should_be_before_last_turnover_date(){
        $bond = Bond::first();
        $id = $bond->id;
        // 5 days after the turnover_date
        $order_date = Carbon::parse($bond->last_turnover_date)->addDays(5);

        $response = $this->post('/api/bond/'.$id.'/order', [
            'order_date' => $order_date
        ]);
        $response->assertSessionHasErrors('order_date');
    }

    public function test_bonds_quantity_is_required(){
        $bond = Bond::first();
        $id = $bond->id;
        // 5 days after issue date (which is valid in our case)
        $order_date = Carbon::parse($bond->issue_date)->addDays(5);

        $response = $this->post('/api/bond/'.$id.'/order', [
            'order_date' => $order_date,
            'bonds_quantity' => ''
        ]);
        $response->assertSessionHasErrors('bonds_quantity');
    }

    public function test_bonds_quantity_should_be_integer(){
        $bond = Bond::first();
        $id = $bond->id;
        // 5 days after issue date (which is valid in our case)
        $order_date = Carbon::parse($bond->issue_date)->addDays(5);

        $response = $this->post('/api/bond/'.$id.'/order', [
            'order_date' => $order_date,
            'bonds_quantity' => 'string'
        ]);
        $response->assertSessionHasErrors('bonds_quantity');
    }

    public function test_if_bond_id_exists_and_validation_doesnt_fail_creating_new_order(){
        $bond = Bond::first();
        $id = $bond->id;
        // 5 days after issue date (which is valid in our case)
        $order_date = Carbon::parse($bond->issue_date)->addDays(5);

        $response = $this->post('/api/bond/'.$id.'/order', [
            'order_date' => $order_date,
            'bonds_quantity' => 10
        ]);
        $this->assertCount(4, Order::all());
    }

    public function test_if_interest_payments_service_returns_valid_array(){
        $order = Order::first();
        $periods = 12 / intval($order->bond->payment_frequency);
        $dates = (new InterestPaymentsService($this->interestDates))->calculate_interest_payments($order->id);
        $this->assertCount($periods, $dates);
    }

    public function test_if_order_id_not_exist_is_returning_404(){
        // non-existing record
        $id = -1;
        $this->post('/api/bond/order/'.$id)->assertNotFound();
    }

    public function test_if_order_id_exists_is_returning_200(){
        // existing record
        $id = Order::first()->id;
        $this->post('/api/bond/order/'.$id)->assertOk();
    }
}
