<?php

namespace App\Console\Commands;

use App\Models\Appliance\Appliance;
use App\Services\WishList\SmallAppliancesCrawler;
use Illuminate\Console\Command;

class ImportSmallAppliances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:small-appliances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Small Appliances from www.appliancesdelivered.ie';

    /**
     * @var SmallAppliancesCrawler
     */
    private $smallAppliancesCrawler;

    /**
     * Create a new command instance.
     *
     * @param SmallAppliancesCrawler $smallAppliancesCrawler
     */
    public function __construct(SmallAppliancesCrawler $smallAppliancesCrawler)
    {
        parent::__construct();
        $this->smallAppliancesCrawler = $smallAppliancesCrawler;
    }

    public function handle()
    {
        $this->smallAppliancesCrawler->importData(
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
