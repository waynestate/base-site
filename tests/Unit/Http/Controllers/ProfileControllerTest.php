<?php

namespace Tests\Unit\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use App\Http\Controllers\ProfileController;
use App\Repositories\ProfileRepository;
use Factories\Page;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Waynestate\Api\Connector;

final class ProfileControllerTest extends TestCase
{
    #[Test]
    public function no_profile_accessid_should_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        // Construct the news controller
        $this->profileController = app(ProfileController::class, []);

        // Call the profile listing
        $view = $this->profileController->show(new Request());
    }

    #[Test]
    public function multiple_forced_group_ids_should_hide_filtering(): void
    {
        $request = new Request();
        $request->data = ['base' => app(Page::class)->create(1, true, ['data' => ['profile_group_id' => '10|11']])];

        $profileRepository = Mockery::mock(ProfileRepository::class)->makePartial();
        $profileRepository->shouldReceive('getDropdownOfGroups')->once()->andReturn(['dropdown_groups' => ['' => 'All Profiles', 10 => 'A', 11 => 'B']]);
        $profileRepository->shouldReceive('getProfiles')->once()->with(Mockery::any(), '10|11', Mockery::any())->andReturn(['profiles' => []]);

        $view = app(ProfileController::class, ['profile' => $profileRepository])->index($request);

        $this->assertTrue($view->getData()['hide_filtering']);
    }

    #[Test]
    public function invalid_profile_should_404_using_profile_repository(): void
    {
        $this->expectException(NotFoundHttpException::class);

        // Fake return
        $return = [
            'profiles' => [],
        ];

        $request = new Request();
        $request->accessid = 'aa1234';
        $request->data = [
            'base' => [
                'site' => [
                    'id' => 1,
                ],
            ],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('nextRequestProduction')->once()->andReturn(true);
        $wsuApi->shouldReceive('sendRequest')->with('profile.users.view', Mockery::type('array'))->once()->andReturn($return);

        // Construct the profile repository
        $profileRepository = app(ProfileRepository::class, ['wsuApi' => $wsuApi]);

        // Construct the profile controller
        $this->profileController = app(ProfileController::class, ['profile' => $profileRepository]);

        // Call the profile listing
        $view = $this->profileController->show($request);
    }
}
