# CloudFlare Dynamic DNS Updater

The purpose of this application is to make it easy to update your dns zone hosted on CloudFlare with your public IP. The application supports unlimited domains / subdomains.

Extremely useful in case you have a public dynamic ip address and want to keep your dns records in sync with your ip address.

## Requirements

* Linux
* PHP 7.1+
* CloudFlare API Key
* Composer

## Installation

```
git clone https://github.com/gdarko/cloudflare-dynamic-ip-updater.git
cd cloudflare-dynamic-ip-updater
composer install
```

## Configuration

### Authentication

The login credentails are stored in storage/.data and used when needed.

```
php console.php login EMAIL API_KEY
```

### Add record

The following command will add subdomain `NAME.DOMAIN` to the processing queue. 

Everytime you run `sync`, this record will be updated on CloudFlare with your current IP.

```
php console.php add NAME DOMAIN
```


### Remove record

If you no longer wish specific record to be updated, you can remove it from the processing queue.

```
php console.php remove NAME DOMAIN
```

### Sync records

The sync command loops through the records you added and updates those in CloudFlare with your system's current IP.

```
php console.php sync
```

## Automation

The app makes sense if it is automated. 

For example, you will want to keep your DNS records updated with your current IP and that's possible!

The easiest way to achieve this is to run the `sync` command on every 10-15 minutes using cron.

Sync every 10 munutes example:

```
*/10 * * * * cd /path/to/cloudflare-dynamic-ip-updater && php console.php sync > /dev/null 2>&1
```

## Contribution

Contributions are welcome! Feel free to submit your pull request.

## License

```
Copyright (C) 2020 Darko Gjorgjijoski (https://darkog.com)

This file is part of CloudFlare Dynamic IP Updater

CloudFlare Dynamic IP Updater is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

MegaOptim Image Optimizer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CloudFlare Dynamic IP Updater. If not, see <https://www.gnu.org/licenses/>.
```
