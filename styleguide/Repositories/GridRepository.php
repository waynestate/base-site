<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoRepository as Repository;

class GridRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getGridPromos(int $page_id = null)
    {
        $grid_page_ids = [
            101106 => 15,
        ];

        // Only pull grid for childpage template
        $grid = !empty($grid_page_ids[$data['page']['id']]) ? app('Factories\Grid')->create($grid_page_ids[$data['page']['id']]) : null;

        return [
            // Grid page
            'grid' => $grid,
        ];
    }
}
