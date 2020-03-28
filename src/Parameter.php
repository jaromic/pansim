<?php


namespace Jarosoft;


class Parameter
{
    public $name;
    public $default;
    public $min;
    public $max;
    public $value;
    public $type;

    /**
     * Parameter constructor.
     * @param $name
     * @param $default
     * @param $min
     * @param $max
     * @param $value
     * @param $type
     */
    public function __construct($name, $default, $min, $max)
    {
        $this->name = $name;
        $this->default = $default;
        $this->min = $min;
        $this->max = $max;
        $this->value = $default;
    }


}