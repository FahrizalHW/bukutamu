<?php

return [
    'qr_ttl_seconds' => (int) env('GUESTBOOK_QR_TTL_SECONDS', 90),
    'grant_ttl_minutes' => (int) env('GUESTBOOK_GRANT_TTL_MINUTES', 15),
];
