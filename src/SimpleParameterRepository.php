<?php


namespace Jarosoft;


class SimpleParameterRepository implements ParameterRepository
{
    use Singleton;

    private $parameters = [];

    public function __construct()
    {
        $this->addParameter(new Parameter('mean contact rate', 6.5, 0, PHP_FLOAT_MAX));
        $this->addParameter(new Parameter('sd contact rate', 6.5/3.0, 0, PHP_FLOAT_MAX));
        $this->addParameter(new Parameter('mean infected days', 7.0, 1, PHP_FLOAT_MAX));
        $this->addParameter(new Parameter('sd infected days', 7.0/3.0, 1, PHP_FLOAT_MAX));
        $this->addParameter(new Parameter('contact infection probability', 1.0, 0, 1));
        $this->addParameter(new Parameter('initial infected count', 5, 0, PHP_INT_MAX));
        $this->addParameter(new Parameter('population count', 1000, 0, PHP_INT_MAX));
        $this->addParameter(new Parameter('lethality', 0.008, 0, PHP_FLOAT_MAX));
        $this->addParameter(new Parameter('mean dod', 20.0, 0, PHP_FLOAT_MAX));
        $this->addParameter(new Parameter('sd dod', 2.0/3.0, 0, PHP_FLOAT_MAX));
    }

    public function addParameter(Parameter $parameter)
    {
        $this->parameters[$parameter->name] = $parameter;
    }

    /**
     * @return Parameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $parameter = $this->parameters[$key];
        $parameter->value = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $parameter = $this->parameters[$key];
        return $parameter->value;
    }
}