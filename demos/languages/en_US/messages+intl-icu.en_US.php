<?php
/**
 * Message in Intl ICU format.
 * Using intl-icu require resource file to be name accordingly.
 */
declare(strict_types=1);

return [
    // use as _t('finish_result', ['result' => 2]);
    'finish_result' => 'You finished {result, ordinal,
        one {#st}
        two {#nd}
        few {#rd}
        other {#th}
        }!',
    // the 'other' key is required, and is selected if no other case matches
    'invitation_title' => '{organizer_gender, select,
        female {{organizer_name} has invited you for her party!}
        male   {{organizer_name} has invited you for his party!}
        other  {{organizer_name} have invited you for their party!}
    }',
    'published_at' => 'Published at {publication_date, date} - {publication_date, time, short}',
    'progress' => '{progress, number, percent} of the work is done!',
    'value_of_object' => 'This artifact is worth {value, number, currency}',
    'num_of_apples' => '{apples, plural,
        =0    {There are no apples in basket.}
        one   {There is one apple in basket.}
        other {There are # apples in basket.}
    }',
];
