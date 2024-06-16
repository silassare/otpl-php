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

namespace OTpl\Features;

use Exception;
use OTpl\OTpl;
use OTpl\OTplUtils;

/**
 * Class Import.
 */
final class Import
{
	/**
	 * @import(url [,data]) replacement
	 * const REG = '#@import\([\s]*?[\'"]?(.*?)[\'"]?(?:[\s]*,[\s]*(.+?)[\s]*)?[\s]*\)#';
	 */
	public const REG = '#@import\(\s*?([\'"]?(.*?)[\'"]?)(?:\s*,\s*(.+?)\s*)?\s*\)#';

	/**
	 * @param array $in
	 * @param OTpl  $context
	 *
	 * @return string
	 *
	 * @throws Exception
	 */
	public static function exec(array $in, OTpl $context): string
	{
		$match = $in[0];

		return ' OTplUtils::importCustom( $otpl_root, ' . \preg_replace('#^@import\(\s*#', '', $match);
	}

	public static function register(): void
	{
		OTplUtils::addReplacer(self::REG, [self::class, 'exec']);
	}
}
