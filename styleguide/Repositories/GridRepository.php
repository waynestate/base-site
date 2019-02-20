<?php

namespace Styleguide\Repositories;

use App\Repositories\GridRepository as Repository;

class GridRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getGridPromos(array $data, $limit = 75)
    {
        return [
            // Contact footer
            'grid_promos' => app('Factories\Grid')->create(15),
        ];
    }
}
