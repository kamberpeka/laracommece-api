<?php

namespace App\Support\Classes;

use Illuminate\Database\Eloquent\Model;

class ServiceResponse
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var Model|null
     */
    private $model;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @param bool $success
     * @param Model|null $model
     */
    public function __construct(bool $success, ?Model $model = null, string $message = null)
    {
        $this->success = $success;
        $this->model = $model;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function success()
    {
        return $this->success;
    }

    /**
     * @return Model|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'success' => $this->success,
            'model' => $this->model
        ];
    }
}
