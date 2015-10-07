<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<base target="_blank" />
<div class="container">
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">Generators</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/gii/controller/index">Controller Generator</a></li>
						<li><a href="/gii/crud/index">Crud Generator</a></li>
						<li><a href="/gii/form/index">Form Generator</a></li>
						<li><a href="/gii/model/index">Model Generator</a></li>
						<li><a href="/gii/module/index">Module Generator</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
    <div class="span-6 last">
        <div id="sidebar">
            <div id="yw1" class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">广告功能</div>
                </div>
                <div class="portlet-content">
                    <ul>
                        <li><a href="/ads?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">广告列表</a></li>
                        <li><a href="/ads/look?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">看广告赚PV</a></li>
                        <li><a href="/favorite?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">广告收藏列表</a></li>
                        <li><a href="/favorite/add?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=3213">添加收藏</a></li>
                        <li><a href="/favorite/delete?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=1">删除收藏</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="span-6 last">
        <div id="sidebar">
            <div id="yw1" class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">名片功能</div>
                </div>
                <div class="portlet-content">
                    <ul>
                        <li><a href="/profile?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">名片列表</a></li>
                        <li><a href="/profile/view?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=2">查看名片</a></li>
                        <li><a href="/profile/log?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">被查看记录</a></li>
                        <li><a href="/profile/shake?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">摇一摇</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">群组功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/team?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">群列表</a></li>
						<li><a href="/team/group?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我的群分组列表</a></li>
						<li><a href="/team/category?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">群组分类(行业)列表</a></li>
						<li><a href="/team/create?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&cid=&cname=&name=&desc=&upfile=&tag=&latitude=&longitude=&address=&scale&isverify=">创建群组</a></li>
						<li><a href="/team/update?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=1&cid=1&cname=safasdf&name=wegwe&desc=fwefawef&upfile=&tag=waf&latitude=12&longitude=2133&address=sdfasdf&scale=213&isverify=1">更新群组</a></li>
						<li><a href="/team/delete?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=1">群主删除群</a></li>
						<li><a href="/team/join?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=7&text=dsfs">申请加入群</a></li>
						<li><a href="/team/wing?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=">群组成员列表</a></li>
						<li><a href="/team/chat?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=">群聊天记录</a></li>
						<li><a href="/team/talk?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=&message=fsdfasdf">成员发言</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">优惠券功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/ttg?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">银联优惠券列表</a></li>
						<li><a href="/ttg/bind?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=110319&bid=1&card=6222003602113186559">银联优惠券绑定银行卡</a></li>
						<li><a href="/ttg/consume?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">银行优惠券消费查询</a></li>
						<li><a href="/ttg/card?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我绑定的银行卡</a></li>
						<li><a href="/coupon?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">广告商家优惠券列表</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

    <div class="span-6 last">
        <div id="sidebar">
            <div id="yw1" class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">消息管理</div>
                </div>
                <div class="portlet-content">
                    <ul>
                        <li><a href="/message/type?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">消息类型列表</a></li>
                        <li><a href="/message?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&tid=1">我的消息列表</a></li>
                        <li><a href="/message/verify?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=3&gid=&state=1&name=夺">同意添加翼友</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">调查问卷</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/questionnaire?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">调查问卷列表</a></li>
						<li><a href="/questionnaire/options?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=&qid=1">调查问卷选项列表</a></li>
						<li><a href="/questionnaire/ads?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&aid=1337">获取广告问卷</a></li>
						<li><a href="/questionnaire/answer?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&hash=eNortjK0tFIyijc0NjaPB1ImBmaW5gaGBuZK1lwwWqUGIw,,&id=2&aid=1337&skip=0&oid=1,2">回答问卷</a></li>
						<li><a href="/finding?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">调查结果列表</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">人脉功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/wing/relation?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我的推荐人脉列表</a></li>
						<li><a href="/buddy/group?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我的翼友分组列表</a></li>
						<li><a href="/buddy?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我的翼友列表</a></li>
						<li><a href="/buddy/update?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=15&name=dddd&mobile=1323213231&email=32432@@sdf.sdf&homepage=sdfasdf&remark=sdfasdfasdf">修改翼友备注信息</a></li>
						<li><a href="/buddy/addgroup?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&name=学友">添加翼友分组</a></li>
                        <li><a href="/buddy/add?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=12&text=无可奈何">添加翼友</a></li>
                        <li><a href="/wing/found?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&mobile=13560359913,13226618222">手机号查找是否存在用户和翼友</a></li>
						<li><a href="/wing/nearby?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&latitude=23.133716&longitude=113.376686">附近翼友</a></li>
						<li><a href="/wing/seek?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&cid=&tid=&corp=&name=&mobile=&position=">查找翼友</a></li>
						<li><a href="/wing/know?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&page=0&size=10">可能认识的翼友</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">关注功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/follow?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">关注列表</a></li>
						<li><a href="/follow/add?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=16">添加关注</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">PV商城功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/product?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">商品列表</a></li>
						<li><a href="/address?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">收货地址列表</a></li>
						<li><a href="/order?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">订单列表</a></li>
						<li><a href="/order/add?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=1&name=李均洽&province=广东省&city=广州市&area=天河区&mobile=13123123123&address=天河软件园&qty=1&time=<?php echo time();?>">添加订单(单商品)</a></li>
						<li><a href="/order/multiple?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&name=李均洽&province=广东省&city=广州市&area=天河区&mobile=13123123123&address=天河软件园&qty=1&time=<?php echo time();?>&details=[[1,2],[2,3]]">添加订单(多商品,购物车)</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">其它功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/help?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">帮助列表</a></li>
						<li><a href="/help/class?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">帮助分类列表</a></li>
						<li><a href="/message?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">消息列表</a></li>
						<li><a href="/feedback/create?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&title=&content=">意见反馈</a></li>
						<li><a href="/feedback?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我的意见反馈列表</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
    <div class="span-6 last">
        <div id="sidebar">
            <div id="yw1" class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">爱心功能</div>
                </div>
                <div class="portlet-content">
                    <ul>
                        <li><a href="/wing/love?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">爱心账户信息</a></li>
                        <li><a href="/donor?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">捐赠列表</a></li>
                        <li><a href="/donee?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">受赠对象</a></li>
                        <li><a href="/donor/donate?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=2&pv=13">捐赠PV</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="span-6 last">
        <div id="sidebar">
            <div id="yw1" class="portlet">
                <div class="portlet-decoration">
                    <div class="portlet-title">基础功能</div>
                </div>
                <div class="portlet-content">
                    <ul>
                        <li><a href="/base/regist?appkey=<?php echo $appkey;?>&key=eNortjIyslIyNDYyMjOzMLG0MI43NDEwN7I0MzUwUrIGXDBnXFwGcg,,&pwd=123123&mobile=13226684983&name=右在">注册</a></li>
                        <li><a href="/base/login?appkey=<?php echo $appkey;?>&code=13560359913&pwd=123123&uuid=2312312312312321&latitude=123.31232&longitude=312.234234">登录</a></li>
                        <li><a href="/base/logout?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">退出</a></li>
                        <li><a href="/base/sms?appkey=<?php echo $appkey;?>&mobile=13560359913">发短信验证码</a></li>
                        <li><a href="/base/phonetics?appkey=<?php echo $appkey;?>&mobile=13226684983">发语音验证码</a></li>
                        <li><a href="/base/email?appkey=<?php echo $appkey;?>&email=13560359913">发邮箱验证码</a></li>
                        <li><a href="/base/verify?appkey=<?php echo $appkey;?>&mobile=13226684983&code=1601">验证验证码</a></li>
                        <li><a href="/base/reset?appkey=<?php echo $appkey;?>&pwd=1fd3&key=sdfsdf">设置密码</a></li>
                        <li><a href="/base/category?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&pid=1">商家分类</a></li>
                        <li><a href="/base/province?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">省份列表</a></li>
                        <li><a href="/base/city?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&pid=1">城市列表</a></li>
                        <li><a href="/base/area?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&cid=1">区域列表</a></li>
                        <li><a href="/base/bank?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&pid=1">银行列表</a></li>
                        <li><a href="/base/ttgbank?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&pid=1">TTG银行列表</a></li>
                        <li><a href="/base/ttgcategory?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&pid=1">TTG分类列表</a></li>
                        <li><a href="/base/ttgprovince?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">TTG省份列表</a></li>
                        <li><a href="/base/ttgcity?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&pid=1">TTG城市列表</a></li>
                        <li><a href="/base/ttgarea?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&cid=1">TTG区域列表</a></li>
                        <li><a href="/base/ttgstreet?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&aid=1">TTG街道列表</a></li>
	                    <li><a href="/base/banner?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">BANNER(轮播广告)列表</a></li>
	                    <li><a href="/base/trade?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">行业列表</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">翼族用户功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/wing?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">当前登录用户信息</a></li>
						<li><a href="/wing/update?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&name=厈有&email=1dsf@sf.df&qq=13560359913&province=奇才&city=顶替&area=脸的&address=非机动车顶替 顶替&corp=顶替仍&position=村使用者&trade=顶替仍&supply=顶替仍&require=使用者仍&desc=全使用者脍">更新资料</a></li>
						<li><a href="/wing/setpwd?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&old=123456&pwd=123123">修改密码</a></li>
						<li><a href="/currency?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">当前虚拟币</a></li>
						<li><a href="/currency/log?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">虚拟币日志</a></li>
						<li><a href="/currency/type?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">虚拟币类型</a></li>
						<li><a href="/currency/logtype?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">虚拟币日志类型</a></li>
						<li><a href="/relation?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">我的六度关系</a></li>
						<li><a href="/relation/log?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">六度赚PV统计</a></li>
						<li><a href="/relation/init?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">初始化六度关系</a></li>
						<li><a href="/wing/group?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">用户等级</a></li>
						<li><a href="/wing/identity?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&name=sdfsdf&card=23123123&mobile=123123&front=&back=">用户身份认证</a></li>
						<li><a href="/wing/upgrade?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">升级VIP</a></li>
						<li><a href="/wing/code?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&code=admin">设置翼族号</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="span-6 last">
		<div id="sidebar">
			<div id="yw1" class="portlet">
				<div class="portlet-decoration">
					<div class="portlet-title">电话功能</div>
				</div>
				<div class="portlet-content">
					<ul>
						<li><a href="/call?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&tel=13226684983">拨打好友电话</a></li>
						<li><a href="/call/balance?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">时长信息</a></li>
						<li><a href="/call/receive?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>">领取时长</a></li>
						<li><a href="/call/biz?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=9155">拨打商家电话</a></li>
						<li><a href="/call/log?appkey=<?php echo $appkey;?>&token=<?php echo $token;?>&id=9155">拨打记录</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>