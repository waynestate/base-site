<?php

namespace Tests\Unit\Providers;

use PHPUnit\Framework\Attributes\Test;
use App\Providers\AppServiceProvider;
use Contracts\Repositories\ProfileRepositoryContract;
use Tests\TestCase;

final class AppServiceProviderTest extends TestCase
{
    #[Test]
    public function site_repository_should_overload_base_repository(): void
    {
        $this->fakeClass('App\Repositories\OverloadFixtureRepository');
        $this->fakeClass('App\Repositories\Custom\OverloadFixtureRepository');

        $this->assertSame(
            'App\Repositories\Custom\OverloadFixtureRepository',
            (new AppServiceProvider($this->app))->getRepository('OverloadFixtureRepository')
        );
    }

    #[Test]
    public function base_repository_without_site_overload_should_be_used(): void
    {
        $this->fakeClass('App\Repositories\BaseOnlyFixtureRepository');

        $this->assertSame(
            'App\Repositories\BaseOnlyFixtureRepository',
            (new AppServiceProvider($this->app))->getRepository('BaseOnlyFixtureRepository')
        );
    }

    #[Test]
    public function contracts_should_still_bind_repositories(): void
    {
        // A site may override the repository in Custom
        $this->assertContains(get_class(app(ProfileRepositoryContract::class)), [
            'Styleguide\Repositories\ProfileRepository',
            'Styleguide\Repositories\Custom\ProfileRepository',
        ]);
    }
}
