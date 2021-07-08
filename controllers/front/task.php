<?php

class MultipurposeTaskModuleFrontController extends ModuleFrontController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function init()
	{
		parent::init();
	}

	public function initContent()
	{
		parent::initContent();
		$this->context->smarty->assign(array(
			'nb_product' => Db::getInstance()->getValue('SELECT COUNT(*) FROM `'._DB_PREFIX_.'product`'),
			'categories' => Db::getInstance()->executeS('SELECT `id_category`, `name` FROM `'._DB_PREFIX_.'category_lang` WHERE `id_lang`='.(int)	$this->context->language->id),
			'shop_name' => ''
		));
		$this->setTemplate('module:multipurpose/views/templates/front/task.tpl');
	}
	
	public function setMedia()
	{
		parent::setMedia();
		Media::addJsDef(array(
			'mf_ajax' => _PS_MODULE_DIR_.'moonfriend/ajax.php'
		));
		$this->addJquery();

		$this->addJS(_PS_MODULE_DIR_.'/multipurpose/views/js/jquery.dataTables.js');
		$this->addJS(_PS_MODULE_DIR_.'/multipurpose/views/js/dataTables.bootstrap.js');
		$this->addJS(_PS_MODULE_DIR_.'/multipurpose/views/js/task.js');

		$this->addCSS(_PS_MODULE_DIR_.'/multipurpose/views/css/dataTables.dataTables.css');
		$this->addCSS(_PS_MODULE_DIR_.'/multipurpose/views/css/dataTables.bootstrap.css');

	}
}