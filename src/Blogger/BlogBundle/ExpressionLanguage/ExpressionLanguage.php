<?php

namespace Blogger\BlogBundle\ExpressionLanguage;

//use Symfony\Component\Security\Core\Authorization\ExpressionLanguage as BaseExpressionLanguage;
//use Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage as BaseExpressionLanguage;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage
{
    protected function registerFunctions()
    {
        parent::registerFunctions();

        $this->register('is_login', function ($attributes) {
            var_dump("in language compile : is_login------------------");
            var_dump($attributes);
            var_dump("in language compile : is_login ------------------");
            return '$security_context->isLogin(' . $attributes . ')';
        }, function (array $variables, $st=null) {
            var_dump("in language: is_login------------------");
            var_dump($variables, $st);
            return true;
            $user = $variables['security_context']->getUser();
            return !empty($user);
        });
        $this->register('is_admin', function ($object = null) {
            return '$security_context->isAdmin()';
        }, function (array $variables) {
            var_dump("in language: is_admin ------------------");
            var_dump($variables);
            $user = $variables['security_context']->getUser();
            return !empty($user);
        });
    }
}
