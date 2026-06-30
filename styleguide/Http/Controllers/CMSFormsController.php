<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Waynestate\FormyParser\Parser;

class CMSFormsController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Display the form view.
     */
    public function index(Request $request): View
    {
        $form['form'] = $this->parser->parse('[form id="base-test"]');

        return view('styleguide-cms-forms', merge($request->data, $form));
    }
}
