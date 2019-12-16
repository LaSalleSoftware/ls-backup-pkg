<?php

/**
 * This file is part of the Lasalle Software backup package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see       https://lasallesoftware.ca
 * @see       https://packagist.org/packages/lasallesoftware/lsv2-backup-pkg
 * @see       https://github.com/LaSalleSoftware/lsv2-backup-pkg
 */

namespace Lasallesoftware\Backup\Commands;

// LaSalle Software class
use Illuminate\Console\ConfirmableTrait;
// Laravel classes
use Lasallesoftware\Library\Common\Commands\CommonCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class DatabasebackupCommand.
 *
 * Backup the database.
 *
 * Adapted from
 * https://github.com/laravel/framework/blob/5.7/src/Illuminate/Database/Console/Migrations/FreshCommand.php
 */
class DatabasebackupCommand extends CommonCommand
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lsbackup:databasebackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The LaSalle Software custom database backup command.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "\n\n====================================================================\n";
        echo '              ** start lsbackup:databasebackup **';
        echo "\n====================================================================\n";

        /*
        if ('production' == strtolower(app('config')->get('app.env'))) {
            $this->info('Cancelled running lslibrary:customdrop because this is a production environment.');

            return;
        }

        if (!$this->confirm('Do you really want to drop your database?')) {
            $this->info('Did not drop database tables because you did not confirm.');

            return;
        }

        $database = $this->input->getOption('database');

        //$this->dropAllViews($database);
        //$this->info('Dropped all views successfully.');

        $this->dropAllTables($database);

        $this->info('  ...just successfully dropped all your database tables...');

        echo "\n  -------------------------------\n";
        if ($this->confirm('  *** do you want to run php artisan migrate? ***')) {
            $this->call('migrate');
            echo "\n";
            $this->info('  ...just ran php artisan migrate...');
        } else {
            $this->info(' (did *not* run php artisan migrate)');
        }

        echo "\n  -------------------------------\n";
        if ($this->confirm('  *** do you want to run php artisan lslibrary:customseed?***')) {
            $this->call('lslibrary:customseed');
            echo "\n";
            $this->info('  ...just ran php artisan lslibrary:customseed...');
        } else {
            $this->info(' (did *not* run php artisan lslibrary:customseed)');
        }

        //echo "\n\n";

        echo "\n\n====================================================================\n";
        echo '              ** lslibrary:customdrop is finished **';
        echo "\n====================================================================\n\n";

        */
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use'],
        ];
    }
}
