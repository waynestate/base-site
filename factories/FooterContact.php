<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class FooterContact implements FactoryContract
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
            $title = '';

            if ($i == 2) {
                $title = '<h2><a href="'.$this->faker->url.'">'.$this->faker->words(3, true).'</a></h2>';
            } elseif ($i == 3) {
                $title = '<h2>'.$this->faker->words(3, true).'</h2>';
            }

            $data[$i] = [
                'link' => '/',
                'title' => $this->faker->sentence,
                'description' =>
                    $title.
                    '<p>
                        ' .$this->faker->name.'<br />
                        ' .$this->faker->streetAddress.'<br />
                        ' .$this->faker->city.', '.$this->faker->state.' '.$this->faker->postcode.'<br />
                        <a href="'.$this->faker->url.'">'.$this->faker->word.'</a>
                    </p>',
            ];

            $data[$i] = array_replace_recursive($data[$i], $options);
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
