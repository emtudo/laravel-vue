<?php

namespace Emtudo\Domains\Users\Presenters;

use Emtudo\Support\ViewPresenter\Presenter;

class UserPresenter extends Presenter
{
    public function status()
    {
        if ($this->entity->deleted_at) {
            return 'Suspenso';
        }

        return 'Ativo';
    }

    public function isActive()
    {
        return !($this->entity->deleted_at);
    }
}
