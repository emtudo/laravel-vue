<?php

namespace Emtudo\Units\Admin\Users\Http\Requests\Users;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Request;

class UpdateUserRequest extends Request
{
    public function rules()
    {
        return User::rules()->updating();
    }
}
