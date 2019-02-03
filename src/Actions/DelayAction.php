<?php

namespace BotRuleEngine\Actions;


class DelayAction extends AbstractAction {

    public $delay;

    public static function create($delay) {
        $instance = new DelayAction();
        // '6d:3h:4m'
        $pieces = explode(':', $delay);
        $time = now();
        foreach($pieces as $piece) {
            if (strpos($piece, 'd') !== false) {
                $time->addDays((int)$piece);
            } elseif (strpos($piece, 'h') !== false) {
                $time->addHours((int)$piece);
            } elseif (strpos($piece, 'm') !== false) {
                $time->addMinutes((int)$piece);
            }
        }
        $instance->delay = $time;
        return $instance;
    }

    public function execute() {
        if ($this->getEngine()->getRuleFacade()->delay($this->action, $this->delay) === false) {
            return $this;
        }
        return $this;
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['delay']);
    }

}