<?php
/**
 * Message in Intl ICU format.
 * Using intl-icu require resource file to be name accordingly.
 */
declare(strict_types=1);

return [
    // use as _t('finish_result', ['result' => 2]);
    'finish_result' => 'Vous avez terminé {result, ordinal,
        one
        two
        few
        other
        }!',
    // the 'other' key is required, and is selected if no other case matches
    'invitation_title' => '{organizer_gender, select,
        female {{organizer_name} aimerais vous invitez à son party!}
        male   {{organizer_name} aimerais vous invitez à son party!}
        other  {Nous, {organizer_name}, aimerions vous invitez à notre party!}
    }',
    'published_at' => 'Publié le {publication_date, date} - {publication_date, time, short}',
    'progress' => 'Le travail accompli est de {progress, number, percent}!',
    'value_of_object' => 'Cet object vaut la somme de {value, number, currency}',
    'num_of_apples' => '{apples, plural,
        =0    {Le panier ne contient aucune pomme.}
        one   {Le panier contient une pomme.}
        other {Le panier contient # pommes.}
    }',
];
