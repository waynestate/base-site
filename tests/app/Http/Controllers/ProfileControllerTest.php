<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;

class ProfileControllerTest extends TestCase
{
    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @covers App\Http\Controllers\ProfileController::__construct
     * @covers App\Http\Controllers\ProfileController::show
     * @test
     */
    public function invalid_profile_should_404()
    {
        // Fake return
        $return = [
            'profiles' => [],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('nextRequestProduction')->once()->andReturn(true);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);

        // Construct the profile repository
        $profileRepository = app('App\Repositories\ProfileRepository', [$wsuApi]);

        // Construct the news controller
        $this->profileController = app('App\Http\Controllers\ProfileController', [$profileRepository]);

        // Call the profile listing
        $view = $this->profileController->show(new Request());
    }
}
