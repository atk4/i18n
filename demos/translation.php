<?php

declare(strict_types=1);

use function Atk4\I18n\Resource\_t;
use Atk4\I18n\Service;
use Atk4\I18n\T;
use Atk4\Ui\App;
use Atk4\Ui\Header;
use Atk4\Ui\Table;

require_once __DIR__ . '../../../autoload.php';

$app = new App(['title' => 'Translation addon']);
$app->initLayout([\Atk4\Ui\Layout\Admin::class]);

Service::init('fr_FR');
Service::addResource(__DIR__ . '/languages', 'fr_FR', 'php');
Service::addResource(__DIR__ . '/languages', 'fr_FR', 'yaml');
Service::addResource(__DIR__ . '/languages', 'en_US', 'php');
Service::addResource(__DIR__ . '/languages', 'en_US', 'yaml');

Header::addTo($app, [_t('Translation Sample')]);

$locales = ['en_US', 'fr_FR'];
$messages = [
    ['desc' => 'record.ask.delete', 'msg' => T::from('record.ask.delete')],
    ['desc' => 'modal.save in btn domain', 'msg' => T::from('modal.save', [], 'btn')],
    ['desc' => 'finish_result with 4', 'msg' => T::from('finish_result', ['result' => 4])],
    ['desc' => 'invitation_title using "John" and "male"', 'msg' => T::from('invitation_title', [
        'organizer_name' => 'John',
        'organizer_gender' => 'male',
    ])],
    ['desc' => 'invitation_title using "Mary" and "female"', 'msg' => T::from('invitation_title', [
        'organizer_name' => 'Mary',
        'organizer_gender' => 'female',
    ])],
    ['desc' => 'invitation_title using "John and Mary" and "other"', 'msg' => T::from('invitation_title', [
        'organizer_name' => 'John and Mary',
        'organizer_gender' => 'other',
    ])],
    ['desc' => 'publish_at using datetime object', 'msg' => T::from('published_at', [
        'publication_date' => new \DateTime('2021-01-25 14:30:00'),
    ])],
    ['desc' => 'values_of_object using value 10000', 'msg' => T::from('value_of_object', [
        'value' => 10000,
    ])],
    ['desc' => 'progress using value 0.82', 'msg' => T::from('progress', [
        'progress' => 0.82,
    ])],
    ['desc' => 'num_of_apples using value 0', 'msg' => T::from('num_of_apples', [
        'apples' => 0,
    ])],
    ['desc' => 'num_of_apples using value 1', 'msg' => T::from('num_of_apples', [
        'apples' => 1,
    ])],
    ['desc' => 'num_of_apples using value 34', 'msg' => T::from('num_of_apples', [
        'apples' => 34,
    ])],
];

$source = [];
foreach ($messages as $key => $msg) {
    $source[$key]['Msg_Id'] = $msg['desc'];
    foreach ($locales as $locale) {
        $source[$key][$locale] = $msg['msg']->in($locale);
    }
}

Table::addTo($app)->setSource($source);
