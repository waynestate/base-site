<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileControllerTest extends TestCase
{
    /**
     * @covers App\Http\Controllers\ProfileController::__construct
     * @covers App\Http\Controllers\ProfileController::show
     * @test
     */
    public function no_profile_accessid_should_404()
    {
        $this->expectException(NotFoundHttpException::class);

        // Construct the news controller
        $this->profileController = app('App\Http\Controllers\ProfileController', []);

        // Call the profile listing
        $view = $this->profileController->show(new Request());
    }

    /**
     * @covers App\Http\Controllers\ProfileController::__construct
     * @covers App\Http\Controllers\ProfileController::show
     * @test
     */
    public function invalid_profile_should_404()
    {
        $this->expectException(NotFoundHttpException::class);

        // Fake return
        $return = [
            'profiles' => [],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('nextRequestProduction')->once()->andReturn(true);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);

        // Construct the profile repository
        $profileRepository = app('App\Repositories\ProfileRepository', ['wsuApi' => $wsuApi]);

        // Construct the news controller
        $this->profileController = app('App\Http\Controllers\ProfileController', ['profile' => $profileRepository]);

        $request = new Request();
        $request->accessid = 'aa1234';

        // Call the profile listing
        $view = $this->profileController->show($request);
    }
}
