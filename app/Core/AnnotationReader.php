<?php

namespace app\Core;
use ReflectionClass;

class AnnotationReader
{
    public function getAnnotations($class, $context = null)
    {
        $reflectionClass = new ReflectionClass($class);
        $properties = $reflectionClass->getProperties();

        $annotations = [];
        foreach ($properties as $property) {
            $docComment = $property->getDocComment();
            // preg_match_all('/@(\w+)\((.*?)\)/', $docComment, $matches, PREG_SET_ORDER);
            preg_match_all('/@(\w+)(?:\(([^)]*)\))?/', $docComment, $matches, PREG_SET_ORDER);
    
            foreach ($matches as $match) {
                $value_rule = "";
                if (count($match) == 3){
                    $split = explode(",", trim($match[2], '"'));
                    if ($match[1] === 'Context' && trim($split[0], '"') !== $context) {
                        // continue;
                        $value_rule = trim($split[0], '"') . "," . trim($split[1]);
                    }else{
                        $value_rule = trim($split[0], '"');
                    }
                }

                $annotations[$property->getName()][$match[1]] = $value_rule;
            }
        }

        return $annotations;
    }
}