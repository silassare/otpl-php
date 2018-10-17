<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Features;

	use OTpl\OTpl;
	use OTpl\OTplResolver;
	use OTpl\OTplUtils;

	/**
	 * Class Import
	 * @package OTpl\Features
	 */
	final class Import
	{
		// @import(url [,data]) replacement
		// const REG = '#@import\([\s]*?[\'"]?(.*?)[\'"]?(?:[\s]*,[\s]*(.+?)[\s]*)?[\s]*\)#';
		const REG = '#@import\([\s]*?([\'"]?(.*?)[\'"]?)(?:[\s]*,[\s]*(.+?)[\s]*)?[\s]*\)#';

		/**
		 * @param array      $in
		 * @param \OTpl\OTpl $context
		 *
		 * @return string
		 * @throws \Exception
		 */
		public static function exec(array $in, OTpl $context)
		{
			$src_dir = $context->getSrcDir();
			$root    = ($src_dir) ? $src_dir : OTPL_ROOT_DIR;

			$match         = $in[0];
			$is_expression = !preg_match("#^@import\([\s]*?['\"]#", $match);

			if ($is_expression) {
				return " OTplUtils::importCustom( '$root'," . preg_replace("#^@import\([\s]*#", "", $match);
			}

			$url      = $in[2];
			$data_str = isset($in[3]) ? $in[3] : null;

			$url = OTplResolver::resolve($root, $url);

			if (OTplUtils::isTplFile($url)) {
				return " OTplUtils::importExec( '$url', $data_str ) ";
			}

			return " OTplUtils::loadFile( '$url' ) ";
		}

		public static function register()
		{
			OTplUtils::addReplacer(self::REG, [self::class, 'exec']);
		}
	}