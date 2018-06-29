<?php

namespace Midnite81\LaravelBase\Commands\Routes;

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
    protected $signature = 'm81:urls:list { --method=null } { --showMethods }';
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
        $verb = $this->option('method') == 'null' ? null : strtoupper($this->option('method'));

        if ($routeCollection) {
            foreach ($routeCollection as $route) {
                if (! $verb || in_array($verb, $route->getMethods())) {
                    $info = $route->getPath();
                    if ($this->option('showMethods')) {
                        $info .= ' [' . implode(', ', $route->getMethods()) . ']';
                    }
                    $this->info($info);
                }
            }
        }
    }
}
