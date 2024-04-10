<?php

class Container
{
    public function get(string $class_name): object 
    {
        $reflector = new ReflectionClass($class_name);

        $constructor = $reflector->getConstructor();

        if($constructor === null) {

            return new $class_name;
        }
        
        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            $dependencies[] = $this->get((string) $type);
        }

        return new $class_name(...$dependencies);

    }
}