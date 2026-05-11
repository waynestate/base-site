<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\PromoController;
use Contracts\Repositories\PromoRepositoryContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mockery;
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

    #[Test]
    public function promo_show_appends_slug_and_id_to_canonical_url(): void
    {
        $promo_item_id = 42;
        $title = 'Test Slug Promo';

        $promoRepository = Mockery::mock(PromoRepositoryContract::class);
        $promoRepository->shouldReceive('getPromoView')->once()->andReturn([
            'promo' => [
                'title' => $title,
                'promo_item_id' => $promo_item_id,
            ],
        ]);
        $promoRepository->shouldReceive('getBackToPromoPage')->once()->andReturn('');

        $controller = app(PromoController::class, ['promo' => $promoRepository]);

        $request = new Request();
        $request->data = [
            'base' => [
                'page' => [
                    'canonical' => config('app.url') . '/promos',
                ],
            ],
        ];

        $view = $controller->show($request);

        $expected = config('app.url') . '/promos/' . Str::slug($title) . '-' . $promo_item_id;
        $this->assertEquals($expected, $view->getData()['base']['page']['canonical']);
    }
}
