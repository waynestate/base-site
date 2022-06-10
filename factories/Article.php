<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class Article implements FactoryContract
{
    /**
     * Construct the factory.
     *
     * @param Factory $faker
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

        $featured = [
            'featured' => 1,
            'url' => '/styleguide/image/1600x580',
            'caption' => $this->faker->sentence(rand(5, 10)),
            'alt_text' => $this->faker->sentence(rand(5, 10)),
            'type' => 'Embeddable',
        ];

        for ($i = 1; $i <= $limit; $i++) {
            $data['data'][$i] = [
                'id' => $i,
                'user_id' => $this->faker->randomDigit,
                'application_id' => $this->faker->randomDigit,
                'favicon_id' => null,
                'title' => $this->faker->sentence(rand(6, 10)),
                'short_title' => $this->faker->sentence(rand(3, 6)),
                'sub_title' => null,
                'permalink' => $this->faker->slug,
                'meta_description' => $this->faker->sentence,
                'body' => '<p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(8).'</p>
                <figure class="figure" style="padding-bottom:10px; float:right">
                    <img alt="Placeholder" height="400" src="/styleguide/image/300x400?text=Figure%20float%20right" style="padding:10px" width="300">
                    <figcaption>'.$this->faker->paragraph.'</figcaption>
                </figure>
                <p>'.$this->faker->paragraph.'</p>
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
                    <figcaption>'.$this->faker->paragraph.'</figcaption>
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
                        <figcaption>'.$this->faker->paragraph.'</figcaption>
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
                'article_date' => $this->faker->date,
                'status' => 'Published',
                'link' => '/styleguide/'.config('base.news_view_route').'/item-1',
                'hero_image' => $hero,
                'featured' => $featured,
                'files' => [
                    0 => $hero,
                    1 => $featured,
                ],
                'favicon' => null,
                'user' => null,
                'applications' => null,
            ];

            $data['data'][$i] = array_replace_recursive($data['data'][$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            $data['data'] = current($data['data']);
        }

        $data['meta'] = [
            'total' => '',
            'per_page' => '',
            'current_page' => '',
            'last_page' => 3,
            'next_page_url' => '',
            'prev_page_url' => '',
        ];

        return $data;
    }
}
