<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ControllerTest extends TestCase
{
    /**
     * @test
     */
    public function controllers_should_have_only_one_default(): void
    {
        $data = $this->getControllerComments()->where('Default', 'true');

        $this->assertCount(1, $data, 'Only one controller can have a default=true value: '.$data->implode('File', ' & '));
    }

    /**
     * @test
     */
    public function controllers_should_have_unique_descriptions(): void
    {
        $all = $this->getControllerComments()->pluck('Description');
        $unique = $all->unique();

        $this->assertTrue($all->count() == $unique->count(), 'Controller descriptions must be unique: '.$all->implode(' & '));
    }

    /**
     * Get all controller comments.
     *
     * @return array
     */
    private function getControllerComments(): array
    {
        return collect(Storage::disk('base')->allFiles('app/Http/Controllers/'))
        ->reject(function ($item) {
            return basename($item) === 'Controller.php' || ! Str::endsWith($item, '.php');
        })
        ->map(function ($item) {
            return $this->getCommentData($item);
        });
    }

    /**
     * Get comment data from the top of the controller file.
     *
     * @param string $file
     * @return array
     */
    private function getCommentData(string $file): array
    {
        // Pull only the first 8kiB of the file in.
        $fp = fopen($file, 'r');
        $file_data = fread($fp, 8192);
        fclose($fp);

        // Make sure we catch CR-only line endings.
        $file_data = str_replace("\r", "\n", $file_data);

        $default_headers = ['Status' => 'Status', 'Description' => 'Description', 'Default' => 'Default'];

        foreach ($default_headers as $field => $regex) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $file_data, $match) && $match[1]) {
                $all_headers[ $field ] = trim($match[1]);
            } else {
                $all_headers[ $field ] = '';
            }
        }

        // Append the filename for reference
        $all_headers['File'] = $file;

        return $all_headers;
    }
}
