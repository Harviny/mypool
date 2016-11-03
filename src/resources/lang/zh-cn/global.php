<?php

return [
    'loading' => '加载中...',
    'title' => 'BTC.COM 矿池',
    'menu' => [
        'index' => '首页',
        'dashboard' => '用户面板',
        'miners' => '矿机',
        'poolStats' => '统计',
        'help' => '帮助',
    ],
    'meta' => [
        'keywords' => '比特币,矿池,挖矿,BTC,鱼池,蚁池,国池,币网,via,viabtc,f2pool,antpool,btcc,bw,pool,蚂蚁,矿机',
        'description' => 'BTC矿池是比特币挖矿的全新选择，相比传统矿池，BTC矿池拥有更稳定的矿池系统，更好的用户体验，更优惠的费率，更强大的配套设施。',
    ],
    'common' => [
        'charts' => [
            'poolCharts' => '矿池算力曲线',
            'myCharts' => '我的算力曲线',
            'minerCharts' => '矿机算例曲线',
            'hashrate' => '算力',
            'reject' => '拒绝率',
            'time' => '时间',
        ],
        'group' => [
            'AllGroups' => '全部',
            'Default' => '未分组',
            'emptyName' => '组名称不能为空!',
            'exist' => '该组已存在!',
            'remove' => '该矿机已删除!',
            'remove_not' => '您删除包含有效矿工!',
            'notChecked' => '请勾选矿机,支持批量操作!',
            'remove_default' => '暂不能删除此分组!',
            'd' => '天',
            'h' => '小时',
            'm' => '分钟',
            'ago' => '前',
            'none' => '无',
        ],
        'users' => [
            'currentName' => '当前用户',
            'BitcoinAddress' => 'BTC 收款地址',
            'NamecoinAddress' => 'NMC 收款地址',
            'EarningsHistory' => '收益历史',
            'SignOut' => '退出',
            'locationRegion' => '您当前位于<strong>:node_info</strong>服务器',
            'locationEx' => '
                            <p>BTC矿池在世界各地建立了多个数据中心，每个子账户将绑定一个数据中心，算力、收益均独立结算。</p>
                            <p>请您选择距离最近的区域，这将有助于提升连接质量。</p>
                          ',
            'CurrentRegion' => '当前区域',
            'CN-01' => 'CN-01 中国北京',
            'choose' => '区域选择',
            'ok' => '我知道了',
            'user-center' => '用户中心',
            'create-worker' => '创建子账户',
            'subsidy-address'=>'补贴收款地址',
            'setNMCAddress'=>'请点击设置NMC地址',
            'setSubsidyAddress'=>'请点击设置补贴地址',
        ],
        'setAddress' => [
            'ModifyAddress' => '更改地址',
            'Modify' => '修改',
            'old' => '旧地址',
            'new' => '新地址',
            'enterCode' => '请填写验证码',
            'newBit' => '您的新比特币地址',
            'way' => '我们将发送验证码来确认此次修改 , 请选择验证方式:',
            'sendCodeMail' => '验证码已发送到邮箱',
            'sendCodeMobile' => '验证码已发送到手机',
            'continue' => '下一步',
            'done' => '提交',
            'updateSuccess' => '地址修改成功!',
            'Okay' => '确定',
            'emptyAddress' => '地址不能为空',
            'invalidAddress' => '错误的地址',
            'emptyCode' => '验证码不能为空',
            'wrongCode' => '验证码错误',
            'emailVia' => '发送邮件到',
            'textVia' => '发送短信到'
        ],
        'footer' => [
            'chain' => '区块浏览器',
            'app' => 'App',
            'pool-app' => '矿池App',
            'tools' => '工具',
            'About' => '关于我们',
            'api' => 'API',
            'feedback' => '用户反馈'
        ],
        'errorLater' => '请稍后再试 ...',
        'home' => '首页',
        'language' => '语言',
        'd' => '天',
        'h' => '小时',
        'm' => '分钟',
        'sub_account' => '子账户',
    ],
    'lang' => [
        'en' => 'English',
        'zh-cn' => '简体中文',
        'ru' => 'русский',
    ],
    'index' => [
        'title' => 'BTC矿池，更好的比特币矿池',
        'newChoice' => '全新选择  &nbsp;&nbsp;现已来临',
        'fee' => '零手续费+补贴1%收益',
        'subsidy'=>'* 12月31日前 PPS 手续费全免（原定1.5%），每连续挖矿30天还将获得1%收益补贴',
        'hashrate' => '算力图表',
        'found' => '已挖',
        'workerOnline' => '在线矿机',
        'blocks' => '区块',
        'pool_static' => '矿池数据',
        'sign-up-now' => '马上注册',
        'sign-in' => '登录',
        'customer-service' => '<span class="leader" style="margin-top: 10px;">直接联系客服</span><span class="leader leader-number">400-890-8855 </span><span class="leader">语音提示后选1再选3</span>'
    ],
    'dashboard' => [
        'title' => '用户面板 - BTC Pool',
        'dashboard' => '用户面板',
        'realHashrate' => '实时算力',
        'minute' => '分钟',
        'miners' => '矿机数',
        'active' => '活跃',
        'inActive' => '非活跃',
        'earning' => '收益',
        'today' => '今日',
        'yesterday' => '昨日',
        'hastrateChart' => '算力图表',
        'nowHashrate' => '当前算力',
        'activeMiner' => '活跃矿机',
        'more' => '更多',
        'accountEarning' => '账户收益',
        'unpaid' => '未支付',
        'amoutPaid' => '已支付',
        'history' => '支付记录',
        'lastPaymentTime' => '上一次支付时间',
        'pendingPayouts' => '待确认支付',
        'miningAddress' => '挖矿地址',
        'minerName' => '矿机名设置参考："<span class="workerID">workername</span>.001"，"<span class="workerID">workername</span>.002".',
        'networkStatus' => '网络状态',
        'networkHashrate' => '全网算力',
        'poolHashrate' => '矿池算力',
        'miningEarnings' => '每T收益',
        'nextDifficult' => '预测下次难度',
        'timeRemain' => '距离调整还剩',
        'customer-title' => '售后服务',
        'customer-table' => ' <dl>
                                <dt><a href="https://bitmain.kf5.com/" target="_blank">工单系统</a></dt>
                                <dd> 与在线客服一对一交谈</dd>
                            </dl>
                            <dl>
                                <dt><a href=":feedback_link" target="_blank">吐槽</a></dt>
                                <dd>给开发人员留言</dd>
                            </dl>
                            <dl>
                                <dt>QQ群</dt>
                                <dd>561862396</dd>
                            </dl>
                            <dl>
                                <dt>客服电话</dt>
                                <dd>400-890-8855 语音提示后选1再选3</dd>
                            </dl>
                            <dl>
                                <dt>VIP服务专员</dt>
                                <dd>请拨打客服电话，提供用户名或算力证明后让客服转接</dd>
                            </dl>
                            <hr/>
                            <div>* BTC矿池向大算力用户提供独立服务器和私密IP地址，可100%抵御Ddos攻击。</div>'
    ],
    'miners' => [
        'title' => '矿机管理 - BTC Pool',
        'miners' => '矿机',
        'addGroup' => '创建分组',
        'delGroup' => '删除分组',
        'all' => '全部',
        'active' => '活跃',
        'inactive' => '不活跃',
        'dead' => '失效',
        'total' => '总算力',
        'workerName' => '矿机名',
        'Hashrate' => '算力',
        'Accepted' => '接受数',
        'Rejected' => '拒绝率',
        'LastShare' => '最近提交时间',
        'Status' => '状态',
        'Operation' => '操作',
        'selectAll' => '全选',
        'moveTo' => '移动到',
        'remove' => '删除',
        'delGroupTitle' => '删除分组',
        'groupName' => '分组名称',
        'done' => '提交',
        'confirm' => '确认删除当前分组?',
        'noMiner' => '该分组未检测到矿工',
        'tip' => '全部=活跃+不活跃；不活跃=失去连接超过10分钟；失效=失去连接超过1天。',
    ],
    'poolStats' => [
        'title' => '矿池统计 - BTC Pool',
        'poolStats' => '统计',
        'Hashrate' => '算力',
        'Miners' => '矿机',
        'Found' => '挖矿所得',
        'HashrateChart' => '算力图表',
        'BlocksRelayed' => '广播区块',
        'Height' => '高度',
        'time' => '时间',
        'blocks' => '区块',
        'BlockHash' => '区块哈希',
        'Reward' => '区块奖励'
    ],
    'miner' => [
        'title' => '矿机管理 - BTC Pool',
        'Miners' => '矿机',
        'Hashrate' => '算力',
        'RunningCondition' => '运行状况',
        'M' => '分钟',
        'Rejected' => '拒绝率',
        'Status' => '状态',
        'LastShare' => '最近提交时间',
        'LastShareIP' => '最近提交IP',
        'HashrateChart' => '算力图表',
        'trans' => [
            'seconds' => '秒',
            'mins' => '分钟',
            'hours' => '小时',
            'ago' => '前',
            'ACTIVE' => '活跃',
            'INACTIVE' => '不活跃',
            'DEAD' => '失效',
        ]
    ],
    'earn' => [
        'title' => '收益历史 - BTC Pool',
        'earn' => '收益记录',
        'paid' => '已支付',
        'Unpaid' => '未支付',
        'EarningsToday' => '今日收益',
        'EarningsYesterday' => '昨日收益',
        'Time' => '时间',
        'NetworkDifficulty' => '全网难度',
        'Earnings' => '收益',
        'Payment' => '支付时间',
        'Mode' => '结算模式',
        'Address' => '地址',
        'PaidAmount' => '支付数额',
        'yesterday' => '昨日收益为昨日00:00-24:00（国际标准时间）的收益。',
    ],
    'rebates' => [
        'SubsidyCounting' => '补贴进度',
        'DaysRemain' => '<span class="text-muted">剩余 <span id="activeDay"></span> 天</span>',
        'AccumulatedProfit' => '待发放收益',
        'time' => '补贴发放时间段',
        'AverageHashrate' => '平均算力',
        'ActiveTime' => '签到',
        'Address' => '收款地址',
        'Earnings' => '补贴数额',
        'to'=>'至',
        'support'=>'2016年12月31日前，用户将在持续不间断挖矿30天后获得额外1%的收益补贴（“持续不间断”的标准为日均算力波动不得低于之前最高日的50%，短时间停电、断网等情况请联系客服）。注：这一补贴来自于BTC.com运营经费。',
        'days'=>'天'
    ],
    'help' => [
        'title' => '帮助 - BTC Pool',
        'keywords' => '比特币,矿池,帮助,如何,怎么挖,哪家,挖矿,BTC,鱼池,蚁池,国池,币网,via,viabtc,f2pool,antpool,btcc,bw,pool,蚂蚁,矿机',
        'description' => '如何挖矿？怎么配置矿机和矿池？类似的问题一直困扰着新矿工，那就来BTC矿池吧。BTC矿池是比特币挖矿的全新选择，相比传统矿池，BTC矿池拥有更稳定的矿池系统，更好的用户体验，更优惠的费率，更强大的配套设施。',
        'help' => '帮助',
        'Configurations' => '矿机设置',
        'setAddress' => '矿池设置',
        'earnPayment' => '收益与支付',
        'aboutBitcoin' => '比特币简介',
        'faq' => '常见问题',
        'customer' => '联系客服',
        'beijingNode' => '中国节点挖矿地址',
        'eastAmericaNode' => '美国节点挖矿地址',
        'minerSet' => '矿机名设置',
        'formatWorkerID' => '格式：子账户.矿机编号',
        'exampleWorkerID' => '例如你的子账户是btcminer，你可以将多台矿机依次设置为btcminer.001、btcminer.002...以此类推。 矿机将会按编号顺序依次排列。',
        'password' => '密码：可不填，或随意输入',
        'setFind' => '在网站右上角点击“设置”按钮，可修改账户、地址等相应信息。如图：',
        'paymentTime' => '支付时间',
        'paymentEx' => '北京时间早8点（国际标准时间0点）结算前一日收益，2小时内结算完毕并支付。',
        'OnPaymentTime' => '关于支付确认时间',
        'PaymentTimeEx' => '在比特币网络上，一笔交易从发出到被确认需要一定时间。根据当前网络状况，这一时间大概在1分钟到2小时不等；
                                在比特币网络拥堵时，这一时间可能会更长。我们会通过各种办法，维持您的收款确认时间在行业最短水平。',
        'MiningMode' => '结算模式与手续费率',
        'MiningModeEx' => 'BTC矿池支持PPS结算方式，仅收取1.5%手续费，维持在业内最低水平。',
        'fees' => '支付是否收取手续费',
        'feesEx' => '与其他一些矿池不同：BTC矿池支付手续费由矿池承担。',
        'BitcoinEx' =>
             "<p>比特币是什么?</p>
              <div>比特币是世界主流的虚拟货币，通过“挖矿”产生。“挖矿”实际上是矿机芯片的计算过程，当矿机计算出符合条件的结果，即判定为“挖到”比特币。</div>
              <p>比特币钱包是什么？</p>
              <div>钱包指管理比特币地址的软件，可用来接收、发送和储存比特币。</div>
              <p>比特币地址是什么？</p>
              <div>比特币地址（例如：18AN9XojYq5EU5x8p6pgdYk3RKo6zu9xzy）由一串字符和数字组成。就像别人向您发送电子邮件一样，他可以通过您的比特币地址向您发送比特币。</div>
              <p>比特币私钥是什么？</p>
              <div>用来解锁对应钱包地址的一串字符，例如5J76sF8L5jTtzE96r66Sf8cka9y44wdpJjMwCxR3tzLh3ibVPxh。</div>
              <p>如何保管比特币地址，确保安全？</p>
              <div>使用比特币钱包的备份功能，或者打印您的私钥并放置在安全的地方。</div>
              <p>比特币交易是什么？怎么进行比特币交易？</p>
              <div>简单地说，比特币交易就是把比特币从一个地址发送到另一个地址。打开比特币钱包，填写发送对象的地址（部分钱包支持二维码扫描），发送即可完成交易。</div>
              <p>比特币交易为什么要等待确认？</p>
              <div>当一笔交易被一个区块收录时，可以说它有一次确认；在此区块之后每产生1个区块，此项交易的确认数就再加1。当确认数达到6及以上，通常认为这笔交易比较安全并不可逆转。</div>
              <p>比特币区块链是什么？</p>
              <div>区块链好比一本公开的账簿，它记录了自比特币诞生以来的所有交易，任何人都可自行下载、查看。一个区块相当于账簿上的一页。</div>
              <p>什么是爆块/报块？</p>
              <div>比特币协议规定全网每10分钟会产生1个区块，矿工完成计算任务，发现新的区块后，会获得约12.5个比特币的奖励，发现新区块又被称为爆块或者报块。</div>
              <p>比特币手续费支付给谁?</p>
              <div>比特币交易者需要向发现区块的矿工缴纳一笔交易费用，用来打包这笔交易，相当于把这笔交易记到“账簿”上。</div>
              <p>比特币的价格波动为什么这么大？</p>
              <div>与金银铜等传统贵金属类似，这跟许多因素有关，如政治局势、市场认可度等，但比特币价格通常高于挖矿成本，挖矿过程依然存在利润。</div>
              <p>挖矿需要什么条件？</p>
              <div>大规模挖矿需要通风良好、温度湿度适中的专用场地，稳定供应且价格合理的电力，了解比特币和挖矿的管理人员，精通电力线路维护、网络维护的技术人员。</div>
            ",
        'faqEx' =>
            " <p>我为什么没收到验证邮件?</p>
              <div>可能邮件被拦截放进了垃圾箱，可能被相关关键词屏蔽了，这都需要您去确认邮箱的设置；也可能矿池邮件服务器暂时出现了故障，请联系客服人员。</div>
              <p>如何在BTC矿池挖矿/如何将矿机连接到BTC矿池/如何添加子账户？</p>
              <div>联网登录矿机后台，填写您的子账户（密码建议留空），点击save & apply保存即可，矿机将在数分钟内自动添加到矿池网站页面。</div>
              <div>矿机名规则为：子账户+英文句号+编号，例如，您的子账户是wakuang，可以设置矿机名为wakuang.001、wakuang.002，以此类推，每个矿机名对应一台矿机。</div>
              <p>如何登录矿机后台？</p>
              <div>获取到矿机的IP地址，在同一局域网的电脑上使用网页浏览器访问该IP地址，使用默认账号（用户名root密码root）登录，即可访问矿机后台。</div>
              <p>矿机设置的密码怎么填？</p>
              <div>建议留空，当前市面上需要使用密码的矿池极少。</div>
              <p>如何在BTC矿池填写自己的比特币收款地址？</p>
              <div>登录BTC矿池，点击“设置”进入设置页面，再点击“编辑”按钮，即可填写收款地址。</div>
              <p>什么是幸运值？</p>
              <div>矿池爆块存在一定概率因素，爆块速度时快时慢；幸运值在理论值100%上下浮动，当幸运值高时，矿池的收益会增大，反之减小，但这只会影响选择PPLNS的用户。</div>
              <p>大概每过半个月收益都会减少一点，这是为什么？</p>
              <div>比特币全网难度每过半个月都会略有一些提升，矿工在保持原来算力的情况下。</div>
              <p>API有什么作用？</p>
              <div>API全称为“应用程序接口”，供技术人员调用获取矿池、矿机的信息。</div>
              <p>什么是拒绝数？拒绝率？</p>
              <div>拒绝数是指矿机提交的算力不符合服务器要求，被服务器拒绝的工作量。拒绝率是指拒绝数占总提交数的比例，数值越小，矿机的工作效率就越高。</div>
              <p>打款前后，待支付金额的数字变化和我收到的款项不符，这是为什么？</p>
              <div>因为扣除了1.5%的PPS结算手续费，所以余额中减少的金额与您收到的金额并不相等。</div>
            ",
        'QQGroup' => '<p>QQ群：561862396</p>',
        'feedback' => '意见反馈',
    ],
    'first-set' => [
        'title' => '创建子账户 - BTC Pool',
        'create-worker' => '创建子账户',
        'no-node' => '您还未选择节点!',
        'select-region' => '选择地区',
        'set-worker' => '设置子账户名称',
        'enter-worker' => '请输入子账户名称',
        'enter-address' => '请输入比特币地址',
        'region-ex' => 'BTC.com在全球都部署服务器，选择最近的服务器能获得最好的体验。',
        'worker-ex' => '<div class="worker-star">您设置的子账户将绑定于所选地区。您最多可设置12个子账户。矿机名设置参考: "<span class="workerID">zizhanghu</span>.001"，"<span class="workerID">zizhanghu</span>.002"。</div>',
        'worker-caution' => '<div class="worker-star">* 请注意，同一子账户不支持跨地区挖矿，您创建于当前地区的子账户在其他区域不存在。如果您在其他地区拥有矿机，请重新创建对应地区的子账户。</div>',
        'set-address' => '填写提币地址',
        'save' => '保存并登录',
        'verify-worker' => '矿工名仅支持由3-20位字母或数字组成',
    ],
    'download' => [
        'btc-pool' => 'BTC矿池 更好的矿池',
        'app-download' => 'BTC矿池APP下载',
        'version'=>'版本V0.99',
        'ios-setting'=>'iOS用户下载后务必进行以下设置',
        'setting'=>'设置',
        'genenal'=>'通用',
        'device-management'=>'设备管理',
        'trust'=>'信任BITMAIN'
    ]
];