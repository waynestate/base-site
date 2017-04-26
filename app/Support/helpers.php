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

if (! function_exists('elixir')) {
    /**
     * Get the path to a versioned elixir file.
     *
     * @param string $file
     * @param string $buildDirectory
     * @return string
     * @throws \InvalidArgumentException
     */
    function elixir($file, $buildDirectory = '_resources/build')
    {
        static $manifest = [];
        static $manifestPath;

        if (empty($manifest) || $manifestPath !== $buildDirectory) {
            $path = app()->basePath('public/'.$buildDirectory.'/rev-manifest.json');

            if (file_exists($path)) {
                $manifest = json_decode(file_get_contents($path), true);
                $manifestPath = $buildDirectory;
            }
        }

        if (isset($manifest[$file])) {
            return '/'.trim($buildDirectory.'/'.$manifest[$file], '/');
        }

        $unversioned = app()->basePath('public/_resources/'.$file);

        if (file_exists($unversioned)) {
            return '/'.trim('_resources/'.$file, '/');
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}
