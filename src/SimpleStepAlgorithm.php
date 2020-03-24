<?php


namespace Jarosoft;


class SimpleStepAlgorithm implements StepAlgorithm
{
    public function step()
    {
        foreach (Person::$population as $person) {
            $this->handleState($person);
        }
        TickCounter::getInstance()->increment();
    }

    private function handleState(Person $person) {
        switch($person->getState()) {
            case Person::STATE_INFECTED:
                foreach($person->friends as $friend) {
                    if ($friend->getState() == Person::STATE_SUSCEPTIBLE && random_int(0, 10) > 2) {
                        $friend->setState(Person::STATE_INFECTED);
                    }
                }
                if($person->getStateDuration()>10 && random_int(1,10)<=1) {
                    $person->setState(Person::STATE_DECEASED);
                } elseif ($person->getStateDuration() > 14 && random_int(1,10)>7) {
                    $person->setState(Person::STATE_IMMUNE);
                }


        }
    }

}