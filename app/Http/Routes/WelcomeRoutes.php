<?php
namespace App\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Router;
use LaravelBA\RouteBinder\RouteBinder;

class WelcomeRoutes implements RouteBinder
{
	/**
	 * Bind parameters, filters or anything you need to do
	 * with the concrete router here.
	 *
	 * NOTE: If an object that's not an instance (nor an extension) of the concrete
	 * \Illuminate\Routing\Router is bound as the \Illuminate\Contracts\Routing\Registrar
	 * in the Container, **this method will never be called!**
	 *
	 * @param Router $router
	 *
	 * @return void
	 */
	public function addBindings(Router $router)
	{
		//
	}

	/**
	 * Add all needed routes to the router.
	 *
	 * NOTE: This methods will NOT be called if the routes are cached,
	 * so any binding logic should be done in `addBindings` and not here.
	 *
	 * @param Registrar $router
	 *
	 * @return void
	 */
	public function addRoutes(Registrar $router)
	{
        $router->group(['middleware' => 'web'], function (Registrar $router) {
            $router->get('/', function () {
                return view('welcome');
            });
        });

        $router->group(['middleware' => 'api', 'prefix' => 'api'], function (Registrar $router) {
            $router->get('/user', function (\Illuminate\Http\Request $request) {
                return $request->user();
            })->middleware('auth:api');

        });
	}
}
