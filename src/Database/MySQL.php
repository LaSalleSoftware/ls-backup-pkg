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
 * @see       https://packagist.org/packages/lasallesoftware/ls-backup-pkg
 * @see       https://github.com/LaSalleSoftware/ls-backup-pkg
 */

namespace Lasallesoftware\Backup\Database;

class MySQL
{
    /**
     * Get the MySQLDUMP command that will "dump" the database.
     *
     * @see https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html
     *
     * @return string
     */
    public static function getMySQLDumpCommand($filename = null)
    {
        if (is_null($filename)) {
            return;
        }


        $user             = env('DB_USERNAME');
        $password         = env('DB_PASSWORD');
        $path             = env('LASALLE_BACKUP_MYSQLDUMP_PATH');
        $databaseToBackup = env('DB_DATABASE');

        $command   = [$path.'mysqldump'];
        $command[] = '-u '.$user;

        //https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#option_mysqldump_password
        $command[] = '--password='.$password;


        // "--opt" is shorthand for --add-drop-table --add-locks --create-options --disable-keys --extended-insert
        // --lock-tables --quick --set-charset

        // "The --opt option turns on several settings that work together to perform a fast dump operation. 
        // All of these settings are on by default, because --opt is on by default. Thus you rarely if ever 
        // specify --opt. Instead, you can turn these settings off as a group by specifying --skip-opt, the 
        // optionally re-enable certain settings by specifying the associated options later on the command line.

        // https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#option_mysqldump_opt
        // https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#option_mysqldump_opt --> SCROLL DOWN TO "Option Groups"

        //$command[] = '--opt';
        $command[] = '--skip-opt';

        
        // All my database tables are the 'InnoDB' engine
        // https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#option_mysqldump_single-transaction
        if (env('LASALLE_BACKUP_SINGLE_TRANSACTION_OPTION') == 'yes') {
            $command[] = '--single-transaction';
        } else {
            $command[] = '--lock-all-tables';
        }

        // https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#mysqldump-option-summary
        $command[] = '--complete-insert';
        $command[] = '--add-drop-table';           
        $command[] = '--create-options ';
        $command[] = '--comments';
        $command[] = '--disable-keys';
        $command[] = '--dump-date';
        $command[] = '--set-charset';

        $command[] = $databaseToBackup;

        return implode(' ', $command).' > '.self::getLocalTemporaryBackupFolder().'/'.$filename;
    }

    /**
     * Get the file name of the saved file.
     */
    public static function getFileName(): string
    {
        return 'database-'.env('LASALLE_APP_DOMAIN_NAME').'-'.date('Ymd-His').'.sql';
    }

    /**
     * Get the local temporary backup folder location.
     */
    public static function getLocalTemporaryBackupFolder(): string
    {
        return storage_path('app/backup-temp');
    }
}
