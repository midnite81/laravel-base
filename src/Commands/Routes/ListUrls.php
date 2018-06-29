<?php

namespace Midnite81\LaravelBase\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Routing\Router;

class ListUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm81:urls:list {--verb }';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the route urls';

    /**
     * @var Router
     */
    protected $router;

    /**
     * Create a new command instance.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct();
        $this->router = $router;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routeCollection = $this->router->getRoutes();

        if ($routeCollection) {
            foreach ($routeCollection as $route) {
                if (! $this->option('verb') || in_array($this->option('verb'), $route->getMethods())) {
                    $this->info($route->getPath() . ' [' . implode(', ', $route->getMethods()) . ']');
                }
            }
        }
    }
}
