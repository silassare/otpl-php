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

/**
 * Class Html
 */
final class Html
{
	/**
	 * @param $data
	 *
	 * @return string
	 */
	public static function setAttr($data)
	{
		$arr = [];

		foreach ($data as $key => $val) {
			$attr = $key;

			if (\strlen($val)) {
				$attr .= '="' . self::Escape($val) . '"';
			}

			\array_push($arr, $attr);
		}

		return \implode(' ', $arr);
	}

	/**
	 * @param string $str
	 *
	 * @return string
	 */
	public static function escape($str)
	{
		$str = \htmlentities($str, \ENT_QUOTES, 'UTF-8');

		return \str_replace('&amp;', '&', $str);
	}

	public static function register()
	{
		OTplUtils::addPlugin('HtmlSetAttr', [self::class, 'setAttr']);
		OTplUtils::addPlugin('HtmlEscape', [self::class, 'escape']);
	}
}
