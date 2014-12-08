<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
	protected $tableName = 'user';

	/**
	 * 字段映射
	 */
	protected $_map = array(
        'AccountId' =>'name', 
        'pass'  =>'pwd',
    
    );
}