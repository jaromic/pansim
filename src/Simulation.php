<?php

namespace Jarosoft;

class Simulation
{
    /**
     * @var Person[]
     */
    private $population;

    /**
     * @var PopulationGenerator
     */
    private $populationGenerator;

    /**
     * @var StepAlgorithm
     */
    private $stepAlgorithm;

    /**
     * For each person state and day, the respective count
     * @var array
     */
    protected $statistics;

    public function __construct(PopulationGenerator $populationGenerator, StepAlgorithm $stepAlgorithm, int $populationCount, int $infectedCount)
    {
        $this->populationGenerator = $populationGenerator;
        $this->stepAlgorithm = $stepAlgorithm;

        $this->populationGenerator->generate($populationCount, $infectedCount);
    }

    public function run($steps=1) {
        for($i=0; $i<$steps; ++$i) {
            $this->stepAlgorithm->step();

            $currentTick = TickCounter::getInstance()->getTicks();
            for($personState=0; $personState<=Person::MAX_STATE; ++$personState) {
                $this->statistics[$personState][$currentTick] = Person::getCountByState($personState);
            }
        }
    }

    public function getStatistics() {
        return $this->statistics;
    }
}