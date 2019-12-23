# LaSalle Software's Backup Package

<p align="center">
<a href="https://packagist.org/packages/lasallesoftware/lsv2-backup-pkg"><img src="https://poser.pugx.org/lasallesoftware/lsv2-backup-pkg/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lasallesoftware/lsv2-backup-pkg"><img src="https://poser.pugx.org/lasallesoftware/lsv2-backup-pkg/license.svg" alt="License"></a>
</p>

Backup package for my LaSalle Software Version 2.

I want a very clean, and very lean, way to backup my admin app's database to Amazon Web Service's S3. So I created this package. This is likely the most self serving package of my LaSalle Software suite, because the code is so darn specific to my own needs.

I have drawn obvious inspiration from [Laravel Backup](https://github.com/spatie/laravel-backup) and [another Spatie package](https://github.com/spatie/db-dumper). And, from over a decade of using the incredible [Akeeba Backup](https://www.akeebabackup.com/). 

## Installation

#### Set up your AWS environment variables

In your .env file, specify your AWS parameters for this package. Please note that you can upload to a different AWS account or region or bucket or folders than specified in your default AWS settings. 

```
LASALLE_BACKUP_AWS_ACCESS_KEY_ID=
LASALLE_BACKUP_AWS_SECRET_ACCESS_KEY=
LASALLE_BACKUP_AWS_REGION=us-east-1
LASALLE_BACKUP_AWS_BUCKET=
LASALLE_BACKUP_AWS_FOLDER_PATH=
```

Leave ```LASALLE_BACKUP_AWS_FOLDER_PATH``` blank if there is no folder (ie, if you want to upload to your bucket only).

#### Set up your time zone environment variable

Specify your [time zone](https://www.php.net/manual/en/timezones.php) in the ```LASALLE_BACKUP_TIMEZONE``` enviornment variable. 

#### Set up your CRON job

If you want your backups to run automatically, set up a CRON job:

```* * * * * cd /path-to-your-project && php artisan lsbackup:databasebackup >> /dev/null 2>&1``` 

The above sets the backup to run every minute. Preferably, run it at, say, 4:00am nightly. 

Forge has a facility to [manage CRON entries](https://forge.laravel.com/docs/1.0/resources/scheduler.html). 

## Security

If you discover any security related issues, please email Bob Bloom at "bob dot bloom at lasallesoftware dot ca" instead of using the issue tracker.

## Links

* [Change Log](CHANGELOG.md)
* [MIT License File](LICENSE.md)