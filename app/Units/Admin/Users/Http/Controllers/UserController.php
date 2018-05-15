<?php

namespace Emtudo\Units\Admin\Users\Http\Controllers;

use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\Admin\Users\Http\Requests\Users\CreateUserRequest;
use Emtudo\Units\Admin\Users\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return [type]
     */
    public function index(Request $request, UserRepository $repository)
    {
        $users = $repository
          ->setTrashed($request->get('trashed', false))
          ->getAllByParams($this->params, $this->itemsPerPage, $this->paginate);

        return $this->respond->ok($users);
    }

    public function show(string $id, UserRepository $repository)
    {
        $user = $repository
              ->withTrashed()
              ->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado!');
        }

        return $this->respond->ok($user);
    }

    /**
     * @param CreateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return [type]
     */
    public function store(CreateUserRequest $request, UserRepository $repository)
    {
        $user = $repository->create($request->all());

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado!');
        }

        if ($request->get('is_admin', false)) {
            $user->is_admin = true;
            $user->save();
        }

        return $this->respond->ok($user);
    }

    /**
     * @param string            $id
     * @param UpdateUserRequest $request
     * @param UserRepository    $repository
     *
     * @return [type]
     */
    public function update(string $id, UpdateUserRequest $request, UserRepository $repository)
    {
        $user = $repository
          ->withTrashed()
          ->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado!');
        }

        $repository->update($user, $this->params);

        $user->is_admin = $request->get('is_admin', false);
        $user->save();

        return $this->respond->ok($user);
    }

    /**
     * @param string         $id
     * @param UserRepository $repository
     *
     * @return [type]
     */
    public function suspend(string $id, UserRepository $repository)
    {
        $user = $repository->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado!');
        }

        if ($user->id === $this->user->id) {
            return $this->respond->error('Você não pode suspender a você mesmo!');
        }

        $repository->delete($user);

        return $this->respond->ok($user);
    }

    /**
     * @param string         $id
     * @param UserRepository $repository
     *
     * @return [type]
     */
    public function activate(string $id, UserRepository $repository)
    {
        $user = $repository->onlyTrashed()->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado!');
        }

        if ($user->id === $this->user->id) {
            return $this->respond->error('Você não pode ativar a você mesmo!');
        }

        $repository->restore($user);

        return $this->respond->ok($user);
    }

    /**
     * @param string         $id
     * @param UserRepository $repository
     *
     * @return [type]
     */
    public function destroy(string $id, UserRepository $repository)
    {
        $user = $repository->withTrashed()->findByPublicID($id);

        if (!$user) {
            return $this->respond->notFound('Usuário não encontrado!');
        }

        if ($user->id === $this->user->id) {
            return $this->repsond->error('Você não pode apagar a você mesmo!');
        }

        $deleted = $repository->delete($user, true);

        if (!$deleted) {
            return $this->repsond->error('Não foi possível excluir o usuário!');
        }

        return $this->respond->ok($user);
    }
}
