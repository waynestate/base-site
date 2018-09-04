<?php

namespace Factories;

use Contracts\Factories\FactoryContract;
use Faker\Factory;

class ImageButton implements FactoryContract
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
    public function create($limit = 1, $flatten = false)
    {
        for ($i = 1; $i <= $limit; $i++) {
            $data[$i] = [
                'promo_group_id' => '',
                'link' => $this->faker->url,
                'relative_url' => $this->faker->boolean === true ? '/styleguide/image/360x131?text=360x131%20('.$i.')' : '',
                'secondary_image' => $this->faker->boolean === true ? "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHN0eWxlPi5zdDB7ZmlsbDojZmZmfTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM5IDI5LjFsLS42LS43LS45LTEuMmMtLjYtLjctMS40LS45LTEuOS0uNy01LjEgMS41LTggNC41LTkuNiA5LjUtLjIuNi4xIDEuNC42IDEuOWwuMS4xYzUuMSA0LjEgMTAuMSA4LjUgMTQuOSAxM2w4LjgtOC44Yy0zLjktNC4zLTcuOC04LjctMTEuNC0xMy4xem00LjYtMy4zbC0uOSAxLjRjLjguOSAxLjYgMS45IDIuMyAyLjgtLjYtMS41LTEuMS0yLjktMS40LTQuMnptMzAuMiAzNy44bC0xLjItLjktLjctLjdjLTQuNS0zLjctOC44LTcuNS0xMy0xMS41bC04LjggOC44YzQuNSA0LjggOC45IDkuOCAxMyAxNC45IDAgMCAwIC4xLjEuMS41LjUgMS4zLjcgMS45LjYgNS0xLjYgNy45LTQuNSA5LjUtOS41LjEtLjUtLjItMS4zLS44LTEuOC4xIDAgLjEgMCAwIDB6bS0uMS01LjNsMS40LS45Yy0xLjItLjQtMi43LS45LTQuMi0xLjUgMSAuOSAxLjkgMS43IDIuOCAyLjR6Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTTUwIDVDMjUuMSA1IDUgMjUuMSA1IDUwczIwLjEgNDUgNDUgNDUgNDUtMjAuMSA0NS00NVM3NC45IDUgNTAgNXptMzEuMSA1My41TDc2LjkgNjFjMi41IDIuNCAxLjQgNS42IDEuNCA1LjYtMS45IDYuMy01LjkgMTAuMy0xMi4yIDEyLjJINjZjLTIgLjQtNC4yLS4yLTUuNi0xLjdsLS4zLS4zQzU2LjMgNzIgNTIuMiA2Ny4zIDQ4IDYyLjljLTIuMiA0LTMuMyA3LjUtMy4yIDEwLjIgMCAuNC0uMy44LS43IDFzLS45IDAtMS4yLS4zbC0yLjMtMy0zLjMgMy40Yy0uMy4zLS43LjQtMS4xLjItLjEtLjEtLjMtLjEtLjQtLjItLjItLjItLjMtLjQtLjMtLjctLjEtMyAuNS02LjMgMS45LTkuOS0zLjYgMS40LTYuOSAyLjEtOS45IDEuOS0uMyAwLS41LS4xLS43LS4zLS4xLS4xLS4yLS4yLS4yLS40LS4xLS40IDAtLjguMi0xLjFsMy40LTMuMy0zLTIuM2MtLjQtLjMtLjUtLjctLjMtMS4yLjItLjQuNi0uNyAxLS43IDIuNy4xIDYuMi0xIDEwLjItMy4yLTQuNS00LjEtOS4xLTguMi0xMy45LTEybC0uMy0uM2MtMS41LTEuNS0yLjEtMy43LTEuNy01LjZWMzVjMS45LTYuMyA1LjktMTAuMyAxMi4yLTEyLjJoLjFjMS44LS41IDQgLjEgNS40IDEuNWwyLjYtNC4xYy40LS43IDEuMi0xIDItLjlzMS40LjcgMS42IDEuNWMwIC4xIDIuNyAxMC43IDcuNCAxOC40bDguNSA4LjVjNy43IDQuOCAxOC4zIDcuNCAxOC40IDcuNC44LjIgMS40LjggMS41IDEuNi4yLjYtLjIgMS40LS44IDEuOHoiLz48L3N2Zz4=" : '',
                'title' => ucfirst(implode(' ', $this->faker->words(2))),
                'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                'option' => '',
            ];

            if ($i === 1) {
                $data[$i] = [
                    'link' => $this->faker->url,
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'option' => '',
                ];
            };

            if ($i === 2) {
                $data[$i] = [
                    'link' => $this->faker->url,
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'option' => 'Bg gradient green',
                ];
            };

            if ($i === 3) {
                $data[$i] = [
                    'link' => $this->faker->url,
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => ucfirst(implode(' ', $this->faker->words(4))),
                    'option' => '',
                ];
            };

            if ($i === 4) {
                $data[$i] = [
                    'link' => $this->faker->url,
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => ucfirst(implode(' ', $this->faker->words(4))),
                    'option' => 'Bg gradient green',
                ];
            };

            if ($i === 5) {
                $data[$i] = [
                    'promo_group_id' => '',
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/131',
                    'secondary_image' => "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHN0eWxlPi5zdDB7ZmlsbDojZmZmfTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM5IDI5LjFsLS42LS43LS45LTEuMmMtLjYtLjctMS40LS45LTEuOS0uNy01LjEgMS41LTggNC41LTkuNiA5LjUtLjIuNi4xIDEuNC42IDEuOWwuMS4xYzUuMSA0LjEgMTAuMSA4LjUgMTQuOSAxM2w4LjgtOC44Yy0zLjktNC4zLTcuOC04LjctMTEuNC0xMy4xem00LjYtMy4zbC0uOSAxLjRjLjguOSAxLjYgMS45IDIuMyAyLjgtLjYtMS41LTEuMS0yLjktMS40LTQuMnptMzAuMiAzNy44bC0xLjItLjktLjctLjdjLTQuNS0zLjctOC44LTcuNS0xMy0xMS41bC04LjggOC44YzQuNSA0LjggOC45IDkuOCAxMyAxNC45IDAgMCAwIC4xLjEuMS41LjUgMS4zLjcgMS45LjYgNS0xLjYgNy45LTQuNSA5LjUtOS41LjEtLjUtLjItMS4zLS44LTEuOC4xIDAgLjEgMCAwIDB6bS0uMS01LjNsMS40LS45Yy0xLjItLjQtMi43LS45LTQuMi0xLjUgMSAuOSAxLjkgMS43IDIuOCAyLjR6Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTTUwIDVDMjUuMSA1IDUgMjUuMSA1IDUwczIwLjEgNDUgNDUgNDUgNDUtMjAuMSA0NS00NVM3NC45IDUgNTAgNXptMzEuMSA1My41TDc2LjkgNjFjMi41IDIuNCAxLjQgNS42IDEuNCA1LjYtMS45IDYuMy01LjkgMTAuMy0xMi4yIDEyLjJINjZjLTIgLjQtNC4yLS4yLTUuNi0xLjdsLS4zLS4zQzU2LjMgNzIgNTIuMiA2Ny4zIDQ4IDYyLjljLTIuMiA0LTMuMyA3LjUtMy4yIDEwLjIgMCAuNC0uMy44LS43IDFzLS45IDAtMS4yLS4zbC0yLjMtMy0zLjMgMy40Yy0uMy4zLS43LjQtMS4xLjItLjEtLjEtLjMtLjEtLjQtLjItLjItLjItLjMtLjQtLjMtLjctLjEtMyAuNS02LjMgMS45LTkuOS0zLjYgMS40LTYuOSAyLjEtOS45IDEuOS0uMyAwLS41LS4xLS43LS4zLS4xLS4xLS4yLS4yLS4yLS40LS4xLS40IDAtLjguMi0xLjFsMy40LTMuMy0zLTIuM2MtLjQtLjMtLjUtLjctLjMtMS4yLjItLjQuNi0uNyAxLS43IDIuNy4xIDYuMi0xIDEwLjItMy4yLTQuNS00LjEtOS4xLTguMi0xMy45LTEybC0uMy0uM2MtMS41LTEuNS0yLjEtMy43LTEuNy01LjZWMzVjMS45LTYuMyA1LjktMTAuMyAxMi4yLTEyLjJoLjFjMS44LS41IDQgLjEgNS40IDEuNWwyLjYtNC4xYy40LS43IDEuMi0xIDItLjlzMS40LjcgMS42IDEuNWMwIC4xIDIuNyAxMC43IDcuNCAxOC40bDguNSA4LjVjNy43IDQuOCAxOC4zIDcuNCAxOC40IDcuNC44LjIgMS40LjggMS41IDEuNi4yLjYtLjIgMS40LS44IDEuOHoiLz48L3N2Zz4=",
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'Icon dark',
                ];
            };

            if ($i === 6) {
                $data[$i] = [
                    'promo_group_id' => '',
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/132',
                    'secondary_image' => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNMzkgMjkuMWwtLjYtLjctLjktMS4yYy0uNi0uNy0xLjQtLjktMS45LS43LTUuMSAxLjUtOCA0LjUtOS42IDkuNS0uMi42LjEgMS40LjYgMS45bC4xLjFjNS4xIDQuMSAxMC4xIDguNSAxNC45IDEzbDguOC04LjhjLTMuOS00LjMtNy44LTguNy0xMS40LTEzLjF6TTQzLjYgMjUuOGwtLjkgMS40Yy44LjkgMS42IDEuOSAyLjMgMi44LS42LTEuNS0xLjEtMi45LTEuNC00LjJ6TTczLjggNjMuNmwtMS4yLS45LS43LS43Yy00LjUtMy43LTguOC03LjUtMTMtMTEuNWwtOC44IDguOGM0LjUgNC44IDguOSA5LjggMTMgMTQuOSAwIDAgMCAuMS4xLjEuNS41IDEuMy43IDEuOS42IDUtMS42IDcuOS00LjUgOS41LTkuNS4xLS41LS4yLTEuMy0uOC0xLjguMSAwIC4xIDAgMCAwek03My43IDU4LjNsMS40LS45Yy0xLjItLjQtMi43LS45LTQuMi0xLjUgMSAuOSAxLjkgMS43IDIuOCAyLjR6Ii8+PHBhdGggZD0iTTUwIDVDMjUuMSA1IDUgMjUuMSA1IDUwczIwLjEgNDUgNDUgNDUgNDUtMjAuMSA0NS00NVM3NC45IDUgNTAgNXptMzEuMSA1My41TDc2LjkgNjFjMi41IDIuNCAxLjQgNS42IDEuNCA1LjYtMS45IDYuMy01LjkgMTAuMy0xMi4yIDEyLjJINjZjLTIgLjQtNC4yLS4yLTUuNi0xLjdsLS4zLS4zQzU2LjMgNzIgNTIuMiA2Ny4zIDQ4IDYyLjljLTIuMiA0LTMuMyA3LjUtMy4yIDEwLjIgMCAuNC0uMy44LS43IDEtLjQuMi0uOSAwLTEuMi0uM2wtMi4zLTMtMy4zIDMuNGMtLjMuMy0uNy40LTEuMS4yLS4xLS4xLS4zLS4xLS40LS4yLS4yLS4yLS4zLS40LS4zLS43LS4xLTMgLjUtNi4zIDEuOS05LjktMy42IDEuNC02LjkgMi4xLTkuOSAxLjktLjMgMC0uNS0uMS0uNy0uMy0uMS0uMS0uMi0uMi0uMi0uNC0uMS0uNCAwLS44LjItMS4xbDMuNC0zLjMtMy0yLjNjLS40LS4zLS41LS43LS4zLTEuMi4yLS40LjYtLjcgMS0uNyAyLjcuMSA2LjItMSAxMC4yLTMuMi00LjUtNC4xLTkuMS04LjItMTMuOS0xMmwtLjMtLjNjLTEuNS0xLjUtMi4xLTMuNy0xLjctNS42VjM1YzEuOS02LjMgNS45LTEwLjMgMTIuMi0xMi4yaC4xYzEuOC0uNSA0IC4xIDUuNCAxLjVsMi42LTQuMWMuNC0uNyAxLjItMSAyLS45LjguMSAxLjQuNyAxLjYgMS41IDAgLjEgMi43IDEwLjcgNy40IDE4LjRsOC41IDguNWM3LjcgNC44IDE4LjMgNy40IDE4LjQgNy40LjguMiAxLjQuOCAxLjUgMS42LjIuNi0uMiAxLjQtLjggMS44eiIvPjwvc3ZnPg==",
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'Icon light',
                ];
            };

            if ($i === 7) {
                $data[$i] = [
                    'promo_group_id' => '',
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/133',
                    'secondary_image' => "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMTAwIDEwMCI+PHN0eWxlPi5zdDB7ZmlsbDojZmZmfTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM5IDI5LjFsLS42LS43LS45LTEuMmMtLjYtLjctMS40LS45LTEuOS0uNy01LjEgMS41LTggNC41LTkuNiA5LjUtLjIuNi4xIDEuNC42IDEuOWwuMS4xYzUuMSA0LjEgMTAuMSA4LjUgMTQuOSAxM2w4LjgtOC44Yy0zLjktNC4zLTcuOC04LjctMTEuNC0xMy4xem00LjYtMy4zbC0uOSAxLjRjLjguOSAxLjYgMS45IDIuMyAyLjgtLjYtMS41LTEuMS0yLjktMS40LTQuMnptMzAuMiAzNy44bC0xLjItLjktLjctLjdjLTQuNS0zLjctOC44LTcuNS0xMy0xMS41bC04LjggOC44YzQuNSA0LjggOC45IDkuOCAxMyAxNC45IDAgMCAwIC4xLjEuMS41LjUgMS4zLjcgMS45LjYgNS0xLjYgNy45LTQuNSA5LjUtOS41LjEtLjUtLjItMS4zLS44LTEuOC4xIDAgLjEgMCAwIDB6bS0uMS01LjNsMS40LS45Yy0xLjItLjQtMi43LS45LTQuMi0xLjUgMSAuOSAxLjkgMS43IDIuOCAyLjR6Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTTUwIDVDMjUuMSA1IDUgMjUuMSA1IDUwczIwLjEgNDUgNDUgNDUgNDUtMjAuMSA0NS00NVM3NC45IDUgNTAgNXptMzEuMSA1My41TDc2LjkgNjFjMi41IDIuNCAxLjQgNS42IDEuNCA1LjYtMS45IDYuMy01LjkgMTAuMy0xMi4yIDEyLjJINjZjLTIgLjQtNC4yLS4yLTUuNi0xLjdsLS4zLS4zQzU2LjMgNzIgNTIuMiA2Ny4zIDQ4IDYyLjljLTIuMiA0LTMuMyA3LjUtMy4yIDEwLjIgMCAuNC0uMy44LS43IDFzLS45IDAtMS4yLS4zbC0yLjMtMy0zLjMgMy40Yy0uMy4zLS43LjQtMS4xLjItLjEtLjEtLjMtLjEtLjQtLjItLjItLjItLjMtLjQtLjMtLjctLjEtMyAuNS02LjMgMS45LTkuOS0zLjYgMS40LTYuOSAyLjEtOS45IDEuOS0uMyAwLS41LS4xLS43LS4zLS4xLS4xLS4yLS4yLS4yLS40LS4xLS40IDAtLjguMi0xLjFsMy40LTMuMy0zLTIuM2MtLjQtLjMtLjUtLjctLjMtMS4yLjItLjQuNi0uNyAxLS43IDIuNy4xIDYuMi0xIDEwLjItMy4yLTQuNS00LjEtOS4xLTguMi0xMy45LTEybC0uMy0uM2MtMS41LTEuNS0yLjEtMy43LTEuNy01LjZWMzVjMS45LTYuMyA1LjktMTAuMyAxMi4yLTEyLjJoLjFjMS44LS41IDQgLjEgNS40IDEuNWwyLjYtNC4xYy40LS43IDEuMi0xIDItLjlzMS40LjcgMS42IDEuNWMwIC4xIDIuNyAxMC43IDcuNCAxOC40bDguNSA4LjVjNy43IDQuOCAxOC4zIDcuNCAxOC40IDcuNC44LjIgMS40LjggMS41IDEuNi4yLjYtLjIgMS40LS44IDEuOHoiLz48L3N2Zz4=",
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'Icon dark w/ img bg',
                ];
            };

            if ($i === 8) {
                $data[$i] = [
                    'promo_group_id' => '',
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/134',
                    'secondary_image' => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNMzkgMjkuMWwtLjYtLjctLjktMS4yYy0uNi0uNy0xLjQtLjktMS45LS43LTUuMSAxLjUtOCA0LjUtOS42IDkuNS0uMi42LjEgMS40LjYgMS45bC4xLjFjNS4xIDQuMSAxMC4xIDguNSAxNC45IDEzbDguOC04LjhjLTMuOS00LjMtNy44LTguNy0xMS40LTEzLjF6TTQzLjYgMjUuOGwtLjkgMS40Yy44LjkgMS42IDEuOSAyLjMgMi44LS42LTEuNS0xLjEtMi45LTEuNC00LjJ6TTczLjggNjMuNmwtMS4yLS45LS43LS43Yy00LjUtMy43LTguOC03LjUtMTMtMTEuNWwtOC44IDguOGM0LjUgNC44IDguOSA5LjggMTMgMTQuOSAwIDAgMCAuMS4xLjEuNS41IDEuMy43IDEuOS42IDUtMS42IDcuOS00LjUgOS41LTkuNS4xLS41LS4yLTEuMy0uOC0xLjguMSAwIC4xIDAgMCAwek03My43IDU4LjNsMS40LS45Yy0xLjItLjQtMi43LS45LTQuMi0xLjUgMSAuOSAxLjkgMS43IDIuOCAyLjR6Ii8+PHBhdGggZD0iTTUwIDVDMjUuMSA1IDUgMjUuMSA1IDUwczIwLjEgNDUgNDUgNDUgNDUtMjAuMSA0NS00NVM3NC45IDUgNTAgNXptMzEuMSA1My41TDc2LjkgNjFjMi41IDIuNCAxLjQgNS42IDEuNCA1LjYtMS45IDYuMy01LjkgMTAuMy0xMi4yIDEyLjJINjZjLTIgLjQtNC4yLS4yLTUuNi0xLjdsLS4zLS4zQzU2LjMgNzIgNTIuMiA2Ny4zIDQ4IDYyLjljLTIuMiA0LTMuMyA3LjUtMy4yIDEwLjIgMCAuNC0uMy44LS43IDEtLjQuMi0uOSAwLTEuMi0uM2wtMi4zLTMtMy4zIDMuNGMtLjMuMy0uNy40LTEuMS4yLS4xLS4xLS4zLS4xLS40LS4yLS4yLS4yLS4zLS40LS4zLS43LS4xLTMgLjUtNi4zIDEuOS05LjktMy42IDEuNC02LjkgMi4xLTkuOSAxLjktLjMgMC0uNS0uMS0uNy0uMy0uMS0uMS0uMi0uMi0uMi0uNC0uMS0uNCAwLS44LjItMS4xbDMuNC0zLjMtMy0yLjNjLS40LS4zLS41LS43LS4zLTEuMi4yLS40LjYtLjcgMS0uNyAyLjcuMSA2LjItMSAxMC4yLTMuMi00LjUtNC4xLTkuMS04LjItMTMuOS0xMmwtLjMtLjNjLTEuNS0xLjUtMi4xLTMuNy0xLjctNS42VjM1YzEuOS02LjMgNS45LTEwLjMgMTIuMi0xMi4yaC4xYzEuOC0uNSA0IC4xIDUuNCAxLjVsMi42LTQuMWMuNC0uNyAxLjItMSAyLS45LjguMSAxLjQuNyAxLjYgMS41IDAgLjEgMi43IDEwLjcgNy40IDE4LjRsOC41IDguNWM3LjcgNC44IDE4LjMgNy40IDE4LjQgNy40LjguMiAxLjQuOCAxLjUgMS42LjIuNi0uMiAxLjQtLjggMS44eiIvPjwvc3ZnPg==",
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'Icon light w/ img bg',
                ];
            };

            if ($i === 9) {
                $data[$i] = [
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/135',
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'Bg image dark',
                ];
            };

            if ($i === 10) {
                $data[$i] = [
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/136',
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'Bg image light',
                ];
            };


            if ($i === 11) {
                $data[$i] = [
                    'promo_group_id' => '',
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/137',
                    'secondary_image' => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNjAgMTMxIj48cGF0aCBkPSJNMTI3LjcgOTFoMTcuMnY1LjFoLTExLjZ2NC43aDExdjUuMWgtMTF2NS4xaDEyLjJ2NS4xaC0xNy44Vjkxek0xNTQgMTA3bC01LjgtOC4xaDYuM2wzLjEgNC43IDMtNC43aDZMMTYxIDEwN2w2LjcgOS4zaC02LjNsLTMuOC01LjgtNC4xIDUuOGgtNi4ybDYuNy05LjN6TTE4MCAxMTQuMWMtLjcuOS0xLjUgMS42LTIuNCAyLTEgLjQtMiAuNi0zLjEuNi0uOCAwLTEuNi0uMS0yLjMtLjMtLjctLjItMS40LS42LTItMS0uNi0uNS0xLTEtMS40LTEuNy0uMy0uNy0uNS0xLjQtLjUtMi4zIDAtMSAuMi0xLjguNi0yLjUuNC0uNy45LTEuMyAxLjUtMS43LjYtLjUgMS4zLS44IDIuMi0xLjEuOC0uMiAxLjYtLjQgMi41LS42LjktLjEgMS43LS4yIDIuNi0uMmgyLjRjMC0xLS4zLTEuNy0xLTIuMy0uNy0uNi0xLjUtLjgtMi40LS44LS45IDAtMS43LjItMi40LjYtLjcuNC0xLjQuOS0xLjkgMS41bC0yLjktMi45YzEtLjkgMi4yLTEuNiAzLjUtMi4xIDEuMy0uNSAyLjctLjcgNC4xLS43IDEuNiAwIDIuOS4yIDMuOS42IDEgLjQgMS44IDEgMi40IDEuNy42LjggMSAxLjcgMS4zIDIuOC4yIDEuMS40IDIuNC40IDMuOHY4LjhIMTgwdi0yLjJ6bS0xLjMtNS40Yy0uNCAwLS45IDAtMS41LjEtLjYgMC0xLjIuMS0xLjcuMy0uNi4yLTEgLjQtMS40LjctLjQuMy0uNi44LS42IDEuNCAwIC42LjMgMS4xLjggMS40LjUuMyAxLjEuNSAxLjcuNS41IDAgMS0uMSAxLjUtLjJzLjktLjMgMS4zLS42LjctLjYuOS0xYy4yLS40LjMtLjkuMy0xLjR2LTEuMWgtMS4zek0xODguMyA5OC45aDUuMXYyLjRoLjFjLjItLjMuNC0uNy43LTFzLjctLjYgMS4xLS45Yy40LS4zLjktLjUgMS41LS42LjUtLjIgMS4xLS4yIDEuOC0uMiAxLjIgMCAyLjMuMiAzLjIuNy45LjUgMS42IDEuMyAyLjEgMi40LjYtMS4xIDEuNC0xLjkgMi4yLTIuNC45LS41IDItLjcgMy4yLS43IDEuMiAwIDIuMS4yIDIuOS42czEuNC45IDEuOSAxLjZjLjUuNy44IDEuNSAxIDIuNC4yLjkuMyAxLjkuMyAyLjl2MTAuMkgyMTB2LTEwLjFjMC0uOC0uMi0xLjUtLjUtMi4xcy0xLS45LTEuOC0uOWMtLjYgMC0xLjEuMS0xLjYuMy0uNC4yLS43LjUtMSAuOC0uMi40LS40LjgtLjUgMS4yLS4xLjUtLjIgMS0uMiAxLjV2OS4ySDE5OVYxMDd2LTEuMWMwLS41LS4xLS45LS4yLTEuM3MtLjQtLjctLjctMWMtLjMtLjMtLjgtLjQtMS40LS40LS43IDAtMS4yLjEtMS43LjQtLjQuMi0uOC42LTEgMS0uMi40LS40LjktLjQgMS40LS4xLjUtLjEgMS4xLS4xIDEuNnY4LjZoLTUuNFY5OC45ek0yMTkuOSA5OC45aDQuOXYyLjNoLjFjLjItLjMuNS0uNi44LS45cy44LS42IDEuMi0uOWMuNS0uMyAxLS41IDEuNS0uNi41LS4yIDEuMS0uMiAxLjctLjIgMS4zIDAgMi40LjIgMy41LjcgMSAuNCAxLjkgMS4xIDIuNyAxLjlzMS4zIDEuNyAxLjcgMi44Yy40IDEuMS42IDIuMy42IDMuNiAwIDEuMi0uMiAyLjQtLjYgMy41LS40IDEuMS0uOSAyLjEtMS42IDIuOS0uNy45LTEuNSAxLjUtMi41IDIuMS0xIC41LTIuMS44LTMuMy44LTEuMSAwLTIuMi0uMi0zLjEtLjUtMS0uMy0xLjgtLjktMi40LTEuOGgtLjF2MTBoLTUuNFY5OC45em00LjkgOC43YzAgMS4zLjQgMi40IDEuMSAzLjIuNy44IDEuOCAxLjIgMy4yIDEuMiAxLjQgMCAyLjQtLjQgMy4yLTEuMi43LS44IDEuMS0xLjkgMS4xLTMuMiAwLTEuMy0uNC0yLjQtMS4xLTMuMi0uOC0uOC0xLjgtMS4yLTMuMi0xLjItMS40IDAtMi40LjQtMy4yIDEuMi0uOC44LTEuMSAxLjktMS4xIDMuMnpNMjQxLjkgODkuM2g1LjR2MjdoLTUuNHYtMjd6TTI2Ny41IDExMy4zYy0uOSAxLjEtMS45IDEuOS0zLjIgMi41LTEuMy42LTIuNy45LTQuMS45LTEuMyAwLTIuNi0uMi0zLjgtLjYtMS4yLS40LTIuMi0xLTMuMS0xLjgtLjktLjgtMS42LTEuOC0yLjEtMi45LS41LTEuMS0uNy0yLjQtLjctMy43IDAtMS40LjItMi42LjctMy43LjUtMS4xIDEuMi0yLjEgMi4xLTIuOS45LS44IDEuOS0xLjQgMy4xLTEuOCAxLjItLjQgMi40LS42IDMuOC0uNiAxLjIgMCAyLjQuMiAzLjQuNiAxIC40IDEuOSAxIDIuNiAxLjguNy44IDEuMiAxLjggMS42IDIuOS40IDEuMS42IDIuNC42IDMuN3YxLjdIMjU2Yy4yIDEgLjcgMS44IDEuNCAyLjQuNy42IDEuNi45IDIuNi45LjkgMCAxLjYtLjIgMi4yLS42czEuMS0uOSAxLjYtMS41bDMuNyAyLjd6bS00LjUtNy43YzAtLjktLjMtMS43LS45LTIuMy0uNi0uNi0xLjQtMS0yLjQtMS0uNiAwLTEuMS4xLTEuNi4zLS41LjItLjguNC0xLjIuNy0uMy4zLS42LjYtLjcgMS0uMi40LS4zLjgtLjMgMS4yaDcuMXpNMjkzLjkgMTAzLjJoLTQuN3Y1LjhjMCAuNSAwIC45LjEgMS4zIDAgLjQuMi43LjMgMSAuMi4zLjQuNS44LjcuMy4yLjguMiAxLjQuMi4zIDAgLjcgMCAxLjEtLjEuNS0uMS44LS4yIDEuMS0uNHY0LjVjLS42LjItMS4yLjQtMS45LjQtLjYuMS0xLjMuMS0xLjkuMS0uOSAwLTEuNy0uMS0yLjUtLjMtLjgtLjItMS40LS41LTItLjktLjYtLjQtMS0xLTEuMy0xLjYtLjMtLjctLjUtMS41LS41LTIuNHYtOC4yaC0zLjRWOTloMy40di01LjFoNS40Vjk5aDQuN3Y0LjJ6TTMxMy4xIDExMy4zYy0uOSAxLjEtMS45IDEuOS0zLjIgMi41LTEuMy42LTIuNy45LTQuMS45LTEuMyAwLTIuNi0uMi0zLjgtLjYtMS4yLS40LTIuMi0xLTMuMS0xLjgtLjktLjgtMS42LTEuOC0yLjEtMi45LS41LTEuMS0uNy0yLjQtLjctMy43IDAtMS40LjItMi42LjctMy43LjUtMS4xIDEuMi0yLjEgMi4xLTIuOS45LS44IDEuOS0xLjQgMy4xLTEuOCAxLjItLjQgMi40LS42IDMuOC0uNiAxLjIgMCAyLjQuMiAzLjQuNiAxIC40IDEuOSAxIDIuNiAxLjguNy44IDEuMiAxLjggMS42IDIuOS40IDEuMS42IDIuNC42IDMuN3YxLjdoLTEyLjRjLjIgMSAuNyAxLjggMS40IDIuNC43LjYgMS42LjkgMi42LjkuOSAwIDEuNi0uMiAyLjItLjZzMS4xLS45IDEuNi0xLjVsMy43IDIuN3ptLTQuNi03LjdjMC0uOS0uMy0xLjctLjktMi4zLS42LS42LTEuNC0xLTIuNC0xLS42IDAtMS4xLjEtMS42LjMtLjUuMi0uOC40LTEuMi43LS4zLjMtLjYuNi0uNyAxLS4yLjQtLjMuOC0uMyAxLjJoNy4xek0zMjEuOCAxMDdsLTUuOC04LjFoNi4zbDMuMSA0LjcgMy00LjdoNmwtNS42IDguMSA2LjcgOS4zSDMyOWwtMy44LTUuOC00LjEgNS44SDMxNWw2LjgtOS4zek0zNDguOCAxMDMuMmgtNC43djUuOGMwIC41IDAgLjkuMSAxLjMgMCAuNC4yLjcuMyAxIC4yLjMuNC41LjguNy4zLjIuOC4yIDEuNC4yLjMgMCAuNyAwIDEuMS0uMS41LS4xLjgtLjIgMS4xLS40djQuNWMtLjYuMi0xLjIuNC0xLjkuNC0uNi4xLTEuMy4xLTEuOS4xLS45IDAtMS43LS4xLTIuNS0uMy0uOC0uMi0xLjQtLjUtMi0uOS0uNi0uNC0xLTEtMS4zLTEuNi0uMy0uNy0uNS0xLjUtLjUtMi40di04LjJoLTMuNFY5OWgzLjR2LTUuMWg1LjRWOTloNC43djQuMnoiLz48L3N2Zz4=",
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'SVG overlay light',
                ];
            };

            if ($i === 12) {
                $data[$i] = [
                    'promo_group_id' => '',
                    'link' => $this->faker->url,
                    'relative_url' => 'http://placekitten.com/360/138',
                    'secondary_image' => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNjAgMTMxIj48cGF0aCBkPSJNMTI3LjcgOTFoMTcuMnY1LjFoLTExLjZ2NC43aDExdjUuMWgtMTF2NS4xaDEyLjJ2NS4xaC0xNy44Vjkxem0yNi4zIDE2bC01LjgtOC4xaDYuM2wzLjEgNC43IDMtNC43aDZMMTYxIDEwN2w2LjcgOS4zaC02LjNsLTMuOC01LjgtNC4xIDUuOGgtNi4ybDYuNy05LjN6bTI2IDcuMWMtLjcuOS0xLjUgMS42LTIuNCAyLTEgLjQtMiAuNi0zLjEuNi0uOCAwLTEuNi0uMS0yLjMtLjMtLjctLjItMS40LS42LTItMS0uNi0uNS0xLTEtMS40LTEuNy0uMy0uNy0uNS0xLjQtLjUtMi4zIDAtMSAuMi0xLjguNi0yLjUuNC0uNy45LTEuMyAxLjUtMS43LjYtLjUgMS4zLS44IDIuMi0xLjEuOC0uMiAxLjYtLjQgMi41LS42LjktLjEgMS43LS4yIDIuNi0uMmgyLjRjMC0xLS4zLTEuNy0xLTIuMy0uNy0uNi0xLjUtLjgtMi40LS44cy0xLjcuMi0yLjQuNi0xLjQuOS0xLjkgMS41bC0yLjktMi45YzEtLjkgMi4yLTEuNiAzLjUtMi4xczIuNy0uNyA0LjEtLjdjMS42IDAgMi45LjIgMy45LjZzMS44IDEgMi40IDEuN2MuNi44IDEgMS43IDEuMyAyLjguMiAxLjEuNCAyLjQuNCAzLjh2OC44SDE4MHYtMi4yem0tMS4zLTUuNGMtLjQgMC0uOSAwLTEuNS4xLS42IDAtMS4yLjEtMS43LjMtLjYuMi0xIC40LTEuNC43LS40LjMtLjYuOC0uNiAxLjRzLjMgMS4xLjggMS40IDEuMS41IDEuNy41Yy41IDAgMS0uMSAxLjUtLjJzLjktLjMgMS4zLS42LjctLjYuOS0xIC4zLS45LjMtMS40di0xLjFoLTEuM3YtLjF6bTkuNi05LjhoNS4xdjIuNGguMWMuMi0uMy40LS43LjctMXMuNy0uNiAxLjEtLjljLjQtLjMuOS0uNSAxLjUtLjYuNS0uMiAxLjEtLjIgMS44LS4yIDEuMiAwIDIuMy4yIDMuMi43czEuNiAxLjMgMi4xIDIuNGMuNi0xLjEgMS40LTEuOSAyLjItMi40LjktLjUgMi0uNyAzLjItLjdzMi4xLjIgMi45LjYgMS40LjkgMS45IDEuNi44IDEuNSAxIDIuNC4zIDEuOS4zIDIuOXYxMC4ySDIxMHYtMTAuMWMwLS44LS4yLTEuNS0uNS0yLjFzLTEtLjktMS44LS45Yy0uNiAwLTEuMS4xLTEuNi4zLS40LjItLjcuNS0xIC44LS4yLjQtLjQuOC0uNSAxLjItLjEuNS0uMiAxLS4yIDEuNXY5LjJIMTk5VjEwNS45YzAtLjUtLjEtLjktLjItMS4zcy0uNC0uNy0uNy0xLS44LS40LTEuNC0uNGMtLjcgMC0xLjIuMS0xLjcuNC0uNC4yLS44LjYtMSAxcy0uNC45LS40IDEuNGMtLjEuNS0uMSAxLjEtLjEgMS42djguNmgtNS40Vjk4LjloLjJ6bTMxLjYgMGg0Ljl2Mi4zaC4xYy4yLS4zLjUtLjYuOC0uOXMuOC0uNiAxLjItLjljLjUtLjMgMS0uNSAxLjUtLjYuNS0uMiAxLjEtLjIgMS43LS4yIDEuMyAwIDIuNC4yIDMuNS43IDEgLjQgMS45IDEuMSAyLjcgMS45czEuMyAxLjcgMS43IDIuOGMuNCAxLjEuNiAyLjMuNiAzLjYgMCAxLjItLjIgMi40LS42IDMuNS0uNCAxLjEtLjkgMi4xLTEuNiAyLjktLjcuOS0xLjUgMS41LTIuNSAyLjEtMSAuNS0yLjEuOC0zLjMuOC0xLjEgMC0yLjItLjItMy4xLS41LTEtLjMtMS44LS45LTIuNC0xLjhoLS4xdjEwaC01LjRWOTguOWguM3ptNC45IDguN2MwIDEuMy40IDIuNCAxLjEgMy4yLjcuOCAxLjggMS4yIDMuMiAxLjJzMi40LS40IDMuMi0xLjJjLjctLjggMS4xLTEuOSAxLjEtMy4yIDAtMS4zLS40LTIuNC0xLjEtMy4yLS44LS44LTEuOC0xLjItMy4yLTEuMnMtMi40LjQtMy4yIDEuMmMtLjguOC0xLjEgMS45LTEuMSAzLjJ6bTE3LjEtMTguM2g1LjR2MjdoLTUuNHYtMjd6bTI1LjYgMjRjLS45IDEuMS0xLjkgMS45LTMuMiAyLjUtMS4zLjYtMi43LjktNC4xLjktMS4zIDAtMi42LS4yLTMuOC0uNi0xLjItLjQtMi4yLTEtMy4xLTEuOC0uOS0uOC0xLjYtMS44LTIuMS0yLjlzLS43LTIuNC0uNy0zLjdjMC0xLjQuMi0yLjYuNy0zLjdzMS4yLTIuMSAyLjEtMi45Yy45LS44IDEuOS0xLjQgMy4xLTEuOHMyLjQtLjYgMy44LS42YzEuMiAwIDIuNC4yIDMuNC42czEuOSAxIDIuNiAxLjggMS4yIDEuOCAxLjYgMi45LjYgMi40LjYgMy43djEuN0gyNTZjLjIgMSAuNyAxLjggMS40IDIuNC43LjYgMS42LjkgMi42LjkuOSAwIDEuNi0uMiAyLjItLjZzMS4xLS45IDEuNi0xLjVsMy43IDIuN3ptLTQuNS03LjdjMC0uOS0uMy0xLjctLjktMi4zLS42LS42LTEuNC0xLTIuNC0xLS42IDAtMS4xLjEtMS42LjMtLjUuMi0uOC40LTEuMi43LS4zLjMtLjYuNi0uNyAxLS4yLjQtLjMuOC0uMyAxLjJoNy4xdi4xem0zMC45LTIuNGgtNC43djUuOGMwIC41IDAgLjkuMSAxLjMgMCAuNC4yLjcuMyAxIC4yLjMuNC41LjguNy4zLjIuOC4yIDEuNC4yLjMgMCAuNyAwIDEuMS0uMS41LS4xLjgtLjIgMS4xLS40djQuNWMtLjYuMi0xLjIuNC0xLjkuNC0uNi4xLTEuMy4xLTEuOS4xLS45IDAtMS43LS4xLTIuNS0uMy0uOC0uMi0xLjQtLjUtMi0uOXMtMS0xLTEuMy0xLjZjLS4zLS43LS41LTEuNS0uNS0yLjR2LTguMmgtMy40Vjk5aDMuNHYtNS4xaDUuNFY5OWg0Ljd2NC4yaC0uMXptMTkuMiAxMC4xYy0uOSAxLjEtMS45IDEuOS0zLjIgMi41LTEuMy42LTIuNy45LTQuMS45LTEuMyAwLTIuNi0uMi0zLjgtLjYtMS4yLS40LTIuMi0xLTMuMS0xLjhzLTEuNi0xLjgtMi4xLTIuOS0uNy0yLjQtLjctMy43YzAtMS40LjItMi42LjctMy43czEuMi0yLjEgMi4xLTIuOSAxLjktMS40IDMuMS0xLjggMi40LS42IDMuOC0uNmMxLjIgMCAyLjQuMiAzLjQuNnMxLjkgMSAyLjYgMS44IDEuMiAxLjggMS42IDIuOS42IDIuNC42IDMuN3YxLjdoLTEyLjRjLjIgMSAuNyAxLjggMS40IDIuNC43LjYgMS42LjkgMi42LjkuOSAwIDEuNi0uMiAyLjItLjZzMS4xLS45IDEuNi0xLjVsMy43IDIuN3ptLTQuNi03LjdjMC0uOS0uMy0xLjctLjktMi4zLS42LS42LTEuNC0xLTIuNC0xLS42IDAtMS4xLjEtMS42LjMtLjUuMi0uOC40LTEuMi43LS4zLjMtLjYuNi0uNyAxLS4yLjQtLjMuOC0uMyAxLjJoNy4xdi4xem0xMy4zIDEuNGwtNS44LTguMWg2LjNsMy4xIDQuNyAzLTQuN2g2bC01LjYgOC4xIDYuNyA5LjNIMzI5bC0zLjgtNS44LTQuMSA1LjhIMzE1bDYuOC05LjN6bTI3LTMuOGgtNC43djUuOGMwIC41IDAgLjkuMSAxLjMgMCAuNC4yLjcuMyAxIC4yLjMuNC41LjguNy4zLjIuOC4yIDEuNC4yLjMgMCAuNyAwIDEuMS0uMS41LS4xLjgtLjIgMS4xLS40djQuNWMtLjYuMi0xLjIuNC0xLjkuNC0uNi4xLTEuMy4xLTEuOS4xLS45IDAtMS43LS4xLTIuNS0uMy0uOC0uMi0xLjQtLjUtMi0uOXMtMS0xLTEuMy0xLjZjLS4zLS43LS41LTEuNS0uNS0yLjR2LTguMmgtMy40Vjk5aDMuNHYtNS4xaDUuNFY5OWg0Ljd2NC4yaC0uMXoiIGZpbGw9IiNmZmYiLz48L3N2Zz4=",
                    'title' => ucfirst(implode(' ', $this->faker->words(2))),
                    'excerpt' => $this->faker->boolean === true ? ucfirst(implode(' ', $this->faker->words(4))) : '',
                    'option' => 'SVG overlay dark',
                ];
            };
        }

        if ($limit === 1 && $flatten === true) {
            return current($data);
        }

        return $data;
    }
}
