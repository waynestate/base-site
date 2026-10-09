<?php

namespace Tests\Unit\Support;

use App\Support\FakerFactory;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FakerFactoryTest extends TestCase
{
    #[Test]
    public function container_resolves_faker_factory_to_custom_factory(): void
    {
        $factory = app(Factory::class);

        $this->assertInstanceOf(FakerFactory::class, $factory);
    }

    #[Test]
    public function factory_create_returns_container_singleton_generator(): void
    {
        $factory = app(Factory::class);
        $generator = $factory->create();

        $this->assertInstanceOf(Generator::class, $generator);
        $this->assertSame(fake(), $generator);
    }

    #[Test]
    public function subsequent_calls_return_the_same_generator_instance(): void
    {
        $factory = app(Factory::class);

        $generator1 = $factory->create();
        $generator2 = $factory->create();

        $this->assertSame($generator1, $generator2);
    }
}
