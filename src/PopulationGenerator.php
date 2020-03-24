<?php

namespace Jarosoft;

interface PopulationGenerator {
    public function generate(int $populationCount, int $infectedCount);
}