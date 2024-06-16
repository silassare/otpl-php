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
 * Class Assert.
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
	public static function has(mixed $data, string $key, ?string $type = null): bool
	{
		if (!$data) {
			return false;
		}

		return (empty($type) && isset($data[$key])) || (isset($data[$key]) && self::type($data[$key], $type));
	}

	/**
	 * @param mixed  $value
	 * @param string $type
	 *
	 * @return bool
	 */
	public static function type(mixed $value, string $type): bool
	{
		$ans = false;

		switch ($type) {
			case 'string':
				$ans = \is_string($value);

				break;

			case 'map':
				$ans = \is_array($value);

				break;

			case 'numeric':
				$ans = \is_numeric($value);

				break;
		}

		return $ans;
	}

	public static function register(): void
	{
		OTplUtils::addPlugin('has', [self::class, 'has']);
		OTplUtils::addPlugin('type', [self::class, 'type']);
	}
}
