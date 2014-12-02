<?php
namespace Home \ Controller;
use Think \ Controller;
use Org\Util\Tree;
class IndexController extends Controller {
	public function index() {
		$tree = M('tree');
		$list = $tree->order('Pid ASC,Name,Url,Class DESC,Id ASC')->select();
//		print_r(Tree :: tree($list));
		$this->assign('treeList', Tree :: tree($list));
		$this->display();
	}
}