<?PHP

// $Id$

/**
 * 管理后台页面的请求对象缓存
 *
 * 结构说明：
 * 资源名称 -> 行为名称 -> lifetime
 *
 * 操作角色的定义在 admin.roles.conf.php
 *
 */

return array(
	'catalog' => array(
		'shewCategory' => array('life' => 60 * 5, 'params' => 'act,nodeid,_search,rows,page,sidx,sord,parentid'),
		'brandQuery' => array('life' => 60 * 5, 'params' => 'q,limit'),
		'brandGrid' => array('life' => 60 * 5, 'params' => '_source,id,sn,name,supplier_id,land,type_id,status,_search,rows,page,sidx,sord,delivery_cycle'),
		'goodsGrid' => array('life' => 60 * 6, 'params' => '_source,id,sn,name,kw,cate_sn,brand_id,supplier_id,land,market_price,selling_price,in_price,created_start,created_end,updated_start,updated_end,status,sales_type,_search,rows,page,sidx,sord'),
	)
);

