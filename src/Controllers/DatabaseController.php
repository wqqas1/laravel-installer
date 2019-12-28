<?php
//Just updating tag
namespace Wqqas\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Wqqas\LaravelInstaller\Helpers\DatabaseManager;

class DatabaseController extends Controller
{

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->middleware('checkDemo');
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        if (env('APP_TYPE') != 'new'){
            return redirect('/')->with([
                'message'=> language_data('Invalid access'),
                'message_important' => true
            ]);
        }

        $response = $this->databaseManager->migrateAndSeed();

        return redirect()->route('LaravelInstaller::setup')
                         ->with(['message' => $response]);
    }
}
