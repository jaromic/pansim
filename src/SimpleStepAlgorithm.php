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

    private function handleState($person) {
        switch($person->getState()) {
            case Person::STATE_INFECTED:
                foreach($person->friends as $friend) {
                    if ($friend->getState() == Person::STATE_SUSCEPTIBLE && random_int(0, 1) > 0) {
                        $friend->setState(Person::STATE_INFECTED);
                    }
                }

        }
    }

}