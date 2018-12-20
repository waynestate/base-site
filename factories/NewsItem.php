<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class NewsItem implements FactoryContract
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
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'news_id' => $i,
                'app_id' => $this->faker->randomDigit,
                'slug' => $this->faker->slug,
                'title' => $this->faker->sentence(rand(6, 10)),
                'posted' => $this->faker->date,
                'excerpt' => '',
                'archive' => 1,
                'link' => '',
                'full_link' => '/styleguide/'.config('base.news_view_route').'/item-1',
                'filename' => '/styleguide/image/1600x580',
                'filename_url_relative' => '/styleguide/image/1600x580',
                'filename_url_absolute' => '/styleguide/image/1600x580',
                'categories' => null,
                'body' => '<p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(8).'</p>
                <figure class="figure" style="padding-bottom:10px; float:right">
                    <img alt="Placeholder" height="400" src="/styleguide/image/300x400?text=Figure%20float%20right" style="padding:10px" width="300">
                    <figcaption>'.$this->faker->paragraph.'</figcaption>
                </figure>
                <p>'.$this->faker->paragraph.'</p>
                <blockquote>
                    <p>'.$this->faker->paragraph(1).'</p>
                </blockquote>
                <p>'.$this->faker->paragraph(8).'</p>
                <p>'.$this->faker->paragraph(8).'</p>
                <blockquote>
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
                <blockquote>
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

            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
