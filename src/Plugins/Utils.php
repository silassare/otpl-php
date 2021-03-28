<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
		return \implode($sep, $items);
	}

	/**
	 * @param string $a
	 * @param string $b
	 *
	 * @return string
	 */
	public static function concat($a, $b)
	{
		return self::join(\func_get_args(), '');
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public static function keys(array $data)
	{
		return \array_keys($data);
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public static function values(array $data)
	{
		return \array_values($data);
	}

	/**
	 * @param mixed $value
	 *
	 * @return int
	 */
	public static function length($value)
	{
		if (\is_string($value)) {
			return \strlen($value);
		}

		if (\is_bool($value) || \is_numeric($value) || null === $value) {
			return (int) $value;
		}

		return \count($value);
	}

	/**
	 * @param bool   $exp
	 * @param string $a
	 * @param string $b
	 *
	 * @return string
	 */
	public static function ifCond($exp, $a = '', $b = '')
	{
		return $exp ? $a : $b;
	}

	public static function register()
	{
		OTplUtils::addPlugin('join', [self::class, 'join']);
		OTplUtils::addPlugin('concat', [self::class, 'concat']);
		OTplUtils::addPlugin('keys', [self::class, 'keys']);
		OTplUtils::addPlugin('values', [self::class, 'values']);
		OTplUtils::addPlugin('length', [self::class, 'length']);
		OTplUtils::addPlugin('if', [self::class, 'ifCond']);
	}
}
