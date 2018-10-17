<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Plugins;

	use OTpl\OTplUtils;

	/**
	 * Class Assert
	 * @package OTpl\Plugins
	 */
	final class Assert
	{
		/**
		 * @param mixed       $data
		 * @param string      $key
		 * @param null|string $type
		 *
		 * @return bool
		 */
		public static function has($data, $key, $type = null)
		{
			if (!$data) {
				return false;
			}

			return (empty($type) AND isset($data[$key])) OR (isset($data[$key]) AND self::type($data[$key], $type));
		}

		/**
		 * @param mixed  $value
		 * @param string $type
		 *
		 * @return bool
		 */
		public static function type($value, $type)
		{
			$ans = false;

			switch ($type) {
				case 'string':
					$ans = is_string($value);
					break;
				case 'map':
					$ans = is_array($value);
					break;
				case 'numeric':
					$ans = is_numeric($value);
					break;
			}

			return $ans;
		}

		public static function register()
		{
			OTplUtils::addPlugin('has', [self::class, 'has']);
			OTplUtils::addPlugin('type', [self::class, 'type']);
		}
	}
