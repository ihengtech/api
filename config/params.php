<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'allowOrigin' => [
        'http://localhost',
        'http://dev.adv.frontend.ihengtech.com',
        'http://dev.adv.backend.ihengtech.com',
        'http://adv.frontend.ihengtech.com',
        'http://adv.backend.ihengtech.com',
    ],
    'accessControlExposeHeaders' => [
        'X-Pagination-Total-Count',
        'X-Pagination-Page-Count',
        'X-Pagination-Current-Page',
        'X-Pagination-Per-Page',
        'Link',
    ],
    'accessControlAllowHeaders' => ['content-type', 'accept', 'authorization'],
    'accessControlRequestMethod' => ['*'],
    'accessControlMaxAge' => 3600,
];
