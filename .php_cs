<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/contracts')
    ->in(__DIR__ . '/factories')
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/styleguide')
    ->in(__DIR__ . '/tests');

$fixers = [
    '@PSR2' => true,
    'full_opening_tag' => true,
    'blank_line_after_namespace' => true,
    'class_definition' => true,
    'indentation_type' => true,
    'line_ending' => true,
    'method_argument_space' => ['ensure_fully_multiline' => true],
    'no_break_comment' => true,
    'no_closing_tag' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_blank_line_at_eof' => true,
    'single_class_element_per_statement' => ['elements' => ['property']],
    'single_import_per_statement' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'visibility_required' => true,
];

return Config::create()
    ->setFinder($finder)
    ->setRules($fixers)
    ->setUsingCache(true);
