<?php
return array (
	//'配置项'=>'配置值'
	'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息

	/* 主题设置 */
// 	'DEFAULT_THEME' => 'aspjzy', // 默认模板主题名称
	//	'ACTION_SUFFIX' => 'Action', // 操作方法后缀
	'URL_PARAMS_BIND' => true, // URL变量绑定到操作方法作为参数
	// 关闭字段缓存
	'DB_FIELDS_CACHE' => false,

	// 添加数据库配置信息
	//	'DB_TYPE' => 'mysql', // 数据库类型
	//	'DB_HOST' => '127.0.0.1', // 服务器地址
	//	'DB_NAME' => 'opensips', // 数据库名
	//	'DB_USER' => 'root', // 用户名
	//	'DB_PWD' => 'root', // 密码
	//	'DB_PORT' => 3306, // 端口
	//	//'DB_PREFIX' => 'think_', // 数据库表前缀
	//	'DB_CHARSET' => 'utf8', // 字符集	

	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_HOST' => 'localhost', // 服务器地址
	'DB_NAME' => 'opensips', // 数据库名
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => 'root', // 密码
	'DB_PORT' => 3306, // 端口
	//'DB_PREFIX' => 'think_', // 数据库表前缀
	'DB_CHARSET' => 'utf8', // 字符集	

	
);