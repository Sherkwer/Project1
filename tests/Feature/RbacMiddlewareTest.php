<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\RoleMiddleware;
use App\Models\User;

class RbacMiddlewareTest extends TestCase
{
    public function test_allows_matching_role()
    {
        $user = new User(['user_role' => 'Administrator']);

        $request = Request::create('/test', 'GET');
        $request->setUserResolver(fn () => $user);

        $middleware = new RoleMiddleware();

        $response = $middleware->handle($request, function ($req) {
            return response('ok', 200);
        }, 'Administrator');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_denies_non_matching_role()
    {
        $user = new User(['user_role' => 'Student']);

        $request = Request::create('/test', 'GET');
        $request->setUserResolver(fn () => $user);

        $middleware = new RoleMiddleware();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $middleware->handle($request, function ($req) {
            return response('ok', 200);
        }, 'Administrator');
    }

    public function test_allows_alias_role()
    {
        // user has canonical role "Administrator" but middleware is asked for alias 'admin'
        $user = new User(['user_role' => 'Administrator']);

        $request = Request::create('/test', 'GET');
        $request->setUserResolver(fn () => $user);

        $middleware = new RoleMiddleware();

        $response = $middleware->handle($request, function ($req) {
            return response('ok', 200);
        }, 'admin');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
