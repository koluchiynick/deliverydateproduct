<?php
if (!defined('_PS_VERSION_'))
  exit;
 
class deliverydateproduct extends Module
{
  public function __construct()
  {
    $this->name = 'deliverydateproduct';
    $this->tab = 'other';
    $this->version = '1.0.0';
    $this->author = 'koluchiy';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
    $this->bootstrap = true;
 
    parent::__construct();
 
    $this->displayName = $this->l('delivery date product');
    $this->description = $this->l('delivery date product.');
 
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
 
    if (!Configuration::get('deliverydateproduct_NAME'))      
      $this->warning = $this->l('No name provided');
  }
public function install()
	{
		return parent::install()
			&& Configuration::updateValue('deliverydateproduct_NAME')
			&& $this->registerHook('DisplayLeftColumnProduct');
	}

public function uninstall()
	{
		// Delete configuration
		return Configuration::deleteByName('deliverydateproduct_NAME')
			&& parent::uninstall();
	}
	
	
	public function hookDisplayLeftColumnProduct()
	{
		$this->context->controller->addCSS($this->_path.'css/deliverydateproduct.css', 'all');
		
		function working_days($count) { 

    $date              = date( 'd.m.Y' ); 
     
    $day_week          = date( 'N', strtotime( $date ) ); 
     
    $day_count         = $count + $day_week; 
     
    $week_count        = floor($day_count/5); 
     
    $holiday_count     = ( $day_count % 5 > 0 ) ? 0 : 2; 
     
    $week_day          = $week_count * 7 - $day_week + ( $day_count % 5 ) - $holiday_count; 
     
    $date_end          = date( "d.m.Y", strtotime( $date . " + $week_day day " ) ); 
     
    $date_end_count    = date( 'N', strtotime( $date_end ) ); 
     
    $holiday_shift     = $date_end_count > 5 ? 7 - $date_end_count + 1 : 0; 
     
    return date("d.m.Y", strtotime($date_end . " + $holiday_shift day ")); 
} 
	
	$arr = working_days(5);
	
	$this->context->smarty->assign('deliverydate', $arr);
	return $this->display(__FILE__, 'deliverydateproduct.tpl');
	}
	
	



}