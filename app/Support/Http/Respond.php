<?php

namespace Emtudo\Support\Http;

use Emtudo\Support\Domain\Fractal\Manager;
use Illuminate\Http\JsonResponse as Response;

class Respond
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Respond constructor.
     */
    public function __construct()
    {
        $this->manager = new Manager();
    }

    public function generic($data = null, $message = '', $includes = [], $meta = [], $headers = [], $transformer = null)
    {
        return $this->factory(Response::HTTP_OK, $data, $message, $includes, $meta, $headers, $transformer);
    }

    public function ok($data = null, $message = '', $includes = [], $meta = [], $headers = [], $transformer = null)
    {
        return $this->generic($data, $message, $includes, $meta, $headers, $transformer);
    }

    public function created($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->factory(Response::HTTP_CREATED, $data, $message, $includes, $meta, $headers);
    }

    public function accepted($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->factory(Response::HTTP_ACCEPTED, $data, $message, $includes, $meta, $headers);
    }

    public function updated($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->accepted($data, $message, $includes, $meta, $headers);
    }

    public function deleted($data = null, $message = '', $includes = [], $meta = [], $headers = [])
    {
        return $this->accepted($data, $message, $includes, $meta, $headers);
    }

    public function invalid($errors = [], $message = 'Dados informados são inválidos.', $headers = [])
    {
        return $this->factory(Response::HTTP_UNPROCESSABLE_ENTITY, $errors, $message, $headers);
    }

    public function unauthorized($errors = [], $message = 'Não autorizado!', $headers = [])
    {
        return $this->factory(Response::HTTP_UNAUTHORIZED, $errors, $message, $headers);
    }

    public function notFound($message, $headers = [])
    {
        return $this->factory(Response::HTTP_NOT_FOUND, [], $message, [], $headers);
    }

    public function error($message, $headers = [])
    {
        return $this->factory(Response::HTTP_INTERNAL_SERVER_ERROR, [], $message, [], $headers);
    }

    public function file($data = null, $type = 'application/pdf', $encode = 'base64', $message = '', $meta = [], $headers = [])
    {
        return $this->generic(['file' => $data, 'type' => $type, 'encode' => $encode], $message, [], $meta, $headers);
    }

    protected function factory($code = 200, $data = null, $message = '', $includes = [], $meta = [], $headers = [], $transformer = null)
    {
        $transformed = $this->manager->transform($data, $includes, $transformer);

        $msg = $message;
        if (!is_array($msg)) {
            $msg = ['message' => $msg];
        }
        $transformed->addMeta($msg);

        if (count($meta) > 0) {
            $transformed->addMeta($meta);
        }

        return new Response($transformed, $code, $headers);
    }
}
