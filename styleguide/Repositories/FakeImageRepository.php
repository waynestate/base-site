<?php

namespace Styleguide\Repositories;

use Contracts\Repositories\FakeImageRepositoryContract;

class FakeImageRepository implements FakeImageRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function create($width = 150, $height = 150, $text = null)
    {
        // Create the image
        $image = imagecreatetruecolor($width, $height);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 180, 180, 180, 0));

        // Text that overlays on the image
        $overlay = $text !== null ? $text : $width . ' x ' . $height;

        // Overlay the text on the image
        $textwidth = strlen($overlay) * imagefontwidth(5);
        $xpos = ($width - $textwidth)/2;
        $ypos = ($height- imagefontheight(5))/2;
        imagestring($image, 5, $xpos, $ypos, $overlay, imagecolorallocatealpha($image, 255, 255, 255, 50));

        return $image;
    }

    /**
     * {@inheritdoc}
     */
    public function dimensions($size)
    {
        // Image size
        list($width, $height) = explode('x', $size);

        return [
            'width' => (int) $width,
            'height' => (int) $height,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function reasonableSize($dimensions)
    {
        return $dimensions['width'] * $dimensions['height'] < 9000000;
    }
}
