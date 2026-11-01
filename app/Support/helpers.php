<?php

if (! function_exists('whatsapp_url')) {
    function whatsapp_url(?string $phone, ?string $message = null): ?string
    {
        $number = preg_replace('/\D/', '', (string) $phone);

        if ($number === '') {
            return null;
        }

        $number = preg_replace('/^0/', '62', $number);

        return 'https://wa.me/'.$number.($message ? '?text='.rawurlencode($message) : '');
    }
}
