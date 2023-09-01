<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'AuditStash' => $baseDir . '/vendor/lorenzo/audit-stash/',
        'Authentication' => $baseDir . '/vendor/cakephp/authentication/',
        'Authorization' => $baseDir . '/vendor/cakephp/authorization/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakePdf' => $baseDir . '/vendor/friendsofcake/cakepdf/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'CsvView' => $baseDir . '/vendor/friendsofcake/cakephp-csvview/',
        'DatabaseLog' => $baseDir . '/vendor/dereuromark/cakephp-databaselog/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'IdeHelper' => $baseDir . '/vendor/dereuromark/cakephp-ide-helper/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Muffin/Trash' => $baseDir . '/vendor/muffin/trash/',
        'Search' => $baseDir . '/vendor/friendsofcake/search/',
    ],
];
