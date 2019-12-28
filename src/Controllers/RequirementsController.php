<?php

namespace Wqqas\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Wqqas\LaravelInstaller\Helpers\RequirementsChecker;

class RequirementsController extends Controller
{

    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
        $this->middleware('checkDemo');
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        if (env('APP_TYPE') != 'new'){
            return redirect('/')->with([
                'message'=> language_data('Invalid access'),
                'message_important' => true
            ]);
        }

        $requirements = $this->requirements->check(
            config('installer.requirements')
        );

        return view('vendor.installer.requirements', compact('requirements'));
    }
}
