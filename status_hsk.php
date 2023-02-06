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
		.char.wip {
			background-color: #ff00ff;
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

		.active {
			outline: dashed blue 2px;
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
	'Frequently used hanzi not in HSK (875 characters)' => '卜乃弓刃屯冈仆爪丹凤轧禾兰尼芝匠邪贞朱乔刘奸坊芹芬芳芦杏杨歼吴呜肝龟卵亩冶汪沈宋尿妖纱驴茄茅枣顷肾咏罗岭凯秆侍斧狐闸炕孟陕驼垮赵拴茧柄柏柳砌虾贱缸竿疮阀阁姜剃袄垦垒骆绞蚕盏匪莲荷桂桐栗轿毙晌蚊钳秧笋倚徐爹翁狸浆脊浙涝浩绢勒萝菊萍菠梅啄铲犁笛鹿寇窑屠婶绵揪葛葱葵棚雁蛙蛛蜓锄鹅筝腊粪絮缎瑞蒜鹊槐榆蛾锡锣锯痰韵粱碧暮榴蜻蝇蜘锹箩僚熔寨翠凳骡槽樱燕薯橘蹄螺穗糠镰鹰囊匕刁戈夭仑冗邓艾夯卢叽皿囚矢乍冯玄邦迂邢芋芍吏夷吕吆屹廷臼仲伊肋旭匈凫亥汛讹诀弛驮驯纫玖玛抠扼汞扳抡坎坞芙芜苇芥芯芭杉巫杈甫匣轩卤吱吠呐呛吭邑囤吮岖牡佑佃囱肛肘甸鸠彤灸刨庐闰灼沥沦沪忱诅妓姊玫卦坷坯坪坤拂拇拗茉苛苫苞茁苔枢枫杭矾奄昙咕咒咆帕贮秉刽忿瓮肮狞疟疚卒炬沽泞怔宛衩祈诡帚弧函虱叁驹绊契贰玷玲珊拭拷拱挟垢垛拯荆茸茬荚茵茴荞荠荧荔栈柑栅柠枷砂泵砚鸥轴韭盹咧昵昭盅勋咪哟钠钧钮毡氢秕俏俄侯胚胧狰饵峦奕飒闺闽籽娄洼柒涎洛恃恬恤宦祠诲屎陨姚娜蚤骇耘耙秦匿埂捂袁捌捅埃耿聂荸莽莱莉莹莺梆栖桦栓桅桩贾砰砾殉逞哮蚌蚜蚣蚪蚓哩圃鸯唁唧赃钾铆氨秫笆俺殷舀豺豹胯胰脐脓卿鸵鸳馁郭斋疹羔烙浦涡涣涤涧悍悯袒谆祟娩骏琐麸琉琅捺捶赦埠捻掂掖掸掺菱菲菩萤乾萧萨菇彬梗梧梭曹硅盔匾颅彪曼晦冕畦趾蛆蚯蛉蛀唬崎崔赊铐铛铝铡铣矫秸秽笙笤偎傀躯舷舵敛翎脯逸凰猖祭庶庵痊阎眷焊焕鸿涯淑淌淮渊淫淳淤悴窒裆祷谒谚尉隅婉绰绷绽琳琼堰揩揽揖彭揣壹搔葫募蒋韩棱椰焚棺榔粟棘酣酥硝硫颊雳凿棠鼎喳跋跛蛔蜒蛤鹃啼赎赐锉锌甥氮氯黍筏牍粤逾腌腋腕猩猬敦痘痢竣遂焙湘渤湃愕惶窖窘犀媚婿缅缆缕瑟鹉瑰搪靴靶蓖蒿蒲蓉楔椿楷榄楞楣酪碘硼碉嗜暇畸跷跺蜈蜗蜕蛹嗡嗤蜀幌锚锥锨锭锰颓魁衙腮腺鹏肄猿煞雏馍馏禀痴靖誊漓溢溯滓溺窥窟褂裸缤剿赘赫蔫摹蔗熙榛榕酵碟碴碱嘁蝉嘀幔镀箍箕箫僧孵瘟漱漩漾寡寥谭褐褪嫡缨撵撩撮撬擒墩撰鞍蕊樊樟橄豌醇碾嘶嘹蝠蝎蝌蝗蝙镊镐稽篓膘鲤鲫褒瘪凛澎潭潦澳潘澜憔懊憎翩褥鹤憨嬉缭擂薛薇翰噩橱瓢蟥霎冀踱蹂蟆螃螟鹦黔穆篡篙篱膳鲸燎懈窿缰壕檬檐檩檀礁磷瞭瞳曙蟋蟀嚎赡镣魏簇儡徽爵朦臊鳄糜懦豁臀藕藤嚣鳍癞襟璧戳孽蘑藻鳖蹭簿蟹靡癣羹鬓攘蠕巍鳞糯霹躏髓蘸瓤矗',
	'Commonly used hanzi not in HSK nor frequently used (3462 characters)' => '乂乜亍兀弋彳丫巳孑孓幺亓韦廿卅仄厄曰壬仃仉仂兮刈爻殳卞亢闩讣尹夬爿毋邗戋卉邛艽艿札叵匝丕戊匜劢卟叱叩叻冉氕仨仕仟仡仫伋仞卮氐犰卯刍庀邝邙汀汈忉宄讦讧讪讫尻弗弘阢阡尕弁驭匡耒玎玑戎圩圬圭扦圪圳圹扪圯圮芏芊芨芄芎芑芗亘厍戌夼戍尥尧乩旯曳岌屺凼囝囡钆钇缶氘氖牝伎伛伢仳佤仵伥伧伉伫囟甪汆氽刖夙旮犴刎犷犸舛邬饧冱邡汕汔汲汐汜汝汊忖忏讴讵祁讷聿艮厾阮阪丞妁妃牟纡纣纥纨纩玕玙玚抟抔坜圻坂扺坍抃抉毐芫邯芸芾芰苈苊苣芷芮苋芼苌苁芩芪芴芡芟苄苎苡杌杓杧杞忑孛吾邴酉邳矶奁豕忒欤轪轫迓邶忐芈卣邺旰呋呓呔呖呃旸吡町虬呙呗吣吲岍帏岐岈岘岑岚兕囵囫钊钋钌迕氙氚岙佞邱佐伾攸佚佝佟佗伽彷佘佥孚豸坌肟邸奂劬狄狃狁邹饨饩饫饬亨庑庋疔疖肓闱闳闵闶羌炀沣沅沄沔沤沌沘沏沚汩汨汭沂汾沨汴汶沆沩沁泐怃忮怄忡忤忾怅忻忪怆忭忸诂诃祀祃诋诌诎诏诐诒屃孜陇阽阼陀陂陉妍妩妪妣妊妗妫妞姒妤邵劭刭甬邰矣纭纰纴纶纻纾玮玡玠玢玥玦甙盂忝匦邽坩垅抨拤拈坫垆抻拃拊坼拎坻坨坭抿拚坳耵耶苷苯苤茏苴苜苒苘茌苻苓茚茆茑苑茓茔茕苠茀苕枥枇杪杳枘枧杵枨枞枋杻杷杼矸矻矽砀刳瓯殁郏轭郅鸢盱昊杲昃咂呸昕昀旻昉炅咔畀虮迪呷黾呱呤咚咛咄呶呦咝岵岢岿岬岫帙岣峁刿峂迥岷剀帔峄沓囹罔钍钎钏钐钒钔钕钗邾迭迮牦竺迤佶佬佴侑佰侉臾岱侗侏侩佻佾侪佼佯侬帛阜侔郈徂郐郄怂籴戗肼朊肽肱肫肭肷剁迩郇狉狙狎狝狍狒咎炙枭饯饳饴冽冼庖疠疝疡兖庚妾於劾炜炖炝炔泔沭泷泸泱泅泗泠泜泺泃泖泫泮沱泯泓泾怙怵怦怛怏怍怩怫怊怿怡宕穸穹宓诓诔诖诘戾诙戽郓祆祎祉诛诜诟诠诣诤诨诩鸤戕孢亟陔卺妲妯姗妮帑弩孥驽迦迢迨绀绁绂驵驷驸绉驺绋绌驿骀甾砉耔珏珐珂珑玳珀顸珉珈韨拮垭挝垣垯挞垤赳贲垱垌哉垲挢埏郝垍垧垓垟垞挦垠拶茜荙荑贳荛荜茈茼莒茱莛茯荏荇荃荟荀茗茭茨垩茳荥荦荨茛荩荪荫茹荬荭柰栉柯柘栊柩枰栌柙枵柚枳柞柝栀柃柢栎枸柈柁柽剌郚剅酊郦砗砑砘砒斫砭砜奎耷虺殂殇殄殆轱轲轳轵轶轷轸轹轺虿毖觇尜哐眄眍郢眇眊昽眈咭禺哂咴曷昴昱咦哓哔畎毗呲胄畋畈虼虻咣哕剐郧咻囿咿哌哙哚咯咩咤哝哏哞峙峣罘帧峒峤峋峥峧帡贶贻钘钚钛钡钣钤钨钪钫钬钭钯矧氡氟牯郜秭竽笈笃俦俨俅俪叟垡牮俣俚俜皈禹俑俟逅徇徉舢舣俞弇郗俎卻爰郛瓴胨胩胪胛胂胙胍胗胝朐胫鸨匍狨狯飐飑狩狲訇訄逄昝饷饸饹饻胤孪娈庤弈庥疬疣疥疭疢庠竑彦闼闾闿羑籼酋兹炳炻炟炽炯烀炷烃洱洹洧洌浃泚浈浉洇洄洙洑洎洫浍洮洵洚洺洨浐洴洣浒浔浕洳恸恹恫恺恻恂恪恽宥宬窀扃袆衲衽衿袂祛祜祓祚诮祗祢诰诳鸩昶郡咫弭牁胥陛陟陧姞娅娆姝姽姣姘姹怼羿炱癸矜绔骁骅绗绚彖绛骈耖挈恝珥珙顼珰珽珩珧珣珞琤珲敖恚埔埕埘埚埙挹耆耄捋埒贽垸捃盍莰茝莆莳莴莪莠莓莜莅荼莶莩荽莸荻莘莎莞莨莙鸪莼栲栳郴桓桡桎桢桄桤梃栝桕桁桧栒栟桉栩逑逋彧鬲豇酐酎酏逦厝孬砝砹砺砧砷砟砼砥砣硁恧剞砻轼轾辀辁辂鸫趸剕龀鸬虔逍眬唛晟眩眙唝哧哳哽唔晔晁晏晖鸮趵趿畛蚨蚍蚋蚬蚝蚧唢圄唣唏盎唑帱崂崃罡罟峨峪觊赅赆钰钲钴钵钷钹钺钼钽钿铀铂铄铈铉铊铋铌铍铎眚氩氤氦毪舐秣盉笄笕笊笫笏俸倩俵倻偌俳俶倬倏恁倭倪俾倜隼隽倞倓倌倥臬皋郫倨衄颀徕舨舫瓞釜奚鬯衾鸰胱胴胭脍脎胲胼朕脒胺鸱玺鱽鸲狴狷猁狳猃狺逖狻桀袅眢饽馀凇栾挛勍亳疳疴疽疸痄痈疱疰痃痂痉衮凋颃恣旆旄旃阃阄阆恙桊敉粑朔郸烜烨烩烊剡郯烬浡涑浯涞涟娑涅涠浞涓涢浥涔浜浠浼浣涘浚悖悚悭悝悃悒悌悢悛宸窅窈剜诹扅诼冢袪袗袢袯祯祧冥诿谀谂谄谇屐屙陬勐奘疍牂蚩陲陴烝姬娠娌娉娟娲娥娴娣娓婀砮哿畚逡剟绠骊绡骋绤绥绦骍绨骎邕鸶彗耜焘舂琎琏琇掭揶埴掎埼埯捯焉掳掴埸堌赧捭晢逵埝堋堍掬鸷掊堉捩掮悫埭埽掇掼聃聆聍菁菝萁菥菘堇萘萋勩菽菖萜萸萑菂棻菔菟萏萃菼菏菹菪菅菀萦菰菡梽梵梾梏觋桴桷梓棁桫棂郾匮敕豉鄄酞酚厣戛硎硭硒硖硗硐硚硇硌鸸瓠匏厩龚殒殓殍赉雩辄堑龁眭唪眦啧晡眺眵眸圊啪喏喵啉勖晞晗啭趼趺啮跄蚶蛄蛎蚰蚺蛊圉蚱蛏蚴鄂啁啕唿啐唼唷啴啖啵啶啷唳啜帻崦帼崮帷崟崤崞崆崛赇赈铑铒铕铗铘铙铚铞铟铠铢铤铥铧铨铩铪铫铬铮铯铰铱铳铴铵铷氪牾鸹稆秾逶笺筇笸笪笮笱笠笥笳笾笞偾鸺偃偕偈偲偬偻皑皎鸻徜舸舻舳舴鸼龛瓻豚脶脞脬脘脲脧匐鱾猗猡猊猞猄猝斛觖猕馗馃馄鸾孰庹庼庾庳痔痍疵翊旌旎袤阇阈阉阊阋阌阍阏羚羝羟粝粕焐烯焓烽焖烷烺焌渍渚淇淅淞渎涿淖挲淏淠涸渑淦淝淬涪淙涫渌淄惬悻悱惝惘悸惟惆惚惇寅逭窕谌谏扈皲谑袼裈裉祲谔谕谖谗谙谛谝敝逯艴隋郿隈粜隍隗婧婊婞婳婕娼婢婵胬袈翌恿欸绫骐绮绯骒绲骓绶绹绺绻绾骖缁耠琫琵琶琪瑛琦琥琨靓琰琮琯琬琛琚辇鼋揳堞搽塃揸揠堙趄揾颉塄揿堠耋揄蛰蛩絷塆揞揎摒揆掾葜聒葑葚靰靸葳蒇蒈葺蒉葸萼蓇萩葆葩葶蒌葓蒎萱葖戟葭楮棼椟棹椤棰椑鹀赍椋椁棬楗棣椐鹁覃酤酢酡酦鹂觌硪硷厥殚殛雯辊辋椠辌辍辎斐黹牚睐睑睇睃戢喋嗒喃喱喹晷喈跖跗跞跚跎跏跆蛱蛲蛭蛳蛐蛞蛴蛟蛘蛑畯喁喟斝啾嗖喤喑嗟喽嗞喀喔喙嵘嵖崴遄詈嵎崽嵚嵬嵛翙嵯嵝嵫幄嵋赑铹铻铼铽铿锃锂锆锇锊锎锏锑锒锓锔锕掣矬氰毳毽犊犄犋鹄犍颋嵇稃稂筘筚筜筅筵筌傣傈舄傥傧遑皓皖傩遁徨舾畲弑颌翕釉鹆舜貂腈腓腆腴腑腙腚腱腒鱿鲀鲂鲃颍猢猹猥飓觞觚猸猱飧馇馉馊亵脔裒廋斌痣痨痦痞痤痫痧鄌赓竦瓿啻颏鹇阑阒阕粞遒孳焯焜焱鹈湛渫湮湎湝湨湜渭湍湫溲湟溆渝湲溠溇湔湉渲渥湄滁愠惺愦惴愀愎愔喾寐谟扉棨扊裢裎裣裥祾祺祼谠禅禄幂谡谥谧塈遐孱弼巽骘媪媛婷巯毵翚皴婺骛缂缃缄彘缇缈缌缏缑缒缗骙飨耢瑚瑁瑀瑜瑗瑄瑕遨骜瑙遘韫髡塥塬鄢趔趑摅摁赪塮蜇搋搒搐搛搠摈彀毂搌搦搡蓁戡蓍鄞靳蓐蓦鹋蒽蓓蓊蒯蓟蓑蒺蓠蒟蒡蒹蒴蒗蓂蓥颐蓣楠楂楝楫榀楸椴槌楯榇榈槎榉楦楹椽裘剽甄酮酰酯酩蜃碛碓碚碇碜鹌辏辒龃龅龆觜訾粲虞睚嗪睫韪嗷嗉睨睢雎睥嘟嗑嗫嗬嗔嗝戥嗄煦暅遢暌跬跶跸跐跣跹跻跤蛸蜎蜊蜍蜉蜣畹嗣嗥嗲嗳嗌嗍嗵罨嵊嵩嵴骰锖锗锘锛锜锝锞锟锢锧锪锫锩锬锱雉氲犏歃稞稗稔筠筢筮筻筲筼筱牒煲鹎敫僇徭愆艄觎毹貊貅貉颔腠腩腼腽腭腧塍媵詹鲅鲆鲇鲈鲉鲊稣鲋鲌鲍鲏鲐鹐飔飕觥遛馌馐鹑亶廒瘃痱痼痿瘐瘁瘅瘆鄘麂鄣歆旒雍阖阗阘阙羧豢粳猷煳煜煨煅煊煸煺滟溱溘滠漭滢滇溥溧溽裟溻溷溦滗滫溴滏滃滦溏滂溟滘滍滪愫慑慥慊鲎骞窦窠窣裱褚裼裨裾裰禊谩谪谫媾嫫媲嫒嫔媸缙缜缛辔骝缟缡缢缣骟耥璈瑶瑭瑢獒觏慝嫠韬墈摽墁撂摞撄翥踅銎摭墉墒榖撖摺綦蔷靺靼鞅靽鞁靿蔌甍蔸蓰蔹蔡蔟蔺戬蕖蔻蓿斡鹕嘏蓼榧槚槛榻榫槜榭槔槁槟槠榷榍僰酽酾酲酶酴酹厮碶碡碣碲碹碥劂臧豨殡霆霁辗蜚裴翡龇龈睿夥瞅瞍睽嘞嘌嘎暝踌踉跽蜞蜥蜮蜾蝈蜴蜱蜩蜷蜿螂蜢嘘嘡鹗嘣嘤嘚嗾嘧罴罱嶂幛赙罂骷骶鹘锴锶锷锸锽锾锵锿镁镂镃镄镅犒箐箦箧箸箨箬箅箪箔箜箢箓毓僖儆僳僭僬劁僦僮魃魆睾艋鄱膈膑鲑鲔鲙鲚鲛鲟獐獍飗觫雒夤馑銮塾麽廙瘌瘗瘊瘥瘘瘙廖韶旖膂阚鄯鲞粼粽糁槊鹚熘煽熥潢潆漤漕滹漯漶潋潴漪漉漳澉潍慵搴窬窨窭寤肇綮谮褡褙褓褛褊禚谯谰谲暨屣鹛嫣嫱嫖嫦嫚嫘嫜嫪鼐翟瞀鹜骠缥缦缧骢缪缫耦耧瑾璜璀璎璁璋璇璆奭髯髫撷撅赭墦撸鋆撙撺墀聩觐鞑蕙鞒蕈蕨蕤蕞蕺瞢劐蕃蕲蕰赜鼒槿樯槭樗樘槲鹝醌醅靥魇餍磊磔磙磉殣慭霄霈辘龉龊觑瞌瞑嘻嘭噎噶颙暹踔踝踟踬踮踣踯踺踞蝽蝾蝻蝰蝮螋蝓蝣蝼蝤噗嘬颚噍噢噙噜噌噀噔颛幞幡嶓嶙嶝骺骼骸镆镈镉镋镌镍镎镏镑镒镓镔稷箴篑篁篌篆牖儇儋徵磐虢鹞鹟滕鲠鲡鲢鲣鲥鲦鲧鲩鲪鲬橥獗獠觯鹠馓馔麾廛瘛瘼瘢瘠齑鹡羯羰糇遴糌糍糈糅翦鹣熜熵熠澍澌潵潸鲨潲鋈潟潼潽潺潏憬憧寮窳谳褴褫禤谵屦勰戮蝥缬缮缯骣畿耩耨耪璞璟靛璠璘聱螯髻髭髹擀熹甏擐擞磬鄹颞蕻鞘黇颟薤薨檠薏蕹薮薜薅樾橛橇樵檎橹橦樽樨橼墼橐翮醛醐醍醚醑觱磺磲赝飙殪霖霏霓錾辚臻遽氅瞟瞠瞰嚄嚆噤暾曈蹀蹅踶踹踵踽蹉蹁螨蟒螈螅螭螗螠噱噬噫噻噼幪罹圜镖镗镘镚镛镝镞镠氇氆憩穑穄篝篚篥簉篦篪盥劓翱魉魈徼歙盦膪螣膦膙鲭鲮鲯鲰鲱鲲鲳鲴鲵鲷鲺鲹鲻獴獭獬邂憝亸鹧廨赟癀瘭瘰廪瘿瘵瘴癃瘳斓麇麈嬴壅羲糗瞥甑燠燔燧燊燏濑濉潞澧澴澹澥澶濂澼憷黉褰寰窸褶禧嬖犟隰嬗鹨翯颡缱缲缳璨璩璐璪螫擤觳罄擢藉薹鞡薷薰藓藁檑檄懋醢翳繄礅磴鹩龋龌豳壑黻瞵嚅蹑蹒蹊蹓蹐螬螵疃螳蟑嚓羁罽罾嶷黜黝髁髀镡镢镤镥镦镧镨镩镪镫罅黏簧簌篾簃篼簏簖簋鼢黛鹪鼾皤魍艚龠繇貘邈貔臌膻臁臆臃鲼鲽鲾鳀鳁鳂鳃鳅鳆鳇鳈鳉鳊獯螽燮鹫襄縻膺癍麋馘懑濡濮濞濠濯蹇謇邃襕襁檗甓擘孺隳嬷蟊鹬鍪鏊鳌鬹鬈鬃瞽鞯鞨鞫鞧鞣藜藠藩鹲檫檵醪蹙礞礓礌燹餮蹩瞿曛颢曜躇鹭蹢蹜蟛蟪蟠蟮嚚鹮黠黟髅髂镬镭镯镱馥簠簟簪簦鼫鼬鼩雠艟臑鳎鳏鳐鳑鹱癔癜癖糨冁瀍瀌鎏懵彝邋鬏攉鞲鞴藿蘧蘅麓醭醮醯礤酃霪霭黼嚯蹰蹶蹽蹼蹯蹴蹾蹿蠖蠓蠋蟾蠊巅黢髋髌镲籀籁鳘齁魑艨鼗鳓鳔鳕鳗鳙鳚麒鏖蠃羸瀚瀣瀛襦谶襞骥缵瓒馨蘩蘖蘘醵醴霰颥酆矍曦躅鼍巉黩黥镳镴黧纂鼯犨臜鳜鳝鳟獾瀹瀵孀骧耰瓘鼙醺礴礳颦曩黯鼱鳡鳢癫麝赣夔爝灏禳鐾羼蠡耲耱懿韂鹳糵蘼霾氍饕躔躐髑镵穰鳤饔鬻鬟趱攫攥颧躜鼹鼷癯麟蠲蠹醾躞衢鑫灞襻纛鬣攮囔馕戆蠼爨齉'
);

$count = (object)array(
	'hanzivg' => 0,
	'animhanzi' => 0,
	'kanjivg' => 0,
	'missing' => 0,
	'wip' => 0,
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

$totalchars = 0;
$totalcharsHSK = 0;

foreach ($hsk as $n => $charstring) {
	$chars = preg_split('//u', $charstring, -1, PREG_SPLIT_NO_EMPTY);
	$charcount = count($chars);
	$totalchars+= $charcount;

	$thisCount = (object)array(
		'total' => 0,
		'hanzivg' => 0,
		'animhanzi' => 0,
		'kanjivg' => 0,
		'missing' => 0,
		'wip' => 0,
	);
	$thisTodoCount = 0;

	if (is_numeric($n)) {
		$totalcharsHSK+= $charcount;
		print '<hr><h2>HSK ' . ($n+1) . ' (' . $charcount . ')</h2>';
	} else {
		print '<hr><h2>' . $n . '</h2>';
	}

	foreach ($chars as $char) {
		$d = substr("00000" . dechex(uniord($char)),-5);
		$class = '';
		if (is_file('hanzi/' . $d . '.svg')) {
			$class.= ' ok';
			$count->hanzivg++;
			$thisCount->hanzivg++;
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
		} else if (is_file('hanzi_wip/' . $d . '.svg') || is_file('hanzi_wip/' . $d . '.raw.svg')) {
			$class.= ' wip';
			$count->wip++;
			$thisCount->wip++;
			$thisTodoCount++;
		} else if (is_file('animhanzi/' . $d . '.svg')) {
			$class.= ' animhanzi';
			$count->animhanzi++;
			$thisCount->animhanzi++;
			$thisTodoCount++;
		} else if (is_file('kanji/' . $d . '.svg')) {
			$class.= ' kanji';
			$count->kanjivg++;
			$thisCount->kanjivg++;
			$thisTodoCount++;
		} else {
			$count->missing++;
			$thisCount->missing++;
			$thisTodoCount++;
		}

		$thisCount->animhanzi_hours = round( $thisCount->animhanzi * 10 / 60, 2);
		$thisCount->kanjivg_hours = round( $thisCount->kanjivg * 20 / 60, 2);
		$thisCount->missing_hours = round( $thisCount->missing * 30 / 60, 2);

		$thisCount->total_hours = $thisCount->animhanzi_hours + $thisCount->kanjivg_hours + $thisCount->missing_hours;

		print '<span class="char' . ($class) . '">' . $char .'</span>';
	}
	?>
<p>
<span class="legend char ok"><?= $thisCount->hanzivg ?></span> <span class="legend char animhanzi"><?= $thisCount->animhanzi . ( $thisCount->animhanzi_hours ? "(≈" . $thisCount->animhanzi_hours . "h)" : '' ) ?></span> <span class="legend char kanji"><?= $thisCount->kanjivg . (  $thisCount->kanjivg_hours ? "(≈" . $thisCount->kanjivg_hours . "h)" : '' ) ?></span> <span class="legend char"><?= $thisCount->missing . ( $thisCount->missing_hours ? "(≈" . $thisCount->missing_hours . "h)" : '' ) ?></span> <span class="legend char wip"><?= $thisCount->wip ?></span> | TODO: <?= $thisTodoCount ?> <?= ( $thisCount->total_hours ? "(≈" . $thisCount->total_hours . "h)" : '' ) ?> | <?= round(($charcount - $thisTodoCount) / $charcount * 100, 2) ?>% done
</p>
<?php
}
$body = ob_get_clean();

?>
<span class="legend char ok"><?= $count->hanzivg ?></span> = implemented in HanziVG | <span class="legend char animhanzi"><?= $count->animhanzi ?></span> = TODO: check from AnimHanzi | <span class="legend char kanji"><?= $count->kanjivg ?></span> = TODO: check from KanjiVG | <span class="legend char"><?= $count->missing ?></span> = TODO: missing / from scratch | <span class="legend char wip"><?= $count->wip ?></span> = TODO: work in progress

<?php

print '<p>overall progess (HSK): ' . $count->hanzivg . ' / ' . $totalcharsHSK . '(' . round($count->hanzivg / $totalcharsHSK * 100, 2) . '%)</p>';
print '<p>overall progess (all): ' . $count->hanzivg . ' / ' . $totalchars . '(' . round($count->hanzivg / $totalchars * 100, 2) . '%)</p>';

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
				var active = document.querySelector('.active');
				if (active) {
					active.classList.remove('active');					
				}
				ev.target.classList.add('active');
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