<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ArticleComponent implements FactoryContract
{
    /**
     * Construct the factory.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * {@inheritdoc}
     */
    public function create($limit = 1, $flatten = false, $options = [])
    {
        $hero = [
            'featured' => 0,
            'url' => '/styleguide/image/1600x580',
            'caption' => $this->faker->sentence(rand(5, 10)),
            'alt_text' => $this->faker->sentence(rand(5, 10)),
            'type' => 'Hero Image',
        ];

        $social = [
            'featured' => 0,
            'url' => '/styleguide/image/1600x580',
            'caption' => $this->faker->sentence(rand(5, 10)),
            'alt_text' => $this->faker->sentence(rand(5, 10)),
            'type' => 'Social Image',
        ];

        $featured = [
            'featured' => 1,
            'url' => '/styleguide/image/770x434',
            'caption' => $this->faker->sentence(rand(5, 10)),
            'alt_text' => $this->faker->sentence(rand(5, 10)),
            'type' => 'Embeddable',
        ];

        $faculty = [];
        for ($i = 0; $i < 3; $i++) {
            $faculty[] = [
                'id' => $this->faker->randomDigit(),
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'accessid' => $this->faker->randomLetter().$this->faker->randomLetter().$this->faker->randomNumber(4, true),
            ];
        }

        $programs = [];
        for ($i = 0; $i < 3; $i++) {
            $programs[] = [
                'name' => $this->faker->randomElement(['Accounting (BS)', 'Art Education (BA)', 'Biological Sciences (BA)', 'Chemical Engineering (MS)']),
                'url' => 'https://wayne.edu',
            ];
        }

        $assets = [];
        for ($i = 0; $i < 3; $i++) {
            $assets[] = [
                'id' => $this->faker->randomDigit(),
                'url' => 'https://wayne.edu',
                'caption' => $this->faker->sentence(),
                'filename' => substr(md5($this->faker->sentence()), 0, 10).'.pdf',
            ];
        }

        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'id' => $i,
                'user_id' => $this->faker->randomDigit(),
                'application_id' => $this->faker->randomDigit(),
                'favicon_id' => null,
                'title' => $this->faker->sentence(rand(6, 10)),
                'short_title' => $this->faker->sentence(rand(3, 6)),
                'sub_title' => null,
                'permalink' => $this->faker->slug(),
                'meta_description' => $this->faker->sentence(),
                'body' => '<p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(8).'</p>
                <figure class="figure" style="padding-bottom:10px; float:right">
                    <img alt="Placeholder" height="400" src="/styleguide/image/300x400?text=Figure%20float%20right" style="padding:10px" width="300">
                    <figcaption>'.$this->faker->paragraph().'</figcaption>
                </figure>
                <p>'.$this->faker->paragraph().'</p>
                <blockquote class="blockquote1">
                    <p>'.$this->faker->paragraph(1).'</p>
                </blockquote>
                <p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(8).'</p>
                <blockquote class="blockquote2">
                    <p>'.$this->faker->paragraph(1).'</p>
                </blockquote>
                <p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(8).'</p>
                <p>&nbsp;</p>
                <h2>'.$this->faker->paragraph(1).'</h2>
                <figure class="figure" style="padding-bottom:10px; float:left">
                    <img alt="Placeholder" height="600" src="/styleguide/image/800x600?text=Figure%20float%20left" style="padding:10px" width="800">
                    <figcaption>'.$this->faker->paragraph().'</figcaption>
                </figure>
                <p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(15).'</p>
                <blockquote class="blockquote3">
                    <p>'.$this->faker->paragraph(5).'</p>
                </blockquote>
                <p>'.$this->faker->paragraph(15).'</p>
                <div style="text-align:center">
                    <figure class="figure" style="display:inline-block">
                        <img alt="Placeholder" height="450" src="/styleguide/image/800x450?text=Figure%20centered" style="padding:10px" width="800">
                        <figcaption>'.$this->faker->paragraph().'</figcaption>
                    </figure>
                </div>
                <p>'.$this->faker->paragraph(15).'</p>
                <img alt="Placeholder" height="400" src="/styleguide/image/300x400?text=Image%20float%20right" style="padding:10px; float:right" width="300">
                <p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(15).'</p>
                <img alt="Placeholder" height="300" src="/styleguide/image/400x300?text=Image%20float%20left" style="padding:10px; float:left" width="400">
                <p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(15).'</p>
                <p style="text-align:center">
                    <img alt="Placeholder" height="350" src="/styleguide/image/800x350?text=Image%20centered" style="padding:10px" width="800">
                </p>
                <p>'.$this->faker->paragraph(8).'</p>
                ',
                'article_date' => $this->faker->date(),
                'status' => 'Published',
                'link' => '/styleguide/'.config('base.news_view_route').'/item-1',
                'hero_image' => $hero,
                'social_image' => $social,
                'featured' => $featured,
                'files' => [
                    0 => $hero,
                    1 => $featured,
                ],
                'assets' => $this->faker->randomElements($assets, rand(1, 3)),
                'faculty' => $this->faker->randomElements($faculty, rand(1, 3)),
                'programs' => $this->faker->randomElements($programs, rand(1, 3)),
                'favicon' => null,
                'user' => null,
                'applications' => null,
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            $data = current($data);
        }

        return $data;
    }
}
