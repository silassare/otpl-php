<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Plugins;

	use OTpl\OTplUtils;

	/**
	 * Class Html
	 * @package OTpl\Plugins
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

				if (strlen($val)) {
					$attr .= '="' . self::Escape($val) . '"';
				}

				array_push($arr, $attr);
			}

			return join($arr, ' ');
		}

		/**
		 * @param string $str
		 *
		 * @return string
		 */
		public static function escape($str)
		{
			$str = htmlentities($str, ENT_QUOTES, 'UTF-8');

			return str_replace("&amp;", "&", $str);
		}

		public static function register()
		{

			OTplUtils::addPlugin('HtmlSetAttr', [self::class, 'setAttr']);
			OTplUtils::addPlugin('HtmlEscape', [self::class, 'escape']);
		}
	}
