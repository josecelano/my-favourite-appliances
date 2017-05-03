<?php

namespace App\Console\Commands;

use App\Models\Appliance\Appliance;
use App\Services\Wishlist\DishwashersCrawler;
use Illuminate\Console\Command;

class ImportDishwashers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dishwashers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Dishwashers from www.appliancesdelivered.ie';

    /**
     * @var DishwashersCrawler
     */
    private $dishwashersCrawler;

    /**
     * Create a new command instance.
     *
     * @param DishwashersCrawler $dishwashersCrawler
     */
    public function __construct(DishwashersCrawler $dishwashersCrawler)
    {
        parent::__construct();
        $this->dishwashersCrawler = $dishwashersCrawler;
    }

    public function handle()
    {
        $this->dishwashersCrawler->importData(
            function ($loadedPageUrl) {
                $this->info(sprintf('Loaded page: %s', $loadedPageUrl));
            },
            function (Appliance $appliance) {
                $this->info(sprintf('Imported: %s', $appliance->title));
            }
        );
        $this->info('Done!');
    }
}