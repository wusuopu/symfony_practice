<?php

namespace My\Bundle\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Annotations\Annotation;

/**
 * MyCustomAnnotation Resolver
 */
class MyCustomAnnotationResolver
{

    /**
     * Specific annotation evaluation.
     * This method MUST be implemented because is defined in the interface
     *
     * @param Request          $request    Request
     * @param Annotation       $annotation Annotation
     * @param ReflectionMethod $method     Method
     *
     * @return MyCustomAnnotationResolver self Object
     */
    public function evaluateAnnotation(
                                        Request $request,
                                        Annotation $annotation,
                                        ReflectionMethod $method )
    {
        /**
         * You can now manage your annotation.
         * You can acced to its fields using public methods.
         * 
         * Annotation fields can be public and can be acceded directly,
         * but is better for testing to use getters; they can be mocked.
         */
        $field = $annotation->getField();

        /**
         * You can also access to existing method parameters.
         * 
         * Available parameters are:
         * 
         * # ParamConverter parameters ( See `resolver_priority` config value )
         * # All method defined parameters, included Request object if is set.
         */
        $entity = $request->attributes->get('entity');

        /**
         * And you can now place new elements in the controller action.
         * In this example we are creating new method parameter
         * called $myNewField with some value
         */
        $request->attributes->set(
            'myNewField',
            new $field()
        );

        var_dump("in MyCustomAnnotationResolver...");
        return $this;
    }

}
