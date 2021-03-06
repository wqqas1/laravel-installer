<?php

namespace Wqqas\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Wqqas\LaravelInstaller\Helpers\EnvironmentManager;
use Wqqas\LaravelInstaller\Request\UpdateRequest;

/**
 * Class EnvironmentController
 * @package Wqqas\LaravelInstaller\Controllers
 */
class EnvironmentController extends Controller
{

    /**
     * @var EnvironmentManager
     */
    protected $environmentManager;

    /**
     * @param EnvironmentManager $environmentManager
     */
    public function __construct(EnvironmentManager $environmentManager)
    {
        $this->middleware('checkDemo');
        $this->environmentManager = $environmentManager;
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function environment()
    {
        $envConfig = $this->environmentManager->getEnvContent();

        return view('vendor.installer.environment', compact('envConfig'));
    }

    /**
     * @param UpdateRequest $request
     * @return string
     */
    public function save(UpdateRequest $request)
    {
        if (env('APP_TYPE') != 'new'){
            return redirect('/')->with([
                'message'=> language_data('Invalid access'),
                'message_important' => true
            ]);
        }

        $message = $this->environmentManager->saveFile($request);
        return $message;

    }

}
