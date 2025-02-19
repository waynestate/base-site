<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Factories\AccordionItems;
use Factories\ArticleMeta;
use Factories\ArticleComponent;
use Factories\Button;
use Factories\Event;
use Factories\GenericPromo;
use Factories\HeroImage;
use Factories\Icon;
use Factories\IconsRow;
use Factories\Spotlight;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        $components = parent::getModularComponents($data);

        foreach($components as $key => $component) {

            // Transform filename into factory name
            $factoryName = str_replace(['row', 'column', '-', '_'], '', $component['component']['filename']);
            $factoryPath = '\\Factories\\'.ucwords($factoryName, '-');

            // Load factory
            $components[$key]['data'] = app($factoryPath)->create($component['component']['limit'] ?? 1, false);
        }

        return $components;
    }
}
