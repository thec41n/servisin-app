<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private function order(string $status): Order
    {
        $service = Service::create([
            'name' => 'Ganti Baterai HP',
            'category' => 'smartphone',
            'description' => 'Deskripsi',
            'price' => 250000,
            'image' => 'services/test.jpg',
            'status' => true,
        ]);

        return $service->orders()->create([
            'price' => $service->price,
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone_number' => '081234567890',
            'item_detail' => 'Baterai drop',
            'status' => $status,
        ]);
    }

    private function review(Order $order, array $data = [])
    {
        return $this->from(route('track.show', ['code' => $order->tracking_code]))
            ->post(route('reviews.store', $order->tracking_code), [
                'rating' => 5,
                'comment' => 'Cepat dan rapi.',
                ...$data,
            ]);
    }

    public function test_completed_order_can_be_reviewed_once_and_waits_for_moderation(): void
    {
        $order = $this->order('selesai');

        $this->review($order)->assertRedirect(route('track.show', ['code' => $order->tracking_code]));
        $this->review($order)->assertSessionHasErrors('review');

        $this->assertSame(1, Review::count());
        $this->assertFalse(Review::sole()->is_published);
    }

    public function test_unfinished_order_cannot_be_reviewed(): void
    {
        $this->review($this->order('proses'))->assertSessionHasErrors('review');

        $this->assertSame(0, Review::count());
    }

    public function test_rating_must_be_between_one_and_five(): void
    {
        $this->review($this->order('selesai'), ['rating' => 6])->assertSessionHasErrors('rating');
    }

    public function test_only_published_reviews_show_on_home_with_masked_name(): void
    {
        $order = $this->order('selesai');
        $review = $order->review()->create(['rating' => 5, 'comment' => 'Mantap sekali']);

        $this->get(route('home'))->assertDontSee('Mantap sekali');

        $review->forceFill(['is_published' => true])->save();

        $this->get(route('home'))->assertSee('Mantap sekali')->assertSee('Budi S.')->assertDontSee('Budi Santoso');
    }

    public function test_review_pages_render(): void
    {
        $order = $this->order('selesai');

        $this->get(route('track.show', ['code' => $order->tracking_code]))->assertOk()->assertSee('Kirim Ulasan');

        $order->review()->create(['rating' => 4, 'comment' => 'Teknisinya ramah'])->forceFill(['is_published' => true])->save();
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->get(route('services.show_public', $order->service))->assertOk()->assertSee('Teknisinya ramah')->assertSee('(1 ulasan)');
        $this->actingAs($admin)->get(route('admin.reviews.index'))->assertOk()->assertSee('Budi Santoso');
    }

    public function test_admin_can_publish_a_review(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $review = $this->order('dikirim')->review()->create(['rating' => 4, 'comment' => 'Oke']);

        $this->actingAs($admin)->patch(route('admin.reviews.update', $review))->assertRedirect(route('admin.reviews.index'));

        $this->assertTrue($review->fresh()->is_published);
    }
}
