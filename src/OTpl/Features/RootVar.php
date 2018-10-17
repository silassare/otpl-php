<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Features;

	use OTpl\OTplUtils;

	/**
	 * Class RootVar
	 * @package OTpl\Features
	 */
	final class RootVar
	{
		// root data alias $ replacement
		const REG_ROOT_KEY   = "#[$]([^\w.])#";
		const REG_JS_CHAIN_A = "#([$][a-zA-Z0-9_]*|\])\.(\w+)#";
		const REG_JS_CHAIN_B = "#([$])\[(.+?)\]#";
		const REG_AT_VAR     = "#(?!\w)@var(\s+[$][a-zA-Z_])#";
		// shouldn't match @import(
		const REG_AT_PLUGIN = "#(?!\w)@((?!import\()[a-zA-Z_][a-zA-Z0-9_]+)\((.)#";

		/**
		 * @param array $in
		 *
		 * @return string
		 */
		public static function root_key(array $in)
		{
			return OTplUtils::OTPL_DATA_REF . $in[1];
		}

		/**
		 * @param array $in
		 *
		 * @return string
		 */
		public static function js_key_chain(array $in)
		{
			$txt = "";
			@list($found, $start, $key_name) = $in;

			if (!empty($found)) {
				if (preg_match(OTplUtils::OTPL_STR_KEY_NAME_REG, $key_name)) {
					$key_name = "'$key_name'";
				}

				if ($start === '$') {
					// $.toto -> $otpl_data['toto']
					$txt .= OTplUtils::OTPL_DATA_REF . "[$key_name]";
				} elseif ($start === ']') {
					// ].toto -> ]['totot']
					$txt .= "][$key_name]";
				} else {
					// $papa.toto -> $papa['toto']

					$txt .= $start . "[$key_name]";
				}
			}

			return $txt;
		}

		/**
		 * @param array $in
		 *
		 * @return string
		 */
		public static function var_replace(array $in)
		{
			return "if(0){ return; }\n " . $in[1];
		}

		/**
		 * @param array $in
		 *
		 * @return string
		 */
		public static function plugin_replace(array $in)
		{
			$pl_name = $in[1];
			$next    = $in[2];

			if ($next === ")") {
				return "OTplUtils::runPlugin('$pl_name')";
			}

			return "OTplUtils::runPlugin('$pl_name'," . $next;
		}

		public static function register()
		{

			OTplUtils::addReplacer(self::REG_ROOT_KEY, [self::class, 'root_key']);
			OTplUtils::addReplacer(self::REG_JS_CHAIN_A, [self::class, 'js_key_chain']);
			OTplUtils::addReplacer(self::REG_JS_CHAIN_B, [self::class, 'js_key_chain']);

			OTplUtils::addCleaner(self::REG_AT_VAR, [self::class, 'var_replace']);
			OTplUtils::addCleaner(self::REG_AT_PLUGIN, [self::class, 'plugin_replace']);
		}
	}