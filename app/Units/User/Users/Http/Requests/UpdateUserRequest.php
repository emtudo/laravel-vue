<?php

namespace Emtudo\Units\User\Users\Http\Requests;

use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Request;

class UpdateUserRequest extends Request
{
    public function rules()
    {
        return User::rules()->updating();
    }
}
