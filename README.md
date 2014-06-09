#Setting up local copy

1. Download and import the database (From SpringLoops).
2. Run all the scripts in the `sql` folder.
3. Get composer `curl -sS https://getcomposer.org/installer | php`
4. Run `php composer.phar update` from the root directory. This will update dependecy versions.
5. Create a `local.php` file(do not commit this!) in `config/autoload` folder. Example content:

```php
<?php
return array(
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'params' => array(
					'user'		=> 'username',
					'password'	=> 'password',
					'dbname'	=> 'accomm_accommcms',
				),
			),
		    'central' => array(
		        'params' => array(
		            'user'		=> 'username',
		            'password'	=> 'password',
		            'dbname'	=> 'acewebde_centraldb',
		        ),
		    ),
		),
	),
	'db' => array(
        'dsn' => 'mysql:dbname=accomm_accommcms;host=localhost',
        'username' => 'username',
        'password' => 'password'
    ),
);
```
6. Copy the file `vendor/zendframework/zend-developer-tools/config/zenddevelopertools.local.php.dist` to `autoload/config` folder and rename it to `zenddevelopertools.local.php` to enable developer tools.
7. Enable write access for `Apache/Nginx` user to `data` folder.
8. Create a virtual host with `SetEnv APPLICATION_ENV "development"` - caching will be disabled this way. Document root should be the `public` folder.
