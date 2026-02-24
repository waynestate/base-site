<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentJsonLd extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentJsonLdController',
                'title' => 'JSON-LD Metadata',
                'id' => 125100,
                'content' => [
                    'main' => '',
                ],
            ],
            'data' => [
                'meta-json-ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Person',
                    'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
                    'honorificSuffix' => 'PhD, RN, CHFS',
                    'jobTitle' => $this->faker->jobTitle(),
                    'affiliation' => [
                        '@type' => 'CollegeOrUniversity',
                        'name' => 'Wayne State University',
                        'url' => 'https://wayne.edu',
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],
        ]);
    }
}
