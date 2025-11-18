<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\FullWidthController;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FullWidthControllerTest extends TestCase
{
    #[Test]
    public function fullwidth_controller_should_show_view(): void
    {
        $request = new Request();
        $request->data = [
            'base' => [
                'show_site_menu' => true,
            ],
        ];

        $controller = new FullWidthController();
        $view = $controller->index($request);

        $this->assertFalse($view->getData()['base']['show_site_menu']);
        $this->assertEquals('childpage', $view->getName());
    }
}
