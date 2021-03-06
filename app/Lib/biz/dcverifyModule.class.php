<?php
/**
 * 优惠券验证模块
 * @author jobin.lin
 *
 */
class dcverifyModule extends BizBaseModule{
	
	public function __construct()
	{
		parent::__construct();
		global_run();
		$this->check_auth();
	}
	public function index(){
		
		init_app_page();
		$s_account_info = $GLOBALS['account_info'];
		$account_id = intval($s_account_info['id']);
		
		//获取支持的门店
		//$location_list = $GLOBALS['db']->getAll("select sl.id,sl.name from ".DB_PREFIX."supplier_account_location_link sall left join ".DB_PREFIX."supplier_location sl on sl.id = sall.location_id where sall.account_id=".$account_id);
		$location_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."supplier_location where id in (" . implode(",", $s_account_info['location_ids']) . ") ");
		
		$GLOBALS['tmpl']->assign("location_list",$location_list);
		$GLOBALS['tmpl']->assign("page_title","预订电子券验证");
		$GLOBALS['tmpl']->display("pages/dcverify/index.html");
	}
	public function check_dcverify(){
		require_once  APP_ROOT_PATH."system/model/dc.php";
		$s_account_info = $GLOBALS['account_info'];
		$sn = strim($_REQUEST['verify_sn']);
		$location_id = intval($_REQUEST['location_id']);
		ajax_return(biz_check_dcverify($s_account_info,$sn,$location_id));
	}
	public function use_dcverify(){
		require_once  APP_ROOT_PATH."system/model/dc.php";
		$s_account_info = $GLOBALS['account_info'];
		$sn = strim($_REQUEST['verify_sn']);
		$location_id = intval($_REQUEST['location_id']);
		ajax_return(biz_use_dcverify($s_account_info,$sn,$location_id));
	}
}
?>