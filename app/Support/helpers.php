<?php
/**
 * Merge data together and ensure duplicate keys can't exist by throwing an error.
 *
 * @return array
 * @throws \Exception
 */
function merge()
{
    // Params passed in
    $params = func_get_args();

    // Data to return
    $merged = collect();

    foreach ((array) $params as $key => $value) {
        // Require only arrays
        if (! is_array($value)) {
            throw new \Exception('Merged variables must be type array, but a '.gettype($value).' was given. '."\n\n".'Value: '.$value);
        }

        // Make sure every key has a string name
        collect($value)->each(function ($value, $key) {
            if (! is_string($key)) {
                throw new \Exception('Merged variables must have key as a string, but a '.gettype($key).' was given. '."\n\n Key: ".$key."\n Values: ".json_encode(array_keys($value)));
            }
        });

        // Make sure there aren't any similiar keys
        if (collect($value)->diffKeys($merged)->count() != count($value)) {
            throw new \Exception('Array key conflict. Update your array to not conflict with other keys: '."\n\n Values:".json_encode(array_keys($value)));
        }

        // Merge the arrays
        $merged = $merged->merge($value);
    }

    return $merged->toArray();
}

/**
 * Check if we are in the styleguide folder.
 *
 * @return bool
 */
function using_styleguide()
{
    return (config('app.env') == 'testing' || (isset($_SERVER['REQUEST_URI']) && substr($_SERVER['REQUEST_URI'], 0, 11) == '/styleguide'));
}
