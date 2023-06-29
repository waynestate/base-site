<?php

namespace Styleguide\Repositories;

use App\Repositories\PromoPageRepository as Repository;
use Factories\PromoPage;
use Factories\PromoPageWithOptions;
use Faker\Factory;

class PromoPageRepository extends Repository
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

            // Set number of columns
            $promos['template']['columns'] = $group_info['columns'];

            // Manage data with template flags
            $promos = $this->changePromoItemDisplay($promos, $group_info);
        }

        // Organize promos by option
        $promos = $this->organizePromoItemsByOption($promos);

        return $promos;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/promolist';
    }
}
