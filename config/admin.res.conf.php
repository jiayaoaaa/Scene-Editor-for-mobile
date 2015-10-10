<?PHP
// $Id$ 

/**
 * 管理权限配置信息
 * 
 * 结构说明：
 * 资源名称 -> 行为名称 -> 操作角色
 * 
 * 操作角色的定义在 admin.roles.conf.php
 * 
 */


return array(
	// 
	'menu' 	=> array(
		'tree'=>'staff',
		'node'=>'staff',
		'view'=>'staff',
		'grid'=>'administrator',
		'list'=>'administrator',
		'edit'=>'administrator',
		'store'=>'administrator',
	),
	'admin' => array(
		'login'=>'guest',
		'logout'=>'guest',
		'roleGrid'=>'administrator',
		'changePassword'=>'staff', // 修改自己的密码
		'staffGrid'=>'administrator',
		'staffSave'=>'administrator',
		'roles'=>'administrator',
	),
	'shopping' => array(
		'cartGrid' => 'shopping_cart_viewer'
	),
	'order' => array(
		'dict'=>'staff',
		's10Unconfirmed'=>'order_Unconfirmed',
		's20AwaitPay'=>'order_waitPay',
		's30AwaitShip'=>'order_waitShip',
		's40Canceled'=>'order_listCanceled',
		's90Finished'=>'order_Finished',
		'inthebox' => 'order_view', //9inthebox
		'sendOrderLog' => 'order_view', //9inthebox
		'view'=>'order_view',
		'edit'=>'order_edit',
		'save'=>'order_save',
		'orderConvertV1'=>'administrator',
		'delete'=>'administrator',
		'batchUpdateSku'=>'order_save',
		'batchUpdateSkuOther'=>'order_save',
        'batchUpdateReturnMoney'=>'order_batch_update',
		'batchUpdateStockStat'=>'order_batch_update',
		'addOrderByCsv'=>'order_save',
		/* 订单操作相关权限，建设中，暂时注释
		'orderView' => 'order_view',
		'orderGoods' => 'order_view',
		'orderEdit' => 'order_view',
		'orderStatus' => 'order_view',
		 */
	),
	
	'user' => array(
		'list'=>'user_manager',
		'save'=>'user_edit',
		'delete'=>'user_edit',
		'smsGrid'=>'sms_save',
	),
	'union' => array(			//联盟管理
		'listBrand'=>'union_rate',  // 读：写：联盟品牌比例
		'rateGrid'=>'union_rate',  //读：写：分类比率
		'categoryRate'=>'union_rate',  //读：写：分类比率
		'goodsRate'=>'union_rate',  //读：写：分类比率
		'brandRate'=>'union_rate',  //读：写：分类比率
		'source'=>'union_rate',  //读：写：联盟商地区比率
		'save'=>'union_money_pay',    // 写：修改联盟结算支付状态
		'orderlog'=>'union_money',	 //读：查看结算金额
		'orderlist'=>'union_orderlist', // 读：查看订单
		'orderitem'=>'union_orderitem', //读：查看订单明细
		//'nation'=>'union_rate',  // 读：&& 写：联盟商地区比率
		'nationBrand'=>'union_rate',  // 读：&& 写：地区品牌比率
		'orderfrom'=>'union_rate',  // 读：&& 写：联盟商地区比率
		'downorderlog'=>'union_money_export',  //读：下载结算比例
		'downorderfrom'=>'union_orderlist_export', //读：下载订单
		'downorderitem'=>'union_orderitem_export', //读：下载订单详情
		'usersave'=>'union_user_save', //写：修改联盟用户信息
		'overloadorderlog'=>'union_money_redo', //写：联盟重新结算
		'user'=>'union_user_view', //读：查看联盟用户信息
	),
	'catalog' => array(
		'brandQuery' => 'staff',			// 读: 品牌查询
		'shewCategory' => 'staff', 			// 读：展示分类
		'category' => 'shew_category_view',				// 读：属性分类
		'ShewCategorySave'	=> 'shew_category_save',		//写：商品分类保存
		'goodsGrid' => 'goods_view', 			// 读：商品数据浏览
		'goodsExport' => 'goods_view', 			// 读：商品数据导出
		'goodsBatchStatus' => 'goods_save', 	// 写：商品批量更新状态
		'goodsOperation' => 'goods_save', 		// 写：商品操作
		'goodsAdd' => 'goods_creator', 	// 写：商品添加(录入页面)
		'goodsPost' => 'goods_save', 	// 写：商品添加(录入接收)        
		'goodsView' => 'goods_save', 	// 读：商品查看
        'goodsBatchInprice' => 'goods_batch_inprice', 	// 写：商品批量更改进货价
        'goodsBatchSellingprice' => 'goods_batch_selling_price', 	// 写：商品批量更改售价
		'goodsBatchDescription' => 'goods_batch_description', 	// 写：商 品批量更改详细说明
		'goodsBatchUpdate' => 'goods_batch_change', 	// 写：商品批量修改
		'goodsBatchAdd' => 'goods_batch_create', 	// 写：商品批量上传
		'goodsSkuSave' => 'goods_save',				// 写：商品SKU
		'itemCategory' => 'item_catetory_view',  		// 读：树型类目
		'itemCategorySave' => 'item_catetory_save',			//写：商品树型类目保存(属性)
		'goodsImageOp' => 'goods_save',			//写：商品图片保存  
		'itemAttribute' => 'item_attribute_view', //读：商品属性
		'itemAttrSave' =>'item_attribute_save', //写: 商品属性
		'attrValueSave' => 'item_attribute_keeper',		//写：属性值快速录入
		//'saveGoodsAttribute' => 'goods_attr_save', //写：商品属性键保存
		//'goodsAttrValue' => 'goods_attrvalue_save',	//读：商品属性值
		//'saveAttrValue' => 'attr_save',	//写：商品属性键
		//'searchAttrbute' => 'attr_search',	
		'pugView' => 'administrator',			// 读：查看对象日志
		'tagSearch' => 'tag_manager',					//读：查找商品标签
		'tagView' => 'tag_manager',					//读：浏览商品标签
		'brandGrid' => 'brand_viewer',	            //读：浏览品牌
		'brandView' => 'brand_viewer',	            //读：品牌详细信息
		'brandOperation' => 'brand_manager',        //写：修改品牌信息
		'brandAdd' => 'brand_manager',              //写：添加品牌
		'tagUrlSearch' => 'brand_manager',
		'categoryMap' => 'manager',
		'skuGrid' => 'manager',
		'skuGridExport' => 'manager',
		'skuBatchUpdate' => 'goods_sku_save',
        'exportBySkuIds' => 'goods_sku_export',
		'supplyGrid' => 'manager',
		'tenantProfile' => 'manager',
		'tenantContent' => 'manager',
		'tenantCategory' => 'manager',
		'brandLabelGrid' => 'brand_lable_keeper',
        'DownLoadCaomei' => 'manager',
		'BatchUploadImage' => 'manager',
		
	),
	'supply' => array(
		'brandAuto' => 'goods_view',
		'inthebox' => 'goods_view',
        'intheboxTag' => 'inthebox_tag_manager', //写：九盒标签管理
		'category' => 'goods_view',
		'nExistBrand' => 'goods_view', //inthebox品牌相关
		'ogage' => 'supply_ogage_keeper',
		'ogageImport' => 'supply_ogage_keeper',
		'stylifeImport' => 'supply_stylife_keeper',		//stylife商品上传
	),
	'content' => array(
		'brandRecommend' => 'recommend_manager',					// 读：店铺推荐
		'saveGoodsRecommend'  => 'goods_recommend',
		'saveRecBrand' => 'recommend_manager',				// 写：推荐店铺设置
		'tagCategory' => 'tag_manager',					//读：浏览商品标签
        'tagSave' => 'tag_manager',                    //写：保存修改商品标签 
		'viewImages' => 'image_manager',				//读、写：图片编辑
		'imageGrid' => 'image_viewer',				// 读：图片信息
		'imageUpload' => 'image_manager',			// W: upload image
		'imageDelete' => 'image_keeper'	,			// W: 图片维护和删除
		'advertManage' => 'advert_manager',			//读：广告信息
		'advertView' => 'manager',			//读：广告信息
		'voteManage' => 'manager',
		'downVote' => 'manager',
		'voteSubject' => 'manager',
		'transGrid' => 'goods_creator',
		'comment' => 'comment_manager',
	),
	'track' => array(                     //访问统计
		'detail' => 'stat_track_pv',  // 读：网站PV
		'serverSource'=> 'stat_track_source', // 读：联盟From来源
		'ip' => 'stat_track_ip',  // 读：网站IP
		'click' => 'stat_track_click', // 读：页面点击
		'ipTotal' => 'stat_track_ip', // 读：汇总IP总数
		'pvTotal' => 'stat_track_pv', // 读：汇总PV总数
		'visitTotal' => 'stat_track_visit', // 读：日访问总数
		'visitDistribution' => 'stat_track_visit', // 读：汇总访客地域分布
		'clickSearch' => 'stat_track_click', // 读：页面点击查询
		'source' => 'stat_track_source', // 读：来源站点统计
		'visitors' => 'stat_track_visit',  // 读：汇总新访客统计
		'visit' => 'stat_track_visit', // 读：网站访问统计 毕然加的 
		'Pageclick' => 'stat_track_visit', // 读：网站访问统计 毕然加的 
	),
	// 暂时未用
	'page' => array(
		'page' => 'pageM_page',
		'pageCategory' => 'pageM_newpage',
		/*'savepage' => 'pageM_savepage',
		'pageitem' => 'pageM_pageitem',
		'savepageitem' => 'pageM_savepageitem',
		'itemedit' => 'pageM_itemedit',
		'bnredit' => 'pageM_bnredit',
		'txtedit' => 'pageM_txtedit',
		'mapedit' => 'pageM_mapedit',
		'itemupdate' => 'pageM_itemupdate',*/
		'newpage' => 'pageM_newpage',
		'pageForm' => 'pageM_newpage',
		'pageVisual' => 'pageM_newpage',
		/*'newsavepage' => 'pageM_newsavepage',
		'newpageitem' => 'pageM_newpageitem',
		'newsavepageitem' => 'pageM_newsavepageitem',*/
	),
	'brand' => array(
					
		'newSelling' => 'stat_brand',				//读：上传商品情况
		'orderGoods' => 'stat_brand',				//读：有效订单商品数
	
		'sureGoods' => 'stat_brand',					//读：成交订单商品数

		'goodsDiscount' => 'stat_brand',				//读：成交商品折扣分布
		'sureGoodsClass' => 'stat_brand',			//读：分小类分布
		'otherSureGoodsClass' => 'stat_brand',	//读：外部订单分小类分布
		'goodsPrice' => 'stat_brand',					//读：价格分布
		'otherGoodsDiscount' => 'stat_brand',			//读：外部成交商品折扣分布
		'otherGoodsPrice' => 'stat_brand',			//读：外部订单价格分布
	),
	'goods' => array( // stat
		'goodsData' => 'stat_goods',						//读：商品数据统计
		'sellingGoodsPrice' => 'stat_goods',		//读：上架商品售价
		'sellingGoodsClass' => 'stat_goods',		//读：上架商品分类情况
		'submitOrderGoodsNum' => 'stat_goods',	//读：提交订单商品数
		'sendOrderGoodsNum' => 'stat_goods',		//读：发货订单商品数
		'lackGoodsNum' => 'stat_goods',				//读：缺货商品数
		'cancelGoodsNum' => 'stat_goods',			//读：退货商品数
		'compositeGoods' => 'stat_goods',			//读：商品综合统计
		'dict' => 'staff',								//读：各类下拉框(staff)
	),
    'taobao' => array(
		'goodsGrid' => 'taobao_goods_view',			//读：淘宝商品数据浏览
        'ordersGrid' => 'taobao_orders_view',		//读：淘宝商品订单浏览
        'shopCats' => 'taobao_shop_cats',		//读：淘宝店铺类目和本地商品分类匹配		
		'shopTemp' => 'taobao_shop_temp',		//读：淘宝店铺模板	
		'synBatch' => 'taobao_syn_batch',		//读：淘宝批量同步
		'shopBrand' => 'taobao_shop_brand',		//读：淘宝店铺品牌
		'goodsExport' => 'taobao_goods_view',		//读：淘宝店铺品牌
	),
	'promo' => array(								//促销管理
		'goodsRecommend' => 'page_category_goods', //读：写：商品推荐
		'categoryAd' => 'page_category_ad',		 //读：写：分类广告
		'japanDiscount' => 'japanManager',
		'batchTimed' => 'promo_batchtimed',		 //读：写：批量限时促销
		'cash' => 'promo_cash',	
		'cashUse' => 'promo_cashUse',
        'batchTimedByCsv' => 'promo_batchtimed', //读：写：批量限时促销
		'promotionSum' => 'staff',					 //读：写：促销计算
		'promotionItem' => 'order_view',	// 读：取订单商品条目信息
		'promoMarketing' => 'promoMarketing_manager',	//读：写促销管理（开发中）
		'promoSave' => 'promoMarketing_manager',             //写：保存促销信息
		'CouponSave' => 'promo_cash',          //写：保存优惠券信息
		'CouponUseSave' => 'promo_cashUse',    //写：保存优惠券使用信息
		'goodsSearch' => 'promoMarketing_manager',		//读：读取商品及店铺信息
        'goodsPrefix' => 'promo_goods_prefix',		//写：批量添加促销商品前缀
		'promoGift' => 'promo_manager',
		'clearance' => 'promo_clearance',
	),
	'store' => array(
		'stockingIn' => 'store_in_stock',
		'cancelIn' => 'store_in_cancel',
		'salesOut' => 'store_out_sale',
		'initial' => 'store_initial',
		'averageNum' => 'store_average_num',
		'averagePr' => 'store_average_pr',
	),
	'sys' => array(
		'cacheOperation' => 'sys_cache_keeper',
	),
	'orderStat' => array(
		'orderSituation' => 'stat_order',		//读：订购情况综合统计
		'goodsState' => 'stat_order',				//读：内部订单商品状态
		'orderSend' => 'stat_order',					//读：发货情况统计
		'otherGoodsState' => 'stat_order',		//读：外部订单商品状态
		'productLine' => 'productLine_brand',				//读、写：店铺归类(产品线)
		'shopList' => 'productLine_brand',					//读：店铺列表
		'lineSave' => 'productLine_save',					//读、写：产品线操作
		'addLine' => 'productLine_save',					//读、写：添加产品线
		'odrStat' => 'stat_order',				//读：订单来源统计
		'orderPage' => 'stat_order',			//读:订单流程页面权重比
		'partPage' => 'stat_order',				//读：专题统计
	),
	'queue' => array(
		'exportGrid' => 'queue_export_viewer', 	// R: list all queue for export
		'exportRetry' => 'queue_export_keeper', // W: update a queue record for export
		'exportDownload' => 'queue_export_keeper', // W: export download
		'importGrid' => 'queue_import_viewer', 	// R: list all queue for export
		'importRetry' => 'queue_import_keeper', 	// R: list all queue for export
		'queueView' => 'queue_viewer'
	),
	'stat' => array(
		'search' => 'administrator'
	),
	//paipai相关
	'paipai' => array(
		'orderGrid' => 'api_paipai_manager',
        'goodsGrid' => 'api_paipai_manager',
		'itemAdd' => 'api_paipai_save_hide', // 隐藏发布商品
        'goodsOperation' => 'api_paipai_save',
	),
	'payment' => array(
		'moduleGrid' => 'payment_module_keeper',
		'tradeGrid' => 'payment_trade_view',
		'tradeView' => 'payment_trade_view',
		'tradeExport' => 'payment_trade_manager',
		'amountVerifyByCsv' => 'payment_amount_verify',
	),
	'logistics' => array(
		'stock' => 'logistics_stock',
		'batchInStock'  => 'logistics_stock',
		'batchOutStock' => 'logistics_stock',
		'kerryPurchase' => 'logistics_company',
		'togjFast'	    => 'logistics_company',
		'skuGrid'       => 'logistics_company',
		'kerryStock'    => 'logistics_company',
		'kerryStockOut' => 'logistics_company',
		'input'         => 'logistics_company',
		'output'        => 'logistics_company',
		'kerryPurchaseItem' => 'logistics_company',
		'kerryPrint'    => 'logistics_company',
		'kerrySku'      => 'logistics_company',
		'kerrySkuOut'   => 'logistics_company',
		'odrReturned'   => 'logistics_company',
	), 
    'addressbook' => array(
        'addressBook' => 'addressbook_address',
    ),
);

