<?php

if(!defined('_PS_VERSION_'))
	exit;

class Multipurpose extends Module
{
	public function __construct()
	{
		$this->name = 'multipurpose';
		$this->author = 'Moon';
		$this->version = '1.0.0';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('Multipurpose');
		$this->description = $this->l('This is a description of a module');
		$this->ps_versions_compliancy = array('min' => '1.7.7.0', 'max' => '1.7.9.9');
	}

	public function install()
	{
		include_once($this->local_path.'sql/install.php');
		return parent::install()
			&& $this->registerHook('displayHome')
			&& $this->registerHook('header')
			&& $this->createTabLink();
	}

	public function uninstall()
	{
		include_once($this->local_path.'sql/uninstall.php');
		return parent::uninstall();
	}

	public function hookDisplayHome()
	{
		return $this->display(__FILE__, 'views/templates/hook/home.tpl');
	}

	public function hookHeader()
	{
		Media::addJsDef(array(
			'mp_ajax' => $this->_path.'ajax.php'
		));
		$this->context->controller->addCSS(array(
			$this->_path.'views/css/multipurpose.css'
		));
		$this->context->controller->addJS(array(
			$this->_path.'views/js/multipurpose.js'
		));
	}

	public function getContent()
	{
		if(Tools::isSubmit('savemultipurpose')) {
			$name = Tools::getValue('print');
			Configuration::updateValue('MULTIPURPOSE_STR', $name);
		}
		$this->context->smarty->assign(array(
			'MULTIPURPOSE_STR' => Configuration::get('MULTIPURPOSE_STR'),
			'token' => 	$this->generateAdminToken()
		));
		return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}

	public function createTabLink()
	{
		$tab = new Tab;
		foreach (Language::getLanguages() as $lang)
		{
			$tab->name[$lang['id_lang']] = $this->l('Origin');
		}
		$tab->class_name = 'AdminOrigin';
		$tab->module = $this->name;
		$tab->id_parent = 0;
		$tab->add();
		return true;
	}

	public function getProductsByCategoryID($id_category)
	{
		$obj_cat = new Category($id_category, $this->context->language->id);
		$products = $obj_cat->getProducts($this->context->language->id, 0, 100);
		$html = '<ol>';
		foreach($products as $product)
		{
			$html .= '<li>'.$product['name'].'</li>';
		}
		$html .= '</ol>';
		return $html;
	}

	public function generateAdminToken()
	{
		$cookie = new Cookie('psAdmin');
		$id_employee = $cookie->__get('id_employee');
		$controller = 'AdminOrders';
		$id_class = Tab::getIdFromClassName($controller);
		return Tools::getAdminToken($controller.$id_class.$id_employee);
	}

	public function loadProducts($start = 0, $length = 5, $sortby='id_product', $sortway = 'ASC')
	{
		$nb = Db::getInstance()->getValue('SELECT COUNT(*) FROM `'._DB_PREFIX_.'product`');
		$data = Db::getInstance()->executeS('SELECT p.`id_product`, pl.`name`, p.`price`
													FROM `'._DB_PREFIX_.'product` p
													LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
													ON(p.`id_product` = pl.`id_product`)
													WHERE pl.`id_lang` = '.(int)$this->context->language->id.'
													ORDER BY `'.$sortby.'` '.$sortway.'
													LIMIT '.(int)$start.', '.(int)$length);
		return array(
			'recordsTotal' => $nb,
			'recordsFiltered' => $nb,
			'data' => $data
		);
	}
}