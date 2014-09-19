<?php

namespace Blogger\BlogBundle\DMSFilter\Filters;

use DMS\Filter\Filters\BaseFilter;
use DMS\Filter\Rules\Rule;
use DMS\Filter\Exception\FilterException;

/**
 * ToUpper Filter
 *
 * @package DMS
 * @subpackage Filter
 */
class StripWords extends BaseFilter
{
    /**
     * {@inheritDoc}
     *
     * @param \DMS\Filter\Rules\ToUpper $rule
     */
    public function apply(Rule $rule, $value)
    {
        var_dump('StripWords......', $value);
        return strtoupper((string) $value);
    }
}
