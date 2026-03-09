<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\PromoController;
use Illuminate\Http\RedirectResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PromoControllerTest extends TestCase
{
    #[Test]
    public function promo_controller_index_should_redirect_to_app_url()
    {
        $response = app(PromoController::class)->index();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(config('app.url'), $response->getTargetUrl());
        $this->assertEquals(302, $response->getStatusCode());
    }
}
