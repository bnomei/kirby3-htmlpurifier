# Kirby HtmlPurifier

![Release](https://flat.badgen.net/packagist/v/bnomei/kirby3-htmlpurifier?color=ae81ff)
![Downloads](https://flat.badgen.net/packagist/dt/bnomei/kirby3-htmlpurifier?color=272822)
[![Build Status](https://flat.badgen.net/travis/bnomei/kirby3-htmlpurifier)](https://travis-ci.com/bnomei/kirby3-htmlpurifier)
[![Coverage Status](https://flat.badgen.net/coveralls/c/github/bnomei/kirby3-htmlpurifier)](https://coveralls.io/github/bnomei/kirby3-htmlpurifier) 
[![Maintainability](https://flat.badgen.net/codeclimate/maintainability/bnomei/kirby3-htmlpurifier)](https://codeclimate.com/github/bnomei/kirby3-htmlpurifier) 
[![Twitter](https://flat.badgen.net/badge/twitter/bnomei?color=66d9ef)](https://twitter.com/bnomei)

Static class method, Uniform-Guard and Field-Method to filter your "dirty" HTML inputs to "clean" HTML.

[strip_tags](https://www.php.net/manual/en/function.strip-tags.php) and [PHP Input Filter](https://www.phpclasses.org/package/2189-PHP-Filter-out-unwanted-PHP-Javascript-HTML-tags-.html) are not good enough for you? Installing a plugin that has a dependency with lots of code does not bother you? You are willing to take the performance hit if you use it? Read on then...

## Installation

- unzip [master.zip](https://github.com/bnomei/kirby3-htmlpurifier/archive/master.zip) as folder `site/plugins/kirby3-htmlpurifier` or
- `git submodule add https://github.com/bnomei/kirby3-htmlpurifier.git site/plugins/kirby3-htmlpurifier` or
- `composer require bnomei/kirby3-htmlpurifier`

## Usage PHP

```php
$cleanHtml = \Bnomei\HtmlPurifier::purify($dirtyHtml);
```

## Usage Uniform-Guard

Because of the plugin loading order the `htmlPurifyGuard` will only be available with composer installations of this plugin.

```php
$form = new \Uniform\Form;

if (kirby()->request()->is('POST')) {

    $form->honeypotGuard() // needs to be called explicitly now
        ->htmlPurifyGuard(); // purified all data

    if ($form->success()) {
        // ...
    }
}
```

## Usage Field-Method

```php
$dirtHtml = (string) $page->myfield();
$cleanHtml = (string) $page->myfield()->htmlPurify();
$cleanHtml = (string) $page->myfield()->kirbytext()->htmlPurify();
```

## Usage with KQL for headless

If you want to make extra sure your html output to headless is valid html you can purify your fields. Be advised that this will come with a performance penalty since purification is no simple task.

> ⚠️ All proprietary elements (`<template>`, ...) and attributes (`srcset`, `sizes`, `data-*`, `x-*:`, `@*:`, ...) will be removed! 

**KQL Query**
```json
{
    "query": "page('photography')",
    "select": {
        "url": true,
        "title": true,
        "textWithPurifiedHtml": "page.text.kirbytext.htmlPurify"
    }
}
```

**Example: Vue**
```vue
<div v-html="textWithPurifiedHtml"></div>
```

## Settings

| bnomei.htmlpurifier.            | Default        | Description               |            
|---------------------------|----------------|---------------------------|
| config | callback | overwrite this to adjust the config of used HtmlPurifier dependency |

## Dependecies

- [Kirby 3 Plugin Uniform](https://github.com/mzur/kirby-uniform)
- [HtmlPurifier](https://github.com/ezyang/htmlpurifier)

## Disclaimer

This plugin is provided "as is" with no guarantee. Use it at your own risk and always test it yourself before using it in a production environment. If you find any issues, please [create a new issue](https://github.com/bnomei/kirby3-htmlpurifier/issues/new).

## License

[MIT](https://opensource.org/licenses/MIT)

It is discouraged to use this plugin in any project that promotes racism, sexism, homophobia, animal abuse, violence or any other form of hate speech.
