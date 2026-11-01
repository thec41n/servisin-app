<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class WhatsappUrlTest extends TestCase
{
    public function test_local_number_gets_indonesian_country_code(): void
    {
        $this->assertSame('https://wa.me/6281234567890', whatsapp_url('0812-3456-7890'));
    }

    public function test_international_number_is_kept(): void
    {
        $this->assertSame('https://wa.me/6281234567890', whatsapp_url('+62 812 3456 7890'));
    }

    public function test_message_is_url_encoded(): void
    {
        $this->assertSame('https://wa.me/628123?text=Halo%20kak', whatsapp_url('08123', 'Halo kak'));
    }

    public function test_empty_number_returns_null(): void
    {
        $this->assertNull(whatsapp_url(null));
        $this->assertNull(whatsapp_url(' - '));
    }
}
