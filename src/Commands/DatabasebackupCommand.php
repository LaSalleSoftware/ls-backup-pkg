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
 * @copyright  (c) 2019-2020 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see       https://lasallesoftware.ca
 * @see       https://packagist.org/packages/lasallesoftware/ls-backup-pkg
 * @see       https://github.com/LaSalleSoftware/ls-backup-pkg
 */

namespace Lasallesoftware\Backup\Commands;

// Laravel class
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// LaSalle Software classes
use Lasallesoftware\Backup\Database\MySQL;
use Lasallesoftware\Library\Common\Commands\CommonCommand;
// Symfony class
use Symfony\Component\Process\Process;

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

    public function handle()
    {
        // STEP 1: get the backup's filename
        $fileName = MySQL::getFileName();

        // STEP 2: set contstants
        // 5 minute timeout, yes I am hardcoding this number
        $timeout = 60 * 5;

        // STEP 3: figure out the mysqldump command
        $mysqldumpCommand = MySQL::getMySQLDumpCommand($fileName);

        // STEP 4: if this is the first time running a backup, then create the local temporary folder
        if (!file_exists(MySQL::getLocalTemporaryBackupFolder())) {
            mkdir(MySQL::getLocalTemporaryBackupFolder(), 0755, true);
        }

        // STEP 5: run the mysqldump command

     //   echo "\n\n The mysqldump command = " . $mysqldumpCommand . "\n\n";

        // https://symfony.com/doc/current/components/process.html
        $process = Process::fromShellCommandline($mysqldumpCommand, null, null, null, $timeout);
        $process->run();

        // STEP 6: upload the newly created database "dump" file to AWS S3
        $AwsPath = $this->bookendWithSlash(env('LASALLE_BACKUP_AWS_FOLDER_PATH'));

        $storage = Storage::createS3Driver([
            'driver' => 's3',
            'key' => env('LASALLE_BACKUP_AWS_ACCESS_KEY_ID'),
            'secret' => env('LASALLE_BACKUP_AWS_SECRET_ACCESS_KEY'),
            'region' => env('LASALLE_BACKUP_AWS_REGION'),
            'bucket' => env('LASALLE_BACKUP_AWS_BUCKET'),
        ]);

        $storage->put($AwsPath.$fileName, file_get_contents(MySQL::getLocalTemporaryBackupFolder().'/'.$fileName));

        // STEP 7: Delete the newly created database "dump" file from the local folder
        //         CHANGED to deleting all sql files
        //$command = 'rm '.MySQL::getLocalTemporaryBackupFolder().'/'.$fileName;
        $command = 'rm '.MySQL::getLocalTemporaryBackupFolder().'/*.sql';

        $process = Process::fromShellCommandline($command, null, null, null, $timeout);
        $process->run();

     
        $this->info('  ' . $this->name . 'is finished!');
    }

    /**
     * Start and end a string with '/'.
     *
     * @param string $text
     */
    protected function bookendWithSlash($text): string
    {
        if ('/' != Str::substr($text, 0, 1)) {
            $text = '/'.$text;
        }

        if ('/' != Str::substr($text, -1, 1)) {
            $text .= '/';
        }

        return $text;
    }
}
