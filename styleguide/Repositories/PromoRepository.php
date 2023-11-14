<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoRepository as Repository;
use Factories\AccordionItems;
use Factories\FooterContact;
use Factories\FooterSocial;
use Factories\HeroImage;
use Factories\PromoPage;
use Factories\PromoPageWithOptions;
use Factories\UnderMenu;
use Faker\Factory;

class PromoRepository extends Repository
{
    /**
     * Construct the factory.
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
        ];

        // Only pull hero promos if they match the pages_ids that are specificed
        $hero = !empty($hero_page_ids[$data['page']['id']]) ? app(HeroImage::class)->create($hero_page_ids[$data['page']['id']]) : null;

        // Define the pages that the childpage accordion should show on page_id => quanity
        $accordion_page_ids = [
            107100 => 5,
        ];

        // Only pull accordion for childpage template
        $accordion = !empty($accordion_page_ids[$data['page']['id']]) ? app(AccordionItems::class)->create($accordion_page_ids[$data['page']['id']]) : null;

        // Get all the social icons
        $social = collect([
            'x',
            'twitter',
            'tiktok',
            'facebook',
            'instagram',
            'youtube',
            'snapchat',
            'linkedin',
            'flickr',
            'pinterest',
            'mastodon',
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
    public function getPromoView($id)
    {
        return [
            'promo' => app(PromoPage::class)->create(1, true, [
                'description' => '
                    <p>'.$this->faker->text(300).' <a href="https://wayne.edu">'.$this->faker->sentence(3).'</a></p>
                    <p>'.$this->faker->text(100).' <a href="https://wayne.edu">'.$this->faker->sentence(3).'</a> '. $this->faker->text(200).'</p>
                    <p>'.$this->faker->text(50).' <a href="https://wayne.edu">'.$this->faker->sentence(3).'</a> '. $this->faker->text(250).'</p>
                    <figure class="figure float-left mb-4 w-full md:w-1/2 lg:w-1/3">
                        <img src="/styleguide/image/600x450?text=Embedded in description" class="p-2" alt="">
                        <figcaption class="mt-1">This image is from the promotion description</figcaption>
                    </figure>
                    <p>'.$this->faker->text(200).' <a href="https://wayne.edu">'.$this->faker->sentence(3).'</a> '. $this->faker->text(100).'</p>
                    <p>'.$this->faker->text(200).' <a href="https://wayne.edu">'.$this->faker->sentence(3).'</a> '. $this->faker->text(100).'</p>
                    <p>'.$this->faker->text(300).' <a href="https://wayne.edu">'.$this->faker->sentence(3).'</a> '. $this->faker->text(100).'</p>
                ',
                'relative_url' => '/styleguide/image/600x450?text=Primary%20promo%20image'
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/promolist';
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoPagePromos(array $data, $limit = 75)
    {
        if ($data['page']['id'] === 101110200 || $data['page']['id'] === 101110400) {
            // No options
            $promos['promos'] = app(PromoPage::class)->create(12);
        } else {
            $promos['promos'] = app(PromoPageWithOptions::class)->create(12);
        }

        if (!empty($data['data']['promoPage'])) {
            $group_info = $this->parsePromoJSON($data);

            // Assign template markers to promos array
            $promos['template'] = $group_info;

            // Manage data with template flags
            $promos = $this->changePromoDisplay($promos, $group_info);
        }

        // Organize promos by option
        $promos = $this->organizePromoItemsByOption($promos);

        return $promos;
    }
}
