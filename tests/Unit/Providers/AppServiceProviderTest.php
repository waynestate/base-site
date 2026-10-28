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
    public function contracts_should_bind_the_site_repository_when_one_exists(): void
    {
        $expected = class_exists('Styleguide\Repositories\Custom\ProfileRepository')
            ? 'Styleguide\Repositories\Custom\ProfileRepository'
            : 'Styleguide\Repositories\ProfileRepository';

        $this->assertSame($expected, get_class(app(ProfileRepositoryContract::class)));
    }
}
