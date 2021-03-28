<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OTpl;

use OTpl\Features\Import;
use OTpl\Features\Loop;
use OTpl\Features\RootVar;
use OTpl\Plugins\Assert;
use OTpl\Plugins\Html;
use OTpl\Plugins\Utils;

\define('OTPL_ROOT_DIR', __DIR__ . \DIRECTORY_SEPARATOR);
\define('OTPL_ASSETS_DIR', OTPL_ROOT_DIR . '..' . \DIRECTORY_SEPARATOR . 'assets' . \DIRECTORY_SEPARATOR);

final class OTpl
{
	const OTPL_VERSION = '1.1.9';

	const OTPL_VERSION_NAME = 'OTpl php-' . self::OTPL_VERSION;

	const OTPL_COMPILE_DIR_NAME = 'otpl_done' . \DIRECTORY_SEPARATOR . self::OTPL_VERSION;

	const OTPL_TAG_REG = '#<%(.+?)?%>#';

	const OTPL_SCRIPT_REG = "#^(\s*)?(if|else|for|foreach|while|break|continue|switch|case|default|})#";

	const OTPL_CLEAN_PHP_TAG_REG = "#((?:(?:<\?(?:[pP][hH][pP]|=)?)|\?>)[\r\n]*)#";

	const OTPL_CLEAN_LEFT_REG = "#([\r\n]+)[\t ]*(<%.*?[}{]\s*%>)#";

	const OTPL_PRESERVE_NEWLINE_REG = "#(<%.*?%>)(\s+)(?!<%.*?[}{]\s*%>)#";

	private static $checked_func = [];

	private $input = '';

	private $output;

	private $is_url = false;

	private $src_path = '';

	private $dst_path = '';

	private $func_name;

	private $func_callable;

	private $compile_time = 0;

	public function __construct()
	{
	}

	public function export($dest)
	{
		if (\file_exists($dest)) {
			\unlink($dest);
		}

		\copy($this->dst_path, $dest);

		return $this;
	}

	/**
	 * @param string $tpl
	 * @param bool   $force_new_compile
	 * @param bool   $timed_func_name
	 *
	 * @throws \Exception
	 *
	 * @return $this
	 */
	public function parse($tpl, $force_new_compile = false, $timed_func_name = false)
	{
		$this->is_url = OTplUtils::isTplFile($tpl);

		if ($this->is_url) {
			$tpl            = OTplResolver::resolve(OTPL_ROOT_DIR, $tpl);
			$this->input    = OTplUtils::loadFile($tpl);
			$this->src_path = $tpl;

			$path_info = \pathinfo($tpl);
			$dst_dir   = $path_info['dirname'];

			// change only if file content change or file path change or otpl version change
			$out_file_name = $path_info['filename'] . '_' . \md5($tpl . \md5_file($tpl) . self::OTPL_VERSION);
		} else {
			$this->input = $tpl;

			$dst_dir       = OTPL_ROOT_DIR;
			$out_file_name = 'otpl_' . \md5($tpl . self::OTPL_VERSION);
		}

		$dst_dir .= \DIRECTORY_SEPARATOR . self::OTPL_COMPILE_DIR_NAME;

		if (!\file_exists($dst_dir)) {
			\mkdir($dst_dir, 0777, true);
		}

		$this->dst_path = $dst_dir . \DIRECTORY_SEPARATOR . $out_file_name . '.php';

		if (!$timed_func_name) {
			$this->func_name = 'otpl_func_' . \md5($out_file_name);
		} else {
			$this->func_name = 'otpl_func_' . \md5($out_file_name . \microtime());
		}

		$this->func_callable = '\\OTpl\\' . $this->func_name;

		if (!\file_exists($this->dst_path) || $force_new_compile) {
			$this->output = $this->engine();
			$this->save();
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSrcPath()
	{
		return $this->src_path;
	}

	/**
	 * @return string
	 */
	public function getSrcDir()
	{
		return \pathinfo($this->getSrcPath(), \PATHINFO_DIRNAME);
	}

	/**
	 * @return string
	 */
	public function getOutputUrl()
	{
		return $this->dst_path;
	}

	/**
	 * @return string
	 */
	public function getCallable()
	{
		return $this->func_callable;
	}

	/**
	 * @param mixed $data
	 *
	 * @throws \Exception
	 */
	public function runWith($data)
	{
		if (\file_exists($this->dst_path)) {
			require $this->dst_path;
		}

		$n = $this->func_callable;

		if (isset(self::$checked_func[$n]) && \is_callable($n)) {
			\call_user_func($n, new OTplData($data, $this));
		} else {
			@\unlink($this->dst_path);

			$tpl = $this->is_url ? $this->src_path : $this->input;
			$o   = new self();

			// let's parse again with a timed func_name: just for this use
			$o->parse($tpl, true, true)
			  ->runWith($data);

			@\unlink($this->dst_path);
		}
	}

	/**
	 * @param mixed  $data
	 * @param string $to
	 *
	 * @throws \Exception
	 */
	public function runSave($data, $to)
	{
		$to = OTplResolver::resolve(__DIR__, $to);

		$this->writeFile($to, $this->runGet($data));
	}

	/**
	 * @param mixed $data
	 *
	 * @throws \Exception
	 *
	 * @return string
	 */
	public function runGet($data)
	{
		\ob_start();
		$this->runWith($data);

		return \ob_get_clean();
	}

	/**
	 * @throws \Exception
	 *
	 * @return $this
	 */
	private function save()
	{
		$path = $this->dst_path;

		$code = OTplUtils::loadFile(OTPL_ASSETS_DIR . 'output.php.sample');

		$code = \str_replace([
			'{otpl_version}',
			'{otpl_version_name}',
			'{otpl_root_ref}',
			'{otpl_data_ref}',
			'{otpl_src_path}',
			'{otpl_compile_time}',
			'{otpl_func_name}',
			'{otpl_func_callable}',
			'{otpl_func_body}',
		], [
			self::OTPL_VERSION,
			self::OTPL_VERSION_NAME,
			OTplUtils::OTPL_ROOT_REF,
			OTplUtils::OTPL_DATA_REF,
			$this->src_path,
			$this->compile_time,
			$this->func_name,
			$this->func_callable,
			$this->output,
		], $code);

		$this->writeFile($path, $code);

		return $this;
	}

	/**
	 * @param string $path
	 * @param string $content
	 *
	 * @throws \Exception
	 */
	private function writeFile($path, $content)
	{
		// make sure that file is writable at this location,
		if (!\file_exists(\dirname($path)) || !\is_writable(\dirname($path))) {
			throw new \Exception("OTpl: '$path' is not writable.");
		}

		$f = \fopen($path, 'w');
		\fwrite($f, $content);
		\fclose($f);
	}

	/**
	 * @param callable[] $workers
	 * @param string     $code
	 *
	 * @return string
	 */
	private function runner(array $workers, $code)
	{
		foreach ($workers as $worker) {
			$in  = [];
			$reg = $worker[0];
			$fn  = $worker[1];

			if (\is_callable($fn)) {
				while (\preg_match($reg, $code, $in)) {
					$found   = $in[0];
					$args    = [$in, $this];
					$replace = \call_user_func_array($fn, $args);
					// replace only the first
					// str_replace may lead to error
					// for example: $.my_var is different from $.my_var_bis

					$code = self::replaceFirst($found, $replace, $code);
				}
			}
		}

		return $code;
	}

	/**
	 * @return string
	 */
	private function engine()
	{
		$tpl = self::clean($this->input);

		$in = [];

		while (\preg_match(self::OTPL_TAG_REG, $tpl, $in)) {
			@list($found, $code) = $in;

			$code = $this->runner(OTplUtils::getCleanHooks(), $code);
			$code = $this->runner(OTplUtils::getReplaceHooks(), $code);

			if (\preg_match(self::OTPL_SCRIPT_REG, $code)) {
				$result = "<?php $code ?>";
			} else {
				$result = "<?php echo ($code); ?>";
			}

			$tpl = \str_replace($found, $result, $tpl);
		}

		$this->compile_time = \time();

		return $tpl;
	}

	/**
	 * @param array $desc
	 *
	 * @return bool
	 */
	public static function register($desc)
	{
		if (self::check($desc)) {
			$callable                      = $desc['func_callable'];
			self::$checked_func[$callable] = true;

			// make sure the function is not already defined
			return !\is_callable($callable);
		}

		return false;
	}

	/**
	 * @param string   $name
	 * @param callable $callable
	 */
	public static function addPluginAlias($name, $callable)
	{
		OTplUtils::addPlugin($name, $callable);
	}

	/**
	 * @param array $desc
	 *
	 * @return bool
	 */
	private static function check(array $desc = [])
	{
		if (!isset($desc['func_callable'])) {
			return false;
		}

		if (!isset($desc['version']) || $desc['version'] !== self::OTPL_VERSION) {
			return false;
		}

		return true;
	}

	/**
	 * Replace first search occurrence.
	 *
	 * @param string $search
	 * @param string $replace
	 * @param string $subject
	 *
	 * @return string
	 */
	private static function replaceFirst($search, $replace, $subject)
	{
		$pos = \strpos($subject, $search);

		if ($pos !== false) {
			return \substr_replace($subject, $replace, $pos, \strlen($search));
		}

		return $subject;
	}

	/**
	 * @param $tpl
	 *
	 * @return string
	 */
	private static function clean($tpl)
	{
		$tpl = \preg_replace(self::OTPL_CLEAN_PHP_TAG_REG, "<?php echo '$1';?>", $tpl);
		$tpl = \preg_replace(self::OTPL_CLEAN_LEFT_REG, '$1$2', $tpl);

		return \preg_replace(self::OTPL_PRESERVE_NEWLINE_REG, "$1<?php echo '$2';?>", $tpl);
	}
}

// features
Import::register();
Loop::register();
RootVar::register();

// plugins
Assert::register();
Html::register();
Utils::register();
