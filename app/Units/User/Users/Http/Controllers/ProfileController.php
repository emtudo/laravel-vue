<?php

namespace Emtudo\Units\User\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\User\Users\Http\Requests\UpdateUserRequest;

class ProfileController extends Controller
{
    /**
     * show user's data.
     *
     * @param UserRepository $repository
     *
     * @return [type]
     */
    public function show(UserRepository $repository)
    {
        return $this->respond->ok($this->user);
    }

    /**
     * Update user's data.
     *
     * @param UpdateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return [type]
     */
    public function update(UpdateUserRequest $request, UserRepository $repository)
    {
        $user = $this->user;
        $repository->update($user, $this->params);

        return $this->respond->ok($user);
    }
}
