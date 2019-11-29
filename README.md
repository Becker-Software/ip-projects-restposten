# Requirements
- PHP 7.1 or higher
- PHP curl extension
- IP-Projects API Credentials
# Install
This is a Composer Package, you may use it with Composer. Or you can include the file Api.php in the src/ directory.
## Composer
To install this Package via Composer run:
```
composer require martin-becker/ip-projects-restposten
```
## Manually Source Code
```php
require_once('/dir/to/Api.php');
```
# Examples
## List all Servers
```
$username = "";
$password = "";

$api = new \MartinBecker\IPProjectsRestposten\Api($username,$password);
$json = $api->request('hardware');
```
