<?php

namespace App\Services;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GetPrefix {
    public function compose(View $view){
        // Retrieve the variable value here
        $prefix = trim(\request()->route()->getPrefix(), '/');

        $currentAction = Route::currentRouteAction();
        // Extract the controller name from the fully qualified action name
        $controllerName = class_basename($currentAction);

        // Remove the method name and get only the controller name
        $controllerName = str_replace('@' . request()->route()->getActionMethod(), '', $controllerName);

        // Pass the variable to the view
        $view->with([
            'prefix' => $prefix,
            'controllerName' => $controllerName
        ]);
    }
}
