<?php

namespace Styleguide\Repositories;

use App\Repositories\ProfileRepository as Repository;
use Factories\Article;
use Factories\Courses;
use Factories\Profile;
use Factories\ProfileGroup;

class ProfileRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getProfiles(int $site_id, ?string $selected_group = null): array
    {
        $limit = is_int($selected_group) ? rand(2, 5) : 20;

        $profiles = app(Profile::class)->create($limit);

        return [
            'profiles' => collect($profiles)->sortBy('last_name')->toArray(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDropdownOfGroups(int $site_id): array
    {
        $groups = collect(app(ProfileGroup::class)->create(10))->map(function ($item) {
            return $item['display_name'];
        })
        ->prepend('All Profiles', '')
        ->toArray();

        return [
            'dropdown_groups' => $groups,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getProfile(int $site_id, string $accessid): array
    {
        $articles = app(Article::class)->create(3, true);

        return [
            'profile' => app(Profile::class)->create(1, true),
            'courses' => app(Courses::class)->create(1, true),
            'articles' => $articles['data'] ?? [],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToProfileListUrl($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function sortGroupsByDisplayOrder($grouped, $groups)
    {
        // There is no need to sort the groups in the styleguide since the order is random
        return $grouped;
    }
}
