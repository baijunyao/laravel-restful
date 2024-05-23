<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

abstract class RestfulController extends BaseController
{
    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/filtering
     */
    protected const FILTERS = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/sorting
     */
    protected const SORTS = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/selecting-fields
     */
    protected const FIELDS = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v5/features/selecting-fields#selecting-fields-for-included-relations
     */
    protected const RELATIONS = [];

    /**
     * @see \Illuminate\Database\Eloquent\Builder::paginate($perPage, ...)
     */
    protected const PER_PAGE = 15;

    /**
     * Laravel model name
     */
    protected const MODEL = null;

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\WithTrashed::withTrashed()
     */
    protected const WITH_TRASHED = false;

    public static function getFilters(): array
    {
        return static::FILTERS;
    }

    public static function getSorts(): array
    {
        return static::SORTS;
    }

    public static function getFields(): array
    {
        return static::FIELDS;
    }

    public static function getRelations(): array
    {
        return static::RELATIONS;
    }

    public static function withTrashed(): bool
    {
        return static::WITH_TRASHED;
    }

    public static function getPerPage(): int
    {
        return static::PER_PAGE;
    }

    public function customPaginate(SpatieQueryBuilder $builder): Paginator|CursorPaginator
    {
        return $builder->paginate(static::getPerPage());
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetRouteId::getRouteId()
     */
    protected function getRouteId(): int|string
    {
        return current(request()->route()->parameters);
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
        return static::MODEL ?? $this->getAppNamespace() . 'Models\\' . $this->getResourceName();
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

        return $fillable === [] ? request()->all() : request()->only($fillable);
    }

    protected function formRequestValidation(string $className): void
    {
        $requestClass = $this->getAppNamespace() . 'Http\\Requests\\' . $this->getResourceName() . '\\' . $className;

        if (class_exists($requestClass)) {
            $app     = app();
            $request = $requestClass::createFrom($app['request']);

            assert($request instanceof \Illuminate\Foundation\Http\FormRequest);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }

    protected function makeQueryBuilder(?EloquentBuilder $builder = null): SpatieQueryBuilder
    {
        $spatie_query_builder = SpatieQueryBuilder::for($builder ?? $this->getModelFqcn());

        $filters   = static::getFilters();
        $sorts     = static::getSorts();
        $fields    = static::getFields();
        $relations = static::getRelations();

        if ($filters !== []) {
            $spatie_query_builder->allowedFilters($filters);
        }

        if ($sorts !== []) {
            $spatie_query_builder->allowedSorts($sorts);
        }

        if ($fields !== []) {
            $spatie_query_builder->allowedFields($fields);
        }

        if ($relations !== []) {
            $spatie_query_builder->allowedIncludes($relations);
        }

        return $spatie_query_builder;
    }
}
