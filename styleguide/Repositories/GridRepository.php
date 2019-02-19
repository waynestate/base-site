<?php

namespace Styleguide\Repositories;

use App\Repositories\GridRepository as Repository;

class GridRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getGridPromos()
    {
        return [
            // Contact footer
            'grid_promos' => app('Factories\Grid')->create(15),
        ];
    }
}
