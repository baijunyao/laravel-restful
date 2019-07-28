<?php

namespace Baijunyao\LaravelRestful;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;

class RestfulController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected const MODEL = null;

    protected function getRouteId()
    {
        return current(request()->route()->parameters);
    }

    protected function getResourceName()
    {
        return substr(trim(strrchr(static::class, '\\'),'\\'), 0, -10);
    }

    protected function getModelFQCN()
    {
        $model = static::MODEL;

        if (empty($model)) {
            $model = '\\App\\Models\\' . $this->getResourceName();
        }

        return $model;
    }

    protected function getResourceFQCN()
    {
        $resource  = '\\App\\Http\\Resources\\' . $this->getResourceName();

        return $resource;
    }

    protected function formRequestValidation($className)
    {
        if (file_exists(app_path('Http/Requests/' . $this->getResourceName() . '/' . $className . '.php'))) {
            $app = app();
            $requestFQCN = '\\App\\Http\\Requests\\' . $this->getResourceName() . '\\' . $className;
            $request = $requestFQCN::createFrom($app['request']);
            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            $request->validateResolved();
        }
    }
}
