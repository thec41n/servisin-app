<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCatalogTest extends TestCase
{
    use RefreshDatabase;

    private function service(string $name, string $category): Service
    {
        return Service::create([
            'name' => $name,
            'category' => $category,
            'description' => 'Deskripsi',
            'price' => 100000,
            'image' => 'services/test.jpg',
            'status' => true,
        ]);
    }

    public function test_services_can_be_filtered_by_category(): void
    {
        $this->service('Install Ulang OS', 'laptop');
        $this->service('Ganti Baterai HP', 'smartphone');

        $this->get(route('services.index_public', ['category' => 'smartphone']))
            ->assertOk()
            ->assertSee('Ganti Baterai HP')
            ->assertDontSee('Install Ulang OS');
    }

    public function test_home_lists_most_ordered_services_first(): void
    {
        $this->service('Install Ulang OS', 'laptop');
        $popular = $this->service('Ganti Baterai HP', 'smartphone');
        $popular->orders()->create([
            'price' => $popular->price,
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'phone_number' => '081234567890',
            'item_detail' => 'Baterai drop',
        ]);

        $this->get(route('home'))->assertSeeInOrder(['Ganti Baterai HP', 'Install Ulang OS']);
    }

    public function test_service_detail_shows_breadcrumb_and_whatsapp_link(): void
    {
        Setting::create(['phone_number' => '081234567890']);
        $service = $this->service('Install Ulang OS', 'laptop');

        $this->get(route('services.show_public', $service))
            ->assertOk()
            ->assertSee('Laptop &amp; PC', false)
            ->assertSee('https://wa.me/6281234567890?text=', false);
    }

    public function test_unknown_category_is_rejected(): void
    {
        $this->get(route('services.index_public', ['category' => 'kulkas']))
            ->assertSessionHasErrors('category');
    }

    public function test_updating_without_new_image_keeps_the_old_image(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $service = $this->service('Install Ulang OS', 'laptop');

        $this->actingAs($admin)->put(route('admin.services.update', $service), [
            'name' => 'Install Ulang OS',
            'category' => 'smartphone',
            'description' => 'Deskripsi baru',
            'price' => 150000,
            'status' => 1,
        ])->assertRedirect(route('admin.services.index'));

        $service->refresh();
        $this->assertSame('services/test.jpg', $service->image);
        $this->assertSame('smartphone', $service->category);
    }
}
