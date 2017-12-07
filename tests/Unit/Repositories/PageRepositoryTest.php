<?php

namespace Tests\App\Repositories;

use Tests\TestCase;

class PageRepositoryTest extends TestCase
{
    /**
     * Passing wrong path should 404.
     *
     * @covers App\Repositories\PageRepository::getRequestData
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function non_exisitent_page_should_404()
    {
        // Change the ENV so it runs through the real DataMiddleware
        config(['app.env' => 'dev']);

        // Fake request
        $request = [
            'parameters' => [
                'path' => $this->faker->word.'/'.$this->faker->word.'/'.$this->faker->word.'/',
            ],
            'server' => [
                'path' => '',
            ],
        ];

        app('App\Repositories\PageRepository')->getRequestData($request);
    }

    /**
     * @covers App\Repositories\PageRepository::getRequestData
     * @test
     */
    public function getting_page_data_should_return_parsed_json()
    {
        $path = '1234567890';

        $filename = storage_path().'/app/public/'.$path.'.json';

        // Create a temporary file
        file_put_contents($filename, '{}');

        // Parse the page data
        $data = app('App\Repositories\PageRepository')->getRequestData(['parameters' => ['path' => $path]]);

        // Delete the temp file
        unlink($filename);

        // Make sure we have a blank array
        $this->assertEquals([], $data);
    }

    /**
     * @covers App\Repositories\PageRepository::getFilename
     * @test
     */
    public function getting_filename_should_return_correct_filename()
    {
        $pageRepository = app('App\Repositories\PageRepository');

        // Homepage should be index
        $this->assertEquals('index.json', $pageRepository->getFilename('/'));

        // Regular
        $this->assertEquals('mypage.json', $pageRepository->getFilename('mypage'));

        // Dash
        $this->assertEquals('mypage-dash.json', $pageRepository->getFilename('mypage-dash'));

        // Underscore
        $this->assertEquals('mypage_dash.json', $pageRepository->getFilename('mypage_dash'));

        // Folder should be underscore
        $this->assertEquals('my_folder.json', $pageRepository->getFilename('my/folder'));
    }
}
