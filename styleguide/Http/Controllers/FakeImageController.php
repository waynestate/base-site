<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\FakeImageRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FakeImageController extends Controller
{
    /**
     * Construct the HomepageController.
     *
     * @param FakeImageRepositoryContract $image
     */
    public function __construct(FakeImageRepositoryContract $image)
    {
        $this->image = $image;
    }
    /**
     * Display an example accordion.
     *
     * @param Request $request
     * @return image/png
     */
    public function index(Request $request)
    {
        $dimensions = $this->image->dimensions($request->size);

        if (! $this->image->onSameHost('https://'.$request->server('HTTP_HOST'), $request->server('HTTP_REFERER'))) {
            return abort('404');
        }

        if (! $this->image->reasonableSize($dimensions)) {
            return abort('404');
        }

        $image = $this->image->create($dimensions['width'], $dimensions['height'], $request->text);

        imagepng($image);
        imagedestroy($image);

        return response(200)->header('Content-Type', 'image/png');
    }
}
