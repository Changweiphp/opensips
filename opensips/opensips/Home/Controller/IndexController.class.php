<?php
namespace Home \ Controller;
use Think \ Controller;
use Org \ Util \ Tree;
class IndexController extends Controller {
	public function index() {
		$tree = M('tree');
		$list = $tree->order('Pid ASC,Name,Url,Class DESC,Id ASC')->select();
		//		print_r(Tree :: tree($list));
		$this->assign('treeList', Tree :: tree($list));
		$this->display();
	}
	public function anauser() {
		$anauser = D('Anauser');
		//		$anauser =new \Home\Model\AnauserModel();
		//		D('Aauser');
		//		$sql = 'select tick,count from ana_user_inc order by tick limit 1';
		//		$date = $anauser->query($sql);
		$data = $anauser->order('tick desc', 'count')->select();

		$tick_date = array ();
		$count_arr = array ();
		$add_count_arr = array ();
		foreach ($data as $row) {
			$tick_date[] = $row['tick'];
			$count_arr[] = $row['count'];
		}
		print_R($tick_date);
		for ($x = 0; $x < count($count_arr); $x++) {
			if ($x == 0) {
				$add_count_arr[] = 4600 + $count_arr[$x];
			} else {
				$add_count_arr[] = $add_count_arr[$x -1] + $count_arr[$x];
			}
		}
		$user_inc = array (
			json_encode($tick_date),
			json_encode($count_arr),
			json_encode($add_count_arr)
		);
		//		$this->date->$date;
		print_r($user_inc);
//		$this->ajaxReturn($data);
		//		$this->assign("date",print_R($date));
		//		$this->display();
	}
}