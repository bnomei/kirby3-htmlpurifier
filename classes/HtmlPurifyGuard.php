<?php

declare(strict_types=1);

namespace Uniform\Guards;

use Bnomei\HtmlPurifier;

final class HtmlPurifyGuard extends Guard
{
    public function perform()
    {
        $purifier = new HtmlPurifier(
            $this->form->data()
        );

        foreach ($purifier->toArray() as $key => $value) {
            $this->form->data($key, $value);
        }
    }
}
