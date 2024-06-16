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
 * Class Html.
 */
final class Html
{
	/**
	 * @param array<string,null|string> $data
	 *
	 * @return string
	 */
	public static function setAttr(array $data): string
	{
		$arr = [];

		foreach ($data as $key => $val) {
			$attr = $key;

			if (null !== $val && '' !== $val) {
				$attr .= '="' . self::Escape($val) . '"';
			}

			$arr[] = $attr;
		}

		return \implode(' ', $arr);
	}

	/**
	 * @param string $str
	 *
	 * @return string
	 */
	public static function escape($str): string
	{
		$str = \htmlentities($str, \ENT_QUOTES, 'UTF-8');

		return \str_replace('&amp;', '&', $str);
	}

	public static function register(): void
	{
		OTplUtils::addPlugin('HtmlSetAttr', [self::class, 'setAttr']);
		OTplUtils::addPlugin('HtmlEscape', [self::class, 'escape']);
	}
}
