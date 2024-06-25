<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

abstract class RestfulController extends BaseController
{
    protected ?Request $request = null;

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/filtering
     */
    protected array $allowedFilters = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/sorting
     */
    protected array $allowedSorts = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/selecting-fields
     */
    protected array $allowedFields = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/including-relationships
     */
    protected array $allowedIncludes = [];

    /**
     * @see \Illuminate\Database\Eloquent\Builder::paginate($perPage, ...)
     */
    protected int $perPage = 15;

    /**
     * Laravel model name
     */
    protected ?string $model = null;

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\WithTrashed::withTrashed()
     */
    protected bool $withTrashed = false;

    public function getAllowedFilters(): array
    {
        return $this->allowedFilters;
    }

    public function getAllowedSorts(): array
    {
        return $this->allowedSorts;
    }

    public function getAllowedFields(): array
    {
        return $this->allowedFields;
    }

    public function getAllowedIncludes(): array
    {
        return $this->allowedIncludes;
    }

    public function withTrashed(): bool
    {
        return $this->withTrashed;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function customPaginate(SpatieQueryBuilder $builder): Paginator|CursorPaginator
    {
        return $builder->paginate($this->getPerPage());
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetRouteId::getRouteId()
     */
    protected function getRouteId(): int|string
    {
        return current($this->getRequest()->route()->parameters);
    }

    protected function getResourceName(): string
    {
        return Str::before(class_basename(static::class), 'Controller');
    }

    protected function getAppNamespace(): string
    {
        return Str::before(static::class, 'Http\\');
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn::getModelFqcn()
     */
    protected function getModelFqcn(): string
    {
        return $this->model ?? $this->getAppNamespace() . 'Models\\' . $this->getResourceName();
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn::getResourceFqcn()
     */
    protected function getResourceFqcn(): string
    {
        return $this->getAppNamespace() . 'Http\\Resources\\' . $this->getResourceName() . 'Resource';
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn::getResourceFqcn()
     */
    protected function getResourceCollectionFqcn(): string
    {
        return $this->getAppNamespace() . 'Http\\Resources\\' . $this->getResourceName() . 'Collection';
    }

    protected function getFilteredPayload(): array
    {
        $model = new ($this->getModelFqcn());

        assert($model instanceof Model);

        $fillable = $model->getFillable();

        return $fillable === [] ? $this->getRequest()->all() : $this->getRequest()->only($fillable);
    }

    protected function formRequestValidation(string $className): void
    {
        $requestClass = $this->getAppNamespace() . 'Http\\Requests\\' . $this->getResourceName() . '\\' . $className;

        if (class_exists($requestClass)) {
            $app     = App::getInstance();
            $request = $requestClass::createFrom($this->getRequest());

            assert($request instanceof \Illuminate\Foundation\Http\FormRequest);

            $request->setContainer(App::getInstance())->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }

    protected function addQueryForIndex(SpatieQueryBuilder $spatieQueryBuilder): SpatieQueryBuilder
    {
        return $spatieQueryBuilder;
    }

    protected function addQueryForShow(SpatieQueryBuilder $spatieQueryBuilder): SpatieQueryBuilder
    {
        return $spatieQueryBuilder;
    }

    protected function makeQueryBuilder(string $action): SpatieQueryBuilder
    {
        $spatieQueryBuilder = SpatieQueryBuilder::for($this->getModelFqcn());

        $allowedFilters  = $this->getAllowedFilters();
        $allowedSorts    = $this->getAllowedSorts();
        $allowedFields   = $this->getAllowedFields();
        $allowedIncludes = $this->getAllowedIncludes();

        if ($allowedFilters !== []) {
            $spatieQueryBuilder->allowedFilters($allowedFilters);
        }

        if ($allowedSorts !== []) {
            $spatieQueryBuilder->allowedSorts($allowedSorts);
        }

        if ($allowedFields !== []) {
            $spatieQueryBuilder->allowedFields($allowedFields);
        }

        if ($allowedIncludes !== []) {
            $spatieQueryBuilder->allowedIncludes($allowedIncludes);
        }

        if ($action === 'index') {
            $spatieQueryBuilder = $this->addQueryForIndex($spatieQueryBuilder);
        } elseif ($action === 'show') {
            $spatieQueryBuilder = $this->addQueryForShow($spatieQueryBuilder);
        } else {
            $function = 'addQueryFor' . ucfirst($action);

            if (method_exists($this, $function)) {
                $spatieQueryBuilder = $this->$function($spatieQueryBuilder);
            }
        }

        return $spatieQueryBuilder;
    }

    protected function getRequest(): Request
    {
        if ($this->request === null) {
            $this->request = App::make(Request::class);
        }

        return $this->request;
    }
}
