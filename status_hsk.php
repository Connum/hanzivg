<?php ob_start(); ?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Current status of characters (HSK)</title>
	<style type="text/css">
		* {
			font-family: stheiti, simhei, "apple lisong", "Microsoft JhengHei", "hiragino kaku gothic pro", "ms gothic", sans-serif;
		}
		.char {
			display: inline-block;
			margin: 3px;
			width: 1.6em;
			height: 1.6em;
			line-height: 1.6em;
			vertical-align: middle;
			text-align: center;
			background-color: #f00;
			color: #fff;
		}
		.char.ok {
			background-color: #008800;
			color: #fff;
		}
		.char.animhanzi {
			background-color: orange;
		}
		.char.kanji {
			background-color: #eee;
			color: #262626;
		}
		.char.legend {
			width: auto;
			min-width: 1.6em;
			box-sizing: border-box;
			padding: 0 7px;
		}
		.char.clickable {
			cursor: pointer;
			text-decoration: none;
		}
		.char.clickable:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>

<?php
ob_start();
// taken from: https://gist.github.com/stevegrunwell/3363975
/**
 * Get the hash of the current git HEAD
 * @param str $branch The git branch to check
 * @return mixed Either the hash or a boolean false
 */
function get_current_git_commit( $branch='master' ) {
  if ( $hash = file_get_contents( sprintf( '.git/refs/heads/%s', $branch ) ) ) {
    return trim($hash);
  } else {
    return false;
  }
}

$lastCommitHash = get_current_git_commit();
$lastCommitUrl = parse_ini_file('.git/config')['url'] . '/commits/master';
print '<p>Last update of this overview based on commit <a href="' . $lastCommitUrl . '" target="_blank">' . $lastCommitHash . '</a></p>';


// HSK char grouping data taken from http://gooo.free.fr/animHanzi/
$hsk = array(
	'我的你是了不们这一他么在有个好来人那会什没说吗想能上去她很看对里都子生时样和下现做大怎出点起天开谢些家后儿多话小回果见听觉太妈打再呢女前先明中作面爱电哪西候欢关车年喜认爸谁老机分今工东名同学叫本国友高请住钱吃朋系几气少医三兴服字水号师星识坐期买影二喝月写姐飞视衣钟十睡亮狗脑院书四米校客岁五漂喂块店语热杯昨饭冷午习六读商八汉租猫七菜北桌雨九椅茶京苹',
	'要就到为道可知得过吧还以事也真让给但着意别所然走经因告最手找快等从情诉已问错孩它间次正进比帮晚动常长白第两非公身题完望离新思场始外件表希边男准员玩每备试体乐早门房球夫路日舞笑报教色远眼蛋息室运哥火条病弟您送近穿助司跑忙站跳便歌务黑票游唱考往步班药卖百妹足慢妻床休洗奶千共懂介红鱼牛馆肉旅鸡丈睛笔虽啡课咖纸左右旁雪贵汽瓜阴累绍踢宾泳零羊颜姓篮宜铅晴',
	'啊把只如自发心定该当用地行而像被跟成感干法己信实方应头特相需放直才于带力种者安理重记加接拿解其又更马结难位刚查或变物总办主算必害选且向照提决求目留清世片口酒周赛须卡婚根单张万声音奇怕护花节怪愿除界担空阿注坏久议礼数平调文业包参风复忘假据嘴越简易答乎超轻满静故极讲趣戏容化束终差图半楚市城换船级刻迎段检脸择楼皮练历山元角街料板顾遇史画闻急糕脚聊居词突努辆句季双牙南冰响网箱园冒甜香叔搬迟烧借聪腿鞋树银短环哭康般境爷灯裤盘附阳健较耳草层末铁黄夏舒旧蓝疼河鸟骑饿瓶典育净李鲜扫惯邮帽啤梯鼻绿熊胖爬邻春朵饮裙澡渴衫刷衬姨秋碗绩冬刮瘦矮炼伞饱锻蕉斤筷',
	'死之克无全美许亲尔保受活何伙谈部计任确利警士拉将证管处切失性此合队抱通并歉命入掉演够案约肯伤父指原底棒收交停格金内至消整度持光与象使察海绝反由论亚续母尽弄密线继份止拜紧联精转却基台另况否险言幸传量首改术局永烦取随式律费科麻流倒划味区支连弹吸呀醒梦赢丽付排敢油餐破激程讨责落林及争猜建惊标各民功示释引疑赶俩存断松博观码恐普价怀验呼祝剧乱展则深迷具福职即挺负脱仅资弃修危专甚苦适骗厌值众预际咱卫养导虑戴志杂误规陪森纪浪顺举按坚免印严推毛压败究评速获细丢态判货围签牌户质供奖袋脏效座沙扰困概登竟彩招巧剩烟封低技输仍扔社秀刀族广镜播温遍尝列毕聚尊汤优偶熟微抽艺研散饼糖富降怜既笨航匙秒挂勇钥奋忆折景默禁诚谅厅稍窗章仔款拒童翻洲互例垃染漫圾缺针扮邀闹辛竞厉厨允授估帅键傲减著鼓盒寄赚材尤愉序烤悔暂惜拾申批乘辣躺肥址占省增擦洋符骄羞贺敲购售耐琴貌倍桥肤厕植距虎济粗肚暖励积云幽龄汁钢篇汗酸叶趟抬悉页桶巾穷扬污填塑丰孙恼详葡萄脾凉厚矿逛堵胳谊泉袜膊懒盐江鸭膏慕阅寒棵橡泼础戚暑咳聘郊傅羽籍勺羡硕咸译乓嗽乒柿饺',
	'杀嗯德神枪官救宝搞战布装贝击器制哈达待托强军代血疯鬼巴兄品英抓统维派恶糟令毒治控录拍组造集类曾投未威显偷权某立闭庭雷团王义唯夜靠独娘顿设置逃痛狂模索灵承产政领纳退秘架背追炸射傻藏瞧呆碰念华冲型麦似套私滚食形石测丝防恋武胜屋斗守致称吓古状疗操遗寻胡替拥股挑姑项摩享配迹阻属婆骨摄委暗训善轮顶兵锁木抢档群坦土伴恨移编刺毫库荣充创劳忍势吻营盖府透掌升临智归撞搜摆岛避织执戒佛妙宣烂悲妇圈敬劲醉吵龙挥彼废初素敌欧旦依雄朝恭补摇躲源滑碎弱臭幻闪沉卷财墙拳触胁施胸孕硬销虫握迫采辈限巨尾青席犹赞访良驾范猪淘洞冠伟珍朗欠丑烈村堆庆率寓谓余核损辩摸途敏版订俱尺鼠幕憾隔彻插尚构绪吐吹颗宁罚乡豪征括稳胆甲佩启赏震述阵乖咬蜜拼池虚频违诊络辞献农姻恢描匹软纯贴略陆载嫁喊灰摔厂怨剪豆挡糊卧域闲涂碍柜裁账固漏夹辑喷饰灾欣滩闯圆延凭捐挣宽驶伸析媒矩绕益壁汇缩诗殊含甩燃炒晕偿岸绳蛇链薄瞎齐哎逐肩筑艰冻遵酱齿忽肠押玻姿召柔阶歇亿胶眠仿潮舍宴兔奈胃挤脆询蜂夸企递铃振册璃慰宿睁脖陌返扇肌猴慌凌税湿膀幅泪拆玉币魅炮桃培腐砍宠腰俗弯渐措毯霉缓逗撕娶勤滴钓踩革惠淡拦逻赔熬漠衡趁盾尘骂跃粘疲肃幼嘉映俊沟愧娱催捡叉狮亏蹲乏哲披拐讽劝裹慧雾浓唉扩煮烫繁悄妨扶谨抖屈荐均飘矛摘润贷紫氛慎浅眉悠寂兼锅寿促辅览棋贡艳嗓综劣豫痒柴盼翅迅晒椒舅咨歪盆洒耽昆删届涨厢匆苗蝶狡夕寞纷煤裔蝴皂梳愁厦抄醋斜谦泛屉县恳猾兑贸壶帘竹叙蔬浇秩嫩虹粮鞭髦勿燥践梨炭乙吨孝厘姥趋塘骤绸惭糙窄桔浏嚏傍纲倡屿匀旬馒',
	'哦斯嘿嗨犯嘛帝啦罪混恩杰圣探监哇姆吉奥狱谎伦踪屁尸蒂魔谋波毁诺撒州凶伯审蠢塔亡鲁堂露爆镇暴纽诞捕赌塞酷曲莫异誓雇野搭症攻蒙苏魂啥隐协泰抗迈绑沃副瓦丁粉徒灭孤伍纹残砸拖牢惹逮劫袭嫌怖墨陷蹈雅逼叛扯剂怒液磨娃刑泡堡愚盛皇夺盗汰猎潜霍爽扎讯侦欲杜盯赖胎帐抛遭若仪宫祖耍忠策钻桑尖惧痕佳掩荒督撤援郎埋惨浴侵挖兽洁晨奏欺端障慈仇逊黎额罢裂偏丧乌宇葬党壮珠勃唐荡扣仰君晓牧巡牲昏凡谷愤盟窃辜伪田蕾倾辱缝惑狼脉宗祸趴泽诱溜隆狠抵揭涉牵婴胞湖讶瞒呵缘予泄拨癌乳罐骚恰擅患剑牺割拔扭融臂舌焦赋径撑泥贩哼艘寸誉陈惩墓伏缠妒妆旋廉遥侧舰筹纵猛耀耻殿瘾唤棍疾磅谍忌堪奉廊仓鉴仁孔杆嫉箭揍捉恕吊踏罩尴郁尬崩港淋勾署奴弥抚甘唇截宙搅舱轨蛮侠滋闷债吞肿仙奔庄袖愈磁肺储番肖嘲氧井艇炉旗昂垫栋渡薪腾驱钉横贼溃拘犬佣忧宰坠霸瘤膝役菌崇哀浮卑谬抑壳铺腔摧晃僵妥窝岩诈虐诸挨喉扑董搏倦械纠挽晋棕栏氏央灌谱侣屏疫轰挪沿悬贫腹抹朴稿雕蜡粹添兜喘锋隶仗沮浑竭炎疏呈鄙煎耗晶衰掘谜捷馅瞄沾覆侄跪逝赠笼川湾翼筒丸塌吼枚辨擎绅侮峰庞丛剥妄漆筋贪兆畏枕陶讼穴遮瞬捣串赤脂歧饶疤篷谣摊钩苍凑缉酬舔畜垂悦畅循烛堕颠券衷盲膜斑氓稀嚷跨扁携粒呕跌坟御恒罕钞敞啰肢咙饥宅岗刊渣阱贿棉贤淹榜喻拟躁蓄慨坑颈焰鸽泣熏遣津翘逆柱滥皆鸣嘱弊蒸赴宪刹凝哨炫慷殖叨睹绘蚁顽隧颁橙捏坡剖锤丘膛枝旺酗芒噪辉叮巷贯嚼叹卸茫陋掏纤臣蔽俘颤砖驳迁宵袍洪撼卓翔秃驻眨幢削乞聋锦沼赂辐鸦拽阔皱哄谐蹦碳咋锐帆斥峡捞铜悼巢庇禽履浸衔绒雀熄杖悟寺霜殴钝逢奢挫撇弦掐昧庸搁梁涌挚坛窍腥晰祥旨叠框碑蓬咐酿唠墅亦伐咽婪惕稚曝捆泊嗅瓷渔哑驰屑烘栽铭冤溪舟绎胀肆溅拌吩剔茎竖枯椎勉缚挠崖瘫俯沫亭烹磕庙颇腻掠辖肪渗攀叭蚂歹憋喇缴郑吟溶碌娇蔓滤岔崭蚀儒捧昔掷馈帖谴颂唾宏痪敷渺僻榨澄扒裕芽瞪狭涕拙躬饪灿昌锈瘸琢掀朽渠拧辙惫帜雌拣斩岳拓劈虏稻滞滨蔑钦伺盈辫沸柬丙贬鞠壤杠窜洽啃颖坝铸煌衅怯苟侈迄谤觅绣魄堤墟泌粥濒寝旷伶岂隙韧痹衍瀑拢诽萎瓣搂捍枉袱扛徘诫徊膨诵掰揉嵌瘩涵滔疙唆烁凹桨吁沛熨捎晤筛攒毅泻勘耸紊呻镶沐蔼哗丐藐诬纬陵侥涩嗦惦凄淆睬茂饲睦瞩峻耕吝殃旱钙辰株惰喧凸辟廓甭稼涛媳彰嫂蹋愣搓蹬梢阐晾叼恍啬筐屡哺潇讳萌抒咀簸汹暧缀兢畔纺倔澈啸涮舆酝灶侃赁巩奠斟蕴缔遏惋昼陡譬搀迸徙眶狈讥秤蔚酌隘俐怠阂嘈眯裳畴淀峭垄瞻肴惮椭俭稠倘诧沧霞疆馋浊雹哆溉暄拄磋辽荤炊挎侨舶锲辕踊',
);

$count = (object)array(
	'hanzivg' => 0,
	'animhanzi' => 0,
	'kanjivg' => 0,
	'missing' => 0,
);

// the following two functions have been taken from
// https://stackoverflow.com/questions/9361303/can-i-get-the-unicode-value-of-a-character-or-vise-versa-with-php#answer-27444149

// code point to UTF-8 string
function unichr($i) {
    return iconv('UCS-4LE', 'UTF-8', pack('V', $i));
}

// UTF-8 string to code point
function uniord($s) {
    return unpack('V', iconv('UTF-8', 'UCS-4LE', $s))[1];
}

foreach ($hsk as $n => $charstring) {
	print '<h2>HSK ' . ($n+1) . '</h2>';
	$chars = preg_split('//u', $charstring, -1, PREG_SPLIT_NO_EMPTY);
	foreach ($chars as $char) {
		$d = substr("00000" . dechex(uniord($char)),-5);
		$class = '';
		if (is_file('hanzi/' . $d . '.svg')) {
			$class.= ' ok';
			$count->hanzivg++;
			// delete files from kanji and animhanzi if they exist in hanzivg (including variants)
			if(is_file('kanji/' . $d . '.svg')) {
				unlink('kanji/' . $d . '.svg');
			}
			$variants = glob('kanji/' . $d . '-*.svg');
			if(count($variants)) {
				foreach ($variants as $variantFile) {
					unlink($variantFile);
				}
			}
			if(is_file('animhanzi/' . $d . '.svg')) {
				unlink('animhanzi/' . $d . '.svg');
			}
		} else if (is_file('animhanzi/' . $d . '.svg')) {
			$class.= ' animhanzi';
			$count->animhanzi++;
		} else if (is_file('kanji/' . $d . '.svg')) {
			$class.= ' kanji';
			$count->kanjivg++;
		} else {
			$count->missing++;
		}

		print '<span class="char' . ($class) . '">' . $char .'</span>';
	}
}
$body = ob_get_clean();

?>
<span class="legend char ok"><?= $count->hanzivg ?></span> = implemented in HanziVG | <span class="legend char animhanzi"><?= $count->animhanzi ?></span> = TODO: check from AnimHanzi | <span class="legend char kanji"><?= $count->kanjivg ?></span> = TODO: check from KanjiVG | <span class="legend char"><?= $count->missing ?></span> = TODO: missing / from scratch

<?php
print $body;
?>
<script type="text/javascript">
	if (!/(htmlpreview\.github\.io|rawgit\.com)/.test(window.location.host)) {
		var chars = document.getElementsByClassName('char');
		for (var i = 0; i < chars.length; i++) {
			var char = chars[i];
			if(char.classList.contains('legend')) continue;
			char.classList.add('clickable');
			char.addEventListener('click', function(ev) {
				window.open('compare.php?hanzi=' + ev.target.textContent);
			});
		}
	}
</script>
</body>
</html>
<?php
// write to HTML file which we can link to in the README
$content = ob_get_flush();
file_put_contents('status_hsk.html', $content);