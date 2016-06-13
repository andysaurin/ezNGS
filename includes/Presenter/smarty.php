<?php
/**
* NQ_Presenter_smarty
*
* @package Framework
* @filesource
*/

require_once(SMARTY_DIR.'Smarty.class.php');


/**
* NQ_Presenter_smarty
*
* By default we use Smarty as our websites presentation layer (view).
*
* @package Framework
* @link http://smarty.php.net
*/
class NQ_Presenter_smarty extends NQ_Presenter_common
{
	private $template = null;
	private $path = null;

	public function __construct(NQ_Module $module)
	{
		parent::__construct($module);
		$this->path = SYSTEM_DIRECTORY_ROOT.'/templates/'.SYSTEM_TEMPLATE;
		$this->template = new Smarty();
		$this->template->plugins_dir = array(SMARTY_DIR.'plugins',SYSTEM_DIRECTORY_ROOT.'/modules/smarty_common/plugins');
		$this->template->template_dir = $this->path.'/'.'templates';
		$this->template->compile_dir = $this->path.'/'.'compile';
		$this->template->cache_dir = $this->path.'/'.'cache';
		//$this->template->config_dir = $this->path.'/'.'config';

		/**
		* NQ_Presenter_smarty
		*
     	* Enables template caching.
     	* <ul>
     	*  <li>0 = no caching</li>
     	*  <li>1 = use class cache_lifetime value</li>
     	*  <li>2 = use cache_lifetime in cache file</li>
     	* </ul>
     	* @var integer
     	*/
		$this->template->caching = 0;

	    /**
     	* NQ_Presenter_smarty
		*
		* This forces templates to compile every time. Useful for development
     	* or debugging.
     	*
     	* @var boolean
    	*/
		$this->template->force_compile = true;
	}

	public function display()
	{
		if ( isset($this->user->session->access_denied) && $this->user->session->access_denied > 0) {
			$this->tplFile = 'common/denied.tpl';
		} else {
			$this->tplFile = $this->module->moduleName . '/' . $this->module->tplFile;
		}
		$this->template->assign('templatePath',$this->template->template_dir);
		$this->template->assign('tplFile',$this->tplFile);
unset($this->user->db);
		$this->template->assign('user',$this->user);
		if ( isset($this->user->session) )
			$this->template->assign('session',$this->user->session);
		else
			$this->template->assign('session', null);

		if (defined('MO_SUBTITLE'))
			$this->template->assign('PageTitle', SYSTEM_PAGE_TITLE ." - ". MO_SUBTITLE);
		else
			$this->template->assign('PageTitle', SYSTEM_PAGE_TITLE);

		if (defined('MO_NOSIDEBAR')) {
			$this->template->assign('hide_sidebar', 1);
		}

		foreach ($this->module->getData() as $var => $val) {
			if (!in_array($var,array('path','tplFile'))) {
				$this->template->assign($var,$val);
			}
		}

		if ($this->module->pageTemplateFile == null) {
			$pageTemplateFile = 'common/page.tpl';
		} else {
			$pageTemplateFile = $this->module->pageTemplateFile;
		}

		if (!defined('MO_BODYONLY')) {

			/**
			* NQ_Presenter_smarty
			*
			* include any further common template variables
			* Included smarty_common modules inherit this class and variables set within
			* will only show in the smarty templates (and importantly not in any other presenters, eg rest)
			*
			* useful for common content (ie menus, headers, footers etc)
			* @package Framework
			* @global string smarty_common Common files to be included in all Smarty calls where MO_BODYONLY is not defined
			*/
			$smarty_common = array(
						'global',
						);

			foreach ($smarty_common as $file) {
				@include_once(SYSTEM_DIRECTORY_ROOT.'/modules/smarty_common/'.$file.'.config.php');
				require_once(SYSTEM_DIRECTORY_ROOT.'/modules/smarty_common/'.$file.'.php');
			}


		} else {
			$this->template->assign('ShowBodyOnly', 1);
		}

		$mtime = microtime();
		$mtime = explode(" ", $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$this->module->endTime = $endtime;

		$this->totalTime = ($endtime - $this->module->startTime);
		$this->template->assign('renderTime', $this->totalTime);

		if (PRESENTER == 'debug' && SYSTEM_DEBUG_OUTPUT == 'display' ) {
				$this->template->debugging = true;
				$this->template->assign ('debugMode', SYSTEM_DEBUG_OUTPUT);
		}
		$this->template->display($pageTemplateFile);
		$this->log->log('Smarty: displaying templates');

	}

	public function __destruct()
	{
		if (isset($_SESSION['message']))
			unset($_SESSION['message']);
		parent::__destruct();
	}
}

?>
