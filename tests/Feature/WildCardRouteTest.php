<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

final class WildCardRouteTest extends TestCase
{
    #[Test]
    public function request_with_file_extension_should_throw_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $this->call('GET', '/path/to/image.jpg');
    }

    #[Test]
    public function request_with_dot_in_path_should_throw_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $this->call('GET', '/some.path/file');
    }

    #[Test]
    public function request_with_file_extension_with_exception_handling_returns_404(): void
    {
        $this->withExceptionHandling();

        $response = $this->call('GET', '/path/to/image.jpg');

        $this->assertEquals(404, $response->status());
    }
}
