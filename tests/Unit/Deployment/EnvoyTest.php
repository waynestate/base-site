<?php

namespace Tests\Unit\Deployment;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class EnvoyTest extends TestCase
{
    private string $envoyContent;

    protected function setUp(): void
    {
        parent::setUp();
        $this->envoyContent = file_get_contents(base_path('Envoy.blade.php'));
    }

    #[Test]
    public function envoy_defines_exclude_patterns_array(): void
    {
        $this->assertStringContainsString('$exclude_patterns = [', $this->envoyContent);
        $this->assertStringNotContainsString('$exclude_addon_pattens', $this->envoyContent);
    }

    #[Test]
    public function envoy_exclude_patterns_contains_all_expected_items(): void
    {
        preg_match('/\$exclude_patterns\s*=\s*\[(.*?)\];/s', $this->envoyContent, $matches);
        $this->assertNotEmpty($matches, 'Could not find $exclude_patterns array in Envoy.blade.php');

        $extracted = $matches[1];

        $expectedExcludes = [
            'node_modules',
            'storage',
            '.yarn',
            'tests',
            '.env',
            '.env.example',
            '*.map',
            'composer.lock',
            'yarn.lock',
            'resources/js',
            'resources/scss',
            'resources/images',
            'Envoy.blade.php',
            'phpunit.xml',
            '.phpunit.cache',
            'phpstan.neon',
            'pint.json',
            'eslint.config.js',
            '.stylelintrc',
            '.editorconfig',
            '.babelrc',
            '.nvmrc',
            '.phpbrewrc',
            'sami.php',
            'fontello-config.json',
            '.github',
            'hooks',
            'stubs',
            'makefile',
            'server.php',
            'tailwind.config.js',
            'webpack.mix.js',
            'README.md',
            'CONTRIBUTING.md',
            'CODEOWNERS',
            'AGENTS.md',
        ];

        foreach ($expectedExcludes as $expected) {
            $this->assertStringContainsString("'{$expected}'", $extracted, "Expected {$expected} in \$exclude_patterns");
        }
    }

    #[Test]
    public function envoy_pack_release_task_uses_exclude_flags(): void
    {
        $this->assertStringContainsString('{{ $exclude_flags }}', $this->envoyContent);
        $this->assertStringNotContainsString('--exclude=storage --exclude=node_modules', $this->envoyContent);
    }

    #[Test]
    public function envoy_anchors_exclude_patterns_to_source_name(): void
    {
        $this->assertMatchesRegularExpression('/\$source_name\s*\.\s*[\'"]\/[\'"]\s*\.\s*ltrim\(\$pattern/', $this->envoyContent);
    }
}
