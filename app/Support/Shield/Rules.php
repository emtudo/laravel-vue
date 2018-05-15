<?php

namespace Emtudo\Support\Shield;

use Emtudo\Support\Shield\Contracts\Rules as RulesContract;

class Rules implements RulesContract
{
    public function defaultRules()
    {
        return [];
    }

    /**
     * @param string $type
     * @param mixed  $callback
     *
     * @return array
     */
    public function byRequestType($type, $callback = null)
    {
        $type = mb_strtolower($type);
        if ('post' === $type) {
            return method_exists($this, 'creating') ? $this->creating($callback) : [];
        }
        if ('put' === $type) {
            return method_exists($this, 'updating') ? $this->updating($callback) : [];
        }

        return $this->defaultRules();
    }

    protected function returnRules(array $rules = [], $callback = null)
    {
        $rules = array_merge($this->defaultRules(), $rules);

        return $this->rules($rules, $callback);
    }

    protected function rules(array $rules = [], $callback = null)
    {
        if (is_callable($callback)) {
            return $callback($rules);
        }

        return $rules;
    }
}
