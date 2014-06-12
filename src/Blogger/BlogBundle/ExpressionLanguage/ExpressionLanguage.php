<?php

namespace Blogger\BlogBundle;

use Symfony\Component\Security\Core\Authorization\ExpressionLanguage as BaseExpressionLanguage;
//use Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage
{
    protected function registerFunctions()
    {
        parent::registerFunctions();

        $this->register('is_login', function ($attributes, $object = null) {
            return '$security_context->isLogin()';
        }, function (array $variables) {
            var_dump($variables);
            $user = $variables['security_context']->getUser();
            return !empty($user);
        });
    }
}
