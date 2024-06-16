<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/**
 * Copyright (c) 2017-present, Emile Silas Sare.
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OTpl\Plugins;

use OTpl\OTplUtils;

/**
 * Class Utils.
 */
final class Utils
{
	/**
	 * @param array  $items
	 * @param string $sep
	 *
	 * @return string
	 */
	public static function join(array $items, string $sep = ''): string
	{
		return \implode($sep, $items);
	}

	/**
	 * @param string $a
	 * @param string $b
	 *
	 * @return string
	 */
	public static function concat(string $a, string $b): string
	{
		return self::join(\func_get_args(), '');
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public static function keys(array $data): array
	{
		return \array_keys($data);
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public static function values(array $data): array
	{
		return \array_values($data);
	}

	/**
	 * @param mixed $value
	 *
	 * @return int
	 */
	public static function length(mixed $value): int
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
	 * @param mixed  $exp
	 * @param string $a
	 * @param string $b
	 *
	 * @return string
	 */
	public static function ifCond(mixed $exp, string $a = '', string $b = ''): string
	{
		return $exp ? $a : $b;
	}

	public static function register(): void
	{
		OTplUtils::addPlugin('join', [self::class, 'join']);
		OTplUtils::addPlugin('concat', [self::class, 'concat']);
		OTplUtils::addPlugin('keys', [self::class, 'keys']);
		OTplUtils::addPlugin('values', [self::class, 'values']);
		OTplUtils::addPlugin('length', [self::class, 'length']);
		OTplUtils::addPlugin('if', [self::class, 'ifCond']);
	}
}
