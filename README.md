# CloudFlare Dynamic DNS Updater

The purpose of this application is to make it easy to update your dns zone hosted on CloudFlare with your public IP. The application supports unlimited domains / subdomains.

Extremely useful in case you have a public dynamic ip address and want to keep your dns records in sync with your ip address changes.

## Requirements

* Linux
* PHP 7.1+
* CloudFlare api key
* Composer

## Installation

`git clone repo`

`cd repo`

`composer install`

## Configuration

`php console.php login EMAIL API_KEY`

#### Add record in domain zone

`php console.php add NAME DOMAIN`

#### Remove record from domain zone

`php console.php remove NAME DOMAIN`

#### To update with your ip

`php console.php sync`

## Automation

The app makes sense if properly automated. For example if i want the subdomain to be updated in case my ip changes. 

The easiest thing to keep your subdomains up to date is to run cron with the `sync` command on 10-15 minutes interval.


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
