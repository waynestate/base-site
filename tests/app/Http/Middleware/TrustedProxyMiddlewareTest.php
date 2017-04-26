<?php

namespace Tests\App\Http\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;

class TrustedProxyMiddlewareTest extends TestCase
{
    /**
     * @covers App\Http\Middleware\TrustedProxyMiddleware::handle
     * @test
     */
    public function setting_trusted_proxy_should_set_current_remote_addr()
    {
        // Fake IP
        $ip = $this->faker->localIpv4;

        // Set a fake IP
        $request = new Request();
        $request->server->set('REMOTE_ADDR', $ip);

        // Call the middleware
        app('App\Http\Middleware\TrustedProxyMiddleware')->handle($request, function ($response) use ($ip) {
            $proxies = $response->getTrustedProxies();

            $this->assertContains($ip, $proxies);
        });
    }
}
