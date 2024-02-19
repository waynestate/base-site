<?php

namespace Styleguide\Repositories;

use App\Repositories\PromosExtendedRepository as Repository;
use Faker\Factory;
use Factories\GenericPromo;

class PromosExtendedRepository extends Repository
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
    public function getRequestData(array $data)
    {
        /*
        // Extend a Styleguide repository
        $promoRepoRequestData = Container::getInstance()->make(PromoRepository::class)->getRequestData($data);

        // Example page specific Hero
        if(!empty($data['page']['id']) && $data['page']['id'] === 99999) {
            $exampleHero = app(HeroImage::class)->create(1, false, [
                'option' => 'Half',
                'relative_url' => '/styleguide/image/1600x580?text=1920x1080',
                'filename_url' => '/styleguide/image/1600x580?text=1920x1080',
            ]);
        } else {
            $hero = $promoRepoRequestdata['hero'];
        }

        // Example addition to the Global Promos data
        if(!empty($data['page']['id']) && $data['page']['id'] === 99998) {
            $page_field_data = app(GenericPromo::class)->create(3, false, [
                'relative_url' => '/styleguide/image/800x600',
                'secondary_relative_url' => '/styleguide/image/100x100',
            ]);
        } else {
            $page_field_data = [];
        }

        /*
        return [
            'contact' => $promoRepoRequestData['contact'],
            'social' => $promoRepoRequestData['social'],
            'hero' => $hero,
            'under_menu' => $promoRepoRequestData['under_menu'],
        ];
         */
    }
}
