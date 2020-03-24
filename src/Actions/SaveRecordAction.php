<?php


namespace BotRuleEngine\Actions;


class SaveRecordAction extends AbstractAction {

    public $variables;

    public $fields;

    public $default;

    public $table;

    public $userId;

    public static function create($userId, $table, $variables, $fields, $default) {
        $instance = new SaveRecordAction();
        $instance->userId = $userId;
        $instance->variables = $variables;
        $instance->fields = $fields;
        $instance->default = $default;
        $instance->table = $table;
        return $instance;
    }

    public function execute() {
        $variables = explode(',',$this->variables);
        $fields = ($this->fields ? explode(',',$this->fields) : []);
        $default = ($this->default ? explode(',',$this->default) : []);
        if ($this->getEngine()->getRuleFacade()->saveRecord($this->table, $variables, $fields, $default, $this->userId) === false) {
            return $this;
        }
        return parent::execute();
    }

    public function __sleep() {
        return array_merge(parent::__sleep(), ['variables', 'fields', 'default', 'table', 'userId']);
    }

}