<?php


namespace BotRuleEngine;


use BotTemplateFramework\TemplateEngine;

class FlowHelper {

    protected $engine;

    public $scenario;

    public function __construct(TemplateEngine $engine) {
        $this->engine = $engine;
        $this->scenario = $engine->getTemplate();
    }

    public function getFlowName($blockName) {
        return $blockName;
    }

    public function getFlowByName($name) {
        $block = $this->engine->getBlock($this->getFlowName($name));
        return $this->getFlowByBlock($block);
    }

    public function getFlowByBlock($block) {
        $flow = [$block];

        if (!array_key_exists('next', $block)) {
            return $flow;
        }

        if (is_array($block['next'])) {

            if ($block['type'] == 'if') {
                foreach($block['next'] as $eq) {
                    $key = $eq[3];
                    $next = $this->engine->getBlock($key,
                        array_key_exists('locale', $block) ? $block['locale'] : null);
                    $flow = array_merge($flow, $this->getFlowByBlock($next));
                }

            } else {
                $keys = array_keys($block['next']);
                foreach($keys as $key) {
                    $next = $this->engine->getBlock($block['next'][$key],
                        array_key_exists('locale', $block) ? $block['locale'] : null);
                    $flow = array_merge($flow, $this->getFlowByBlock($next));
                }
            }

        } else {
            $next = $this->engine->getBlock($block['next'],
                array_key_exists('locale', $block) ? $block['locale'] : null);
            $flow = array_merge($flow, $this->getFlowByBlock($next));
        }

        return $flow;
    }

    public function getAllFlowNames() {
        $blocks = $this->scenario['blocks'];
        $flowNames = [];
        foreach ($blocks as $block) {
            if (array_key_exists('template', $block)) {
                $flowNames[] = $this->getFlowName($block['name']);
            }
        }
        return $flowNames;
    }

    public function getAllBlockNames() {
        $blocks = $this->scenario['blocks'];
        $names = [];
        foreach ($blocks as $block) {
            $names[] = $block['name'];
        }
        return $names;
    }

    public function getAllBlockNamesInFlow($name) {
        $flow = $this->getFlowByName($name);
        $names = [];
        foreach ($flow as $block) {
            $names[] = $block['name'];
        }
        return $names;
    }

}