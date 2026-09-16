<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Faker\Factory;
use Factories\GenericPromo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComponentListservSubscribeController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Listserv Subscribe Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '';

        $components = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'component_config',
                        'description' => '',
                        'tr1' => [
                            'Page field' => 'modular-listserv-subscribe-row-1',
                            'Data' => '{
"id":000000,
"config":"limit:1",
"list":"your-list-slug",
"form_id":"0000",
"sitekey":"your-recaptcha-sitekey"
}',
                        ],
                        'tr2' => [
                            'Page field' => 'modular-listserv-subscribe-row-2',
                            'Data' => '{
"heading":"Stay connected",
"id":000000,
"config":"limit:1",
"list":"your-list-slug",
"form_id":"0000",
"sitekey":"your-recaptcha-sitekey",
"campaign":{
"utm_source":"base",
"utm_medium":"web"
}
}',
                        ],
                    ],
                    1 => [
                        'title' => 'Field details',
                        'promo_item_id' => 'promo_details',
                        'description' => '',
                        'table' => [
                            'list' => 'Required. Formy subscriptions list slug, used for the form action and the f_28436 hidden field.',
                            'form_id' => 'Required. The Formy form id, e.g. "4970" from "form-4970".',
                            'sitekey' => 'Required. Google reCAPTCHA site key tied to that Formy form.',
                            'id' => 'Optional. Promotion group ID that populates the heading, description, and image.',
                            'config' => 'Optional. Promotion config, defaults to "limit:1".',
                            'campaign' => 'Optional. Extra query params appended to the form action, e.g. UTM tracking.',
                            'heading' => 'Optional. Section heading displayed above the component container.',
                            'formHeading' => 'Optional. Fallback form heading used when no promotion group is connected.',
                        ],
                    ],
                    2 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promo_details',
                        'description' => '',
                        'table' => [
                            'Title' => 'Heading in the component (e.g. "Subscribe to our newsletter").',
                            'Description' => 'Optional descriptive text displayed above the form.',
                            'Primary image' => 'Optional image or icon displayed alongside the form. The column collapses when omitted.',
                        ],
                    ],
                ],
                'component' => [
                    'filename' => 'accordion-styleguide',
                ],
            ],
            'listserv-subscribe-row-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Subscribe to our newsletter',
                    'description' => '<p>Get the latest updates, event invitations, and research stories delivered directly to your inbox.</p>',
                    'relative_url' => '/styleguide/image/400x400?text=400x400',
                    'filename_alt_text' => 'Newsletter graphic',
                ]),
                'component' => [
                    'heading' => 'Stay connected',
                    'filename' => 'listserv-subscribe-row',
                    'list' => 'styleguide-example-list',
                    'form_id' => '0000',
                    'sitekey' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
                ],
            ],
            'listserv-subscribe-row-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Join the department listserv',
                    'description' => '<p>Subscribe to receive important campus news and announcements.</p>',
                    'relative_url' => '',
                ]),
                'component' => [
                    'filename' => 'listserv-subscribe-row',
                    'list' => 'styleguide-example-list',
                    'form_id' => '0000',
                    'sitekey' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
                ],
            ],
            'listserv-subscribe-row-3' => [
                'data' => [[]],
                'component' => [
                    'visibility' => 'always',
                    'formHeading' => 'Subscribe without a promo group',
                    'filename' => 'listserv-subscribe-row',
                    'list' => 'styleguide-example-list',
                    'form_id' => '0000',
                    'sitekey' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
