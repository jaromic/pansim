<?php


namespace Jarosoft;


class SimplePopulationGenerator implements PopulationGenerator
{

    public function generate()
    {
        $populationCount = SimpleParameterRepository::getInstance()->get('population count');
        $infectedToCreate = SimpleParameterRepository::getInstance()->get('initial infected count');

        for ($i = 0; $i < $populationCount; ++$i) {
            Person::addPerson(random_int(15,50));
        }

        $shuffledPopulation = Person::$population;
        shuffle($shuffledPopulation);

        foreach ($shuffledPopulation as $person) {
            if ($infectedToCreate > 0) {
                $person->setState(Person::STATE_INFECTED);
                $infectedToCreate -= 1;
            }

        }
    }
}