<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;

class RestfulController extends BaseController
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

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetRouteId::getRouteId()
     */
    protected function getRouteId(): int
    {
        return (int) current(request()->route()->parameters);
    }

    protected function getResourceName(): string
    {
        return substr(trim(strrchr(static::class, '\\'), '\\'), 0, -10);
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetModelFqcn::getModelFqcn()
     */
    protected function getModelFqcn(): string
    {
        return static::MODEL ?? '\\App\\Models\\' . $this->getResourceName();
    }

    /**
     * @see \Baijunyao\LaravelRestful\Traits\Functions\GetResourceFqcn::getResourceFqcn()
     */
    protected function getResourceFqcn(): string
    {
        return '\\App\\Http\\Resources\\' . $this->getResourceName() . 'Resource';
    }

    protected function formRequestValidation(string $className): void
    {
        $requestClass = '\\App\\Http\\Requests\\' . $this->getResourceName() . '\\' . $className;

        if (class_exists($requestClass)) {
            $app     = app();
            $request = $requestClass::createFrom($app['request']);

            assert($request instanceof \Illuminate\Foundation\Http\FormRequest);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }

    protected function getFilteredPayload(): array
    {
        $model = new ($this->getModelFqcn());

        assert($model instanceof Model);

        $fillable = $model->getFillable();

        return $fillable === [] ? request()->all() : request()->only($fillable);
    }

    protected function getFilters(): array
    {
        return static::FILTERS;
    }

    protected function getSorts(): array
    {
        return static::SORTS;
    }

    protected function getFields(): array
    {
        return static::FIELDS;
    }

    protected function getRelations(): array
    {
        return static::RELATIONS;
    }

    protected function withTrashed(): bool
    {
        return static::WITH_TRASHED;
    }

    protected function getPerPage(): int
    {
        return static::PER_PAGE;
    }
}
