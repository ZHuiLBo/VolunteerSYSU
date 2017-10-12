<?php
    //1.确定应用名称(分为前台home和后台admin应用名称) 
    define('APP_NAME','Home');
    //2.确定应用路径(./表示与这个脚本文件同级的目录，所有目录名称首字母大写)
    define('APP_PATH','./Home/');
	//3.开启调试模式
	define('APP_DEBUG',true);
    //4.引入核心文件
    require  './ThinkPHP/ThinkPHP.php';
	
?>