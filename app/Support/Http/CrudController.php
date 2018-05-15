<?php

namespace Emtudo\Support\Http;

use Emtudo\Support\Exception\RepositoryUndefinedException;

abstract class CrudController extends Controller
{
    protected $storeRequest;
    protected $updateRequest;
    protected $destroyRequest;
    protected $repositoryClass;
    protected $repository;

    public function __construct()
    {
        $this->checkRepository();
        parent::__construct();
        $this->repository = app()->make($this->repositoryClass);
    }

    public function index()
    {
        $values = $this->repository->getAllByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($values);
    }

    public function show(string $hashedId)
    {
        $item = $this->repository->findByPublicID($hashedId);
        if (!$item) {
            return $this->respond->notFound('Nada encontrado com os dados informados.');
        }

        return $this->respond->ok($item);
    }

    public function store()
    {
        if ($this->createRequest) {
            $request = app()->make($this->createRequest);
        }
        $item = $this->repository->create($this->params);
        if (!$item) {
            return $this->respond->error('Houve um erro na criação');
        }

        return $this->respond->ok($item);
    }

    public function update(string $hashedId)
    {
        if ($this->updateRequest) {
            $request = app()->make($this->updateRequest);
        }
        $item = $this->repository->findByPublicID($hashedId);
        if (!$item) {
            return $this->respond->notFound('Nada encontrado com os dados informados.');
        }

        $updated = $this->repository($item, $this->params);

        if ($updated) {
            return $this->respond->error('Falha ao atualizar as informações.');
        }

        return $this->respond->ok($item);
    }

    public function destroy(string $hashedId)
    {
        if ($this->destroyRequest) {
            $request = app()->make($this->destroyRequest);
        }
        $item = $this->repository->findByPublicID($hashedId);
        if (!$item) {
            return $this->respond->notFound('Nada encontrado com os dados informados.');
        }

        $deleted = $this->repository($item, $this->params);

        return $this->respond->ok(['deleted' => $deleted]);
    }

    protected function checkRepository()
    {
        if (!$this->repositoryClass) {
            throw new RepositoryUndefinedException();
        }
    }
}
