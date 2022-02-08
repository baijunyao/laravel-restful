<?php

declare(strict_types=1);

namespace Baijunyao\LaravelRestful;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;

class RestfulController extends BaseController
{
    /**
     * @link https://spatie.be/docs/laravel-query-builder/v3/features/filtering
     */
    protected const FILTERS = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v3/features/sorting
     */
    protected const SORTS = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v3/features/selecting-fields
     */
    protected const FIELDS = [];

    /**
     * @link https://spatie.be/docs/laravel-query-builder/v3/features/selecting-fields#selecting-fields-for-included-relations
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

    protected function getRouteId(): int
    {
        return (int) current(request()->route()->parameters);
    }

    protected function getResourceName(): string
    {
        return substr(trim(strrchr(static::class, '\\'), '\\'), 0, -10);
    }

    /**
     * @return class-string<Model>
     */
    protected function getModelFQCN(): string
    {
        return static::MODEL ?? '\\App\\Models\\' . $this->getResourceName();
    }

    /**
     * @return class-string<JsonResource>
     */
    protected function getResourceFQCN(): string
    {
        return '\\App\\Http\\Resources\\' . $this->getResourceName();
    }

    protected function formRequestValidation(string $className): void
    {
        if (file_exists(app_path('Http/Requests/' . $this->getResourceName() . '/' . $className . '.php'))) {
            $requestFQCN = '\\App\\Http\\Requests\\' . $this->getResourceName() . '\\' . $className;

            $app     = app();
            $request = $requestFQCN::createFrom($app['request']);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }

    protected function getFilteredPayload(): array
    {
        $modelFQCN = $this->getModelFQCN();
        $model     = new $modelFQCN();

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
}
