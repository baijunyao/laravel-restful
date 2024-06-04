<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Illuminate\Database\Eloquent\Model;

class JsonResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * @var class-string<\Baijunyao\LaravelRestful\RestfulController>
     */
    protected string $controllerFqcn;

    public function __construct($resource, $controllerFqcn = null)
    {
        /**
         * @see \Illuminate\Http\Resources\Json\ResourceCollection::collectResource()
         * The `$resource->mapInto($collects)` will make $controllerFqcn into int
         */
        if ($controllerFqcn !== null && class_exists((string) $controllerFqcn)) {
            $this->setControllerFqcn($controllerFqcn);
        }

        parent::__construct($resource);
    }

    /**
     * @param class-string<\Baijunyao\LaravelRestful\RestfulController> $controllerFqcn
     */
    public function setControllerFqcn($controllerFqcn): void
    {
        $this->controllerFqcn = $controllerFqcn;
    }

    /**
     * @return class-string<\Baijunyao\LaravelRestful\RestfulController>
     */
    public function getControllerFqcn(): string
    {
        return $this->controllerFqcn;
    }

    public function toArray($request)
    {
        /** @var class-string<\Baijunyao\LaravelRestful\RestfulController> $controllerFqcn */
        $controllerFqcn = $this->getControllerFqcn();
        $fields         = (new $controllerFqcn())->getAllowedFields();

        if ($fields === []) {
            return parent::toArray($request);
        }

        $fields = $this->filterFields($fields);

        assert($this->resource instanceof Model);

        return $this->resource->only(array_merge($fields, array_keys($this->resource->getRelations())));
    }

    public function filterFields(array $fields): array
    {
        return $fields;
    }
}
