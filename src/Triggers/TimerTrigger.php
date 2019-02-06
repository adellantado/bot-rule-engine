<?php


namespace BotRuleEngine\Triggers;


use BotRuleEngine\RuleEngine;

class TimerTrigger extends AbstractTrigger {

    public function __construct(RuleEngine $engine, $time, $every) {
        parent::__construct($engine);

        // 5d | 1w | 1m | once
        $lastTimeRan = $engine->getRuleFacade()->getLastTimerRan();
        $now = (new \DateTime())->setTime(0, 0);

        if (strpos($every, 'once') !== false) {

            if ($lastTimeRan) {
                return;
            }

        } elseif (strpos($every, 'd') !== false) {

            $ok = $now->diff($lastTimeRan)->d == (int)$every;
            if (!$ok) {
                return;
            }

        } elseif (strpos($every, 'w') !== false) {

            $ok = $now->diff($lastTimeRan)->d == 7 * (int)$every;
            if (!$ok) {
                return;
            }

        } elseif (strpos($every, 'm') !== false) {

            $ok = $now->diff($lastTimeRan)->m == (int)$every;
            if (!$ok) {
                return;
            }

        }

        // 3rd 15:24 | Thu 15:24 | 15:24
        $time = trim($time);
        $now = new \DateTime();

        // check time ( 15:24 )
        if ($now->format('H:i') == $time) {
            $this->trigger();
            return;
        }

        // check day of week and time ( Thu 15:24 )
        if ($now->format('D H:i') == trim($time)) {
            $this->trigger();
            return;
        }

        // check day number and time ( 3rd 15:24 )
        $day = $now->format('j');
        $suf = $day < 4 ? ['st', 'nd', 'rd'][$day] : 'th';
        $t = $now->format('H:i');
        if ($day.$suf.' '.$t == trim($time)) {
            $this->trigger();
            return;
        }
    }

    public function trigger() {
        $this->getEngine()->getRuleFacade()->saveLastTimerRan(new \DateTime());
        parent::trigger();
    }

}