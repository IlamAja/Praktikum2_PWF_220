<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Dedoc\Scramble\Configuration\OperationTransformers;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityRequirement;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Dedoc\Scramble\Support\RouteInfo;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::configure()
            ->routes(function (Route $route) {
                return Str::startsWith($route->uri, 'api/');
            })
            ->withDocumentTransformers(function (OpenApi $openApi) {
                $openApi->components->addSecurityScheme(
                    'bearerAuth',
                    SecurityScheme::http('bearer', 'JWT')
                        ->setDescription('Use Bearer token for API authentication.')
                );
            })
            ->withOperationTransformers(function (OperationTransformers $transformers) {
                $transformers->append(function (Operation $operation, RouteInfo $routeInfo) {
                    $middlewares = $routeInfo->route->gatherMiddleware();

                    if (collect($middlewares)->contains(fn ($middleware) => Str::contains($middleware, 'auth'))) {
                        $operation->addSecurity(new SecurityRequirement(['bearerAuth' => []]));
                    }
                });
            });

        Gate::define('viewApiDocs', function () {
            return true;
        });

        Gate::define('manage-product', function ($user) {
            return $user->role === 'admin';
        });

        Gate::policy(Product::class, ProductPolicy::class);
    }
}
