<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Repositories\ProfileRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Waynestate\Api\Connector;

class ProfileControllerTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\ProfileController::__construct
     * @covers \App\Http\Controllers\ProfileController::show
     * @test
     */
    public function no_profile_accessid_should_404()
    {
        $this->expectException(NotFoundHttpException::class);

        // Construct the news controller
        $this->profileController = app(ProfileController::class, []);

        // Call the profile listing
        $view = $this->profileController->show(new Request());
    }

    /**
     * @covers \App\Http\Controllers\ProfileController::__construct
     * @covers \App\Http\Controllers\ProfileController::show
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
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('nextRequestProduction')->once()->andReturn(true);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);

        // Construct the profile repository
        $profileRepository = app(ProfileRepository::class, ['wsuApi' => $wsuApi]);

        // Construct the news controller
        $this->profileController = app(ProfileController::class, ['profile' => $profileRepository]);

        $request = new Request();
        $request->accessid = 'aa1234';

        // Call the profile listing
        $view = $this->profileController->show($request);
    }
}
