<?php

require_once "vendor/autoload.php";

use Jarosoft\Person;
use Jarosoft\SimplePopulationGenerator;
use Jarosoft\SimpleStepAlgorithm;
use Jarosoft\Simulation;
use Jarosoft\TickCounter;

$populationGenerator = new SimplePopulationGenerator();
$stepAlgorithm = new SimpleStepAlgorithm();
$simulation = new Simulation($populationGenerator, $stepAlgorithm, 10, 1);

echo "ticks: ". TickCounter::getInstance()->getTicks() . "\n";
echo "before:\n";
Person::dumpPopulation();

$simulation->run(100);

echo "ticks: ". TickCounter::getInstance()->getTicks() . "\n";
echo "after:\n";
Person::dumpPopulation();