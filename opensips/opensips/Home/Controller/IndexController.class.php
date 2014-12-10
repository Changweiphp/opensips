<?php

namespace Home\Controller;

use Think\Controller;
use Org\Util\Tree;

class IndexController extends Controller {
	public function index() {
		/**
		 * 导航树代码
		 */
		// $tree = M('tree');
		// $list = $tree->order('Pid ASC,Name,Url,Class DESC,Id ASC')->select();
		// // print_r(Tree :: tree($list));
		// $this->assign('treeList', Tree :: tree($list));
		// $this->display();
		/**
		 * 图形数据显示
		 */
		
		/**
		 * *************************************************************************************
		 *
		 * 获取每天新增的用户数量
		 * 将每天的用户叠加上去获取累积用户数量
		 * @tick_date:时间;
		 * @count_arr:当天新增用户数量;
		 * @add_count_arr:层叠新增用户数量;
		 * 在意json格式传给echart 图形处理
		 * 4600 是刚开始的用户数量可以通过数值它来设置用户数量起点
		 *
		 * *************************************************************************************
		 */
		$anauser = D ( 'Anauser' );
		// $sql="select * from ana_user_inc order by tick";
		$data = $anauser->order ( 'tick asc', 'count' )->select ();
		$tick_date = array ();
		$count_arr = array ();
		$add_count_arr = array ();
		foreach ( $data as $row ) {
			$tick_date [] = $row ['tick'];
			$count_arr [] = $row ['count'];
		}
		for($x = 0; $x < count ( $count_arr ); $x ++) {
			if ($x == 0) {
				$add_count_arr [] = 4600 + $count_arr [$x];
			} else {
				$add_count_arr [] = $add_count_arr [$x - 1] + $count_arr [$x];
			}
		}
		$this->assign ( "tick_date", json_encode ( $add_count_arr ) );
		$this->assign ( "count_arr", json_encode ( $count_arr ) );
		$this->assign ( "add_count_arr", json_encode ( $add_count_arr ) );
		
		/**
		 * ***********************************************************************************************************************
		 *
		 * 获取每小时在线用户的数量
		 * @subscreber_date:对应时间
		 * @subscreber:每小时在线用户的数量
		 * 返回json格式给echarts图形处理
		 *
		 * ***********************************************************************************************************************
		 */
		$anauser = D ( 'Analytics' );
		// $sql="select * from analytics order by tick";
		$data = $anauser->order ( 'tick asc', 'count' )->select ();
		$subscreber_date = array ();
		$subscriber = array ();
		foreach ( $data as $row ) {
			$subscreber_date [] = $row ['tick'];
			$subscreber [] = $row ['count'];
		}
		$this->assign ( "subscreber_date", json_encode ( $subscreber_date ) );
		$this->assign ( "subscreber", json_encode ( $subscreber ) );
		
		/**
		 * ************************************************************
		 *
		 * 区域分布和区域总量的数据提取
		 * @provinces 省份
		 * @region_dates 保留了最近7天的时间
		 * @all_regions 省份的时间和数量重新组列成数组
		 * 日后创维的需求变动很大
		 * ***********************************************************
		 */
		$anauser = M ();
		$sql = "select * from ana_region_day where region!='' group by tick desc limit 7";
		$data = $anauser->query ( $sql );
		$rs = array ();
		foreach ( $data as $row ) {
			$rs [] = $row ['tick'];
		}
		
		$sql = "select * from ana_region_day where region!='' && tick between '" . end ( $rs ) . "' and '" . $rs [0] . "' group by tick order by tick";
		$data = $anauser->query ( $sql );
		$region_dates = array ();
		$provinces = array ();
		foreach ( $data as $row ) {
			$region_dates [] = $row ['tick'];
		}
		
		$sql_c = "select (select d.sn1 from dict_region d where d.region=a.region) region, sum(a.count) s  from ana_region_day a where a.region!='' && a.tick between '" . end ( $rs ) . "' and '" . $rs [0] . "'  group by region order by s asc";
		$data = $anauser->query ( $sql );
		foreach ( $data as $row ) {
			$provinces [] = $row ['region'];
		}
		$regiondays = array ();
		$sql_d = "select a.tick, (select d.sn1 from dict_region d where d.region=a.region) region, a.`count` from ana_region_day a where a.region!='' && a.tick between '" . end ( $rs ) . "' and '" . $rs [0] . "'";
		$data = $anauser->query ( $sql );
		foreach ( $data as $row ) {
			$regiondays ["$row[0]$row[1]"] = $row [2];
		}
		$all_regions = array ();
		foreach ( $provinces as $province ) {
			foreach ( $region_dates as $region_date ) {
				if (array_key_exists ( "$region_date$province", $regiondays )) {
					$all_regions [$province] [] = $regiondays ["$region_date$province"];
				} else {
					$all_regions [$province] [] = "0";
				}
			}
		}
		$date_region = array ();
		foreach ( $region_dates as $region_date ) {
			foreach ( $provinces as $province ) {
				if (array_key_exists ( "$region_date$province", $regiondays )) {
					$date_region [$region_date] [] = $regiondays ["$region_date$province"];
				} else {
					$date_region [$region_date] [] = "0";
				}
			}
		}
		$this->assign ( "provinces", json_encode ( $provinces ) );
		$this->assign ( "region_dates", json_encode ( $region_dates ) );
		$this->assign ( "all_regions", json_encode ( $all_regions ) );
		$this->assign ( "date_region", json_encode ( $date_region ) );		
		$this->display ();
	}

}