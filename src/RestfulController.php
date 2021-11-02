<?php

namespace Baijunyao\LaravelRestful;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\BindingResolutionException;
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

    /**
     * @return int
     *
     * @author hanmeimei
     */
    protected function getRouteId()
    {
        return current(request()->route()->parameters);
    }

    /**
     * Get Resource Name
     *
     * @return bool|string
     *
     * @author hanmeimei
     */
    protected function getResourceName()
    {
        return substr(trim(strrchr(static::class, '\\'), '\\'), 0, -10);
    }

    /**
     * Get Model
     *
     * @return Model
     *
     * @author hanmeimei
     */
    protected function getModelFQCN()
    {
        /* @var $model Model */
        $model = static::MODEL ?? '\\App\\Models\\' . $this->getResourceName();

        return $model;
    }

    /**
     * Get Resource
     *
     * @return JsonResource
     *
     * @author hanmeimei
     */
    protected function getResourceFQCN()
    {
        /* @var $resource JsonResource */
        $resource = '\\App\\Http\\Resources\\' . $this->getResourceName();

        return $resource;
    }

    /**
     * Validation Request Form
     *
     * @param string $className
     *
     * @throws BindingResolutionException
     *
     * @author hanmeimei
     */
    protected function formRequestValidation(string $className)
    {
        if (file_exists(app_path('Http/Requests/' . $this->getResourceName() . '/' . $className . '.php'))) {
            $requestFQCN = '\\App\\Http\\Requests\\' . $this->getResourceName() . '\\' . $className;

            $app = app();
            $request = $requestFQCN::createFrom($app['request']);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }

    protected function getFilteredPayload()
    {
        $model = new ($this->getModelFQCN());

        assert($model instanceof Model);

        $fillable = $model->getFillable();

        return $fillable === [] ? request()->all() : request()->only($fillable);
    }

    protected function getFilters()
    {
        return static::FILTERS;
    }

    protected function getSorts()
    {
        return static::SORTS;
    }

    protected function getFields()
    {
        return static::FIELDS;
    }

    protected function getRelations()
    {
        return static::RELATIONS;
    }
}
