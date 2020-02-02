# LaSalle Software's Backup Package

<p align="center">
<a href="https://packagist.org/packages/lasallesoftware/lsv2-backup-pkg"><img src="https://poser.pugx.org/lasallesoftware/lsv2-backup-pkg/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/lasallesoftware/lsv2-backup-pkg"><img src="https://poser.pugx.org/lasallesoftware/lsv2-backup-pkg/license.svg" alt="License"></a>
</p>

Backup package for my LaSalle Software Version 2.

I want a very clean, and very lean, way to backup my admin app's database to Amazon Web Service's S3. So I created this package. This is likely the most self serving package of my LaSalle Software suite, because the code is so darn specific to my own needs.

I have drawn obvious inspiration from [Laravel Backup](https://github.com/spatie/laravel-backup) and [another Spatie package](https://github.com/spatie/db-dumper). And, from over a decade of using the incredible [Akeeba Backup](https://www.akeebabackup.com/). 

## Caveat

I cannot stress enough how casual this package is. It's sole intention is to scratch a personal itch. No doubt you are better off with Spatie's package! Also, Forge is coming out with a new database backup feature, and Vapor has its own database backup feature.

## Security

If you discover any security related issues, please email Bob Bloom at "bob dot bloom at lasallesoftware dot ca" instead of using the issue tracker.

## Links

* [Change Log](CHANGELOG.md)
* [Installation](INSTALLATION.md)