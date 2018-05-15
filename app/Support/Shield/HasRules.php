<?php

namespace Emtudo\Support\Shield;

use Emtudo\Support\Shield\Exceptions\UndefinedRules;

trait HasRules
{
    /**
     * @return \Emtudo\Support\Shield\Rules
     */
    public static function rules()
    {
        $className = self::$rulesFrom;
        if (class_exists($className)) {
            return new $className();
        }

        throw new UndefinedRules("Rules class {$className} do not exists.");
    }
}
