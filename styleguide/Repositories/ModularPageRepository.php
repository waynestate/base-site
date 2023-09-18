<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\GenericPromo;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularPromos(array $data)
    {
        $promos['button-row'] = app(GenericPromo::class)->create(3, false, [
            'group' => [
                'heading' => 'Button row',
            ] 
        ]);
        $promos['button-column'] = app(GenericPromo::class)->create(3, false, [
            'group' => [
                'heading' => 'Button column',
            ] 
        ]);
        
        $promos['image-column'] = app(GenericPromo::class)->create(1, false, [
            'group' => [
                'heading' => 'Image column',
            ] 
        ]);

        $promos['image-grid'] = app(GenericPromo::class)->create(2, true, [
            'group' => [
                'heading' => 'Image grid',
                'columns' => '2',
            ] 
        ]);

        $promos['content-row-1'] = app(GenericPromo::class)->create(2, false, [
            'title' => 'Promo item title',
            'group' => [
                'heading' => 'Content row with heading',
            ] 
        ]);

        $promos['content-row-2'] = app(GenericPromo::class)->create(1, false, [
            'title' => 'Content row (Promo item title)',
        ]);

        $promos['content-column-1'] = app(GenericPromo::class)->create(1, false, [
            'title' => 'Content column (promo item title)',
        ]);

        $promos['content-column-2'] = app(GenericPromo::class)->create(1, false, [
            'title' => 'Promo item title',
            'group' => [
                'heading' => 'Content column with heading',
            ] 
        ]);

        $promos['accordion-1'] = app(GenericPromo::class)->create(3, true, [
            'group' => [
                'heading' => 'Accordion 1',
            ] 
        ]);

        $promos['accordion-2'] = app(GenericPromo::class)->create(3, true, [
            'group' => [
                'heading' => 'Accordion 2',
            ] 
        ]);

        $promos['video-row'] = app(GenericPromo::class)->create(1, true, [
            'group' => [
                'heading' => 'Video row',
            ] 
        ]);

        $promos['video-column'] = app(GenericPromo::class)->create(1, true, [
            'group' => [
                'heading' => 'Video column',
            ] 
        ]);

        //$promos['spotlight-1'] = app(GenericPromo::class)->create(3, true);

        $promos['steps-column'] = app(GenericPromo::class)->create(4, true, [
            'group' => [
                'heading' => 'Steps column',
            ] 
        ]);

        dump($promos);

        return $promos;
    }
}
