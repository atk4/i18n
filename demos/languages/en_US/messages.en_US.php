<?php

declare(strict_types=1);

return [
    // use as _t('record.ask.delete');
    'record' => [
        'ask' => [
            'delete' => 'Are you sure you want to delete this record?',
        ],
    ],
    // the 'other' key is required, and is selected if no other case matches
    'invitation_title' => '{organizer_gender, select,
        female {{organizer_name} has invited you for her party!}
        male   {{organizer_name} has invited you for his party!}
        other  {{organizer_name} have invited you for their party!}
    }',
];
