<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularPromos(array $data)
    {
        return [
            'buttons' => app(\Factories\GenericPromo::class)->create(3),
            'image-promos' => app(\Factories\GenericPromo::class)->create(2),
            'spotlight' => app(\Factories\GenericPromo::class)->create(1, true),
            'steps' => app(\Factories\GenericPromo::class)->create(4),
            'text-promo' => app(\Factories\GenericPromo::class)->create(1, true),
            'video' => app(\Factories\GenericPromo::class)->create(1, true),
        ];
    }
}
