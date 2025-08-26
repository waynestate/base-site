<?php

use PHPUnit\Framework\Attributes\Test;
use App\Http\Controllers\DirectoryController;
use App\Repositories\ProfileRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Factories\Page;
use Factories\Profile;

final class DirectoryControllerTest extends TestCase
{
    #[Test]
    public function directory_index_should_order_profiles_by_accessid_when_configured(): void
    {
        // Create mock profiles data
        $profile_listing = app(Profile::class)->create(5);

        // Get AccessIDs and create a custom order
        $access_ids = collect($profile_listing)->pluck('data.AccessID')->toArray();
        $profiles_by_accessid = implode('|', array_reverse($access_ids));

        // Create profiles grouped by department
        $grouped_profiles = [
            'profiles' => [
                'Department A' => array_slice($profile_listing, 0, 3),
                'Department B' => array_slice($profile_listing, 3, 2),
            ],
            'anchors' => [
                'Department A' => 'department-a',
                'Department B' => 'department-b',
            ],
        ];

        // Create request data with profile configuration
        $base_data = app(Page::class)->create(1, true, [
            'data' => [
                'profile-config' => json_encode([
                    'profiles_by_accessid' => $profiles_by_accessid,
                ]),
            ],
        ]);

        $request = new Request();
        $request->data = ['base' => $base_data];

        // Mock the ProfileRepository
        $profileRepository = Mockery::mock(ProfileRepository::class);

        // Mock parseProfileConfig to set the config
        $profileRepository->shouldReceive('parseProfileConfig')
            ->once()
            ->with($base_data)
            ->andReturnUsing(function ($data) use ($profiles_by_accessid) {
                Config::set('base.profile.profiles_by_accessid', $profiles_by_accessid);
            });

        // Mock getSiteID
        $profileRepository->shouldReceive('getSiteID')
            ->once()
            ->with($base_data)
            ->andReturn($base_data['site']['id']);

        // Mock getProfilesByGroup (since group_id is not set)
        $profileRepository->shouldReceive('getProfilesByGroup')
            ->once()
            ->with($base_data['site']['id'], $base_data['site']['subsite-folder'])
            ->andReturn($grouped_profiles);

        // Mock orderProfilesById for each department
        $profileRepository->shouldReceive('orderProfilesById')
            ->twice()
            ->with(Mockery::type('array'), $profiles_by_accessid)
            ->andReturnUsing(function ($department_profiles, $profiles_by_accessid) {
                // Simulate the ordering logic
                $accessids = explode('|', $profiles_by_accessid);
                $ordered = collect($accessids)->map(function ($accessid) use ($department_profiles) {
                    return collect($department_profiles)->firstWhere('data.AccessID', trim($accessid));
                })->filter()->values()->toArray();

                $remaining = collect($department_profiles)->reject(function ($profile) use ($accessids) {
                    return in_array($profile['data']['AccessID'], $accessids);
                })->values()->toArray();

                return array_merge($ordered, $remaining);
            });

        // Create controller instance
        $controller = new DirectoryController($profileRepository);

        // Call the index method
        $view = $controller->index($request);

        // Verify the view was returned
        $this->assertEquals('directory', $view->getName());
    }

    #[Test]
    public function directory_index_should_use_group_order_when_group_id_configured(): void
    {
        // Create mock profiles data
        $profile_listing = app(Profile::class)->create(3);
        $group_id = '1|2|3';

        // Create profiles grouped by department
        $grouped_profiles = [
            'profiles' => [
                'Department A' => $profile_listing,
            ],
            'anchors' => [
                'Department A' => 'department-a',
            ],
        ];

        // Create request data
        $base_data = app(Page::class)->create(1, true, [
            'data' => [
                'profile-config' => json_encode([
                    'group_id' => $group_id,
                ]),
            ],
        ]);

        $request = new Request();
        $request->data = ['base' => $base_data];

        // Mock the ProfileRepository
        $profileRepository = Mockery::mock(ProfileRepository::class);

        // Mock parseProfileConfig to set the config
        $profileRepository->shouldReceive('parseProfileConfig')
            ->once()
            ->with($base_data)
            ->andReturnUsing(function ($data) use ($group_id) {
                Config::set('base.profile.group_id', $group_id);
            });

        // Mock getSiteID
        $profileRepository->shouldReceive('getSiteID')
            ->once()
            ->with($base_data)
            ->andReturn($base_data['site']['id']);

        // Mock getProfilesByGroupOrder (since group_id is set)
        $profileRepository->shouldReceive('getProfilesByGroupOrder')
            ->once()
            ->with($base_data['site']['id'], $group_id, $base_data['site']['subsite-folder'])
            ->andReturn($grouped_profiles);

        // Create controller instance
        $controller = new DirectoryController($profileRepository);

        // Call the index method
        $view = $controller->index($request);

        // Verify the view was returned
        $this->assertEquals('directory', $view->getName());
    }
}
