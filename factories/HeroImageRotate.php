<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class HeroImageRotate implements FactoryContract
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
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'title' => $this->faker->sentence(3),
                'description' => '<p>' . $this->faker->text(100) . ' <a href="https://wayne.edu">'. $this->faker->sentence(3)  .'</a></p>',
                'link' => 'https://wayne.edu',
                'relative_url' => '/styleguide/image/1600x580?text=Primary%20image%20('.$i.')',
                'filename_url' => '/styleguide/image/1600x580?text=Primary%20image%20('.$i.')',
                'filename_alt_text' => 'Example background image',
                'secondary_filename_url' => '/styleguide/image/400x250?text=Secondary%20image%20('.$i.')',
                'secondary_relative_url' => '/styleguide/image/400x250?text=Secondary%20image%20('.$i.')',
                'secondary_alt_text' => 'Example secondary image',
                'option' => $this->faker->randomElement(['Text Overlay', 'Half', 'Logo Overlay', 'Banner large']),
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
