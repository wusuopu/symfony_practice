<?php

namespace Blogger\BlogBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsWordValidator extends ConstraintValidator
{
    /**
     * Validate value.
     *
     * @param mix         $value
     * @param Constraints $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^[0-9]+$/', $value, $matches)) {
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
        }
    }
}
