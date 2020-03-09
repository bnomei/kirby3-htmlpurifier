<?php

declare(strict_types=1);

namespace Bnomei;

use HTMLPurifier_Config;
use Kirby\Cms\Field;

final class HtmlPurifier
{
    /** @var string|string[]|Field */
    private $data;

    /**
     * HtmlPurifier constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config = \option('bnomei.htmlpurifier.config')($config);

        $this->purifier = new \HTMLPurifier($config);
        $this->data = $data;
    }

    /**
     * @param $data
     * @return string|string[]|Field
     */
    public function result()
    {
        return $this->process($this->data);
    }

    /**
     * @param $data
     * @return string|string[]|Field
     */
    public function process($data)
    {
        if (is_a($data, Field::class)) {
            $data->value = $this->purifier->purify((string) $data->value);
            return $data;
        }

        if (is_array($data)) {
            return $this->purifier->purifyArray($data);
        }

        return $this->purifier->purify($data);
    }

    public static function purify($data)
    {
        return (new self($data))->result();
    }
}
