<?php

namespace Tests\Unit\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use App\Http\Controllers\ProfileController;
use App\Repositories\ProfileRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Factories\Page;
use Factories\Profile;
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

    #[Test]
    public function profile_index_should_order_profiles_by_accessid_when_configured(): void
    {
        // Create mock profiles data
        $profile_listing = app(Profile::class)->create(5);

        // Pick a custom order for a subset of the profiles
        $access_ids = collect($profile_listing)->pluck('data.AccessID')->toArray();
        $ordered_access_ids = [$access_ids[3], $access_ids[1]];
        $profiles_by_accessid = implode('|', $ordered_access_ids);

        $base_data = app(Page::class)->create(1, true);

        $request = new Request();
        $request->data = ['base' => $base_data];

        $profileRepository = $this->mockProfileRepositoryForIndex($base_data, ['profiles' => $profile_listing], function () use ($profiles_by_accessid) {
            Config::set('base.profile.profiles_by_accessid', $profiles_by_accessid);
        });

        // Use the real ordering logic
        $profileRepository->shouldReceive('orderProfilesById')
            ->once()
            ->with($profile_listing, $profiles_by_accessid)
            ->passthru();

        $controller = new ProfileController($profileRepository);

        $view = $controller->index($request);

        $this->assertEquals('profile-listing', $view->getName());

        // The configured profiles come first, in order, followed by the rest
        $result_access_ids = collect($view->getData()['profiles'])->pluck('data.AccessID')->toArray();
        $this->assertEquals($ordered_access_ids, array_slice($result_access_ids, 0, 2));
        $this->assertCount(5, $result_access_ids);
        $this->assertEqualsCanonicalizing($access_ids, $result_access_ids);
    }

    #[Test]
    public function profile_index_should_not_order_profiles_when_accessid_not_configured(): void
    {
        $profile_listing = app(Profile::class)->create(3);

        $base_data = app(Page::class)->create(1, true);

        $request = new Request();
        $request->data = ['base' => $base_data];

        $profileRepository = $this->mockProfileRepositoryForIndex($base_data, ['profiles' => $profile_listing]);
        $profileRepository->shouldNotReceive('orderProfilesById');

        $controller = new ProfileController($profileRepository);

        $view = $controller->index($request);

        $this->assertEquals($profile_listing, $view->getData()['profiles']);
    }

    #[Test]
    public function profile_index_should_not_order_profiles_when_no_profiles_returned(): void
    {
        $base_data = app(Page::class)->create(1, true);

        $request = new Request();
        $request->data = ['base' => $base_data];

        $profileRepository = $this->mockProfileRepositoryForIndex($base_data, ['profiles' => []], function () {
            Config::set('base.profile.profiles_by_accessid', 'aa1234|bb5678');
        });
        $profileRepository->shouldNotReceive('orderProfilesById');

        $controller = new ProfileController($profileRepository);

        $view = $controller->index($request);

        $this->assertEquals([], $view->getData()['profiles']);
    }

    /**
     * Mock the ProfileRepository calls made by ProfileController::index().
     */
    private function mockProfileRepositoryForIndex(array $base_data, array $profiles, ?callable $parse_config = null): Mockery\MockInterface
    {
        $profileRepository = Mockery::mock(ProfileRepository::class);

        $profileRepository->shouldReceive('parseProfileConfig')
            ->once()
            ->with($base_data)
            ->andReturnUsing($parse_config ?? function () {
            });

        $profileRepository->shouldReceive('getSiteID')
            ->once()
            ->with($base_data)
            ->andReturn($base_data['site']['id']);

        $profileRepository->shouldReceive('getDropdownOfGroups')
            ->once()
            ->andReturn(['dropdown_groups' => []]);

        $profileRepository->shouldReceive('getGroupIds')
            ->once()
            ->andReturn(null);

        $profileRepository->shouldReceive('getProfiles')
            ->once()
            ->andReturn($profiles);

        $profileRepository->shouldReceive('getDropdownOptions')
            ->once()
            ->andReturn([]);

        return $profileRepository;
    }
}
