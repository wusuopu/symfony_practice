<?php

namespace Blogger\BlogBundle\DMSFilter;

class MyCustomeFilter
{

    public function filter($value)
    {
        var_dump('StripWords service......', $value);
        return strtoupper((string) $value);
    }
}
