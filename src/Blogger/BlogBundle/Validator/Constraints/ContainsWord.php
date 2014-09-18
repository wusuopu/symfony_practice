<?php

namespace Blogger\BlogBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Check a string whether contains some word.
 *
 * @Annotation
 */
class ContainsWord extends Constraint
{
    public $message = 'The string "%string%" contains some sensitive word.';
}
