<?php

namespace Baijunyao\LaravelRestful;

use Baijunyao\LaravelRestful\Support\Model;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;

class RestfulController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
            /* @var $requestFQCN FormRequest */
            $requestFQCN = '\\App\\Http\\Requests\\' . $this->getResourceName() . '\\' . $className;

            $app = app();
            $request = $requestFQCN::createFrom($app['request']);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }
}
