# CloudFlare Dynamic DNS Updater

The purpose of this application is to make it easy to update your dns zone hosted on CloudFlare with your public IP. The application supports unlimited domains / subdomains.

Extremely useful in case you have a public dynamic ip address and want to keep your dns records in sync with your ip address changes.

## Requirements

* Linux
* PHP 7.1+
* CloudFlare api key
* Composer

## Installation

```
git clone https://github.com/gdarko/cloudflare-dynamic-ip-updater.git
cd cloudflare-dynamic-ip-updater
composer install
```

## Configuration

`php console.php login EMAIL API_KEY`

#### Add record

The following command you will add subdomain NAME.DOMAIN to the processing queue. 

Everytime you run `sync`, this record will be updated on CloudFlare with your current IP.

`php console.php add NAME DOMAIN`

To remove specific subdomain/domain from the processing queue

#### Remove record

`php console.php remove NAME DOMAIN`

#### To update with your ip

`php console.php sync`

## Automation

The app makes sense if properly automated. For example if i want the subdomain to be updated in case my ip changes. 

The easiest thing to keep your subdomains up to date is to run cron with the `sync` command on 10-15 minutes interval.

Sync every 10 munutes example:

```
*/10 * * * * cd /path/to/cloudflare-dynamic-ip-updater && php console.php sync > /dev/null 2>&1
```

## Contribution

Contributions are welcome! Feel free to submit your pull request.

## License

```
Copyright (C) 2020 Darko Gjorgjijoski (https://megaoptim.com)

This file is part of CloudFlare Dynamic IP Updater

MegaOptim Image Optimizer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

MegaOptim Image Optimizer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with MegaOptim Image Optimizer. If not, see <https://www.gnu.org/licenses/>.
```
