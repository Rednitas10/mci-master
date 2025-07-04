<?php
/* SVN FILE: $Id$ */
/**
 * Methods for displaying presentation data in the view.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Included libraries.
 */
App::import('Core', array('Helper', 'ClassRegistry'));
/**
 * View, the V in the MVC triad.
 *
 * Class holding methods for displaying presentation data.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.view
 */
class View extends Object {
/**
 * Path parts for creating links in views.
 *
 * @var string Base URL
 * @access public
 */
	var $base = null;
/**
 * Stores the current URL (for links etc.)
 *
 * @var string Current URL
 */
	var $here = null;
/**
 * Name of the plugin.
 *
 * @link          http://manual.cakephp.org/chapter/plugins
 * @var string
 */
	var $plugin = null;
/**
 * Name of the controller.
 *
 * @var string Name of controller
 * @access public
 */
	var $name = null;
/**
 * Action to be performed.
 *
 * @var string Name of action
 * @access public
 */
	var $action = null;
/**
 * Array of parameter data
 *
 * @var array Parameter data
 */
	var $params = array();
/**
 * Current passed params
 *
 * @var mixed
 */
	var $passedArgs = array();
/**
 * Array of data
 *
 * @var array Parameter data
 */
	var $data = array();
/**
 * An array of names of built-in helpers to include.
 *
 * @var mixed A single name as a string or a list of names as an array.
 * @access public
 */
	var $helpers = array('Html');
/**
 * Path to View.
 *
 * @var string Path to View
 */
	var $viewPath = null;
/**
 * Variables for the view
 *
 * @var array
 * @access public
 */
	var $viewVars = array();
/**
 * Name of layout to use with this View.
 *
 * @var string
 * @access public
 */
	var $layout = 'default';
/**
 * Path to Layout.
 *
 * @var string Path to Layout
 */
	var $layoutPath = null;
/**
 * Title HTML element of this View.
 *
 * @var string
 * @access public
 */
	var $pageTitle = false;
/**
 * Turns on or off Cake's conventional mode of rendering views. On by default.
 *
 * @var boolean
 * @access public
 */
	var $autoRender = true;
/**
 * Turns on or off Cake's conventional mode of finding layout files. On by default.
 *
 * @var boolean
 * @access public
 */
	var $autoLayout = true;
/**
 * File extension. Defaults to Cake's template ".ctp".
 *
 * @var string
 */
	var $ext = '.ctp';
/**
 * Sub-directory for this view file.
 *
 * @var string
 */
	var $subDir = null;
/**
 * Theme name.
 *
 * @var string
 */
	var $themeWeb = null;
/**
 * Used to define methods a controller that will be cached.
 *
 * @see Controller::$cacheAction
 * @var mixed
 * @access public
 */
	var $cacheAction = false;
/**
 * holds current errors for the model validation
 *
 * @var array
 */
	var $validationErrors = array();
/**
 * True when the view has been rendered.
 *
 * @var boolean
 */
	var $hasRendered = false;
/**
 * Array of loaded view helpers.
 *
 * @var array
 */
	var $loaded = array();
/**
 * True if in scope of model-specific region
 *
 * @var boolean
 */
	var $modelScope = false;
/**
 * Name of current model this view context is attached to
 *
 * @var string
 */
	var $model = null;
/**
 * Name of association model this view context is attached to
 *
 * @var string
 */
	var $association = null;
/**
 * Name of current model field this view context is attached to
 *
 * @var string
 */
	var $field = null;
/**
 * Suffix of current field this view context is attached to
 *
 * @var string
 */
	var $fieldSuffix = null;
/**
 * The current model ID this view context is attached to
 *
 * @var mixed
 */
	var $modelId = null;
/**
 * List of generated DOM UUIDs
 *
 * @var array
 */
	var $uuids = array();
/**
 * Holds View output.
 *
 * @var string
 **/
	var $output = false;
/**
 * List of variables to collect from the associated controller
 *
 * @var array
 * @access protected
 */
	var $__passedVars = array(
		'viewVars', 'action', 'autoLayout', 'autoRender', 'ext', 'base', 'webroot',
		'helpers', 'here', 'layout', 'name', 'pageTitle', 'layoutPath', 'viewPath',
		'params', 'data', 'plugin', 'passedArgs', 'cacheAction'
	);
/**
 * Scripts (and/or other <head /> tags) for the layout
 *
 * @var array
 * @access private
 */
	var $__scripts = array();
/**
 * Holds an array of paths.
 *
 * @var array
 */
	var $__paths = array();
/**
 * Constructor
 *
 * @return View
 */
	function __construct(&$controller, $register = true) {
		if (is_object($controller)) {
			$count = count($this->__passedVars);
			for ($j = 0; $j < $count; $j++) {
				$var = $this->__passedVars[$j];
				$this->{$var} = $controller->{$var};
			}
		}
		parent::__construct();

		if ($register) {
			ClassRegistry::addObject('view', $this);
		}
	}
/**
 * Renders a piece of PHP with provided parameters and returns HTML, XML, or any other string.
 *
 * This realizes the concept of Elements, (or "partial layouts")
 * and the $params array is used to send data to be used in the
 * Element.  Elements can be cached through use of the cache key.
 *
 * @param string $name Name of template file in the/app/views/elements/ folder
 * @param array $params Array of data to be made available to the for rendered
 *                      view (i.e. the Element)
 *    Special params:
 *		cache - enable caching for this element accepts boolean or strtotime compatible string.
 *      Can also be an array
 *				if an array,'time' is used to specify duration of cache.  'key' can be used to
 *              create unique cache files.
 *
 * @return string Rendered Element
 * @access public
 */
	function element($name, $params = array(), $loadHelpers = false) {
		$file = $plugin = $key = null;

		if (isset($params['plugin'])) {
			$plugin = $params['plugin'];
		}

		if (isset($this->plugin) && !$plugin) {
			$plugin = $this->plugin;
		}

		if (isset($params['cache'])) {
			$expires = '+1 day';

			if (is_array($params['cache'])) {
				$expires = $params['cache']['time'];
				$key = Inflector::slug($params['cache']['key']);
			} elseif ($params['cache'] !== true) {
				$expires = $params['cache'];
				$key = implode('_', array_keys($params));
			}

			if ($expires) {
				$cacheFile = 'element_' . $key . '_' . $plugin . Inflector::slug($name);
				$cache = cache('views' . DS . $cacheFile, null, $expires);

				if (is_string($cache)) {
					return $cache;
				}
			}
		}
		$paths = $this->_paths($plugin);

		foreach ($paths as $path) {
			if (file_exists($path . 'elements' . DS . $name . $this->ext)) {
				$file = $path . 'elements' . DS . $name . $this->ext;
				break;
			} elseif (file_exists($path . 'elements' . DS . $name . '.thtml')) {
				$file = $path . 'elements' . DS . $name . '.thtml';
				break;
			}
		}

		if (is_file($file)) {
			$params = array_merge_recursive($params, $this->loaded);
			$element = $this->_render($file, array_merge($this->viewVars, $params), $loadHelpers);
			if (isset($params['cache']) && isset($cacheFile) && isset($expires)) {
				cache('views' . DS . $cacheFile, $element, $expires);
			}
			return $element;
		}
		$file = $paths[0] . 'elements' . DS . $name . $this->ext;

		if (Configure::read() > 0) {
			return "Not Found: " . $file;
		}
	}
/**
 * Renders view for given action and layout. If $file is given, that is used
 * for a view filename (e.g. customFunkyView.ctp).
 *
 * @param string $action Name of action to render for
 * @param string $layout Layout to use
 * @param string $file Custom filename for view
 * @return string Rendered Element
 */
	function render($action = null, $layout = null, $file = null) {
		if ($this->hasRendered) {
			return true;
		}
		$out = null;

		if ($file != null) {
			$action = $file;
		}

		if ($action !== false && $viewFileName = $this->_getViewFileName($action)) {
			if (substr($viewFileName, -3) === 'ctp' || substr($viewFileName, -5) === 'thtml') {
				$out = View::_render($viewFileName, $this->viewVars);
			} else {
				$out = $this->_render($viewFileName, $this->viewVars);
			}
		}

		if ($layout === null) {
			$layout = $this->layout;
		}

		if ($out !== false) {
			if ($layout && $this->autoLayout) {
				$out = $this->renderLayout($out, $layout);
				$isCached = (
					isset($this->loaded['cache']) &&
					(($this->cacheAction != false)) && (Configure::read('Cache.check') === true)
				);

				if ($isCached) {
					$replace = array('<cake:nocache>', '</cake:nocache>');
					$out = str_replace($replace, '', $out);
				}
			}
			$this->hasRendered = true;
		} else {
			$out = $this->_render($viewFileName, $this->viewVars);
			$msg = __("Error in view %s, got: <blockquote>%s</blockquote>", true);
			trigger_error(sprintf($msg, $viewFileName, $out), E_USER_ERROR);
		}
		return $out;
	}
/**
 * Renders a layout. Returns output from _render(). Returns false on error.
 * Several variables are created for use in layout.
 *	title_for_layout - contains page title
 *	content_for_layout - contains rendered view file
 *	scripts_for_layout - contains scripts added to header
 *  cakeDebug - if debug is on, cake debug information is added.
 *
 * @param string $content_for_layout Content to render in a view, wrapped by the surrounding layout.
 * @return mixed Rendered output, or false on error
 */
	function renderLayout($content_for_layout, $layout = null) {
		$layoutFileName = $this->_getLayoutFileName($layout);
		if (empty($layoutFileName)) {
			return $this->output;
		}

		$debug = '';

		if (isset($this->viewVars['cakeDebug']) && Configure::read() > 2) {
			$params = array('controller' => $this->viewVars['cakeDebug']);
			$debug = View::element('dump', $params, false);
			unset($this->viewVars['cakeDebug']);
		}

		if ($this->pageTitle !== false) {
			$pageTitle = $this->pageTitle;
		} else {
			$pageTitle = Inflector::humanize($this->viewPath);
		}
		$data_for_layout = array_merge($this->viewVars, array(
			'title_for_layout' => $pageTitle,
			'content_for_layout' => $content_for_layout,
			'scripts_for_layout' => join("\n\t", $this->__scripts),
			'cakeDebug' => $debug
		));

		if (empty($this->loaded) && !empty($this->helpers)) {
			$loadHelpers = true;
		} else {
			$loadHelpers = false;
			$data_for_layout = array_merge($data_for_layout, $this->loaded);
		}

		$this->_triggerHelpers('beforeLayout');

		if (substr($layoutFileName, -3) === 'ctp' || substr($layoutFileName, -5) === 'thtml') {
			$this->output = View::_render($layoutFileName, $data_for_layout, $loadHelpers, true);
		} else {
			$this->output = $this->_render($layoutFileName, $data_for_layout, $loadHelpers);
		}

		if ($this->output === false) {
			$this->output = $this->_render($layoutFileName, $data_for_layout);
			$msg = __("Error in layout %s, got: <blockquote>%s</blockquote>", true);
			trigger_error(sprintf($msg, $layoutFileName, $this->output), E_USER_ERROR);
			return false;
		}

		$this->_triggerHelpers('afterLayout');

		return $this->output;
	}
/**
 * Fire a callback on all loaded Helpers
 *
 * @param string $callback name of callback fire.
 * @access protected
 * @return void
 */
	function _triggerHelpers($callback) {
		if (empty($this->loaded)) {
			return false;
		}
		$helpers = array_keys($this->loaded);
		foreach ($helpers as $helperName) {
			$helper =& $this->loaded[$helperName];
			if (is_object($helper)) {
				if (is_subclass_of($helper, 'Helper')) {
					$helper->{$callback}();
				}
			}
		}
	}
/**
 * Render cached view
 *
 * @param string $filename the cache file to include
 * @param string $timeStart the page render start time
 */
	function renderCache($filename, $timeStart) {
		ob_start();
		include ($filename);

		if (Configure::read() > 0 && $this->layout != 'xml') {
			echo "<!-- Cached Render Time: " . round(getMicrotime() - $timeStart, 4) . "s -->";
		}
		$out = ob_get_clean();

		if (preg_match('/^<!--cachetime:(\\d+)-->/', $out, $match)) {
			if (time() >= $match['1']) {
				@unlink($filename);
				unset ($out);
				return false;
			} else {
				if ($this->layout === 'xml') {
					header('Content-type: text/xml');
				}
				echo str_replace('<!--cachetime:' . $match['1'] . '-->', '', $out);
				return true;
			}
		}
	}
/**
 * Returns a list of variables available in the current View context
 *
 * @return array
 * @access public
 */
	function getVars() {
		return array_keys($this->viewVars);
	}
/**
 * Returns the contents of the given View variable(s)
 *
 * @return array
 * @access public
 */
	function getVar($var) {
		if (!isset($this->viewVars[$var])) {
			return null;
		} else {
			return $this->viewVars[$var];
		}
	}
/**
 * Adds a script block or other element to be inserted in $scripts_for_layout in
 * the <head /> of a document layout
 *
 * @param string $name
 * @param string $content
 * @return void
 * @access public
 */
	function addScript($name, $content = null) {
		if (empty($content)) {
			if (!in_array($name, array_values($this->__scripts))) {
				$this->__scripts[] = $name;
			}
		} else {
			$this->__scripts[$name] = $content;
		}
	}
/**
 * Generates a unique, non-random DOM ID for an object, based on the object type and the target URL.
 *
 * @param string $object Type of object, i.e. 'form' or 'link'
 * @param string $url The object's target URL
 * @return string
 * @access public
 */
	function uuid($object, $url) {
		$c = 1;
		$url = Router::url($url);
		$hash = $object . substr(md5($object . $url), 0, 10);
		while (in_array($hash, $this->uuids)) {
			$hash = $object . substr(md5($object . $url . $c), 0, 10);
			$c++;
		}
		$this->uuids[] = $hash;
		return $hash;
	}
/**
 * Returns the entity reference of the current context as an array of identity parts
 *
 * @return array An array containing the identity elements of an entity
 */
	function entity() {
		$assoc = ($this->association) ? $this->association : $this->model;
		return array_values(Set::filter(
			array($assoc, $this->modelId, $this->field, $this->fieldSuffix)
		));
	}
/**
 * Allows a template or element to set a variable that will be available in
 * a layout or other element. Analagous to Controller::set.
 *
 * @param mixed $one A string or an array of data.
 * @param mixed $two Value in case $one is a string (which then works as the key).
 *              Unused if $one is an associative array, otherwise serves as the
 *              values to $one's keys.
 * @return unknown
 */
	function set($one, $two = null) {
		$data = null;
		if (is_array($one)) {
			if (is_array($two)) {
				$data = array_combine($one, $two);
			} else {
				$data = $one;
			}
		} else {
			$data = array($one => $two);
		}

		if ($data == null) {
			return false;
		}

		foreach ($data as $name => $value) {
			if ($name == 'title') {
				$this->pageTitle = $value;
			} else {
				$this->viewVars[$name] = $value;
			}
		}
	}
/**
 * Displays an error page to the user. Uses layouts/error.ctp to render the page.
 *
 * @param integer $code HTTP Error code (for instance: 404)
 * @param string $name Name of the error (for instance: Not Found)
 * @param string $message Error message as a web page
 */
	function error($code, $name, $message) {
		header ("HTTP/1.1 {$code} {$name}");
		print ($this->_render(
			$this->_getLayoutFileName('error'),
			array('code' => $code, 'name' => $name, 'message' => $message)
		));
	}
/**
 * Renders and returns output for given view filename with its
 * array of data.
 *
 * @param string $___viewFn Filename of the view
 * @param array $___dataForView Data to include in rendered view
 * @return string Rendered output
 * @access protected
 */
	function _render($___viewFn, $___dataForView, $loadHelpers = true, $cached = false) {
		$loadedHelpers = array();

		if ($this->helpers != false && $loadHelpers === true) {
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);

			foreach (array_keys($loadedHelpers) as $helper) {
				$camelBackedHelper = Inflector::variable($helper);
				${$camelBackedHelper} =& $loadedHelpers[$helper];
				$this->loaded[$camelBackedHelper] =& ${$camelBackedHelper};
			}

			$this->_triggerHelpers('beforeRender');
		}

		extract($___dataForView, EXTR_SKIP);
		ob_start();

		if (Configure::read() > 0) {
			include ($___viewFn);
		} else {
			@include ($___viewFn);
		}

		if ($loadHelpers === true) {
			$this->_triggerHelpers('afterRender');
		}

		$out = ob_get_clean();
		$caching = (
			isset($this->loaded['cache']) &&
			(($this->cacheAction != false)) && (Configure::read('Cache.check') === true)
		);

		if ($caching) {
			if (is_a($this->loaded['cache'], 'CacheHelper')) {
				$cache =& $this->loaded['cache'];
				$cache->base = $this->base;
				$cache->here = $this->here;
				$cache->helpers = $this->helpers;
				$cache->action = $this->action;
				$cache->controllerName = $this->name;
				$cache->layout	= $this->layout;
				$cache->cacheAction = $this->cacheAction;
				$cache->cache($___viewFn, $out, $cached);
			}
		}
		return $out;
	}
/**
 * Loads helpers, with their dependencies.
 *
 * @param array $loaded List of helpers that are already loaded.
 * @param array $helpers List of helpers to load.
 * @param string $parent holds name of helper, if loaded helper has helpers
 * @return array
 */
	function &_loadHelpers(&$loaded, $helpers, $parent = null) {
		if (empty($loaded)) {
			$helpers[] = 'Session';
		}

		foreach ($helpers as $i => $helper) {
			$options = array();

			if (!is_int($i)) {
				$options = $helper;
				$helper = $i;
			}
			$plugin = $this->plugin;

			if (strpos($helper, '.') !== false) {
				list($plugin, $helper) = explode('.', $helper);
			}
			$helperCn = $helper . 'Helper';

			if (!isset($loaded[$helper])) {
				if (!class_exists($helperCn)) {
					$isLoaded = false;
					if (!is_null($plugin)) {
						$isLoaded = App::import('Helper', $plugin . '.' . $helper);
					}
					if (!$isLoaded) {
						if (!App::import('Helper', $helper)) {
							$this->cakeError('missingHelperFile', array(array(
								'helper' => $helper,
								'file' => Inflector::underscore($helper) . '.php',
								'base' => $this->base
							)));
							return false;
						}
					}
					if (!class_exists($helperCn)) {
						$this->cakeError('missingHelperClass', array(array(
							'helper' => $helper,
							'file' => Inflector::underscore($helper) . '.php',
							'base' => $this->base
						)));
						return false;
					}
				}
				$loaded[$helper] =& new $helperCn($options);
				$vars = array(
					'base', 'webroot', 'here', 'params', 'action', 'data', 'themeWeb', 'plugin'
				);
				$c = count($vars);

				for ($j = 0; $j < $c; $j++) {
					$loaded[$helper]->{$vars[$j]} = $this->{$vars[$j]};
				}

				if (!empty($this->validationErrors)) {
					$loaded[$helper]->validationErrors = $this->validationErrors;
				}
				if (is_array($loaded[$helper]->helpers) && !empty($loaded[$helper]->helpers)) {
					$loaded =& $this->_loadHelpers($loaded, $loaded[$helper]->helpers, $helper);
				}
			}
			if (isset($loaded[$parent])) {
				$loaded[$parent]->{$helper} =& $loaded[$helper];
			}
		}
		return $loaded;
	}
/**
 * Returns filename of given action's template file (.ctp) as a string.
 * CamelCased action names will be under_scored! This means that you can have
 * LongActionNames that refer to long_action_names.ctp views.
 *
 * @param string $action Controller action to find template filename for
 * @return string Template filename
 * @access protected
 */
	function _getViewFileName($name = null) {
		$subDir = null;

		if (!is_null($this->subDir)) {
			$subDir = $this->subDir . DS;
		}

		if ($name === null) {
			$name = $this->action;
		}
		$name = str_replace('/', DS, $name);

		if (strpos($name, DS) === false && $name[0] !== '.') {
			$name = $this->viewPath . DS . $subDir . Inflector::underscore($name);
		} elseif (strpos($name, DS) !== false) {
			if ($name{0} === DS || $name{1} === ':') {
				if (is_file($name)) {
					return $name;
				}
				$name = trim($name, DS);
			} else if ($name[0] === '.') {
				$name = substr($name, 3);
			} else {
				$name = $this->viewPath . DS . $subDir . $name;
			}
		}

		$paths = $this->_paths(Inflector::underscore($this->plugin));
		
		$exts = array($this->ext, '.ctp', '.thtml');
		foreach ($exts as $ext) {
			foreach ($paths as $path) {
				if (file_exists($path . $name . $ext)) {
					return $path . $name . $ext;
				}
			}
		}
		$defaultPath = $paths[0];

		if ($this->plugin) {
			$pluginPaths = Configure::read('pluginPaths');
			foreach ($paths as $path) {
				if (strpos($path, $pluginPaths[0]) === 0) {
					$defaultPath = $path;
					break;
				}
			}
		}
		return $this->_missingView($defaultPath . $name . $this->ext, 'missingView');
	}

/**
 * Returns layout filename for this template as a string.
 *
 * @return string Filename for layout file (.ctp).
 * @access protected
 */
	function _getLayoutFileName($name = null) {
		if ($name === null) {
			$name = $this->layout;
		}
		$subDir = null;

		if (!is_null($this->layoutPath)) {
			$subDir = $this->layoutPath . DS;
		}
		$paths = $this->_paths(Inflector::underscore($this->plugin));
		$file = 'layouts' . DS . $subDir . $name;

		$exts = array($this->ext, '.ctp', '.thtml');
		foreach ($exts as $ext) {
			foreach ($paths as $path) {
				if (file_exists($path . $file . $ext)) {
					return $path . $file . $ext;
				}
			}
		}
		return $this->_missingView($paths[0] . $file . $this->ext, 'missingLayout');
	}
/**
 * Return a misssing view error message
 *
 * @param string $viewFileName the filename that should exist
 * @return cakeError
 */
	function _missingView($file, $error = 'missingView') {

		if ($error === 'missingView') {
			$this->cakeError('missingView', array(
				'className' => $this->name,
				'action' => $this->action,
				'file' => $file,
				'base' => $this->base
			));
			return false;
		} elseif ($error === 'missingLayout') {
			$this->cakeError('missingLayout', array(
				'layout' => $this->layout,
				'file' => $file,
				'base' => $this->base
			));
			return false;
		}
	}
/**
 * Return all possible paths to find view files in order
 *
 * @param string $plugin
 * @return array paths
 * @access protected
 */
	function _paths($plugin = null, $cached = true) {
		if ($plugin === null && $cached === true && !empty($this->__paths)) {
			return $this->__paths;
		}
		$paths = array();
		$viewPaths = Configure::read('viewPaths');
		$corePaths = array_flip(Configure::corePaths('view'));

		if (!empty($plugin)) {
			$count = count($viewPaths);
			for ($i = 0; $i < $count; $i++) {
				if (!isset($corePaths[$viewPaths[$i]])) {
					$paths[] = $viewPaths[$i] . 'plugins' . DS . $plugin . DS;
				}
			}
			$pluginPaths = Configure::read('pluginPaths');
			$count = count($pluginPaths);

			for ($i = 0; $i < $count; $i++) {
				$paths[] = $pluginPaths[$i] . $plugin . DS . 'views' . DS;
			}
		}
		$paths = array_merge($paths, $viewPaths);

		if (empty($this->__paths)) {
			$this->__paths = $paths;
		}
		return $paths;
	}
/**
 * @deprecated
 * @see View::element
 */
	function renderElement($name, $params = array(), $loadHelpers = false) {
		return $this->element($name, $params, $loadHelpers);
	}
}

?>
