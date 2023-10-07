<?php

// $localeConfig = require_once __DIR__.'../../../../config/locale.php';
require base_path('app-boot-helper.php');
changeAppLocale();
// getStoreSettings('default_language')

// reinit configs for translations
config([
    '__tech' => require config_path('__tech.php'),
    '__settings' => require config_path('__settings.php'),
]);