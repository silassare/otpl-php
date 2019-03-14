<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Plugins;

	use OTpl\OTplUtils;

	final class Utils
	{
		/**
		 * @param array  $items
		 * @param string $sep
		 *
		 * @return string
		 */
		public static function join($items, $sep = '')
		{
			return implode($sep, $items);
		}

		/**
		 * @param string $a
		 * @param string $b
		 *
		 * @return string
		 */
		public static function concat($a, $b)
		{
			return self::join(func_get_args(), '');
		}

		/**
		 * @param array $data
		 *
		 * @return array
		 */
		public static function keys(array $data)
		{
			return array_keys($data);
		}

		/**
		 * @param array $data
		 *
		 * @return array
		 */
		public static function values(array $data)
		{
			return array_values($data);
		}

		/**
		 * @param mixed $value
		 *
		 * @return int
		 */
		public static function length($value)
		{
			if (is_string($value)) {
				return strlen($value);
			}
			if (is_bool($value) OR is_numeric($value) OR is_null($value)) {
				return intval($value);
			}

			return count($value);
		}

		/**
		 * @param boolean $exp
		 * @param string  $a
		 * @param string  $b
		 *
		 * @return string
		 */
		public static function _if($exp, $a = '', $b = '')
		{
			return ($exp ? $a : $b);
		}

		public static function register()
		{
			OTplUtils::addPlugin('join', [self::class, 'join']);
			OTplUtils::addPlugin('concat', [self::class, 'concat']);
			OTplUtils::addPlugin('keys', [self::class, 'keys']);
			OTplUtils::addPlugin('values', [self::class, 'values']);
			OTplUtils::addPlugin('length', [self::class, 'length']);
			OTplUtils::addPlugin('if', [self::class, '_if']);
		}
	}
