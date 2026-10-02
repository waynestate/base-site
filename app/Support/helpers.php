<?php

/**
 * Merge data together and ensure duplicate keys can't exist by throwing an error.
 *
 * @return array
 * @throws Exception
 */
function merge(...$params): array
{
    $merged = [];

    foreach ($params as $array) {
        if (!is_array($array)) {
            throw new Exception('Merged variables must be type array, but a ' . gettype($array) . ' was given. ' . "\n\n" . 'Value: ' . $array);
        }

        foreach ($array as $key => $value) {
            if (!is_string($key)) {
                throw new Exception('Merged variables must have key as a string, but a ' . gettype($key) . ' was given. ' . "\n\n Key: " . $key . "\n Values: " . (is_array($value) ? json_encode(array_keys($value)) : $value));
            }

            if (array_key_exists($key, $merged)) {
                throw new Exception('Array key conflict. Update your array to not conflict with other keys: ' . "\n\n Values:" . json_encode(array_keys($array)));
            }

            $merged[$key] = $value;
        }
    }

    if (
        !empty($merged['base']) &&
        !array_key_exists('title', !empty($merged['base']['meta']) ? $merged['base']['meta'] : [])
    ) {
        $merged['base']['meta']['title'] = stringify_page_title($merged['base']);
    }

    return $merged;
}

/**
 * Calculate the title tag based in priority information about the page
 *
 * @param array $data
 * @return string
 */
function stringify_page_title($data)
{
    $titles = [];
    $char_length = 0;

    // Page title (except homepages)
    if (!empty($data['page']['title'])
        && !empty($data['server']['path'])
        && $data['server']['path'] != '/'
        && $data['server']['path'] != rtrim($data['site']['subsite-folder'], '/')
    ) {
        $titles[] = $data['page']['title'];
        $char_length += strlen($data['page']['title']);
    }

    // Site title (if there is enough room)
    if (!empty($data['site']['title'])
        && ($char_length + 22) < 60
    ) {
        $titles[] = $data['site']['title'];
        $char_length += strlen($data['site']['title']);
    }

    // University name (if there is room)
    if (($char_length + 22) <= 70) {
        $titles[] = 'Wayne State University';
    }

    // Use dash separators
    return implode(' - ', $titles);
}

/**
 * Check if we are in the styleguide folder.
 *
 * @return bool
 */
function using_styleguide()
{
    return (config('app.env') == 'testing' || (!empty($_SERVER['REQUEST_URI']) && substr($_SERVER['REQUEST_URI'], 0, 11) == '/styleguide'));
}

/**
 * Swap an App\Http\Controllers class for its App\Http\Controllers\Custom override when one exists.
 */
function site_controller(string $controller): string
{
    $namespace = 'App\Http\Controllers\\';

    if (!str_starts_with($controller, $namespace)) {
        return $controller;
    }

    $site = $namespace . 'Custom\\' . substr($controller, strlen($namespace));

    return class_exists($site) ? $site : $controller;
}

/**
 * Get a modular component's view, preferring its site-specific version.
 */
function component_view(string $filename): string
{
    $site = 'site-specific/components/'.$filename;

    return view()->exists($site) ? $site : 'components/'.$filename;
}

/**
 * Recursively merge two arrays, with values from array2 replacing values from array1.
 * Indexed arrays are completely replaced, while associative arrays are merged recursively.
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function array_replace_recursive_distinct(array &$array1, array &$array2)
{
    $merged = $array1;

    foreach ($array2 as $key => &$value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key]) && !array_is_list($merged[$key])) {
            $merged[$key] = array_replace_recursive_distinct($merged[$key], $value);
        } else {
            $merged[$key] = $value;
        }
    }

    return $merged;
}
