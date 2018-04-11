<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ControllerTest extends TestCase
{
    /**
     * @test
     */
    public function controllers_should_have_only_one_default()
    {
        $data = collect(Storage::disk('base')->allFiles('app/Http/Controllers/'))
            ->reject(function ($item) {
                return basename($item) === 'Controller.php' || ! ends_with($item, '.php');
            })
            ->map(function ($item) {
                return $this->getCommentData($item);
            })
            ->where('Default', 'true');

        $this->assertCount(1, $data, 'Only one controller can have a default=true value: '.$data->implode('File', ' & '));
    }

    /**
     * Get comment data from the top of the controller file.
     *
     * @param string $file
     * @return array
     */
    private function getCommentData($file)
    {
        // Pull only the first 8kiB of the file in.
        $fp = fopen($file, 'r');
        $file_data = fread($fp, 8192);
        fclose($fp);

        // Make sure we catch CR-only line endings.
        $file_data = str_replace("\r", "\n", $file_data);

        $default_headers = array('Status' => 'Status', 'Description' => 'Description', 'Default' => 'Default');

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
