<?php

namespace Styleguide\Repositories;

use App\Repositories\ModularPageRepository as Repository;
use Illuminate\Support\Str;

class ModularPageRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        // Run the page data through the modular repository
        $components = parent::getModularComponents($data);

        // Append factory promos
        foreach ($components as $key => $component) {
            if(! empty($component['component']['filename']) && ! empty($component['component']['factory'])) {
                $factoryPath = '\\Factories\\'.$component['component']['factory'];
                $components[$key]['data'] = app($factoryPath)->create($component['component']['limit'] ?? 1, false);
            }
        }

        // Now that we have promos, modify the data from getPromos()
        foreach($components as $componentName => $componentData) {
            // Adjust promo data
            $adjusted_promo_data= collect($componentData['data'])->map(function ($promoItem) use ($components, $componentName) {
                return $this->adjustPromoData($promoItem, $components[$componentName]['component']);
            })->toArray();

            // Organize by option
            if (! empty($componentData['component']['groupByOptions']) 
                && $componentData['component']['groupByOptions'] === true 
                && Str::startsWith($componentName, 'catalog')) 
            {
                $adjusted_promo_data = $this->organizePromoItemsByOption($adjusted_promo_data);
            }

            // Replace promo data
            $components[$componentName]['data'] = $adjusted_promo_data;
        }

        if(!empty($data['styleguide_accordion'])) {
            array_unshift($components, $data['styleguide_accordion']['accordion']);
        }

        return $components;
    }
}
