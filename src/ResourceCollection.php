<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

class ResourceCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    /**
     * @var class-string<\Baijunyao\LaravelRestful\RestfulController>
     */
    public string $controllerFqcn;

    public function __construct($resource, $controllerFqcn = null)
    {
        if ($controllerFqcn !== null) {
            $this->setControllerFqcn($controllerFqcn);
        }

        parent::__construct($resource);
    }

    /**
     * @param class-string<\Baijunyao\LaravelRestful\RestfulController> $controllerFqcn
     */
    public function setControllerFqcn(string $controllerFqcn): void
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
        foreach ($this->collection as $resouce) {
            $resouce->setControllerFqcn($this->getControllerFqcn());
        }

        return [
            'data' => $this->collection,
        ];
    }
}
