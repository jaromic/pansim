<?php

namespace Jarosoft;

interface ParameterRepository
{
    /**
     * @return Parameter[]
     */
    public function getParameters(): array;

    public function set($key, $value);

    public function get($key);
}