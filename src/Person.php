<?php


namespace Jarosoft;


class Person
{
    const STATE_SUSCEPTIBLE = 0;
    const STATE_INFECTED = 1;
    const STATE_DECEASED = 2;
    const STATE_IMMUNE = 3;

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    protected $state;

    /**
     * @var int
     */
    public $stateStartTick;

    /**
     * @var Person[]
     */
    public $friends = [];

    /**
     * @var int
     */
    public static $count = 0;

    /**
     * @var array Person[]
     */
    public static $population = [];

    public static function addPerson($friendCount = 0)
    {
        $newPerson = new Person(self::$count);
        $newPerson->addRandomFriends($friendCount);
        self::$count += 1;
        array_push(self::$population, $newPerson);
        return $newPerson;
    }

    private function __construct($id)
    {
        $this->state = self::STATE_SUSCEPTIBLE;
        $this->stateStartTick = TickCounter::getInstance()->getTicks();
    }

    private function addRandomFriends(int $friendCount) {
        for($i=0; $i<$friendCount; ++$i) {
            $this->addRandomFriendIfPossible();
        }
    }

    private function addRandomFriendIfPossible()
    {
        // shuffle population so we can add the first suitable person:

        $shuffledPopulation = self::$population;
        shuffle($shuffledPopulation);

        foreach($shuffledPopulation as $person) {
            if($person->id = $this->id) {
                continue; // this person is ourselves
            } elseif (in_array($person, $this->friends)) {
                continue; // this person is one of our friends already
            } else {      // we don't know them yet, add them
                array_push($this->friends, $person);
                break;
            }

            $randomFriend = array_rand(self::$population);
            // if we don't have this friend already and if its's not us ourselves, add them to our friends array:
            if (!in_array(array_merge([$this], $this->friends), $randomFriend)) {
                array_push($this->friends, $randomFriend);
                break;
            }
        }
    }

    public static function dumpPopulation() {
        foreach(self::$population as $person) {
            echo $person . "\n";
        }
    }

    public function __toString()
    {
        $stateString = $this->getStateString();
        return "Person {$this->id} [{$stateString} for {$this->getStateDuration()} d] (".count($this->friends)." friends)";
    }

    function getStateString()
    {
        return array_flip((new \ReflectionClass(self::class))->getConstants())[$this->state];
    }

    function setState($newState) {
        if($this->state != $newState) // state is changing
        {
            $this->stateStartTick = TickCounter::getInstance()->getTicks();
        }
        $this->state = $newState;
    }

    function getStateDuration() {
        return TickCounter::getInstance()->getTicks() - $this->stateStartTick;
    }

    /**
     * @return int
     */
    function getState(): int {
        return $this->state;
    }
}