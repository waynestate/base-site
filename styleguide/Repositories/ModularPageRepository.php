<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;
use Factories\HeroImage;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        $components = [];
        /*
        $components = [
            'hero-1' => [
                'data' => app(HeroImage::class)->create(1, false),
                'component' => [
                    'filename' => 'hero',
                ],
            ],
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Four column catalog',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
        ];
         */

        return $components;
    }
}
