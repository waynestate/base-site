<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoRepository as Repository;

class PromoRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(int $page_id = null)
    {
        return [
            //'key' => app('Factories\YourFactory')->create(5),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data)
    {
        // Define the pages that have under menu promos: page_id => quanity
        $under_menu_page_ids = [
            100 => 4, // Styleguide
        ];

        // Only pull under_menu promos if they match the page_ids that are specified
        $under_menu = !empty($under_menu_page_ids[$data['page']['id']]) ? app('Factories\UnderMenu')->create($under_menu_page_ids[$data['page']['id']]) : null;

        // Define the pages that have hero images: page_id => quanity
        $hero_page_ids = [
            101101 => 1, // Homepage
            105100100 => 1, // Hero Contained
            105100101 => 3, // Hero Contained - Rotate
            105100102 => 1, // Hero Contained - Text overlay
            105100103 => 1, // Hero Full
            105100104 => 3, // Hero Full - Rotate
            105100105 => 1, // Hero Full - Text overlay
            105100106 => 1, // Hero Full - SVG Overlay
            105100107 => 1, // Hero Full - Logo overlay
        ];

        // Only pull hero promos if they match the pages_ids that are specificed
        $hero = !empty($hero_page_ids[$data['page']['id']]) ? app('Factories\HeroImage')->create($hero_page_ids[$data['page']['id']]) : null;

        // Define the pages that the childpage accordion should show on page_id => quanity
        $accordion_page_ids = [
            107100 => 5,
        ];

        // Only pull accordion for childpage template
        $accordion = !empty($accordion_page_ids[$data['page']['id']]) ? app('Factories\Accordion')->create($accordion_page_ids[$data['page']['id']]) : null;

        // Get all the social icons
        $social = collect([
            'twitter',
            'facebook',
            'instagram',
            'linkedin',
            'flickr',
            'pinterest',
            'youtube',
            'snapchat',
        ])->map(function ($name) {
            return app('Factories\FooterSocial')->create(1, true, ['title' => $name]);
        })
        ->reject(function ($item) {
            return empty($item);
        })
        ->toArray();

        return [
            'contact' => app('Factories\FooterContact')->create(1),
            'social' => $social,
            'hero' => $hero,
            'under_menu' => $under_menu,
            'accordion_page' => $accordion,
        ];
    }
}
