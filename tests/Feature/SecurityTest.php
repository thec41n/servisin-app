<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    private function service(array $attributes = []): Service
    {
        return Service::create([
            'name' => 'Ganti Baterai',
            'description' => 'Deskripsi',
            'price' => 250000,
            'image' => 'services/test.jpg',
            'status' => true,
            ...$attributes,
        ]);
    }

    private function orderFor(Service $service): Order
    {
        return $service->orders()->create([
            'price' => $service->price,
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone_number' => '081234567890',
            'item_detail' => 'Layar retak',
        ]);
    }

    public function test_registration_is_closed(): void
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_non_admin_cannot_access_admin_pages(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_pages(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_receipt_is_not_reachable_by_numeric_id(): void
    {
        $order = $this->orderFor($this->service());

        $this->get("/orders/{$order->id}/receipt")->assertNotFound();
        $this->get(route('orders.receipt', $order->tracking_code))->assertOk();
    }

    public function test_order_stores_price_from_service_and_ignores_client_fields(): void
    {
        $service = $this->service();

        $this->post(route('orders.store'), [
            'service_id' => $service->id,
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone_number' => '081234567890',
            'item_detail' => 'Layar retak',
            'price' => 1,
            'status' => 'selesai',
            'tracking_code' => 'SVS-HACK',
        ])->assertRedirect(route('home'));

        $order = Order::sole();
        $this->assertSame(250000, (int) $order->price);
        $this->assertSame('menunggu', $order->fresh()->status);
        $this->assertNotSame('SVS-HACK', $order->tracking_code);
    }

    public function test_inactive_service_cannot_be_ordered(): void
    {
        $service = $this->service(['status' => false]);

        $this->get(route('orders.create', $service))->assertNotFound();
        $this->post(route('orders.store'), [
            'service_id' => $service->id,
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone_number' => '081234567890',
            'item_detail' => 'Layar retak',
        ])->assertSessionHasErrors('service_id');

        $this->assertSame(0, Order::count());
    }

    public function test_service_with_orders_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $service = $this->service();
        $this->orderFor($service);

        $this->actingAs($admin)
            ->delete(route('admin.services.destroy', $service))
            ->assertSessionHas('error');

        $this->assertModelExists($service);
        $this->assertSame(1, Order::count());
    }
}
