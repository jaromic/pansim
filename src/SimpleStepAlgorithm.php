<?php


namespace Jarosoft;


class SimpleStepAlgorithm implements StepAlgorithm
{

    public function step()
    {
        $individualContactRateToday =
            Statistics::randomIntNormalDistribution(
                SimpleParameterRepository::getInstance()->get('mean contact rate'),
                SimpleParameterRepository::getInstance()->get('sd contact rate')
            );

        $susceptiblePeople = [];
        foreach (Person::$population as $person) {
            switch ($person->getState()) {
                case Person::STATE_SUSCEPTIBLE:
                    array_push($susceptiblePeople, $person);
                    break;
                case Person::STATE_INFECTED:
                    /* infect others: */
                    for($i=0; $i<round($individualContactRateToday); ++$i) {
                        if(SimpleParameterRepository::getInstance()->get('contact infection probability') * random_int(0,1) && count($susceptiblePeople)>0) {
                            $otherPerson = array_pop($susceptiblePeople);
                            $otherPerson->setState(Person::STATE_INFECTED);
                        }
                    }

                    $daysInfectedAlready = $person->getStateDuration();

                    /* die: */
                    if($person->willDie && $person->individualDayOfDeath <= $daysInfectedAlready) {
                        $person->setState(Person::STATE_DECEASED);
                    }

                    /* become immune: */
                    if($daysInfectedAlready>=$person->individualInfectionDuration) {
                        $person->setState(Person::STATE_IMMUNE);
                    }

                break;
                case Person::STATE_IMMUNE:
            }
        }

        TickCounter::getInstance()->increment();
    }

}