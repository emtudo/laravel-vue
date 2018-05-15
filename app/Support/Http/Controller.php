<?php

namespace Emtudo\Support\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array includes Transformer
     */
    protected $includes = [];

    /**
     * @var int number of items per page on index
     */
    protected $itemsPerPage = 30;

    protected $params = [];

    protected $paginate = true;

    protected $cleanTypes = [
        'document' => 'removeChars',
        'zip' => 'removeChars',
        'phone' => 'removeChars',
        'checkbox' => 'fixCheckbox',
        'select' => 'fixSelect',
        'ccNumber' => 'removeSpaces',
        'ccDate' => 'removeSpaces',
        'id' => 'revealId',
    ];

    protected $cleaningRules = [];

    /**
     * @var \Emtudo\Domains\Users\User
     */
    protected $user;

    /**
     * @var \Emtudo\Support\Http\Respond
     */
    protected $respond;

    /**
     * Controller constructor.
     *
     * Uses a middleware to always detect the running user on all requests.
     */
    public function __construct()
    {
        $this->respond = new Respond();

        $this->middleware(function ($request, $next) {
            $this->user = app('auth')->user();

            $this->itemsPerPage = (int) $request->get('limit', 30);
            $this->params = $this->cleanFields($request->all());

            $this->paginate = $request->get('paginate', true);
            $this->paginate = filter_var($this->paginate, FILTER_VALIDATE_BOOLEAN);

            $this->includes = $request->get('includes', []);
            if (!is_array($this->includes)) {
                $this->includes = explode(',', $this->includes);
            }

            return $next($request);
        });
    }

    /**
     * @param string $hashedId
     *
     * @return int
     */
    public function revealId(?string $hashedId = null)
    {
        if ($hashedId) {
            return decode_id($hashedId);
        }

        return null;
    }

    protected function cleanFields($data = [], $rules = null)
    {
        $newRules = $rules ?? $this->cleaningRules;

        foreach ($newRules as $field => $type) {
            if (isset($data[$field]) && is_array($type)) {
                $data[$field] = $this->cleanFieldsRecursive($data[$field], $type);
            }
            if (isset($data[$field]) && !is_array($type)) {
                $method = $this->cleanTypes[$type];
                $data[$field] = $this->$method($data[$field]);
            }
        }

        return $data;
    }

    protected function cleanFieldsRecursive($data = [], $rules = [])
    {
        $newData = [];
        foreach ($data as $key => $item) {
            if (!$key) {
                $newData[$key] = $this->cleanFields($item, $rules);
            } else {
                $newData[] = $this->cleanFields([$key => $item], $rules);
            }
        }

        return $newData;
    }

    protected function removeChars($value)
    {
        return str_replace(['(', ')', '-', '/', '.', ' '], '', $value);
    }

    protected function removeSpaces($value)
    {
        return str_replace(' ', '', $value);
    }

    protected function fixCheckbox($value)
    {
        if ('on' === $value) {
            return true;
        }

        if ('off' === $value) {
            return false;
        }

        return $value;
    }

    protected function fixSelect($value)
    {
        if ('' === $value) {
            return null;
        }

        return $value;
    }
}
