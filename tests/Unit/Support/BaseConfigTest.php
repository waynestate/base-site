<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

final class BaseConfigTest extends TestCase
{
    private string $configPath;
    private string $testOverrideFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configPath = config_path();
        $this->testOverrideFile = 'test-override.php';
    }

    protected function tearDown(): void
    {
        // Clean up test files
        if (File::exists($this->configPath . '/' . $this->testOverrideFile)) {
            File::delete($this->configPath . '/' . $this->testOverrideFile);
        }
        parent::tearDown();
    }

    #[Test]
    public function config_returns_global_config_when_no_override_is_set(): void
    {
        config(['app.env' => 'testing']);

        // Parse the config as-is
        $config_original = include config_path('base.php');

        // If CONFIG_OVERRIDE is defined with no value
        putenv('CONFIG_OVERRIDE=');

        // Re-parse the base config
        $config_updated = include config_path('base.php');

        // Ensure the app config was not modified
        $this->assertIsArray($config_updated);
        $this->assertEquals($config_original['gtm_code'], $config_updated['gtm_code']);
        $this->assertEquals($config_original['layout'], $config_updated['layout']);
        $this->assertEquals($config_original['top_menu_enabled'], $config_updated['top_menu_enabled']);
    }

    #[Test]
    public function config_returns_global_config_when_override_file_does_not_exist(): void
    {
        // Parse the config as-is
        $config_original = include config_path('base.php');

        // Set CONFIG_OVERRIDE to non-existent file
        putenv('CONFIG_OVERRIDE=non-existent-file.php');

        // Re-parse the base config
        $config_updated = include config_path('base.php');

        // Ensure the app config was not modified
        $this->assertIsArray($config_updated);
        $this->assertEquals($config_original['gtm_code'], $config_updated['gtm_code']);
        $this->assertEquals($config_original['layout'], $config_updated['layout']);
        $this->assertEquals($config_original['top_menu_enabled'], $config_updated['top_menu_enabled']);
    }

    #[Test]
    public function config_merges_override_file_when_it_exists(): void
    {
        // Parse the config as-is
        $config_original = include config_path('base.php');

        // Create a test override file
        $overrideContent = '<?php
return [
    "gtm_code" => "GTM-OVERRIDE",
    "layout" => "custom",
    "top_menu_enabled" => true,
    "new_config_key" => "test_value",
];';

        File::put($this->configPath . '/' . $this->testOverrideFile, $overrideContent);

        // Set CONFIG_OVERRIDE environment variable
        putenv('CONFIG_OVERRIDE=' . $this->testOverrideFile);

        $config = include config_path('base.php');

        $this->assertIsArray($config);
        $this->assertEquals('GTM-OVERRIDE', $config['gtm_code']);
        $this->assertEquals('custom', $config['layout']);
        $this->assertTrue($config['top_menu_enabled']);
        $this->assertEquals('test_value', $config['new_config_key']);

        // Ensure non-overridden values remain
        $this->assertEquals($config_original['twitter_handle'], $config['twitter_handle']);
    }

    #[Test]
    public function config_recursively_merges_nested_arrays(): void
    {
        // Create override file with nested array modifications
        $overrideContent = '<?php
return [
    "hero_full_controllers" => [
        "HomepageController",
        "CustomController"
    ],
    "global" => [
        "all" => [
            "promos" => [
                "main_contact" => [
                    "id" => 123,
                    "config" => "limit:2",
                ],
                "custom_promo" => [
                    "id" => 456,
                    "config" => "test",
                ],
            ],
        ],
        "sites" => [
            1 => [
                "promos" => [
                    "contact" => [
                        "id" => 789,
                    ],
                ],
            ],
        ],
    ],
];';

        File::put($this->configPath . '/' . $this->testOverrideFile, $overrideContent);
        putenv('CONFIG_OVERRIDE=' . $this->testOverrideFile);

        $config = include config_path('base.php');

        // Check that nested arrays are properly merged
        $this->assertEquals(['HomepageController', 'CustomController'], $config['hero_full_controllers']);
        $this->assertEquals(123, $config['global']['all']['promos']['main_contact']['id']);
        $this->assertEquals('limit:2', $config['global']['all']['promos']['main_contact']['config']);
        $this->assertEquals(456, $config['global']['all']['promos']['custom_promo']['id']);
        $this->assertEquals(789, $config['global']['sites'][1]['promos']['contact']['id']);

        // Ensure other nested values are preserved
        $this->assertNotNull($config['global']['all']['promos']['main_social']);
        $this->assertNotNull($config['global']['all']['callbacks']);
    }

    #[Test]
    public function config_handles_empty_override_file(): void
    {
        // Parse the config as-is
        $config_original = include config_path('base.php');

        // Create empty override file
        $overrideContent = '<?php
return [];';

        File::put($this->configPath . '/' . $this->testOverrideFile, $overrideContent);
        putenv('CONFIG_OVERRIDE=' . $this->testOverrideFile);

        $config = include config_path('base.php');

        // Should return the global config unchanged
        $this->assertIsArray($config);
        $this->assertEquals($config['gtm_code'], $config['gtm_code']);
        $this->assertEquals($config['layout'], $config['layout']);
    }

    #[Test]
    public function config_override_completely_replaces_array_values(): void
    {
        // Test that array values are completely replaced, not merged
        $overrideContent = '<?php
return [
    "hero_full_controllers" => [
        "OnlyCustomController"
    ],
];';

        File::put($this->configPath . '/' . $this->testOverrideFile, $overrideContent);
        putenv('CONFIG_OVERRIDE=' . $this->testOverrideFile);

        $config = include config_path('base.php');

        // The original array should be completely replaced
        $this->assertEquals(['OnlyCustomController'], $config['hero_full_controllers']);
        $this->assertNotContains('HomepageController', $config['hero_full_controllers']);
        $this->assertNotContains('FullWidthController', $config['hero_full_controllers']);
    }
}
