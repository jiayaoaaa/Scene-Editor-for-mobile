<?PHP
// $Id$
/**
 * 管理角色配置信息
 *
 *
 *
 */

return array(
	// 角色名 ： 继承自角色名，请将被继承的放在前面
	'guest' 	=> null,
	'staff' => 'guest',
	'manager' => 'staff',
    'administrator' => 'manager',
	'japanManager' => 'manager',
	'shopping_cart_viewer' => 'manger',
	'shopping_cart_keeper' => 'manger',
	'order_Unconfirmed'=>'manager',
	'order_waitPay'=>'manager',
	'order_waitShip'=>'manager',
	'order_listCanceled'=>'manager',
	'order_Finished'=>'manager',
	'order_view'=>'manager',
	'order_edit'=>'order_view',
	'order_save'=>'order_edit',
    'order_batch_update'=>'order_save',
	'union_rate'=>'manager',
	'union_money'=>'manager',
	'union_money_export'=>'union_money',
	'union_money_pay'=>'union_money',
	'union_money_redo'=>'union_money',
	'union_orderlist'=>'manager',
	'union_orderlist_export'=>'manager',
	'union_orderitem'=>'manager',
	'union_orderitem_export'=>'manager',
	'union_rate'=>'manager',
	'union_user_view'=>'manager',
	'union_user_save'=>'union_user_view',
	'shew_category_view' => 'manager', //分类基础角色
	'shew_category_save' => 'shew_category_view',
	'item_catetory_view' => 'manager', //类目基础角色
	'item_catetory_save' => 'item_catetory_view',
	'item_attribute_view' => 'manager',	//类目属性
	'item_attribute_save' => 'item_attribute_view',
	'item_attribute_keeper' => 'item_attribute_view', // 类目属性管理员
	'goods_view' => 'manager', // 商品浏览基础角色
	'goods_save' => 'goods_view', // 商品操作员
	'goods_sku_save' => 'goods_view',
	'goods_image_keeper' => 'goods_view', // 商品图片管理者
	'goods_recommend'  => 'goods_view', // 商品推荐者
	'goods_attr_view' => 'goods_view', // 商品属性查看
	'goods_attr_save' =>'goods_attr_view', // 商品属性管理
    'promo_goods_prefix' => 'goods_save',//商品批量更改促销名称
    'goods_batch_inprice' => 'goods_save', //商品批量更改进价
    'goods_batch_selling_price' => 'goods_save', //商品批量更改售价
	'goods_batch_description' => 'goods_save', //商品批量 更改详细说明
    'goods_batch_change' => 'goods_save', //商品批量更新
	'goods_creator' => 'goods_save', // 商品添加
	'goods_batch_create' => 'goods_creator', // 批量商品添加
	'goods_sku_grid' => 'manager',
	'goods_sku_export' => 'goods_sku_grid',
    
    'taobao_goods_view' => 'manager', // 淘宝商品浏览基础角色
    'taobao_orders_view' => 'manager', // 淘宝订单浏览基础角色
    'taobao_shop_cats' => 'taobao_goods_view', // 淘宝店铺类目
	'taobao_shop_temp' => 'taobao_goods_view', // 淘宝店铺模板
	'taobao_syn_batch' => 'taobao_goods_view', // 淘宝批量同步
    'taobao_shop_brand' => 'taobao_goods_view', // 淘宝店铺品牌对照

    'inthebox_tag_manager' => 'manager',  // 九盒标签管理

	'sys_cache_keeper' => 'manager',

	'stat_track_pv' => 'manager',
	'stat_track_ip' => 'manager',
	'stat_track_source' => 'manager',
	'stat_track_click' => 'manager',
	'stat_track_visit' => 'manager',
	'store_in_stock' => 'manager',
	'store_in_cancel' => 'manager',
	'store_out_sale' => 'manager',
	'store_initial' => 'manager',
	'store_average_num' => 'manager',
	'store_average_pr' => 'manager',
	'stat_order' => 'manager',
	'productLine_brand' => 'manager',
	'productLine_save' => 'manager',
	'stat_goods' => 'manager',
	'stat_brand' => 'manager',
	'page_category_goods' => 'goods_view',
	'page_category_ad' => 'manager',
	'promo_batchtimed' => 'manager',
	'promo_clearance' => 'manager',
	'promo_cash' => 'manager',
	'promo_cashUse' => 'manager',
	'catalog_DownLoadCaomei' => 'manager',
	'catalog_BatchUploadImage' => 'manager',
	'user_manager'=>'manager',
	'user_edit'=>'user_manager',
	'queue_viewer' => 'manager',
	'queue_export_viewer' => 'manager',
	'queue_export_keeper' => 'manager',
	'queue_import_viewer' => 'manager',
	'queue_import_keeper' => 'manager',
	'recommend_manager' => 'manager',
	'promoMarketing_manager' => 'manager',
	'tag_manager' => 'manager',
	'comment_manager' => 'manager',
	'brand_viewer' => 'manager',
	'brand_manager' => 'brand_viewer',
	'brand_lable_keeper' => 'brand_manager',
	'image_viewer' => 'staff',
	'image_manager' => 'image_viewer',
	'image_keeper' => 'image_manager',
	'advert_manager' => 'manager',
	'vote_manager' => 'manager',
	'vote_subject' => 'manager',
	'api_paipai_manager' => 'manager',
    'api_paipai_save' => 'paipai_manager',
	'payment_module_keeper' => 'manager',
	'payment_trade_view' => 'manager',
	'payment_trade_manager' => 'manager',
	'payment_amount_verify' => 'payment_trade_manager',
	'page_page' => 'pageM_page',
	'page_newpage' => 'pageM_newpage',
	'page_form' => 'pageM_newpage',
	'page_category' => 'pageM_newpage',
	'category_map' => 'manager',
	'supply_grid' => 'manager',
	'supply_ogage_keeper' => 'manager',
	'promo_manager' => 'manager',
	'supply_stylife_keeper' => 'manager',
	'sms_manager' => 'sms_save',
	'logistics_stock' => 'manager',
	'logistics_company' => 'manager',
    'addressbook_address' => 'manager',
);

