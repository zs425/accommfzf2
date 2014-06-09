<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
		'ze_theme' => array(
				'default_theme' => 'bootstrap',
				'theme_paths' => array(
						'public/themes/'
				),
			/*	'routes'=>array(
						'default'=>array('accommodationhome', 'home')
				),*/
				'adapters' => array(
						'ZeTheme\Adapter\Configuration',
						'ZeTheme\Adapter\Route',
				),
		),
        'config_path' => 'config.ini',
    // ...
);