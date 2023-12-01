<?php

/**
 * Merge data together and ensure duplicate keys can't exist by throwing an error.
 *
 * @return array
 * @throws Exception
 */
function merge()
{
    // Params passed in
    $params = func_get_args();

    // Data to return
    $merged = collect();

    foreach ((array) $params as $key => $value) {
        // Require only arrays
        if (!is_array($value)) {
            throw new Exception('Merged variables must be type array, but a ' . gettype($value) . ' was given. ' . "\n\n" . 'Value: ' . $value);
        }

        // Make sure every key has a string name
        collect($value)->each(function ($value, $key) {
            if (!is_string($key)) {
                throw new Exception('Merged variables must have key as a string, but a ' . gettype($key) . ' was given. ' . "\n\n Key: " . $key . "\n Values: " . (is_array($value) ? json_encode(array_keys($value)) : $value));
            }
        });

        // Make sure there aren't any similiar keys
        if (collect($value)->diffKeys($merged)->count() != count($value)) {
            throw new Exception('Array key conflict. Update your array to not conflict with other keys: ' . "\n\n Values:" . json_encode(array_keys($value)));
        }

        // Merge the arrays
        $merged = $merged->merge($value);
    }

    $merged = $merged->toArray();

    // Add computed title tag
    if (!empty($merged['base']) && !array_key_exists('title', $merged['base']['meta'])) {
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
