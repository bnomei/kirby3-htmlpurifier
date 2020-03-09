<?php

@include_once __DIR__ . '/vendor/autoload.php';

// this will only work in composer setups since kirby loads this plugin before
// uniform (string order) and unless its composer setup it does not know about
// the uniform classes at that point
if (class_exists('Uniform\\Guards\\Guard')) {
    load(['Uniform\\Guards\\HtmlPurifyGuard' => __DIR__ . '/classes/HtmlPurifierGuard.php']);
}

Kirby::plugin('bnomei/htmlpurifier', [
    'options' => [
        'config' => function (\HTMLPurifier_Config $config): \HTMLPurifier_Config {
            // overwrite this to add custom config

            // http://htmlpurifier.org/live/configdoc/plain.html
            $config->set('Attr.ID.HTML5', true);
            $config->set('CSS.MaxImgLength', null);
            $config->set('HTML.MaxImgLength', null);
            $config->set('HTML.TidyLevel', 'heavy');

            return $config;
        }
    ],
    'fieldMethods' => [
        'htmlPurify' => function ($field) {
            $purifier = new \Bnomei\HtmlPurifier($field);
            return $purifier->result();
        },
    ],
]);
