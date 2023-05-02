<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoRepository as Repository;
use Factories\Accordion;
use Factories\FooterContact;
use Factories\FooterSocial;
use Factories\HeroImage;
use Factories\PromoListing;
use Factories\PromoPage;
use Factories\UnderMenu;
use Faker\Factory;

class PromoRepository extends Repository
{
    /**
     * Construct the factory.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos(int $page_id = null)
    {
        return [
            //'key' => app(\Factories\YourFactory::class)->create(5),
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
        $under_menu = !empty($under_menu_page_ids[$data['page']['id']]) ? app(UnderMenu::class)->create($under_menu_page_ids[$data['page']['id']]) : null;

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
        $hero = !empty($hero_page_ids[$data['page']['id']]) ? app(HeroImage::class)->create($hero_page_ids[$data['page']['id']]) : null;

        // Define the pages that the childpage accordion should show on page_id => quanity
        $accordion_page_ids = [
            107100 => 5,
        ];

        // Only pull accordion for childpage template
        $accordion = !empty($accordion_page_ids[$data['page']['id']]) ? app(Accordion::class)->create($accordion_page_ids[$data['page']['id']]) : null;

        // Get all the social icons
        $social = collect([
            'twitter',
            'tiktok',
            'facebook',
            'instagram',
            'youtube',
            'snapchat',
            'linkedin',
            'flickr',
            'pinterest',
        ])->map(function ($name) {
            return app(FooterSocial::class)->create(1, true, ['title' => $name]);
        })
        ->reject(function ($item) {
            return empty($item);
        })
        ->toArray();

        return [
            'contact' => app(FooterContact::class)->create(1),
            'social' => $social,
            'hero' => $hero,
            'under_menu' => $under_menu,
            'accordion_page' => $accordion,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoListingPromos(array $data, $limit = 75)
    {
        return [
            'promos' => app(PromoListing::class)->create(15),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoView($id)
    {
        return [
            'promo' => app(PromoListing::class)->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/promolisting';
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoPagePromos(array $data, $limit = 75)
    {
        $promos['promos'] = app(PromoPage::class)->create(12);

        if (!empty($data['data']['options'])) {
            $promos['promos'] = app(PromoPage::class)->create(12);
            $promos['template']['group_by_options'] = true;
            $promos['template']['columns'] = $this->faker->randomElement(['', 2, 3, 4]);

            // Organize promos by option
            $promos = $this->organizePromoItemsByOption($promos);

            dump($promos['template']['columns']);
        } else {
            $promos['template']['group_by_options'] = '';
        }

        return $promos;
    }
}
