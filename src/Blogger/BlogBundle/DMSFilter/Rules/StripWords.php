<?php

namespace Blogger\BlogBundle\DMSFilter\Rules;

use DMS\Filter\Rules\Rule;

/**
 * ToUpper Rule
 *
 * @package DMS
 * @subpackage Filter
 *
 * @Annotation
 */
class StripWords extends Rule
{
    /**
     * Encoding to be used
     *
     * @var string
     */
    public $encoding = null;

    /**
     * {@inheritDoc}
     */
    public function getDefaultOption()
    {
        return 'encoding';
    }
}
