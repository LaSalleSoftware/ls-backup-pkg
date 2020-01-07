# Installing LaSalle Software's Backup Package 

## Set up your AWS environment variables

In your .env file, specify your AWS parameters for this package. Please note that you can upload to a different AWS account or region or bucket or folders than specified in your default AWS settings. 

```
LASALLE_BACKUP_AWS_ACCESS_KEY_ID=
LASALLE_BACKUP_AWS_SECRET_ACCESS_KEY=
LASALLE_BACKUP_AWS_REGION=us-east-1
LASALLE_BACKUP_AWS_BUCKET=
LASALLE_BACKUP_AWS_FOLDER_PATH=
```

Leave ```LASALLE_BACKUP_AWS_FOLDER_PATH``` blank if there is no folder (ie, if you want to upload to your bucket only).

## Set up your time zone environment variable

Specify your [time zone](https://www.php.net/manual/en/timezones.php) in the ```LASALLE_BACKUP_TIMEZONE``` enviornment variable. 

## Set up your path to the mysqldump command

If you need to specify the path to the mysqldump command, then do so here. Please include a trailing slash. For example, the MAMP Pro path to mysqldump is:

```LASALLE_BACKUP_MYSQLDUMP_PATH=/Applications/MAMP/Library/bin/```

If you do not need to specify the path, the please just leave it blank:

```LASALLE_BACKUP_MYSQLDUMP_PATH=```

## Set up your single transaction option environment variable

If all your database tables are the InnoDB engine, then you should use the --single-transaction option with mysqldump:

```LASALLE_BACKUP_SINGLE_TRANSACTION_OPTION=yes```

See [https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#option_mysqldump_single-transaction](https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#option_mysqldump_single-transaction).

## Set up your CRON job

If you want your backups to run automatically, set up a CRON job:

```* * * * * cd /path-to-your-project && php artisan lsbackup:databasebackup >> /dev/null 2>&1``` 

The above sets the backup to run every minute. Preferably, run it at, say, 4:00am nightly. 

Forge has a facility to [manage CRON entries](https://forge.laravel.com/docs/1.0/resources/scheduler.html). 
