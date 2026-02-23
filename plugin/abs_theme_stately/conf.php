<?php
/* 【开始】配置 */
$stately_setting_img_url_prefix = '../plugin/abs_theme_stately/view/img/_admin/';
$stately_img_url_prefix = 'plugin/abs_theme_stately/view/img/';
if(!isset($HTTP_TYPE)) {
  $HTTP_TYPE = 'http://';
}
$data = array(
  'panels' => [
    'about' => [
      'title' => '关于',
      'sections' => [
        'about_theme' => [
          'title' => '关于 ' . $PLUGIN_PROFILE['name'],
          'options' => [
            'cp_notice' => [
              'label' => '<b>重要提示</b>',
              'type' => 'label',
              'default' => '
              <strong class=text-danger>当心啦</strong>，<b>非官方的主题</b>可能包含恶意代码！会影响网站的安全性与速度，这可要小心了哦~<br>这个主题没有加密，所以你可以随便查看、学习和修改哦！但是<strong class=text-danger>别</strong>拿去加密和/或私自出售噢~'
            ],
            'resell_notice' => [
              'label' => '<b>重要提示</b>',
              'type' => 'label',
              'default' => '
              再次强调，<b>任何通过非官方途径获得的Stately主题，将无法享受到官方提供的任何售后服务与更新支持。</b>这意味着，当您遇到技术难题、需要新功能或发现安全漏洞时，无法获得专业的帮助与解决方案。这对于一个持续发展的网站而言，无疑是一个巨大的隐患。<br>如果您在使用本主题的过程中，发现它并不完全符合您的期望——无论是功能上的缺失，还是排版布局上的不合心意，我鼓励您直接与作者联系。<b>我们始终致力于倾听用户的声音，并根据大家的反馈不断优化和更新我们的产品。</b>只要合理且可行，我们都会尽力满足您的需求，让本主题成为您网站的最佳伙伴。<br>如果经过尝试后，您依然对Stately主题不满意，那么您有权提出退款申请。但请记得，在退款流程完成后，您有责任删除所有与该主题相关的文件，这是对您自身权益的尊重，也是对所有创作者劳动成果的尊重。<br>在决定是否转售Stately主题时，请三思而后行。这不仅仅是一个关于金钱的问题，更是关于诚信、尊重与道德的选择。我的每一行代码，都凝聚着时间与汗水的结晶；您的每一次选择，都应基于公平与正义的原则。让我们共同维护一个健康、和谐的创作环境，让每一份努力都能得到应有的回报。'
            ],
            'authors' => [
              'label' => '作者',
              'type' => 'label',
              'default' => '<a href="https://www.xiunobbs.cn/thread-3888.htm">Geticer</a>'
            ],
            'credits' => [
              'label' => '鸣谢',
              'type' => 'label',
              'default' => implode('<br>', [
                'ThemeSelection - 外观设计',
                'Tillreetree - 制作协力',
                'ZAESKY(NOTEWEB) - 灵感提供、致敬',
                '<a href="https://www.freepik.com/free-vector/anime-girl-with-toy-rabbit-design_24799604.htm#query=anime%20girl&position=2&from_view=search&track=sph">gstudioimagen1</a> on Freepik - 登录页面插图',
                'king - 提出建议',
                '是刘不是牛 - 提出建议',
                'GBT GAMES - 提出建议',
                '菜玩游戏 - 提出建议',
                '午后少年 - 提出建议',
                '七濑胡桃 - 精神支持',
              ])
            ],
            'thank_you_beta_testers' => [
              'label' => '感谢Beta测试者',
              'type' => 'label',
              'default' => implode('<br>', [
                '7232708273',
                'Moonun0930',
                'beyond0729',
                'fenge',
                '委员长',
              ])
            ],
            'thank_you_users' => [
              'label' => '感谢用户提供的建议',
              'type' => 'label',
              'default' => implode('<br>', [
                '萌社区',
                'EDM之家',
                'Spider',
                'Weazel News',
                '黄黄',
                '抚摸三下',
                '云拾图形资源社区',
              ])
            ],
            'C0FFEE' => [
              'label' => $PLUGIN_PROFILE['nothing_to_see_here_move_along'][0],
              'description' => '你的支持是我<abbr title="字面意思">维护本主题的动力！</abbr>',
              'type' => 'label',
              'default' => '<pre style="display:block;line-height:.95;transform:scale(.75);font-family:Menlo,Monaco,Consolas,Courier,monospace;letter-spacing:-.9px;user-select:none;pointer-events:none;">' .
              $PLUGIN_PROFILE['nothing_to_see_here_move_along'][1] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][2] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][3] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][4] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][5] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][6] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][7] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][8] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][9] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][10] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][11] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][12] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][13] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][14] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][15] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][16] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][17] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][18] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][19] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][20] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][21] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][22] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][23] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][24] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][25] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][26] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][27] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][28] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][29] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][30] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][31] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][32] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][33] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][34] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][35] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][36] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][37] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][38] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][39] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][40] . PHP_EOL . $PLUGIN_PROFILE['nothing_to_see_here_move_along'][41] . '</pre> '
            ]
          ],
        ],
      ],
    ],
    'global' => [
      'title' => '全局',
      'sections' => [
        'settings' => [
          'title' => '全局设置',
          '_group' => 'G1',
          '_cols' => 2,
          'options' => [
            'show_back_to_top' => [
              'label' => '显示“返回顶部”按钮？',
              'type' => 'toggle',
              'default' => false,
              'description' => '在页面右下角显示“返回顶部”按钮，方便用户快速回到页面顶部。 '
            ],
            'show_pace' => [
              'label' => '显示加载进度条？',
              'type' => 'toggle',
              'default' => true,
              'description' => '在页面顶部显示当前页面的加载进度。'
            ],
            'show_read_progress' => [
              'label' => '显示阅读进度条？',
              'type' => 'toggle',
              'default' => true,
              'description' => '在页面顶部显示当前页面的滚动进度。'
            ],
            'enable_page_transition' => [
              'label' => '使用页面过渡效果？',
              'type' => 'toggle',
              'default' => false,
              'description' => '启用页面过渡效果，为用户提供更流畅的浏览体验。'
            ],
            'hide_navbar_on_scroll' => [
              'label' => '当用户滚动页面时隐藏导航栏？',
              'type' => 'toggle',
              'default' => false,
              'description' => '当用户向下滚动页面时，隐藏顶部导航栏，当用户向上滚动页面时，显示顶部导航栏。可获得更大的视野。'
            ],
            'hide_appbar_on_scroll' => [
              'label' => '当用户滚动页面时隐藏App底部栏？',
              'type' => 'toggle',
              'default' => false,
              'description' => '当用户向下滚动页面时，隐藏App底部栏，当用户向上滚动页面时，显示App底部栏。可获得更大的视野。'
            ],

            'enable_open_graph' => [
              'label' => '启用Open Graph Protocol (开放内容协议)相关Meta Tags？',
              'description' => '推荐启用，当贵站的内容被分享到社交媒体平台时，可以更好地展示您的网站信息。可在一定程度上优化SEO。',
              'type' => 'toggle',
              'default' => true,
            ],
            /*
            'image_lazyload' => [
              'label' => '图片懒加载',
              'description' => '启用后，将只加载帖子中在屏幕中的图片，节省流量，提升浏览体验。',
              'type' => 'toggle',
              'default' => false
            ],
            */
          ],
        ],
        'datetime_format' => [
          'title' => '时间格式设置',
          '_group' => 'G1',
          'description' => '以下时间格式在本主题中的各个角落中使用。不影响“相对时间”（如“1天前”等）。',
          '_cols' => 3,
          'options' => [
            'date_only' => [
              'label' => '只有日期',
              'type' => 'text',
              'default' => 'Y-m-d',
              'description' => '至少输入年、月、日'
            ],
            'time_only' => [
              'label' => '只有时间',
              'type' => 'text',
              'default' => 'H:i',
              'description' => '至少输入时、分'
            ],
            'date_and_time' => [
              'label' => '日期和时间组合',
              'type' => 'text',
              'default' => 'Y-m-d H:i',
              'description' => '至少输入年、月、日、时、分'
            ],
            'explain' => [
              'label' => '预设',
              'type' => 'label',
              'default' => implode('<br>',[
                '年月日 <code>Y-m-d</code>',
                '月日年 <code>m/d/Y</code>',
                '日月年 <code>d/m/Y</code>',
                '年月日星期 <code>Y-m-d l</code>',
                '年月日时分秒 <code>Y-m-d H:i:s</code>',
                '时间（12小时） <code>h:i A</code>',
                '时间（24小时） <code>H:i</code>',
                '星期全称 月份全称 日 年 <code>l F j, Y</code>',
              ]),
              'description' => '用于参考的预设，复制粉色字到上方的文本框中即可使用。'
            ],
            'cheat_sheet' => [
              'label' => '速查表',
              'type' => 'label',
              'default' => implode('<br>',[
                '<code>Y</code>: 4位数年份<samp> (例如：2022)</samp>',
                '<code>y</code>: 2位数年份<samp> (例如：22)</samp>',
                '<code>M</code>: 月份的英文缩写<samp>(例如：Sep)</samp>',
                '<code>F</code>: 月份的英文全称<samp>(例如：September)</samp>',
                '<code>m</code>: 2位数的月份<samp>（01-12）</samp>',
                '<code>n</code>: 月份<samp>（1-12）</samp>',
                '<code>d</code>: 2位数的日期<samp>（01-31）</samp>',
                '<code>j</code>: 日期<samp>（1-31）</samp>',
                '<code>D</code>: 星期的英文缩写<samp>(例如：Thu)</samp>',
                '<code>l</code>: 星期的英文全称<samp>(例如：Thursday)</samp>',
                '<code>H</code>: 24小时制的小时数<samp>（00-23）</samp>',
                '<code>h</code>: 12小时制的小时数<samp>（01-12）</samp>',
                '<code>i</code>: 分钟数<samp>（00-59）</samp>',
                '<code>s</code>: 秒数<samp>（00-59）</samp>',
                '<code>A</code>: 大写的上午或下午<samp>（AM或PM）</samp>',
                '<code>a</code>: 小写的上午或下午<samp>（am或pm）</samp>',
              ]),
            ]
          ],
        ],
        'icon' => [
          'title' => '标志',
          '_group' => 'G1',
          '_cols' => 2,
          'options' => [
            'logo' => [
              'label' => '网站标志（Logo）',
              'type' => 'text',
              'default' => $conf['logo_pc_url'],
              'description' => '输入图标的网址'
            ],
            'favicon' => [
              'label' => '浏览器图标（Favicon）',
              'type' => 'text',
              'default' => $conf['logo_mobile_url'],
              'description' => '输入图标的网址'
            ],
            'sitename' => [
              'label' => '备选网站名称',
              'type' => 'text',
              'default' => '',
              'description' => '如果网站的全称太长，导致在导航栏中显示效果差的话，请在这里输入网站的简称。只会影响导航栏中的网站名称呈现。留空则使用“网站设置”中填写的网站名称。例如网站的全称是“欢乐购物天堂有限公司”，则可以在这里写“欢乐购物”。'
            ],
          ],
        ],
        'search' => [
          'title' => '搜索',
          '_group' => 'G1',
          'description' => '仅在安装搜索插件后可用',
          '_cols' => '2',
          'options' => [
            'placeholder' => [
              'label' => '搜索框提示语',
              'type' => 'text',
              'default' => '想找什么？'
            ],
            'hot_keywords' => [
              'label' => '热门搜索词',
              'type' => 'text',
              'default' => '活动|交友|xiuno',
              'description' => '使用竖线“|”分割，留空为不显示'
            ],
            'show_history_keywords' => [
              'label' => '记录并显示历史搜索词？',
              'type' => 'toggle',
              'default' => 'false',
              'description' => '启用此选项后，将会在前台页面存储记录并显示用户过去搜索过的内容，以便用户能够轻松查看和重新搜索之前的关键词。用户可以清除历史搜索词。'
            ],
          ],
        ],
        'thread' => [
          'title' => '帖子页面',
          '_group' => 'G4',
          '_cols' => 2,
          'options' => [
            'show_edit_button' => [
              'label' => '显示“编辑”按钮？',
              'description' => '此为总控制开关，该按钮是否显示也受到论坛版块或用户组的控制。该选项对管理员无效。',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_delete_button' => [
              'label' => '显示“删除”按钮？',
              'description' => '此为总控制开关，该按钮是否显示也受到论坛版块或用户组的控制。该选项对管理员无效。',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_postlist' => [
              'label' => '显示回帖列表及回帖表单？',
              'description' => '此为总控制开关。选择“否”将完全隐藏回帖区域（在JSON API中依旧可见），但有回帖权限的用户还是可以通过发送请求的方式进行回帖（便于API操作）。如果不希望任何用户发布回帖，请到“用户组设置”中，取消勾选所有用户组的“回帖”权限。该选项不会影响现有的回帖。该选项对管理员无效，管理员依旧可以查看并管理所有的回帖。',
              'type' => 'toggle',
              'default' => true,
            ],
          ],
        ],
        'reply' => [
          'title' => '回帖',
          '_group' => 'G4',
          '_cols' => 2,
          'options' => [
            'show_edit_button' => [
              'label' => '显示“编辑”按钮？',
              'description' => '此为总控制开关，该按钮是否显示也受到论坛版块或用户组的控制。该选项对管理员无效。',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_delete_button' => [
              'label' => '显示“删除”按钮？',
              'description' => '此为总控制开关，该按钮是否显示也受到论坛版块或用户组的控制。该选项对管理员无效。',
              'type' => 'toggle',
              'default' => true,
            ],
            'refresh_after_reply' => [
              'label' => '回复后刷新页面',
              'type' => 'toggle',
              'default' => false,
              'description' => '用户在回复帖子后自动刷新页面（当帖子中有“回复可见”内容时很好用）'
            ],
          ],
        ],
        'contact' => [
          'title' => '联系方式',
          '_group' => 'G1',
          'description' => '将会显示在“联系我们”页面等处。不填写则不显示对应联系方式。',
          '_cols' => 3,
          'options' => [
            /* 通用 */
            'phone' => [
              'label' => '电话号码',
              'description' => '会自带“tel:”前缀，在手机上点击可直接拨号。如有必要，可添加国际区号，例如“+86”。',
              'type' => 'text',
              'default' => (isset($user) && isset($user['mobile']) && !empty($user['mobile'])) ? $user['mobile'] : '',
            ],
            'email' => [
              'label' => '电子邮件',
              'description' => '会自带“mailto:”前缀，点击可调用电子邮件客户端。',
              'type' => 'text',
              'default' => (isset($user) && isset($user['email']) && !empty($user['email'])) ? $user['email'] : '',
            ],
            'rss' => [
              'label' => 'RSS',
              'description' => '若本站使用了RSS插件，可在这里输入RSS插件提供的网址，便于让用户找到。',
              'type' => 'text',
              'default' => '',
            ],
            /* 国内 */
            'qq' => [
              'label' => 'QQ',
              'description' => '填写您的QQ号码。',
              'type' => 'text',
              'default' => (isset($user) && isset($user['qq']) && !empty($user['qq'])) ? $user['qq'] : '',
            ],
            'weixin' => [
              'label' => '微信',
              'description' => '填写您的微信二维码图片地址。',
              'type' => 'text',
              'default' => '',
            ],
            'weibo' => [
              'label' => '微博',
              'description' => '填写您的微博主页网址，下同。',
              'type' => 'url',
              'default' => '',
            ],
            'zhihu' => [
              'label' => '知乎',
              'type' => 'url',
              'default' => '',
            ],
            'bilibili' => [
              'label' => 'BiliBili',
              'type' => 'url',
              'default' => '',
            ],
            'douyin' => [
              'label' => '抖音',
              'type' => 'url',
              'default' => '',
            ],
            /* 国外 */
            'twitter' => [
              'label' => 'Twitter',
              'description' => '填写您的Twitter主页网址，下同。',
              'type' => 'url',
              'default' => '',
            ],
            'mastodon' => [
              'label' => 'Mastodon',
              'type' => 'url',
              'default' => '',
            ],
            'facebook' => [
              'label' => 'Facebook',
              'type' => 'url',
              'default' => '',
            ],
            'instagram' => [
              'label' => 'Instagram',
              'type' => 'url',
              'default' => '',
            ],
            'snapchat' => [
              'label' => 'Snapchat',
              'type' => 'url',
              'default' => '',
            ],
            'pinterest ' => [
              'label' => 'Pinterest',
              'type' => 'url',
              'default' => '',
            ],
            'skype' => [
              'label' => 'Skype',
              'type' => 'url',
              'default' => '',
            ],
            'whatsapp' => [
              'label' => 'WhatsApp',
              'type' => 'url',
              'default' => '',
            ],
            'telegram' => [
              'label' => 'Telegram',
              'type' => 'url',
              'default' => '',
            ],
            'youtube' => [
              'label' => 'YouTube',
              'type' => 'url',
              'default' => '',
            ],
            'vimeo' => [
              'label' => 'vimeo',
              'type' => 'url',
              'default' => '',
            ],
            'github' => [
              'label' => 'GitHub',
              'type' => 'url',
              'default' => '',
            ],
            'gitlab' => [
              'label' => 'GitLab',
              'type' => 'url',
              'default' => '',
            ],
          ],
        ],
      ],
    ],
    'ui' => [
      'title' => '外观',
      'sections' => [
        'global' => [
          'title' => '全局',
          '_group' => 'G1',
          'options' => [
            'navbar_style' => [
              'label' => '导航栏风格',
              'description' => '选择网站的导航栏布局，影响网站的整体感觉。菜单栏位：<br><b>纵向（左侧）</b>：左侧使用主菜单，顶部右侧使用副菜单，顶部左侧使用副副菜单；<br><b>横向（顶部）</b>：左侧使用主菜单，右侧使用副菜单。在移动端将强制使用左侧菜单。',
              'type' => 'radio-image',
              'default' => 'vertical',
              'choices' => [
                'vertical' => [
                  'label' => '纵向（左侧）',
                  'url' => $stately_setting_img_url_prefix . 'ui.global.navbar_style.vertical.png'
                ],
                'horizontal' => [
                  'label' => '横向（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui.global.navbar_style.horizontal.png'
                ],
              ]
            ],
            'navbar_style_vertical' => [
              'label' => '纵向导航栏选择项风格',
              'type' => 'radio-image',
              'description' => 'V1：标准风格，背景大小恰当；V2：背景紧贴左侧，与“大幅圆角”搭配使用效果好。',
              'default' => 'v1',
              'choices' => [
                'v1' => [
                  'label' => 'V1',
                  'url' => $stately_setting_img_url_prefix . 'ui.global.navbar_style_vertical.v1.png'
                ],
                'v2' => [
                  'label' => 'V2',
                  'url' => $stately_setting_img_url_prefix . 'ui.global.navbar_style_vertical.v2.png'
                ],
              ],
            ],
            'navbar_active_color_vertical' => [
              'label' => '纵向导航栏选择项颜色',
              'type' => 'radio-image',
              'description' => '选择“彩色背景”更加醒目。',
              'default' => 'default',
              'choices' => [
                'default' => [
                  'label' => '浅色背景',
                  'url' => $stately_setting_img_url_prefix . 'ui.global.navbar_active_color_vertical.light.png'
                ],
                'alt' => [
                  'label' => '彩色背景',
                  'url' => $stately_setting_img_url_prefix . 'ui.global.navbar_active_color_vertical.main.png'
                ],
              ],
            ],
            'navbar_use_background_image_vertical' => [
              'label' => '纵向导航栏使用背景图片？',
              'type' => 'toggle',
              'default' => false,
            ],
            'navbar_background_image_vertical' => [
              'label' => '纵向导航栏选择背景图片',
              'type' => 'radio-image',
              'default' => 'sidebar-bg-09.jpg',
              'choices' => [
                'sidebar-bg-01.jpg' => [
                  'label' => '灰阶菱影',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-01.jpg',
              ],
              'sidebar-bg-02.jpg' => [
                  'label' => '简约弧形',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-02.jpg',
              ],
              'sidebar-bg-03.jpg' => [
                  'label' => '粉彩几何',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-03.jpg',
              ],
              'sidebar-bg-04.jpg' => [
                  'label' => '商务三角',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-04.jpg',
              ],
              'sidebar-bg-05.jpg' => [
                  'label' => '灰同心圆',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-05.jpg',
              ],
              'sidebar-bg-06.jpg' => [
                  'label' => '简约几何',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-06.jpg',
              ],
              'sidebar-bg-08.jpg' => [
                  'label' => '三角炫彩',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-08.jpg',
              ],
              'sidebar-bg-09.jpg' => [
                  'label' => '彩同心圆',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-09.jpg',
              ],
              'sidebar-bg-10.jpg' => [
                  'label' => '圆韵渐变',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-10.jpg',
              ],
              'sidebar-bg-11.jpg' => [
                  'label' => '轻奢绿韵',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-11.jpg',
              ],
              'sidebar-bg-12.jpg' => [
                  'label' => '网汇蓝图',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-12.jpg',
              ],
              'sidebar-bg-13.jpg' => [
                  'label' => '蓝商律动',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-13.jpg',
              ],
              'sidebar-bg-14.jpg' => [
                  'label' => '蓝晶几何',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-14.jpg',
              ],
              'sidebar-bg-15.jpg' => [
                  'label' => '紫韵流动',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-15.jpg',
              ],
              'sidebar-bg-16.jpg' => [
                  'label' => '墨蓝交织',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-16.jpg',
              ],
              'sidebar-bg-17.jpg' => [
                  'label' => '秋韵几何',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-17.jpg',
              ],
              'sidebar-bg-18.jpg' => [
                  'label' => '幻彩圆舞',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-18.jpg',
              ],
              'sidebar-bg-19.jpg' => [
                  'label' => '蓝途织联',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-19.jpg',
              ],
              'sidebar-bg-20.jpg' => [
                  'label' => '静谧之舟',
                  'url' => $stately_setting_img_url_prefix . '../' . 'sidebar-bg-20.jpg',
              ],
              'sidebar-bg-21.jpg' => ['label' => '晚霞码头','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-21.jpg',],
              'sidebar-bg-22.jpg' => ['label' => '孤树映晚','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-22.jpg',],
              'sidebar-bg-23.jpg' => ['label' => '蝶恋花  ','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-23.jpg',],
              'sidebar-bg-24.jpg' => ['label' => '紫霞映海','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-24.jpg',],
              'sidebar-bg-25.jpg' => ['label' => '落日余晖','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-25.jpg',],
              'sidebar-bg-26.jpg' => ['label' => '幻彩水母','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-26.jpg',],
              'sidebar-bg-27.jpg' => ['label' => '月夜山影','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-27.jpg',],
              'sidebar-bg-28.jpg' => ['label' => '海滨夕照','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-28.jpg',],
              'sidebar-bg-29.jpg' => ['label' => '鹿望黄昏','url' => $stately_setting_img_url_prefix. '../'. 'sidebar-bg-29.jpg',],
              ],
            ],
            'navbar_width_horizontal' => [
              'label' => '横向导航栏宽度',
              'description' => '标准：和页面内容一样宽；全宽：完全占据屏幕宽度',
              'type' => 'select',
              'default' => 'normal',
              'choices' => [
                'normal' => '标准',
                'fullwidth' => '全宽',
                'fullwidth_but_normal' => '全宽，但导航栏内容宽度不变',
              ],
            ],
            'show_top_left_menu' => [
              'label' => '显示顶部左侧菜单？',
              'description' => '仅在上一项为“纵向（左侧）”时有效！',
              'type' => 'toggle',
              'default' => true,
            ],
            'navbar_logo_show' => [
              'label' => '导航栏标志显示',
              'type' => 'select',
              'default' => 'both',
              'choices' => [
                'logo' => '只有标志',
                'text' => '只有文字 *若未设计标志，请选此项*',
                'both' => '标志和文字 *建议使用方形标志*',
              ],
            ],
            'show_appbar' => [
              'label' => '显示App底部栏？',
              'description' => '只在移动端可见',
              'type' => 'toggle',
              'default' => false,
            ],
            'semitransparent_card' => [
              'label' => '半透明卡片',
              'description' => '开启后，会让所有的“卡片”（如帖子列表、帖子内容等的背景）变成半透明的，适合搭配柔和的背景图片使用。',
              'type' => 'toggle',
              'default' => false,
            ],
            'blurred_card' => [
              'label' => '半透明卡片 - 加磨砂效果',
              'description' => '开启后，会给“卡片”的半透明背景再增加磨砂（模糊）效果，适合搭配复杂的背景图片使用。',
              'type' => 'toggle',
              'default' => false,
              /*
              这个问题可能是由于backdrop-filter属性会创建一个新的层叠上下文，而这个新的层叠上下文可能会影响到modal的显示。在这种情况下，modal的内容会被限制在具有backdrop-filter属性的card元素内部，而不是在整个网页的中间显示。 
              为了解决这个问题，您可以尝试将具有backdrop-filter属性的元素放置在modal之外，或者考虑使用其他方式来实现卡片的磨砂质感效果，而不是使用backdrop-filter属性。您可以尝试使用其他CSS样式或技巧来模拟磨砂效果，以避免影响到modal的显示和功能。
              */
            ],
            'bordered_card' => [
              'label' => '无阴影卡片',
              'description' => '开启后，会让所有的“卡片”的阴影消失，并增强边框，外观更“扁平”。为增加对比度，按钮的阴影不会随之小时。',
              'type' => 'toggle',
              'default' => true,
            ],
            'pull_up_card' => [
              'label' => '浮起的卡片',
              'description' => '开启后，会让帖子列表等处的“卡片”在鼠标放在上面时“浮起来”。不推荐与“无阴影卡片”一同使用。',
              'type' => 'toggle',
              'default' => false,
            ],
            'pull_up_card_style' => [
              'label' => '浮起的卡片风格',
              'description' => '仅在上一项开启的状态下可用！V1：默认风格。V2：会让浮起效果更加花哨好看。',
              'type' => 'select',
              'default' => 'v1',
              'choices' => ['v1' => 'V1', 'v2' => 'V2'],
            ],
            'border-radius' => [
              'label' => '边框圆角程度',
              'description' => '影响输入框、按钮等控件的圆角程度。',
              'type' => 'radio-image',
              'default' => 'medium',
              'choices' => [
                'none' => ['label' => '没有圆角', 'url' => $stately_setting_img_url_prefix . 'ui.global.border-radius.none.png'],
                'medium' => ['label' => '中等圆角（默认）', 'url' => $stately_setting_img_url_prefix . 'ui.global.border-radius.medium.png'],
                'large' => ['label' => '大幅圆角', 'url' => $stately_setting_img_url_prefix . 'ui.global.border-radius.large.png'],
              ]
            ],
            'show_navbar_page_title' => [
              'label' => '导航栏显示当前页面标题',
              'description' => '开启后，会根据页面显示页面标题（或论坛板块名称、帖子名称、用户名）',
              'type' => 'toggle',
              'default' => true,
            ],
            'disable_widget_sidebar_on_mobile' => [
              'label' => '侧边栏在移动端的表现',
              'description' => '指的不是左侧的主菜单，而是右侧的小工具侧栏。此处的设置会影响主页、论坛版块页，帖子详情页。',
              'type' => 'select',
              'type' => 'radio-image',
              'default' => 0,
              'choices' => [
                0 => ['label' => 'PC端的侧边栏会显示在移动端的页面最后', 'url' => $stately_setting_img_url_prefix . 'ui.global.disable_widget_sidebar_on_mobile.false.png'],
                1 => ['label' => 'PC端的侧边栏会隐藏于移动端', 'url' => $stately_setting_img_url_prefix . 'ui.global.disable_widget_sidebar_on_mobile.medium.true.png'],
              ],
            ],
            'use_twemoji' => [
              'label' => '使用Twemoji',
              'description' => '美观、统一的表情符号，开启后将替换全站所有的Emoji。',
              'type' => 'toggle',
              'default' => true,
            ],
            'footer_info_position' => [
              'label' => '页脚信息显示位置',
              'type' => 'select',
              'default' => 'page_end',
              'choices' => [
                'page_end' => '整个页面最后（V1：标准风格）',
                'page_end_v2' => '整个页面最后（V2：带Logo风格）',
                'sidebar_end' => '纵向导航栏的最后 *仅在“导航栏风格”为“纵向（左侧）”时有效！*',
              ],
            ],
          ],
        ],
        'color' => [
          'title' => '颜色',
          '_group' => 'G1',
          '_cols' => 2,
          'options' => [
            'mode' => [
              'label' => '默认颜色模式',
              'description' => '如果用户没有设置颜色模式的话，就会使用这里选择的颜色模式（浅色/深色/自动）。<br>使用“特殊—Base16”就会使用“外观—板式微调→帖子详情-通用→代码高亮配色”中选择的配色，实现“一键懒人配色”效果。<b>务必启用“外观—板式微调→帖子详情-通用→使用代码高亮”才能使用！</b><details>对应色卡中，左边三个颜色表示页面背景、卡片、文字等元素，左边前两个颜色是深色的话就是深色主题，反之就是浅色主题，而右边四个颜色表示主要控件（如按钮等）的颜色。主要按钮默认使用倒数第二个颜色。<br>个人推荐：Ayu Light、Catppuccin Mocha、Everforest、Gruvbox Light Medium、Monokai、Nord、Oceanicnext、Sandcastle、Tokyo Night Dark、Zenburn。<br>如需自定义颜色，可以使用以下自定义CSS：<pre>:root{--bs-primary: var(--baseXX) !important;--bs-secondary: var(--baseXX) !important;}</pre>其中“XX”为[08,09,0A,0B,0C,0D,0E,0F]之间的值（需要大写字母），对应色卡中右边八个颜色。</details>',
              'type' => 'select',
              'default' => 'auto',
              'choices' => [
                'light' => '浅色（日间）',
                'dark' => '深色（夜间）',
                'auto' => '自动（根据时间切换）',
                'special_base16' => '特殊—Base16',
              ],
            ],
            'theme' => [
              'label' => '配色（主色调）',
              'description' => '',
              'type' => 'color',
              'default' => '#696cff',
            ],
            'color_body_light' => [
              'label' => '文字颜色（浅色模式）',
              'description' => '',
              'type' => 'color',
              'default' => '#697a8d',
            ],
            'color_body_dark' => [
              'label' => '文字颜色（深色模式）',
              'description' => '',
              'type' => 'color',
              'default' => '#a3a4cc',
            ],
            'color_body_bright_light' => [
              'label' => '着重文字颜色（浅色模式）',
              'description' => '如标题等文字。',
              'type' => 'color',
              'default' => '#566a7f',
            ],
            'color_body_bright_dark' => [
              'label' => '着重文字颜色（深色模式）',
              'description' => '如标题等文字。',
              'type' => 'color',
              'default' => '#cbcbe2',
            ],
            'color_card_light' => [
              'label' => '卡片背景颜色（浅色模式）',
              'description' => '',
              'type' => 'color',
              'default' => '#ffffff',
            ],
            'color_card_dark' => [
              'label' => '卡片背景颜色（深色模式）',
              'description' => '',
              'type' => 'color',
              'default' => '#2b2c40',
            ],
          ],
        ],
        'auto_dark_mode_config' => [
          'title' => '自动切换颜色模式',
          '_group' => 'G1',
          '_cols' => '2',
          'options' => [
            'begin_time' => [
              'label' => '何时切换到深色模式？',
              'description' => '建议设置到日落时间，或18:00之后',
              'type' => 'time',
              'default' => '18:00'
            ],
            'end_time' => [
              'label' => '何时切换到浅色模式？',
              'description' => '建议设置到日出时间，或08:00之前',
              'type' => 'time',
              'default' => '08:00'
            ],
          ],
        ],
        'background' => [
          'title' => '页面背景',
          '_group' => 'G1',
          'options' => [
            'style' => [
              'label' => '背景样式',
              'description' => '选择网站的背景样式。<br>◐=深浅色均可；●=只有深色；○=只有浅色；<br>“艺术弧形风格”的上半部分可以设置为渐变色或图片，下半部分将使用“背景颜色”。<br>“艺术弧形风格（图片）”将使用稍后的“选择图片”里的设置。<br>“动态”的背景可能会对性能造成影响，在手机上可能会导致发热或整体使用不流畅。',
              'type' => 'select',
              'default' => 'default',
              'choices' => [
                'default' => '◐ 默认 *适合自动切换颜色模式*',
                'color' => '◐ 纯色',
                'image' => '◐ 纯色+图片',
                'art_gridient' => '◐ 艺术弧形风格（渐变色）',
                'art_image' => '◐ 艺术弧形风格（图片）',
                'special_StarryNight' => '● 特殊-星夜',
                'gradient_Garden' => '◐ 渐变-春日花园',
                'gradient_Peach' => '◐ 渐变-蜜桃苏打',
                'gradient_Ocean' => '◐ 渐变-海边漫步',
                'gradient_Tangerine' => '◐ 渐变-夏日柑橘',
                'gradient_Pastel' => '◐ 渐变-珊瑚礁影',
                'gradient_Autumn' => '◐ 渐变-秋意浓情',
                'gradient_Meadow' => '◐ 渐变-青葱岁月',
                'gradient_Twilight' => '◐ 渐变-暮光之城',
                'gradient_Book' => '◐ 渐变-古朴书卷',
                'gradient_Fairy' => '◐ 渐变-梦幻彩虹',
                'dynamic_dark_waterpipe' => '● 动态-深色 流纱幻境', 
                'dynamic_dark_figure' => '◐ 动态-形状从中间飞出', 
                'dynamic_light_figure_circle' => '◐ 动态-圆形放大', 
                'dynamic_light_figure_square' => '◐ 动态-方形放大', 
                'dynamic_dark_meteor' => '● 动态-星夜流星',
                'dynamic_dark_sky' => '● 动态-星空流星', 
                'dynamic_light_antigravity' => '◐ 动态-形状从下方飘入',
                'dynamic_dark_purple_particles_canvas' => '● 动态-紫色梦幻', 
                'dynamic_dark_blue_particles_canvas' => '● 动态-深色蓝色梦幻', 
                'dynamic_light_triangle' => '◐ 动态-灰色三角', 
                'dynamic_dark_stars' => '● 动态-深色 星空从中间飞出',
              ],
            ],
            'color_light' => [
              'label' => '背景颜色-浅色模式',
              'type' => 'color',
              'default' => '#f5f5f9',
            ],
            'color_dark' => [
              'label' => '背景颜色-深色模式',
              'type' => 'color',
              'default' => '#232333',
            ],
            'image' => array(
              'label' => '选择图片',
              'description' => '如果图片是透明的，则会透出背景颜色。',
              'type' => 'css_background_image',
              'default' => array( /* 默认值 */
                'background-url' => '',
                'background-repeat' => 'no-repeat',
                'background-position' => 'center center',
                'background-size' => 'cover',
                'background-attachment' => 'fixed'
              ),
            ),
            'art_gridient_colors' => [
              'label' => '艺术弧形风格-渐变色选择',
              'description' => '左侧颜色为中间部分的颜色，右侧颜色为两边的颜色。',

              'type' => 'color_schemes',
              'default' => 'skyBlue',
              'choices' => [
                'purpleRed' => [
                  'label' => '紫粉色',
                  'colors' => ['#673AB7',  '#EC407A']
                ],
                'greenOrange' => [
                  'label' => '芒果橙',
                  'colors' => ['#689F38',  '#FF8F00']
                ],
                'magenta' => [
                  'label' => '血　橙',
                  'colors' => ['#EC407A',  '#FFA000']
                ],
                'purple' => [
                  'label' => '山　竹',
                  'colors' => ['#AB47BC',  '#00BCD4']
                ],
                'blue' => [
                  'label' => '深海蓝',
                  'colors' => ['#3F51B5',  '#03A9F4']
                ],
                'orange' => [
                  'label' => '橙紫色',
                  'colors' => ['#EF6C00',  '#9C27B0']
                ],
                'cyan' => [
                  'label' => '叶绿色',
                  'colors' => ['#009688',  '#689F38']
                ],
                'red' => [
                  'label' => '石榴红',
                  'colors' => ['#EF5350',  '#607D8B']
                ],
                'skyBlue' => [
                  'label' => '大海蓝',
                  'colors' => ['#2196F3',  '#00BFA5']
                ],
                'grey' => [
                  'label' => '石墨灰',
                  'colors' => ['#607D8B',  '#757575']
                ],
                'yellowBlue' => [
                  'label' => '海椰子',
                  'colors' => ['#039BE5',  '#FF9800']
                ],
                'pinkBlue' => [
                  'label' => '日出海',
                  'colors' => ['#00BCD4',  '#F06292']
                ],
                'yellowCyan' => [
                  'label' => '青　橙',
                  'colors' => ['#F9A825',  '#00BCD4']
                ],
                'blueCyan' => [
                  'label' => '天蓝色',
                  'colors' => ['#039BE5',  '#00BCD4']
                ],
                'greenPurple' => [
                  'label' => '紫葡萄',
                  'colors' => ['#7C4DFF',  '#00C853']
                ],
                'pinkGreen' => [
                  'label' => '青柠桃',
                  'colors' => ['#689F38',  '#F06292']
                ],
                'gold' => [
                  'label' => '木瓜色',
                  'colors' => ['#FF9100',  '#8D6E63']
                ],
              ],
            ],
            'art_gridient_shift_homepage_content' => [
              'label' => '艺术弧形风格-让主页往下挪动？',
              'description' => '选择“是”，将会让主页的内容往下挪动一些距离，可以让用户看清图片。',
              'type' => 'toggle',
              'default' => false,
            ]
          ],
        ],
        'typography' => [
          'title' => '字体',
          '_group' => 'G1',
          'options' => [
            'use_custom' => [
              'label' => '使用自定义值？',
              'type' => '_toggle',
              'default' => 0,
            ],
          ],
        ],
        'other' => [
          'title' => '其他外观设置',
          '_group' => 'G1',
          'options' => [
            'let_it_snow' => [
              'label' => '下雪效果',
              'description' => '启用后会让页面下雪，滚动后下雪效果减弱。可能会影响页面性能。',
              'type' => 'toggle',
              'default' => false,
            ],
            'xmas_lights' => [
              'label' => '小彩灯',
              'description' => '让用户感受到节日氛围。启用后会在20:00到第二天08:00显示，只在主页显示，滚动后消失。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
      ],
    ],
    'ui_style' => [
      'title' => '外观—板式',
      'sections' => [
        'homepage' => [
          'title' => '主页',
          '_group' => 'G2',
          'description' => '背景颜色深一点的就是选中的。',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'default' => 'classic_2col',
              'choices' => [
                'classic_2col' => [
                  'label' => '经典（双栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_2col.png'
                ],
                'classic_1col' => [
                  'label' => '经典（单栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_1col.png'
                ],
                'classic_3col' => [
                  'label' => '经典（三栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_3col.png'
                ],
                'portal_v1' => [
                  'label' => '门户网站风格V1（单栏，使用菜单插件灵活配置）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.homepage.layout.portal_v1.png'
                ],
                'portal_v2' => [
                  'label' => '门户网站风格V2（双栏，固定布局，<br>在“外观—板式微调—门户网站风格V2”中设置标题、显示的板块等）【新闻自媒体】',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.homepage.layout.portal_v2.png'
                ],
                'portal_v3' => [
                  'label' => '门户网站风格V3（双栏，固定布局，<br>在“外观—板式微调—门户网站风格V3”中设置标题、显示的板块等）【便当-新闻自媒体】',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.homepage.layout.portal_v3.png'
                ],
                'bbs_v1' => [
                  'label' => '论坛列表风格（经典BBS）（单栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.bbs.bbs_v1.png'
                ],
                'bbs_v2' => [
                  'label' => '论坛列表风格（现代BBS）（双栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.bbs.bbs_v2.png'
                ],
              ],
            ],
            'still_show_threadlist' => [
              'label' => '“论坛列表风格”和“门户网站风格V1”: 依旧显示帖子列表？',
              'type' => 'toggle',
              'default' => false,
              'description' => '将使用“经典（双栏）”风格显示帖子列表。'
            ]
          ],
        ],
        'bbs' => [
          'title' => '论坛版块列表页面',
          '_group' => 'G6',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'default' => 'bbs_v1',
              'choices' => [
                'bbs_v1' => [
                  'label' => '经典BBS（单栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.bbs.bbs_v1.png'
                ],
                'bbs_v2' => [
                  'label' => '现代BBS（双栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.bbs.bbs_v2.png'
                ],
              ],
            ],
          ],
        ],
        'post' => [
          'title' => '发帖页面',
          '_group' => 'G6',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'description' => 'V1：发帖选项与附件列表在帖子内容之后；V2：发帖选项与附件列表在帖子内容右侧，方便随时调节。在移动端皆位于帖子内容之后。',
              'default' => 'v1',
              'choices' => [
                'v1' => [
                  'label' => 'V1',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.post.layout.v1.png'
                ],
                'v2' => [
                  'label' => 'V2',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.post.layout.v2.png'
                ],
              ],
            ],
          ],
        ],
        'forum' => [
          'title' => '论坛',
          '_group' => 'G3',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'default' => 'classic_2col',
              'choices' => [
                'classic_3col' => [
                  'label' => '经典（三栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_3col.png'
                ],
                'classic_2col' => [
                  'label' => '经典（双栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_2col.png'
                ],
                'classic_1col' => [
                  'label' => '经典（单栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_1col.png'

                ],
              ],
            ],
            'style_forum_info' => [
              'label' => '论坛信息风格',
              'type' => 'radio-image',
              'default' => 'top_v1',
              'choices' => [
                'side_classic' => [
                  'label' => '经典V1（侧边）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.side_classic.png'
                ],
                'side_classic_v2' => [
                  'label' => '经典V2（侧边）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.side_classic_v2.png'
                ],
                'top_v1' => [
                  'label' => '现代V1（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_v1.png'
                ],
                'top_v2' => [
                  'label' => '现代V2（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_v2.png'
                ],
                'top_v3' => [
                  'label' => '现代V3（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_v3.png'
                ],
                'top_v4' => [
                  'label' => '现代V4（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_v4.png'
                ],
                'top_compact' => [
                  'label' => '紧凑（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_compact.png'
                ],
                'top_compact_v2' => [
                  'label' => '紧凑V2（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_compact_v2.png'
                ],
              ],
            ],
            'show_forum_cover_image' => [
              'label' => '论坛信息部分，显示封面图？',
              'description' => '<b>如何设置封面图：</b>安装主题配套的“论坛版块封面图（till_forum_cover）”插件，然后进入论坛板块设置（在后台的导航菜单里），点击对应板块的<b>编辑</b>按钮，在封面图选项中上传图片，最后保存即可。',
              'type' => 'toggle',
              'default' => true,
            ],
          ],
        ],
        'threadlist' => [
          'title' => '帖子列表',
          '_group' => 'G3',
          'options' => [
            'style_global' => [
              'label' => '帖子列表风格（全局）',
              'type' => 'radio-image',
              'default' => 'sns_v1',
              'choices' => [
                'blog_v2_top' => ['label' => '图文列表（宽松）（图在顶部）【博客风格】 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.blog_v2_top.png'],
                'blog_v1' => ['label' => '图文列表（宽松）（图在中间）【博客风格】 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.blog_v1.png'],
                'blog_v2_bottom' => ['label' => '图文列表（宽松）（图在底部）【博客风格】 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.blog_v2_bottom.png'],
                'graphic-list-overhang_v1_top' => ['label' => '图文列表（悬挂）（图在顶部） *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-overhang_v1_top.png'],
                'graphic-list-overhang_v1_left' => ['label' => '图文列表（悬挂）（图在左侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-overhang_v1_left.png'],
                'graphic-list-overhang_v1_right' => ['label' => '图文列表（悬挂）（图在右侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-overhang_v1_right.png'],
                'graphic-list_v1_left' => ['label' => '图文列表（侧边）（图在左侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list_v1_left.png'],
                'graphic-list_v1_right' => ['label' => '图文列表（侧边）（图在右侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list_v1_right.png'],
                'graphic-list_v2_left' => ['label' => '图文列表（侧边V2）（图在左侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list_v2_left.png'],
                'graphic-list_v2_right' => ['label' => '图文列表（侧边V2）（图在右侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list_v2_right.png'],
                'graphic-list-compact_v1_top' => ['label' => '图文列表（紧凑）（图在顶部） *1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-compact_v1_top.png'],
                'graphic-list-compact_v1_middle' => ['label' => '图文列表（紧凑）（图在中间）【大图样式】 *1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-compact_v1_middle.png'],
                'graphic-list-compact_v1_bottom' => ['label' => '图文列表（紧凑）（图在底部） *1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-compact_v1_bottom.png'],
                'image_v1' => ['label' => '图片列表 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.image_v1.png'],
                'image_v2' => ['label' => '图片列表（只有图片） *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.image_v2.png'],
                'graphic-list-special_v1' => ['label' => '【特殊】图文列表（带价格显示：<br>如果帖子里带有付费部分，<br>将显示具体价格，否则显示“免费”。）<br>（图在顶部）*1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-special_v1.png'],
                'special-timeline_v1' => ['label' => '【特殊】时间线*1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.special-timeline_v1.png'],
                'sns_v1' => ['label' => 'SNS风格V1（头像在内）【朋友圈】 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.sns_v1.png'],
                'sns_v2' => ['label' => 'SNS风格V2（头像在外） *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.sns_v2.png'],
                'sns_v3' => ['label' => 'SNS风格V3（头像在内） *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.sns_v3.png'],
                'qa_v1' => ['label' => '问答风格 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.qa_v1.png'],
                'compact_v1' => ['label' => '紧凑卡片（用户名在顶部） *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.compact_v1.png'],
                'compact_v2' => ['label' => '紧凑卡片（用户名在底部） *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.compact_v2.png'],
                'classic_v1' => ['label' => '紧凑列表V1（经典） *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.classic_v1.png'],
                'classic_v2' => ['label' => '紧凑列表V2 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.classic_v2.png'],
                'classic_v3' => ['label' => '紧凑列表V3 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.classic_v3.png'],
                'classic_v4' => ['label' => '紧凑列表V4 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.classic_v4.png'],
                'super-compact_v1' => ['label' => '超紧凑列表V1【线报】*1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.super-compact_v1.png'],
                'super-compact_v2' => ['label' => '超紧凑列表V2 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.super-compact_v2.png'],
                /*'super-compact_v3' => ['label' => '超紧凑列表V3 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.super-compact_v3.png'],*/
              ],
            ],
            'cols_count_global' => [
              'label' => '栏数（全局）',
              'description' => '一行有几个帖子？',
              'type' => 'select',
              'default' => 12,
              'choices' => [
                12 => '1栏',
                6 => '2栏',
                4 => '3栏',
                3 => '4栏',
                2 => '6栏',
              ],
            ],
            'style_for_forum' => [
              'label' => '帖子列表风格（单独）',
              'description' => '覆盖上述设置。',
              'type' => 'dropdown_per_forum',
              'choices' => [
                '_inherit' => '使用全局设置',
                'blog_v2_top'                    => '图文列表（宽松）（图在顶部）【博客风格】 *2/3/4栏*',
                'blog_v1'                        => '图文列表（宽松）（图在中间）【博客风格】 *2/3/4栏*',
                'blog_v2_bottom'                 => '图文列表（宽松）（图在底部）【博客风格】 *2/3/4栏*',
                'graphic-list_v1_left'           => '图文列表（侧边）（图在左侧） *1/2栏*',
                'graphic-list_v1_right'          => '图文列表（侧边）（图在右侧） *1/2栏*',
                'graphic-list_v2_left'           => '图文列表（侧边V2）（图在左侧）',
                'graphic-list_v2_right'          => '图文列表（侧边V2）（图在右侧）',
                'graphic-list-overhang_v1_top'   => '图文列表（悬挂）（图在顶部） *2/3/4栏*',
                'graphic-list-overhang_v1_left'  => '图文列表（悬挂）（图在左侧） *1/2栏*',
                'graphic-list-overhang_v1_right' => '图文列表（悬挂）（图在右侧） *1/2栏*',
                'graphic-list-compact_v1_top'    => '图文列表（紧凑）（图在顶部） *1/2/3/4栏*',
                'graphic-list-compact_v1_middle' => '图文列表（紧凑）（图在中间）【大图样式】 *1/2/3/4栏*',
                'graphic-list-compact_v1_bottom' => '图文列表（紧凑）（图在底部） *1/2/3/4栏*',
                'graphic-list-special_v1'        => '【特殊】图文列表（带价格显示）（图在顶部）*1/2/3/4栏*',
                'image_v1'                       => '图片列表 *2/3/4栏*',
                'image_v2'                       => '图片列表（只有图片） *2/3/4栏*',
                'sns_v1'                         => 'SNS风格V1（头像在内）【朋友圈】 *1栏*',
                'sns_v2'                         => 'SNS风格V2（头像在外） *1栏*',
                'sns_v3'                         => 'SNS风格V3（头像在内） *1栏*',
                'qa_v1'                          => '问答风格*1栏*',
                'compact_v1'                     => '紧凑卡片（用户名在顶部） *1栏*',
                'compact_v2'                     => '紧凑卡片（用户名在底部） *1栏*',
                'classic_v1'                     => '紧凑列表V1（经典） *1栏*',
                'classic_v2'                     => '紧凑列表V2 *1栏*',
                'classic_v3'                     => '紧凑列表V3 *1栏*',
                'classic_v4'                     => '紧凑列表V4 *1栏*',
                'super-compact_v1'               => '超紧凑列表V1【线报】*1栏*',
                'super-compact_v2'               => '超紧凑列表V2 *1栏*',
                'super-compact_v3'               => '超紧凑列表V3 *1栏*',
              ],
            ],
            'cols_count_for_forum' => [
              'label' => '栏数（单独）',
              'description' => '覆盖上述设置。',
              'type' => 'dropdown_per_forum',
              'choices' => [
                '_inherit' => '使用全局设置',
                12 => '1栏',
                6 => '2栏',
                4 => '3栏',
                3 => '4栏',
                2 => '6栏',
              ],
            ],
          ],
        ],
        'thread' => [
          'title' => '帖子详情',
          '_group' => 'G4',
          'options' => [
            'style_global' => [
              'label' => '帖子详情风格（全局）',
              'type' => 'radio-image',
              'default' => 'top_default',
              'choices' => [
                'classic_v1' => ['label' => '经典V1 *2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.classic_v1.png'],
                'classic_v2' => ['label' => '经典V2 *2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.classic_v2.png'],
                'classic_v3' => ['label' => '经典V3 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.classic_v3.png'],
                'blog' => ['label' => '博客V1 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.blog.png'],
                'blog_v2' => ['label' => '博客V2【突出标题，自媒体新闻】 *1栏*<br>在“外观—板式微调—门户网站风格V2”中设置标题', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.blog_v2.png'],
                'qa' => ['label' => '问答 *2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.qa.png'],
                'vintage_v1' => ['label' => '古董 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.vintage_v1.png'],
              ],
            ],
            'style_for_forum' => [
              'label' => '帖子详情风格（单独）',
              'description' => '覆盖上述设置。',
              'type' => 'dropdown_per_forum',
              'choices' => [
                '_inherit'   => '使用全局设置',
                'classic_v1' => '经典V1 *2栏*',
                'classic_v2' => '经典V2 *2栏*',
                'classic_v3' => '经典V3 *2栏*',
                'blog'       => '博客V1 *1栏*',
                'blog_v2'    => '博客V2 *1栏*',
                'qa'         => '问答 *2栏*',
                'vintage_v1' => '古董 *1栏*',
              ],
            ],
          ],
        ],
        'postlist' => [
          'title' => '回帖列表',
          '_group' => 'G4',
          'options' => [
            'style' => [
              'label' => '样式',
              'description' => '注意：当“帖子详情”设置为“古董”风格时，此选项无效。',
              'type' => 'radio-image',
              'default' => 'classic_v1',
              'choices' => [
                'classic_v1' => ['label' => '经典 V1', 'url' => $stately_setting_img_url_prefix . 'ui_style.postlist.style.classic_v1.png'],
                'classic_v2' => ['label' => '经典 V2', 'url' => $stately_setting_img_url_prefix . 'ui_style.postlist.style.classic_v2.png'],
              ],
            ],
          ],
        ],
        'user' => [
          'title' => '用户',
          '_group' => 'G5',
          'description' => '影响个人中心与用户页面。',
          'options' => [
            'style' => [
              'label' => '样式',
              'description' => '现代：主题默认风格；柚子：新的用户页面风格；经典：仿Xiuno BBS原装风格，增加封面图、用户统计和签名等。另见“外观—板式微调”里的“用户页面”部分。',
              'type' => 'radio-image',
              'default' => 'modern_v1',
              'choices' => [
                'classic_v1' => ['label' => '经典', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.classic_v1.png'],
                'modern_v1' => ['label' => '现代 V1', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.modern_v1.png'],
                'modern_v2' => ['label' => '现代 V2', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.modern_v2.png'],
                'modern_v3' => ['label' => '现代 V3【轻简】', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.modern_v3.png'],
                'yuzu_v1'  => ['label' => '柚子  V1', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v1.png'],
                'yuzu_v2'  => ['label' => '柚子  V2', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v2.png'],
                'yuzu_v3'  => ['label' => '柚子  V3', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v3.png'],
                'yuzu_v4'  => ['label' => '柚子  V4', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v4.png'],
                'yuzu_v5'  => ['label' => '柚子  V5', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v5.png'],
                'yuzu_v6'  => ['label' => '柚子  V6', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v6.png'],
                'yuzu_v7'  => ['label' => '柚子  V7', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v7.png'],
                'yuzu_v8'  => ['label' => '柚子  V8', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v8.png'],
                /*'yuzu_v9'  => ['label' => '柚子  V9', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v9.png'],*/
                'yuzu_v10' => ['label' => '柚子 V10', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v10.png'],
                'yuzu_v11' => ['label' => '柚子 V11', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v11.png'],
                'yuzu_v12' => ['label' => '柚子 V12', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v12.png'],
                'yuzu_v13' => ['label' => '柚子 V13', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v13.png'],
                'yuzu_v14' => ['label' => '柚子 V14', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.yuzu_v14.png'],
                /*'special_zb_v2' => ['label' => '【特殊】ZB风格', 'url' => $stately_setting_img_url_prefix . 'ui_style.user.style.special_zb_v2.png'],*/
              ],
            ],
          ],
        ],
        'login' => [
          'title' => '登录',
          '_group' => 'G6',
          'description' => '建议设置成同一种',
          'options' => [
            'style' => [
              'label' => '样式',
              'type' => 'radio-image',
              'default' => 'v1',
              'choices' => [
                'v1' => ['label' => '居中', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v1.png'],
                'v2_left' => ['label' => '左侧', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v2_left.png'],
                'v2_right' => ['label' => '右侧', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v2_right.png']
              ],
            ],
          ],
        ],
        'login_modal' => [
          'title' => '登录弹窗',
          '_group' => 'G6',
          'options' => [
            'style' => [
              'label' => '样式',
              'type' => 'radio-image',
              'default' => 'v1',
              'choices' => [
                'v1' => ['label' => '居中', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v1.png'],
                'special_zb_v1' => ['label' => '【特殊】ZB风格', 'url' => $stately_setting_img_url_prefix . 'ui_style.login_modal.style.special_zb_v1.png'],
              ],
            ],
            'force_show_modal' => [
              'label' => '未登录用户一定显示登录弹窗？',
              'type' => 'toggle',
              'default' => false,
              'description' => '启用后，如果访客没有登录的话，访问每个页面都会显示登录弹窗。建议搭配“ZB风格”登录弹窗使用，将配图设置为“能展现登录后对于访客的好处”的图片，能让用户更加接受。'
            ]
          ],
        ],
        'register' => [
          'title' => '注册',
          '_group' => 'G6',
          'description' => '建议设置成同一种',
          'options' => [
            'style' => [
              'label' => '样式',
              'type' => 'radio-image',
              'default' => 'v1',
              'choices' => [
                'v1' => ['label' => '居中', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v1.png'],
                'v2_left' => ['label' => '左侧', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v2_left.png'],
                'v2_right' => ['label' => '右侧', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v2_right.png'],
                'v3' => ['label' => '【特殊】信件风格（居中）', 'url' => $stately_setting_img_url_prefix . 'ui_style.register.style.v3.png'],
              ],
            ],
          ],
        ],
        'resetpw' => [
          'title' => '忘记密码',
          '_group' => 'G6',
          'description' => '建议设置成同一种',
          'options' => [
            'style' => [
              'label' => '样式',
              'type' => 'radio-image',
              'default' => 'v1',
              'choices' => [
                'v1' => ['label' => '居中', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v1.png'],
                'v2_left' => ['label' => '左侧', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v2_left.png'],
                'v2_right' => ['label' => '右侧', 'url' => $stately_setting_img_url_prefix . 'ui_style.login.style.v2_right.png']
              ],
            ],
          ],
        ],
      ],
    ],
    'ui_tweek' => [
      'title' => '外观—板式微调',
      'sections' => [
        'global' => [
          'title' => '全局',
          '_group' => 'G1',
          'options' => [
            'show_breadcrumb' => [
              'label' => '显示面包屑导航？',
              'description' => '在板块、帖子等页面显示路径导航（面包屑）',
              'type' => 'toggle',
              'default' => false,
            ],
            'breadcrumb_position' => [
              'label' => '面包屑导航显示位置',
              'description' => '默认：会出现在板块帖子列表上方、帖子详情上方等处。顶部左侧：显示在顶部左侧位置；只当“导航栏风格”为“纵向（左侧）”时生效，并且只会显示在PC端，且会覆盖“导航栏显示当前页面标题”的设置（当启用本选项，导航栏就不会显示当前页面标题）！',
              'type' => 'select',
              'default' => 'default',
              'choices' => [
                'default' => '默认',
                'navbar' => '顶部左侧',
              ],
            ],
            'threadlist_tabs_position' => [
              'label' => '帖子列表Tab显示位置',
              'description' => '适用于“紧凑列表”风格的帖子列表调整“最新、精华”等按钮的位置。其他风格请保持选择“外侧”。',
              'type' => 'select',
              'default' => 'outer',
              'choices' => [
                'outer' => '外侧',
                'inner' => '内侧',
              ],
            ]
          ],
        ],
        'navbar_vertical' => [
          'title' => '导航栏-纵向',
          '_group' => 'G1',
          'description' => '影响“纵向（左侧）”导航栏风格，与“横向（顶部）”导航栏风格的移动端菜单。',
          'options' => [
            'replaces_sitename_with_user_info' => [
              'label' => '将网站名称替换成用户信息？',
              'type' => 'select',
              'default' => 'no',
              'choices' => [
                'no' => '否（显示网站名称）',
                'auto' => '只在移动端替换成用户信息（PC端依旧显示网站名称）',
                'yes' => '是（显示用户信息）',
              ],
            ],
            'show_user_cover' => [
              'label' => '用户信息显示封面图？',
              'description' => '只有登录用户才会显示封面图。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'menu_magichref_user_avatar_submenu' => [
          'title' => '菜单-“头像+用户菜单”菜单项',
          '_group' => 'G1',
          'options' => [
            'style' => [
              'label' => '用户菜单显示风格',
              'type' => 'select',
              'default' => 'dropdown',
              'choices' => [
                'dropdown' => '下拉菜单',
                'modal' => '弹窗',
              ],
            ],
            'show_username' => [
              'label' => '显示用户名？',
              'type' => 'toggle',
              'default' => true,
            ],
            'modal_items_per_row' => [
              'label' => '用户菜单-下拉菜单风格-一行有几个菜单项？',
              'type' => 'select',
              'default' => 1,
              'choices' => [
                1 => 1,
                2 => 2,
              ],
            ]
          ],
        ],
        'menu_magichref_user_brief' => [
          'title' => '菜单-“个人信息”菜单项',
          '_group' => 'G1',
          'options' => [
            'show_uid' => [
              'label' => '显示UID？',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_usergroup' => [
              'label' => '显示用户组？',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_stats' => [
              'label' => '显示统计信息？',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_credits' => [
              'label' => '显示积分信息？',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_progress' => [
              'label' => '显示经验进度条？',
              'description' => '启用后，将显示经验值与“到达下一级的进度条”。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'homepage_portal_v2' => [
          'title' => '主页-门户网站风格V2',
          '_group' => 'G2',
          '_cols' => 2,
          'options' => [
            'explained' => [
              'label' => '可以设置的区域解释',
              'description' => implode('<br>', [
                '① 可设置：标题文字、图标、图标颜色、使用的板块', 
                '② 可设置：标题文字、图标、图标颜色、时间范围', 
                '③ 可设置：标题文字、图标、图标颜色、使用的板块', 
                '④ 可设置：标题文字、图标、图标颜色', 
                '⑤ 可设置：标题文字、图标、图标颜色、使用的板块', 
                '⑥ 可设置：标题文字、图标、图标颜色'
              ]),
              'type' => 'label',
              'default' => '<img src="' . $stately_setting_img_url_prefix . 'ui_tweek.homepage_portal_v2.explained.png" class="img-fluid">',
            ],
            '_dummy' => [
              'label' => '',
              'type' => 'hidden',
              'default' => '',
            ],
            'title_p1' => [
              'label' => '区域① 标题',
              'type' => 'text',
              'default' => '要闻推送'
            ],
            'forum_p1' => [
              'label' => '区域① 使用论坛版块',
              'description' => '选择“无”，则使用最新发布的帖子',
              'type' => 'forumlist_dropdown',
              'default' => 0,
            ],
            'icon_p1' => [
              'label' => '区域① 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-bullhorn'
            ],
            'icon_color_p1' => [
              'label' => '区域① 图标颜色',
              'type' => 'select',
              'default' => 'warning',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p2' => [
              'label' => '区域② 标题',
              'type' => 'text',
              'default' => '今日头条'
            ],
            'time_span_p2' => [
              'label' => '获取帖子的时间范围',
              'description' => '如果贵站频繁更新内容，可以选择“日度”或“周度”，否则选择“月度”、“季度”、“年度”',
              'type' => 'select',
              'default' => 'weekly',
              'choices' => [
                'daily' => '日度',
                'weekly' => '周度（7天）',
                'monthly' => '月度（30天）',
                'quarterly' => '季度（3个月）',
                'yearly' => '年度（12个月）',
              ],
            ],
            'icon_p2' => [
              'label' => '区域② 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-newspaper'
            ],
            'icon_color_p2' => [
              'label' => '区域② 图标颜色',
              'type' => 'select',
              'default' => 'danger',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p3' => [
              'label' => '区域③ 标题',
              'type' => 'text',
              'default' => '新闻快讯'
            ],
            'forum_p3' => [
              'label' => '区域③ 使用论坛版块',
              'description' => '此项不能选择“无”',
              'type' => 'forumlist_dropdown',
              'default' => 1,
            ],
            'icon_p3' => [
              'label' => '区域③ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-bolt'
            ],
            'icon_color_p3' => [
              'label' => '区域③ 图标颜色',
              'type' => 'select',
              'default' => 'success',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p4' => [
              'label' => '区域④ 标题',
              'type' => 'text',
              'default' => '最新文章'
            ],
            '_dummy_p4' => [
              'label' => '',
              'type' => 'hidden',
              'default' => '',
            ],
            'icon_p4' => [
              'label' => '区域④ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-file-alt'
            ],
            'icon_color_p4' => [
              'label' => '区域④ 图标颜色',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p5' => [
              'label' => '区域⑤ 标题',
              'type' => 'text',
              'default' => '大家在看'
            ],
            'forum_p5' => [
              'label' => '区域⑤ 使用论坛版块',
              'description' => '此项不能选择“无”',
              'type' => 'forumlist_dropdown',
              'default' => 1,
            ],
            'icon_p5' => [
              'label' => '区域⑤ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-eye'
            ],
            'icon_color_p5' => [
              'label' => '区域⑤ 图标颜色',
              'type' => 'select',
              'default' => 'info',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p6' => [
              'label' => '区域⑥ 标题',
              'type' => 'text',
              'default' => '推荐阅读'
            ],
            '_dummy_p6' => [
              'label' => '',
              'type' => 'hidden',
              'default' => '',
            ],
            'icon_p6' => [
              'label' => '区域⑥ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-bookmark'
            ],
            'icon_color_p6' => [
              'label' => '区域⑥ 图标颜色',
              'type' => 'select',
              'default' => 'warning',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
          ],
        ],
        'homepage_portal_v3' => [
          'title' => '主页-门户网站风格V3',
          '_group' => 'G2',
          '_cols' => 2,
          'options' => [
            'explained' => [
              'label' => '可以设置的区域解释',
              'description' => implode('<br>', [
                '① 可设置：“发新帖”按钮旁边的按钮的文字、网址和图标', 
                '② 可设置：标题文字、图标、图标颜色、时间范围', 
                '③ 可设置：要显示的板块', 
                '④ 可设置：标题文字、图标、图标颜色、使用的板块', 
                '⑤ 可设置：标题文字、图标、图标颜色、使用的板块', 
                '⑥ 可设置：标题文字、图标、图标颜色、使用的板块',
                '⑦ 可设置：标题文字、图标、图标颜色、使用的板块'
              ]),
              'type' => 'label',
              'default' => '<img src="' . $stately_setting_img_url_prefix . 'ui_tweek.homepage_portal_v3.explained.png" class="img-fluid">',
            ],
            '_dummy' => [
              'label' => '',
              'type' => 'hidden',
              'default' => '',
            ],
            'btn1_link_text_p1' => [
              'label' => '区域① 左侧按钮文字',
              'type' => 'text',
              'default' => '发布主题'
            ],
            'btn1_link_href_p1' => [
              'label' => '区域① 左侧按钮网址',
              'description' => '',
              'type' => 'text',
              'default' => 'thread-create-0.htm',
            ],
            'btn1_icon_p1' => [
              'label' => '区域① 左侧按钮图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-send'
            ],
            'btn1_style_p1' => [
              'label' => '区域① 左侧按钮颜色风格',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '【实心】主题主色',
                'secondary' => '【实心】主题辅助色',
                'success' => '【实心】绿色（成功）',
                'info' => '【实心】青色（信息）',
                'warning' => '【实心】橙色（警告）',
                'danger' => '【实心】红色（危险）',
                'light' => '【实心】亮色',
                'dark' => '【实心】暗色',
                'outline-primary' => '（空心）主题主色',
                'outline-secondary' => '（空心）主题辅助色',
                'outline-success' => '（空心）绿色（成功）',
                'outline-info' => '（空心）青色（信息）',
                'outline-warning' => '（空心）橙色（警告）',
                'outline-danger' => '（空心）红色（危险）',
                'outline-light' => '（空心）亮色',
                'outline-dark' => '（空心）暗色',
              ],
            ],
            'btn2_link_text_p1' => [
              'label' => '区域① 右侧按钮文字',
              'type' => 'text',
              'default' => '社区规范'
            ],
            'btn2_link_href_p1' => [
              'label' => '区域① 右侧按钮网址',
              'description' => '',
              'type' => 'text',
              'default' => 'terms.htm',
            ],
            'btn2_icon_p1' => [
              'label' => '区域① 右侧按钮图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-bullhorn'
            ],
            'btn2_style_p1' => [
              'label' => '区域① 右侧按钮颜色风格',
              'type' => 'select',
              'default' => 'outline-primary',
              'choices' => [
                'primary' => '【实心】主题主色',
                'secondary' => '【实心】主题辅助色',
                'success' => '【实心】绿色（成功）',
                'info' => '【实心】青色（信息）',
                'warning' => '【实心】橙色（警告）',
                'danger' => '【实心】红色（危险）',
                'light' => '【实心】亮色',
                'dark' => '【实心】暗色',
                'outline-primary' => '（空心）主题主色',
                'outline-secondary' => '（空心）主题辅助色',
                'outline-success' => '（空心）绿色（成功）',
                'outline-info' => '（空心）青色（信息）',
                'outline-warning' => '（空心）橙色（警告）',
                'outline-danger' => '（空心）红色（危险）',
                'outline-light' => '（空心）亮色',
                'outline-dark' => '（空心）暗色',
              ],
            ],
            'title_p2' => [
              'label' => '区域② 标题',
              'type' => 'text',
              'default' => '今日头条'
            ],
            'time_span_p2' => [
              'label' => '获取帖子的时间范围',
              'description' => '如果贵站频繁更新内容，可以选择“日度”或“周度”，否则选择“月度”、“季度”、“年度”',
              'type' => 'select',
              'default' => 'weekly',
              'choices' => [
                'daily' => '日度',
                'weekly' => '周度（7天）',
                'monthly' => '月度（30天）',
                'quarterly' => '季度（3个月）',
                'yearly' => '年度（12个月）',
              ],
            ],
            'icon_p2' => [
              'label' => '区域② 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-newspaper'
            ],
            'icon_color_p2' => [
              'label' => '区域② 图标颜色',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p3' => [
              'label' => '区域③ 标题',
              'type' => 'text',
              'default' => '推荐板块'
            ],
            '_dummy_p3' => [
              'label' => '',
              'type' => 'hidden',
              'default' => '',
            ],
            'icon_p2' => [
              'label' => '区域③ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-newspaper'
            ],
            'icon_color_p2' => [
              'label' => '区域③ 图标颜色',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'forum_1_p3' => [
              'label' => '区域③ 显示论坛1',
              'type' => 'forumlist_dropdown',
              'description' => '■□□<br>□□□<br>可以选择“无”，这样下一个图标就会替代该图标的位置。',
              'default' => 1,
            ],
            'forum_2_p3' => [
              'label' => '区域③ 显示论坛2',
              'type' => 'forumlist_dropdown',
              'description' => '□■□<br>□□□',
              'default' => 2,
            ],
            'forum_3_p3' => [
              'label' => '区域③ 显示论坛3',
              'type' => 'forumlist_dropdown',
              'description' => '□□■<br>□□□',
              'default' => 3,
            ],
            'forum_4_p3' => [
              'label' => '区域③ 显示论坛4',
              'type' => 'forumlist_dropdown',
              'description' => '□□□<br>■□□',
              'default' => 4,
            ],
            'forum_5_p3' => [
              'label' => '区域③ 显示论坛5',
              'type' => 'forumlist_dropdown',
              'description' => '□□□<br>□■□',
              'default' => 5,
            ],
            'forum_6_p3' => [
              'label' => '区域③ 显示论坛6',
              'type' => 'forumlist_dropdown',
              'description' => '□□□<br>□□■',
              'default' => 6,
            ],
            'title_p4' => [
              'label' => '区域④ 标题',
              'type' => 'text',
              'default' => '精彩阅读'
            ],
            'forum_p4' => [
              'label' => '区域④ 使用论坛版块',
              'description' => '此项不能选择“无”',
              'type' => 'forumlist_dropdown',
              'default' => 1,
            ],
            'icon_p4' => [
              'label' => '区域④ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-book-open'
            ],
            'icon_color_p4' => [
              'label' => '区域④ 图标颜色',
              'type' => 'select',
              'default' => 'warning',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p5' => [
              'label' => '区域⑤ 标题',
              'type' => 'text',
              'default' => '图文热点'
            ],
            'forum_p5' => [
              'label' => '区域⑤ 使用论坛版块',
              'description' => '此项不能选择“无”',
              'type' => 'forumlist_dropdown',
              'default' => 1,
            ],
            'icon_p5' => [
              'label' => '区域⑤ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-newspaper'
            ],
            'icon_color_p5' => [
              'label' => '区域⑤ 图标颜色',
              'type' => 'select',
              'default' => 'danger',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p6' => [
              'label' => '区域⑥ 标题',
              'type' => 'text',
              'default' => '推荐主题'
            ],
            'forum_p6' => [
              'label' => '区域⑥ 使用论坛版块',
              'description' => '此项不能选择“无”',
              'type' => 'forumlist_dropdown',
              'default' => 1,
            ],
            'icon_p6' => [
              'label' => '区域⑥ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-tag'
            ],
            'icon_color_p6' => [
              'label' => '区域⑥ 图标颜色',
              'type' => 'select',
              'default' => 'success',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
            'title_p7' => [
              'label' => '区域⑦ 标题',
              'type' => 'text',
              'default' => '精彩主题'
            ],
            'forum_p7' => [
              'label' => '区域⑦ 使用论坛版块',
              'description' => '此项不能选择“无”',
              'type' => 'forumlist_dropdown',
              'default' => 1,
            ],
            'icon_p7' => [
              'label' => '区域⑦ 图标',
              'type' => 'text',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>）',
              'default' => 'la la-star'
            ],
            'icon_color_p7' => [
              'label' => '区域⑦ 图标颜色',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '主题主色',
                'secondary' => '主题辅助色',
                'success' => '绿色（成功）',
                'info' => '青色（信息）',
                'warning' => '橙色（警告）',
                'danger' => '红色（危险）',
              ],
            ],
          ],
        ],
        'homepage' => [
          'title' => '主页-帖子列表',
          '_group' => 'G2',
          'options' => [
            'show_alltopthreads' => [
              'label' => '显示置顶帖子区域？',
              'description' => '启用后，将会把置顶帖子单独显示出来，更加明显。',
              'type' => 'toggle',
              'default' => true,
            ],
          ]
        ],
        'homepage_sitebrief' => [
          'title' => '主页-站点简介区域',
          '_group' => 'G2',
          'options' => [
            'enable' => [
              'label' => '显示站点简介？',
              'type' => 'toggle',
              'default' => true,
            ],
            'style' => [
              'label' => '站点简介风格',
              'description' => '',
              'type' => 'select',
              'default' => 'v1',
              'choices' => [
                'v1' => '经典',
                'v2' => '现代',
              ],
            ],
            'v2_background_style' => [
              'label' => '站点简介-现代风格 - 背景图',
              'description' => '仅在上一项为“现代”时有效。',
              'type' => 'select',
              'default' => 'v1',
              'choices' => [
                'none' => '无背景',
                'logo' => '重复Logo',
                'image' => '自定义背景图',
              ],
            ],
            'v2_background_image' => [
              'label' => '站点简介-现代风格 - 自定义背景图',
              'description' => '仅在上一项为“自定义背景图”时有效。',
              'type' => 'css_background_image',
              'default' => array( 
                'background-url' => $stately_img_url_prefix . 'siteinfo-bg.png',
                'background-repeat' => 'no-repeat',
                'background-position' => 'top center',
                'background-size' => 'cover',
                'background-attachment' => 'initial'
              ),
            ]
          ],
        ],
        'homepage_userinfo' => [
          'title' => '主页-用户信息',
          '_group' => 'G2',
          '_cols' => 2,
          'options' => [
            'enable' => [
              'label' => '显示用户信息？',
              'description' => '仅在登录后显示；建议将“主页-欢迎辞”中的“欢迎辞风格”设置为“侧边”，有最佳效果。',
              'type' => 'toggle',
              'default' => true,
            ],
            'style' => [
              'label' => '用户信息风格',
              'type' => 'select',
              'default' => 'v1',
              'choices' => [
                'v1' => '现代卡片',
                'v2' => '简洁卡片',
              ],
            ],
            'show_uid' => [
              'label' => '显示UID？',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_usergroup' => [
              'label' => '显示用户组？',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_stats' => [
              'label' => '显示统计信息？',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_credits' => [
              'label' => '显示积分信息？',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_progress' => [
              'label' => '显示经验进度条？',
              'description' => '启用后，将显示经验值与“到达下一级的进度条”。',
              'type' => 'toggle',
              'default' => true,
            ],
          ],
        ],
        'homepage_stats' => [
          'title' => '主页-站点统计',
          '_group' => 'G2',
          'options' => [
            'enable' => [
              'label' => '显示站点统计？',
              'type' => 'toggle',
              'default' => true,
            ],
            'style' => [
              'label' => '站点统计风格',
              'type' => 'radio-image',
              'default' => 'v3',
              'choices' => [
                'v1' => ['label' => '经典（小工具区域）', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.homepage_stats.style.v1.png'],
                'v2' => ['label' => '醒目（小工具区域）', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.homepage_stats.style.v2.png'],
                'v3' => ['label' => '卡片（小工具区域）', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.homepage_stats.style.v3.png'],
                'v4' => ['label' => '极简（帖子列表上方）', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.homepage_stats.style.v4.png'],
                'v5' => ['label' => '紧凑（小工具区域）', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.homepage_stats.style.v5.png'],
                'v6' => ['label' => '经典（帖子列表下方）', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.homepage_stats.style.v6.png'],
              ],
            ],
          ],
        ],
        'bbs' => [
          'title' => '板块列表页',
          '_group' => 'G6',
          'options' => [
            'style' => [
              'label' => '样式',
              'type' => 'radio-image',
              'description' => '“V4 - 含最后回复帖子”会增加数据库查询，可能会增加服务器负担。（所以才会有两个选项）',

              'default' => 'v1',
              'choices' => [
                'v1' => ['label' => 'V1', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.bbs.style.v1.png'],
                'v2' => ['label' => 'V2', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.bbs.style.v2.png'],
                'v3' => ['label' => 'V3', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.bbs.style.v3.png'],
                'v4' => ['label' => 'V4', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.bbs.style.v4.png'],
                'v4_with_last_post' => ['label' => 'V4 - 含最后回复帖子', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.bbs.style.v4_with_last_post.png'],
              ],
            ],
            'cols_count' => [
              'label' => '每行显示几个板块？',
              'description' => '在移动端会自动调整为2栏或1栏。',
              'type' => 'select',
              'default' => 1,
              'choices' => [
                1 => '1栏',
                2 => '2栏',
                3 => '3栏',
                4 => '4栏',
              ],
            ],
            'show_newthread_list' => [
              'label' => '显示“新帖、回帖、精华”帖子列表？',
              'type' => 'toggle',
              'default' => true,
            ],
            'hot_forums_fid' => [
              'label' => '“热门板块”显示哪些板块？',
              'type' => 'forumlist_multi',
              'default' => array(1),
            ],
          ],
        ],
        'threadlist' => [
          'title' => '帖子列表-通用',
          '_group' => 'G3',
          '_cols' => '2',
          'options' => [
            'show_thread_excerpt' => [
              'label' => '显示帖子摘要？',
              'description' => '若帖子内含有收费内容，则不显示摘要；注意：某些板式完全不显示摘要；可能会导致网站变慢',
              'type' => 'toggle',
              'default' => true,
            ],
            'thread_excerpt_length' => [
              'label' => '帖子摘要字数',
              'description' => '单位为字。字母、数字、汉字皆算一个字符。输入“-1”显示帖子全文。',
              'type' => 'number',
              'default' => 140,
              'min' => -1,
              'max' => 2048,
              'step' => 1
            ],
            'show_thread_thumbnail' => [
              'label' => '显示帖子缩略图？',
              'description' => '注意：某些板式完全不显示缩略图；可能会导致网站变慢',
              'type' => 'toggle',
              'default' => true,
            ],
            'default_thumbnail'=> [
              'label' => '默认帖子缩略图',
              'description' => '若填写内容，则当帖子没有合适封面图的时候显示这里填写的图片。留空为不显示（原样）。',
              'type' => 'text',
              'default' => '',
            ],
            'show_user_vcard' => [
              'label' => '显示用户信息卡片？',
              'description' => '将鼠标放在用户头像上即可查看该用户的简略信息。',
              'type' => 'toggle',
              'default' => false,
            ],
            'use_waterfall' => [
              'label' => '使用瀑布流布局？',
              'description' => '如果您在使用“图文列表”风格，且每张图的高度不一样的话，启用这个会有更好的效果。如果栏数设为1，则无需启用。',
              'type' => 'toggle',
              'default' => false,
            ],
            'use_ajax_load' => [
              'label' => '使用Ajax加载？',
              'description' => '选择“是”，会将主页和论坛版块页面底部的翻页按钮替换为“加载更多”按钮。按下按钮后，将动态加载下一页帖子内容并添加到当前页面中，实现无刷新的浏览体验。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'threadlist_style_sns' => [
          'title' => '帖子列表-SNS风格',
          '_group' => 'G3',
          'options' => [
            'thread_thumbnail_count' => [
              'label' => '帖子缩略图数量',
              'type' => 'select',
              'default' => 'auto',
              'choices' => [
                'auto' => '自动：根据帖子内图片数量决定显示多少张图片',
                1 => '　１：单张',
                2 => '　２：左右各一张',
                3 => '　３：左侧一张，右侧垂直两张',
                4 => '　４：两行，每行各两张',
                6 => '　６：两行，每行各三张',
                9 => '　９：三行，每行各三张',
              ],
            ],
          ],
        ],
        'thread_create' => [
          'title' => '发帖页面',
          '_group' => 'G6',
          'options' => [
            'submit_button_position' => [
              'label' => '发帖/编辑提交按钮位置',
              'description' => '顶部：主题默认风格，可以让用户在发表前潜移默化的再检查一遍；底部：Xiuno BBS原装风格。',
              'type' => 'radio',
              'default' => 'top',
              'choices' => [
                'top' => '顶部',
                'bottom' => '底部',
              ]
            ],
          ],
        ],
        'thread' => [
          'title' => '帖子详情-通用',
          '_group' => 'G4',
          'options' => [
            'show_thread_content_on_non_first_page' => [
              'label' => '非第一页显示帖子内容？',
              'description' => '用户在帖子第二页及之后的页码时，是否显示帖子正文？是：显示帖子正文，会增加页面篇幅；否：Xiuno BBS默认行为。',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_fab' => [
              'label' => '显示“悬浮按钮”？',
              'description' => '在帖子左侧显示评论、点赞、收藏等功能按钮，方便使用；点赞、收藏按钮仅在安装对应插件后显示；仅在PC端显示。',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_user_recent_threads' => [
              'label' => '显示“作者最近主题”？',
              'description' => '启用此设置将在用户资料部分中显示作者最近发布的帖子，可以让其他用户更方便地探索作者发布的其他帖子，提高网站的互动性。',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_floor_number' => [
              'label' => '显示楼层数？',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_thread_navigation' => [
              'label' => '显示导航链接？',
              'description' => '在帖子页面上显示上一篇和下一篇文章的导航链接，让用户更方便地浏览网站上的帖子。',
              'type' => 'toggle',
              'default' => false,
            ],
            'show_font_size_btn' => [
              'label' => '显示字号调整按钮？',
              'description' => '在帖子页面上显示字号调整按钮，点击即可放大/恢复字号，便于阅读。',
              'type' => 'toggle',
              'default' => false,
            ],
            'showmore' => [
              'label' => '启用“阅读全文”功能？',
              'description' => '启用后，如果帖子字数过多，将会隐藏一部分。',
              'type' => 'toggle',
              'default' => false,
            ],
            'showmore_excerpt_length' => [
              'label' => '阅读全文-帖子摘要字数',
              'description' => '单位为字。字母、数字、汉字皆算一个字符。',
              'type' => 'number',
              'default' => 512,
              'min' => 1,
              'max' => 65535,
              'step' => 1
            ],
            'use_code_highlight' => [
              'label' => '使用代码高亮？',
              'description' => '在帖子和评论中插入的代码块会呈现为高亮显示的格式，可以使代码更易于阅读和理解。如果你已经在用有相同功能的插件，请将此项设为“否”。',
              'type' => 'toggle',
              'default' => false,
            ],
            'code_highlight_theme' => [
              'label' => '代码高亮配色（深色模式）',
              'description' => '当切换成深色模式时，会使用此处的代码高亮配色。',
              'type' => 'color_schemes',
              'choices' => array ( 'base16-3024.css' => array ( 'label' => ' 3024 ', 'colors' => array ( 0 => '#090300', 1 => '#a5a2a2', 2 => '#d6d5d4', 3 => '#db2d20', 4 => '#fded02', 5 => '#01a252', 6 => '#01a0e4', ), ), 'base16-apathy.css' => array ( 'label' => ' Apathy ', 'colors' => array ( 0 => '#031A16', 1 => '#81B5AC', 2 => '#A7CEC8', 3 => '#3E9688', 4 => '#3E4C96', 5 => '#883E96', 6 => '#96883E', ), ), 'base16-ashes.css' => array ( 'label' => ' Ashes ', 'colors' => array ( 0 => '#1C2023', 1 => '#C7CCD1', 2 => '#DFE2E5', 3 => '#C7AE95', 4 => '#AEC795', 5 => '#95C7AE', 6 => '#AE95C7', ), ), 'base16-atelier-cave-light.css' => array ( 'label' => ' Atelier Cave Light ', 'colors' => array ( 0 => '#efecf4', 1 => '#585260', 2 => '#26232a', 3 => '#be4678', 4 => '#a06e3b', 5 => '#2a9292', 6 => '#576ddb', ), ), 'base16-atelier-cave.css' => array ( 'label' => ' Atelier Cave ', 'colors' => array ( 0 => '#19171c', 1 => '#8b8792', 2 => '#e2dfe7', 3 => '#be4678', 4 => '#a06e3b', 5 => '#2a9292', 6 => '#576ddb', ), ), 'base16-atelier-dune-light.css' => array ( 'label' => ' Atelier Dune Light ', 'colors' => array ( 0 => '#fefbec', 1 => '#6e6b5e', 2 => '#292824', 3 => '#d73737', 4 => '#ae9513', 5 => '#60ac39', 6 => '#6684e1', ), ), 'base16-atelier-dune.css' => array ( 'label' => ' Atelier Dune ', 'colors' => array ( 0 => '#20201d', 1 => '#a6a28c', 2 => '#e8e4cf', 3 => '#d73737', 4 => '#ae9513', 5 => '#60ac39', 6 => '#6684e1', ), ), 'base16-atelier-estuary-light.css' => array ( 'label' => ' Atelier Estuary Light ', 'colors' => array ( 0 => '#f4f3ec', 1 => '#5f5e4e', 2 => '#302f27', 3 => '#ba6236', 4 => '#a5980d', 5 => '#7d9726', 6 => '#36a166', ), ), 'base16-atelier-estuary.css' => array ( 'label' => ' Atelier Estuary ', 'colors' => array ( 0 => '#22221b', 1 => '#929181', 2 => '#e7e6df', 3 => '#ba6236', 4 => '#a5980d', 5 => '#7d9726', 6 => '#36a166', ), ), 'base16-atelier-forest-light.css' => array ( 'label' => ' Atelier Forest Light ', 'colors' => array ( 0 => '#f1efee', 1 => '#68615e', 2 => '#2c2421', 3 => '#f22c40', 4 => '#c38418', 5 => '#7b9726', 6 => '#407ee7', ), ), 'base16-atelier-forest.css' => array ( 'label' => ' Atelier Forest ', 'colors' => array ( 0 => '#1b1918', 1 => '#a8a19f', 2 => '#e6e2e0', 3 => '#f22c40', 4 => '#c38418', 5 => '#7b9726', 6 => '#407ee7', ), ), 'base16-atelier-heath-light.css' => array ( 'label' => ' Atelier Heath Light ', 'colors' => array ( 0 => '#f7f3f7', 1 => '#695d69', 2 => '#292329', 3 => '#ca402b', 4 => '#bb8a35', 5 => '#918b3b', 6 => '#516aec', ), ), 'base16-atelier-heath.css' => array ( 'label' => ' Atelier Heath ', 'colors' => array ( 0 => '#1b181b', 1 => '#ab9bab', 2 => '#d8cad8', 3 => '#ca402b', 4 => '#bb8a35', 5 => '#918b3b', 6 => '#516aec', ), ), 'base16-atelier-lakeside-light.css' => array ( 'label' => ' Atelier Lakeside Light ', 'colors' => array ( 0 => '#ebf8ff', 1 => '#516d7b', 2 => '#1f292e', 3 => '#d22d72', 4 => '#8a8a0f', 5 => '#568c3b', 6 => '#257fad', ), ), 'base16-atelier-lakeside.css' => array ( 'label' => ' Atelier Lakeside ', 'colors' => array ( 0 => '#161b1d', 1 => '#7ea2b4', 2 => '#c1e4f6', 3 => '#d22d72', 4 => '#8a8a0f', 5 => '#568c3b', 6 => '#257fad', ), ), 'base16-atelier-plateau-light.css' => array ( 'label' => ' Atelier Plateau Light ', 'colors' => array ( 0 => '#f4ecec', 1 => '#585050', 2 => '#292424', 3 => '#ca4949', 4 => '#a06e3b', 5 => '#4b8b8b', 6 => '#7272ca', ), ), 'base16-atelier-plateau.css' => array ( 'label' => ' Atelier Plateau ', 'colors' => array ( 0 => '#1b1818', 1 => '#8a8585', 2 => '#e7dfdf', 3 => '#ca4949', 4 => '#a06e3b', 5 => '#4b8b8b', 6 => '#7272ca', ), ), 'base16-atelier-savanna-light.css' => array ( 'label' => ' Atelier Savanna Light ', 'colors' => array ( 0 => '#ecf4ee', 1 => '#526057', 2 => '#232a25', 3 => '#b16139', 4 => '#a07e3b', 5 => '#489963', 6 => '#478c90', ), ), 'base16-atelier-savanna.css' => array ( 'label' => ' Atelier Savanna ', 'colors' => array ( 0 => '#171c19', 1 => '#87928a', 2 => '#dfe7e2', 3 => '#b16139', 4 => '#a07e3b', 5 => '#489963', 6 => '#478c90', ), ), 'base16-atelier-seaside-light.css' => array ( 'label' => ' Atelier Seaside Light ', 'colors' => array ( 0 => '#f4fbf4', 1 => '#5e6e5e', 2 => '#242924', 3 => '#e6193c', 4 => '#98981b', 5 => '#29a329', 6 => '#3d62f5', ), ), 'base16-atelier-seaside.css' => array ( 'label' => ' Atelier Seaside ', 'colors' => array ( 0 => '#131513', 1 => '#8ca68c', 2 => '#cfe8cf', 3 => '#e6193c', 4 => '#98981b', 5 => '#29a329', 6 => '#3d62f5', ), ), 'base16-atelier-sulphurpool-light.css' => array ( 'label' => ' Atelier Sulphurpool Light ', 'colors' => array ( 0 => '#f5f7ff', 1 => '#5e6687', 2 => '#293256', 3 => '#c94922', 4 => '#c08b30', 5 => '#ac9739', 6 => '#3d8fd1', ), ), 'base16-atelier-sulphurpool.css' => array ( 'label' => ' Atelier Sulphurpool ', 'colors' => array ( 0 => '#202746', 1 => '#979db4', 2 => '#dfe2f1', 3 => '#c94922', 4 => '#c08b30', 5 => '#ac9739', 6 => '#3d8fd1', ), ), 'base16-atlas.css' => array ( 'label' => ' Atlas ', 'colors' => array ( 0 => '#002635', 1 => '#a1a19a', 2 => '#e6e6dc', 3 => '#ff5a67', 4 => '#ffcc1b', 5 => '#7fc06e', 6 => '#14747e', ), ), 'base16-ayu-dark.css' => array ( 'label' => ' Ayu Dark ', 'colors' => array ( 0 => '#0F1419', 1 => '#E6E1CF', 2 => '#E6E1CF', 3 => '#F07178', 4 => '#FFB454', 5 => '#B8CC52', 6 => '#59C2FF', ), ), 'base16-ayu-light.css' => array ( 'label' => ' Ayu Light ', 'colors' => array ( 0 => '#FAFAFA', 1 => '#5C6773', 2 => '#242936', 3 => '#F07178', 4 => '#F2AE49', 5 => '#86B300', 6 => '#36A3D9', ), ), 'base16-ayu-mirage.css' => array ( 'label' => ' Ayu Mirage ', 'colors' => array ( 0 => '#171B24', 1 => '#CCCAC2', 2 => '#D9D7CE', 3 => '#F28779', 4 => '#FFD173', 5 => '#D5FF80', 6 => '#5CCFE6', ), ), 'base16-bespin.css' => array ( 'label' => ' Bespin ', 'colors' => array ( 0 => '#28211c', 1 => '#8a8986', 2 => '#9d9b97', 3 => '#cf6a4c', 4 => '#f9ee98', 5 => '#54be0d', 6 => '#5ea6ea', ), ), 'base16-blueforest.css' => array ( 'label' => ' Blueforest ', 'colors' => array ( 0 => '#141F2E', 1 => '#FFCC33', 2 => '#91CCFF', 3 => '#fffab1', 4 => '#91CCFF', 5 => '#80ff80', 6 => '#a2cff5', ), ), 'base16-blueish.css' => array ( 'label' => ' Blueish ', 'colors' => array ( 0 => '#182430', 1 => '#C8E1F8', 2 => '#DDEAF6', 3 => '#4CE587', 4 => '#82AAFF', 5 => '#C3E88D', 6 => '#82AAFF', ), ), 'base16-brewer.css' => array ( 'label' => ' Brewer ', 'colors' => array ( 0 => '#0c0d0e', 1 => '#b7b8b9', 2 => '#dadbdc', 3 => '#e31a1c', 4 => '#dca060', 5 => '#31a354', 6 => '#3182bd', ), ), 'base16-bright.css' => array ( 'label' => ' Bright ', 'colors' => array ( 0 => '#000000', 1 => '#e0e0e0', 2 => '#f5f5f5', 3 => '#fb0120', 4 => '#fda331', 5 => '#a1c659', 6 => '#6fb3d2', ), ), 'base16-brushtrees-dark.css' => array ( 'label' => ' Brushtrees Dark ', 'colors' => array ( 0 => '#485867', 1 => '#B0C5C8', 2 => '#C9DBDC', 3 => '#b38686', 4 => '#aab386', 5 => '#87b386', 6 => '#868cb3', ), ), 'base16-brushtrees.css' => array ( 'label' => ' Brushtrees ', 'colors' => array ( 0 => '#E3EFEF', 1 => '#6D828E', 2 => '#5A6D7A', 3 => '#b38686', 4 => '#aab386', 5 => '#87b386', 6 => '#868cb3', ), ), 'base16-candid.css' => array ( 'label' => ' Candid ', 'colors' => array ( 0 => '#2f343f', 1 => '#efeeea', 2 => '#efeeea', 3 => '#fb7da7', 4 => '#2cda9d', 5 => '#ffcd5b', 6 => '#a18bd3', ), ), 'base16-canvased-pastel.css' => array ( 'label' => ' Canvased Pastel ', 'colors' => array ( 0 => '#170f0d', 1 => '#999f91', 2 => '#c4b67a', 3 => '#b2b08c', 4 => '#837b61', 5 => '#c4b67a', 6 => '#cfc995', ), ), 'base16-catppuccin-frappe.css' => array ( 'label' => ' Catppuccin Frappe ', 'colors' => array ( 0 => '#303446', 1 => '#c6d0f5', 2 => '#f2d5cf', 3 => '#e78284', 4 => '#e5c890', 5 => '#a6d189', 6 => '#8caaee', ), ), 'base16-catppuccin-latte.css' => array ( 'label' => ' Catppuccin Latte ', 'colors' => array ( 0 => '#eff1f5', 1 => '#4c4f69', 2 => '#dc8a78', 3 => '#d20f39', 4 => '#df8e1d', 5 => '#40a02b', 6 => '#1e66f5', ), ), 'base16-catppuccin-macchiato.css' => array ( 'label' => ' Catppuccin Macchiato ', 'colors' => array ( 0 => '#24273a', 1 => '#cad3f5', 2 => '#f4dbd6', 3 => '#ed8796', 4 => '#eed49f', 5 => '#a6da95', 6 => '#8aadf4', ), ), 'base16-catppuccin-mocha.css' => array ( 'label' => ' Catppuccin Mocha ', 'colors' => array ( 0 => '#1e1e2e', 1 => '#cdd6f4', 2 => '#f5e0dc', 3 => '#f38ba8', 4 => '#f9e2af', 5 => '#a6e3a1', 6 => '#89b4fa', ), ), 'base16-chalk.css' => array ( 'label' => ' Chalk ', 'colors' => array ( 0 => '#151515', 1 => '#d0d0d0', 2 => '#e0e0e0', 3 => '#fb9fb1', 4 => '#ddb26f', 5 => '#acc267', 6 => '#6fc2ef', ), ), 'base16-circus.css' => array ( 'label' => ' Circus ', 'colors' => array ( 0 => '#191919', 1 => '#a7a7a7', 2 => '#808080', 3 => '#dc657d', 4 => '#c3ba63', 5 => '#84b97c', 6 => '#639ee4', ), ), 'base16-citrus-mist.css' => array ( 'label' => ' Citrus Mist ', 'colors' => array ( 0 => '#131F25', 1 => '#E1EAEF', 2 => '#B7CDD8', 3 => '#FFC55F', 4 => '#C7E77E', 5 => '#E4F9A9', 6 => '#77A1B6', ), ), 'base16-city-streets-dark.css' => array ( 'label' => ' City Streets Dark ', 'colors' => array ( 0 => '#201e24', 1 => '#c2bec1', 2 => '#cbc5ba', 3 => '#a7a099', 4 => '#e3ddd2', 5 => '#c3bcb2', 6 => '#cbc5ba', ), ), 'base16-city-streets-light.css' => array ( 'label' => ' City Streets Light ', 'colors' => array ( 0 => '#efe8dc', 1 => '#413c3e', 2 => '#2d2b30', 3 => '#3f3d40', 4 => '#6e6765', 5 => '#423e41', 6 => '#4e4a4b', ), ), 'base16-classic-dark.css' => array ( 'label' => ' Classic Dark ', 'colors' => array ( 0 => '#151515', 1 => '#D0D0D0', 2 => '#E0E0E0', 3 => '#AC4142', 4 => '#F4BF75', 5 => '#90A959', 6 => '#6A9FB5', ), ), 'base16-classic-light.css' => array ( 'label' => ' Classic Light ', 'colors' => array ( 0 => '#F5F5F5', 1 => '#303030', 2 => '#202020', 3 => '#AC4142', 4 => '#F4BF75', 5 => '#90A959', 6 => '#6A9FB5', ), ), 'base16-color-star.css' => array ( 'label' => ' Color Star ', 'colors' => array ( 0 => '#000000', 1 => '#bbada9', 2 => '#d3d3d3', 3 => '#f4e199', 4 => '#6067ac', 5 => '#d7b559', 6 => '#7c83c0', ), ), 'base16-colors.css' => array ( 'label' => ' Colors ', 'colors' => array ( 0 => '#111111', 1 => '#bbbbbb', 2 => '#dddddd', 3 => '#ff4136', 4 => '#ffdc00', 5 => '#2ecc40', 6 => '#0074d9', ), ), 'base16-cupcake.css' => array ( 'label' => ' Cupcake ', 'colors' => array ( 0 => '#fbf1f2', 1 => '#8b8198', 2 => '#72677E', 3 => '#D57E85', 4 => '#DCB16C', 5 => '#A3B367', 6 => '#7297B9', ), ), 'base16-cupertino.css' => array ( 'label' => ' Cupertino ', 'colors' => array ( 0 => '#ffffff', 1 => '#404040', 2 => '#404040', 3 => '#c41a15', 4 => '#826b28', 5 => '#007400', 6 => '#0000ff', ), ), 'base16-da-one-black.css' => array ( 'label' => ' Da One Black ', 'colors' => array ( 0 => '#000000', 1 => '#ffffff', 2 => '#ffffff', 3 => '#fa7883', 4 => '#ff9470', 5 => '#98c379', 6 => '#6bb8ff', ), ), 'base16-da-one-gray.css' => array ( 'label' => ' Da One Gray ', 'colors' => array ( 0 => '#181818', 1 => '#ffffff', 2 => '#ffffff', 3 => '#fa7883', 4 => '#ff9470', 5 => '#98c379', 6 => '#6bb8ff', ), ), 'base16-da-one-ocean.css' => array ( 'label' => ' Da One Ocean ', 'colors' => array ( 0 => '#171726', 1 => '#ffffff', 2 => '#ffffff', 3 => '#fa7883', 4 => '#ff9470', 5 => '#98c379', 6 => '#6bb8ff', ), ), 'base16-da-one-paper.css' => array ( 'label' => ' Da One Paper ', 'colors' => array ( 0 => '#faf0dc', 1 => '#181818', 2 => '#000000', 3 => '#de5d6e', 4 => '#b3684f', 5 => '#76a85d', 6 => '#5890f8', ), ), 'base16-da-one-sea.css' => array ( 'label' => ' Da One Sea ', 'colors' => array ( 0 => '#22273d', 1 => '#ffffff', 2 => '#ffffff', 3 => '#fa7883', 4 => '#ff9470', 5 => '#98c379', 6 => '#6bb8ff', ), ), 'base16-da-one-white.css' => array ( 'label' => ' Da One White ', 'colors' => array ( 0 => '#ffffff', 1 => '#181818', 2 => '#000000', 3 => '#de5d6e', 4 => '#b3684f', 5 => '#76a85d', 6 => '#5890f8', ), ), 'base16-danqing-light.css' => array ( 'label' => ' Danqing Light ', 'colors' => array ( 0 => '#fcfefd', 1 => '#5a605d', 2 => '#434846', 3 => '#F9906F', 4 => '#F0C239', 5 => '#8AB361', 6 => '#B0A4E3', ), ), 'base16-danqing.css' => array ( 'label' => ' Danqing ', 'colors' => array ( 0 => '#2d302f', 1 => '#e0f0eF', 2 => '#ecf6f2', 3 => '#F9906F', 4 => '#F0C239', 5 => '#8AB361', 6 => '#B0A4E3', ), ), 'base16-darcula.css' => array ( 'label' => ' Darcula ', 'colors' => array ( 0 => '#2b2b2b', 1 => '#a9b7c6', 2 => '#ffc66d', 3 => '#4eade5', 4 => '#bbb529', 5 => '#6a8759', 6 => '#9876aa', ), ), 'base16-darkmoss.css' => array ( 'label' => ' Darkmoss ', 'colors' => array ( 0 => '#171e1f', 1 => '#c7c7a5', 2 => '#e3e3c8', 3 => '#ff4658', 4 => '#fdb11f', 5 => '#499180', 6 => '#498091', ), ), 'base16-darktooth.css' => array ( 'label' => ' Darktooth ', 'colors' => array ( 0 => '#1D2021', 1 => '#A89984', 2 => '#D5C4A1', 3 => '#FB543F', 4 => '#FAC03B', 5 => '#95C085', 6 => '#0D6678', ), ), 'base16-darkviolet.css' => array ( 'label' => ' Darkviolet ', 'colors' => array ( 0 => '#000000', 1 => '#b08ae6', 2 => '#9045e6', 3 => '#a82ee6', 4 => '#f29df2', 5 => '#4595e6', 6 => '#4136d9', ), ), 'base16-decaf.css' => array ( 'label' => ' Decaf ', 'colors' => array ( 0 => '#2d2d2d', 1 => '#cccccc', 2 => '#e0e0e0', 3 => '#ff7f7b', 4 => '#ffd67c', 5 => '#beda78', 6 => '#90bee1', ), ), 'base16-default-dark.css' => array ( 'label' => ' Default Dark ', 'colors' => array ( 0 => '#181818', 1 => '#d8d8d8', 2 => '#e8e8e8', 3 => '#ab4642', 4 => '#f7ca88', 5 => '#a1b56c', 6 => '#7cafc2', ), ), 'base16-default-light.css' => array ( 'label' => ' Default Light ', 'colors' => array ( 0 => '#f8f8f8', 1 => '#383838', 2 => '#282828', 3 => '#ab4642', 4 => '#f7ca88', 5 => '#a1b56c', 6 => '#7cafc2', ), ), 'base16-dracula.css' => array ( 'label' => ' Dracula ', 'colors' => array ( 0 => '#282936', 1 => '#e9e9f4', 2 => '#f1f2f8', 3 => '#ea51b2', 4 => '#00f769', 5 => '#ebff87', 6 => '#62d6e8', ), ), 'base16-edge-dark.css' => array ( 'label' => ' Edge Dark ', 'colors' => array ( 0 => '#262729', 1 => '#b7bec9', 2 => '#d390e7', 3 => '#e77171', 4 => '#dbb774', 5 => '#a1bf78', 6 => '#73b3e7', ), ), 'base16-edge-light.css' => array ( 'label' => ' Edge Light ', 'colors' => array ( 0 => '#fafafa', 1 => '#5e646f', 2 => '#b870ce', 3 => '#db7070', 4 => '#d69822', 5 => '#7c9f4b', 6 => '#6587bf', ), ), 'base16-eighties.css' => array ( 'label' => ' Eighties ', 'colors' => array ( 0 => '#2d2d2d', 1 => '#d3d0c8', 2 => '#e8e6df', 3 => '#f2777a', 4 => '#ffcc66', 5 => '#99cc99', 6 => '#6699cc', ), ), 'base16-embark-terminal.css' => array ( 'label' => ' Embark Terminal ', 'colors' => array ( 0 => '#100E23', 1 => '#8A889D', 2 => '#CBE3E7', 3 => '#F02E6E', 4 => '#FFE6B3', 5 => '#7FE9C3', 6 => '#78A8FF', ), ), 'base16-embark.css' => array ( 'label' => ' Embark ', 'colors' => array ( 0 => '#1E1C31', 1 => '#8A889D', 2 => '#CBE3E7', 3 => '#ABF8F7', 4 => '#D4BFFF', 5 => '#FFE6B3', 6 => '#F48FB1', ), ), 'base16-embers.css' => array ( 'label' => ' Embers ', 'colors' => array ( 0 => '#16130F', 1 => '#A39A90', 2 => '#BEB6AE', 3 => '#826D57', 4 => '#6D8257', 5 => '#57826D', 6 => '#6D5782', ), ), 'base16-emil.css' => array ( 'label' => ' Emil ', 'colors' => array ( 0 => '#efefef', 1 => '#313145', 2 => '#22223a', 3 => '#f43979', 4 => '#ff669b', 5 => '#0073a8', 6 => '#471397', ), ), 'base16-equilibrium-dark.css' => array ( 'label' => ' Equilibrium Dark ', 'colors' => array ( 0 => '#0c1118', 1 => '#afaba2', 2 => '#cac6bd', 3 => '#f04339', 4 => '#bb8801', 5 => '#7f8b00', 6 => '#008dd1', ), ), 'base16-equilibrium-gray-dark.css' => array ( 'label' => ' Equilibrium Gray Dark ', 'colors' => array ( 0 => '#111111', 1 => '#ababab', 2 => '#c6c6c6', 3 => '#f04339', 4 => '#bb8801', 5 => '#7f8b00', 6 => '#008dd1', ), ), 'base16-equilibrium-gray-light.css' => array ( 'label' => ' Equilibrium Gray Light ', 'colors' => array ( 0 => '#f1f1f1', 1 => '#474747', 2 => '#303030', 3 => '#d02023', 4 => '#9d6f00', 5 => '#637200', 6 => '#0073b5', ), ), 'base16-equilibrium-light.css' => array ( 'label' => ' Equilibrium Light ', 'colors' => array ( 0 => '#f5f0e7', 1 => '#43474e', 2 => '#2c3138', 3 => '#d02023', 4 => '#9d6f00', 5 => '#637200', 6 => '#0073b5', ), ), 'base16-espresso.css' => array ( 'label' => ' Espresso ', 'colors' => array ( 0 => '#2d2d2d', 1 => '#cccccc', 2 => '#e0e0e0', 3 => '#d25252', 4 => '#ffc66d', 5 => '#a5c261', 6 => '#6c99bb', ), ), 'base16-eva-dim.css' => array ( 'label' => ' Eva Dim ', 'colors' => array ( 0 => '#2a3b4d', 1 => '#9fa2a6', 2 => '#d6d7d9', 3 => '#c4676c', 4 => '#cfd05d', 5 => '#5de561', 6 => '#1ae1dc', ), ), 'base16-eva.css' => array ( 'label' => ' Eva ', 'colors' => array ( 0 => '#2a3b4d', 1 => '#9fa2a6', 2 => '#d6d7d9', 3 => '#c4676c', 4 => '#ffff66', 5 => '#66ff66', 6 => '#15f4ee', ), ), 'base16-everforest-light.css' => array ( 'label' => ' Everforest Light ', 'colors' => array ( 0 => '#fdf6e3', 1 => '#5c6a72', 2 => '#829181', 3 => '#3a94c5', 4 => '#dfa000', 5 => '#35a77c', 6 => '#8da101', ), ), 'base16-everforest.css' => array ( 'label' => ' Everforest ', 'colors' => array ( 0 => '#2f383e', 1 => '#d3c6aa', 2 => '#e4e1cd', 3 => '#7fbbb3', 4 => '#dbbc7f', 5 => '#83c092', 6 => '#a7c080', ), ), 'base16-evergarden.css' => array ( 'label' => ' Evergarden ', 'colors' => array ( 0 => '#272E32', 1 => '#D3C6AA', 2 => '#D3C6AA', 3 => '#A2C8C3', 4 => '#DBBC7F', 5 => '#88C096', 6 => '#B2C98F', ), ), 'base16-fairyfloss.css' => array ( 'label' => ' Fairyfloss ', 'colors' => array ( 0 => '#5a5475', 1 => '#f8f8f0', 2 => '#ae81ff', 3 => '#c2ffdf', 4 => '#ffea00', 5 => '#ffb8d1', 6 => '#fff352', ), ), 'base16-flat.css' => array ( 'label' => ' Flat ', 'colors' => array ( 0 => '#2C3E50', 1 => '#e0e0e0', 2 => '#f5f5f5', 3 => '#E74C3C', 4 => '#F1C40F', 5 => '#2ECC71', 6 => '#3498DB', ), ), 'base16-flowershop.css' => array ( 'label' => ' Flowershop ', 'colors' => array ( 0 => '#514036', 1 => '#dbc1a2', 2 => '#efcca0', 3 => '#e5b58b', 4 => '#92b792', 5 => '#c6986f', 6 => '#c4a683', ), ), 'base16-framer.css' => array ( 'label' => ' Framer ', 'colors' => array ( 0 => '#181818', 1 => '#D0D0D0', 2 => '#E8E8E8', 3 => '#FD886B', 4 => '#FECB6E', 5 => '#32CCDC', 6 => '#20BCFC', ), ), 'base16-fruit-soda.css' => array ( 'label' => ' Fruit Soda ', 'colors' => array ( 0 => '#f1ecf1', 1 => '#515151', 2 => '#474545', 3 => '#fe3e31', 4 => '#f7e203', 5 => '#47f74c', 6 => '#2931df', ), ), 'base16-gigavolt.css' => array ( 'label' => ' Gigavolt ', 'colors' => array ( 0 => '#202126', 1 => '#e9e7e1', 2 => '#eff0f9', 3 => '#ff661a', 4 => '#ffdc2d', 5 => '#f2e6a9', 6 => '#40bfff', ), ), 'base16-github-dark.css' => array ( 'label' => ' Github Dark ', 'colors' => array ( 0 => '#24292e', 1 => '#fafbfc', 2 => '#ffffff', 3 => '#f16636', 4 => '#ffffc5', 5 => '#59b36f', 6 => '#4dacfd', ), ), 'base16-github-light.css' => array ( 'label' => ' Github Light ', 'colors' => array ( 0 => '#fafbfc', 1 => '#24292e', 2 => '#41484f', 3 => '#b31d28', 4 => '#595322', 5 => '#22863a', 6 => '#005cc5', ), ), 'base16-google-dark.css' => array ( 'label' => ' Google Dark ', 'colors' => array ( 0 => '#1d1f21', 1 => '#c5c8c6', 2 => '#e0e0e0', 3 => '#CC342B', 4 => '#FBA922', 5 => '#198844', 6 => '#3971ED', ), ), 'base16-google-light.css' => array ( 'label' => ' Google Light ', 'colors' => array ( 0 => '#ffffff', 1 => '#373b41', 2 => '#282a2e', 3 => '#CC342B', 4 => '#FBA922', 5 => '#198844', 6 => '#3971ED', ), ), 'base16-gotham.css' => array ( 'label' => ' Gotham ', 'colors' => array ( 0 => '#0c1014', 1 => '#599cab', 2 => '#99d1ce', 3 => '#c23127', 4 => '#edb443', 5 => '#33859E', 6 => '#195466', ), ), 'base16-grayscale-dark.css' => array ( 'label' => ' Grayscale Dark ', 'colors' => array ( 0 => '#101010', 1 => '#b9b9b9', 2 => '#e3e3e3', 3 => '#7c7c7c', 4 => '#a0a0a0', 5 => '#8e8e8e', 6 => '#686868', ), ), 'base16-grayscale-light.css' => array ( 'label' => ' Grayscale Light ', 'colors' => array ( 0 => '#f7f7f7', 1 => '#464646', 2 => '#252525', 3 => '#7c7c7c', 4 => '#a0a0a0', 5 => '#8e8e8e', 6 => '#686868', ), ), 'base16-green-screen.css' => array ( 'label' => ' Green Screen ', 'colors' => array ( 0 => '#001100', 1 => '#00bb00', 2 => '#00dd00', 3 => '#007700', 4 => '#007700', 5 => '#00bb00', 6 => '#009900', ), ), 'base16-gruber.css' => array ( 'label' => ' Gruber ', 'colors' => array ( 0 => '#181818', 1 => '#f4f4ff', 2 => '#f5f5f5', 3 => '#f43841', 4 => '#ffdd33', 5 => '#73c936', 6 => '#96a6c8', ), ), 'base16-gruvbox-dark-hard.css' => array ( 'label' => ' Gruvbox Dark Hard ', 'colors' => array ( 0 => '#1d2021', 1 => '#d5c4a1', 2 => '#ebdbb2', 3 => '#fb4934', 4 => '#fabd2f', 5 => '#b8bb26', 6 => '#83a598', ), ), 'base16-gruvbox-dark-medium.css' => array ( 'label' => ' Gruvbox Dark Medium ', 'colors' => array ( 0 => '#282828', 1 => '#d5c4a1', 2 => '#ebdbb2', 3 => '#fb4934', 4 => '#fabd2f', 5 => '#b8bb26', 6 => '#83a598', ), ), 'base16-gruvbox-dark-pale.css' => array ( 'label' => ' Gruvbox Dark Pale ', 'colors' => array ( 0 => '#262626', 1 => '#dab997', 2 => '#d5c4a1', 3 => '#d75f5f', 4 => '#ffaf00', 5 => '#afaf00', 6 => '#83adad', ), ), 'base16-gruvbox-dark-soft.css' => array ( 'label' => ' Gruvbox Dark Soft ', 'colors' => array ( 0 => '#32302f', 1 => '#d5c4a1', 2 => '#ebdbb2', 3 => '#fb4934', 4 => '#fabd2f', 5 => '#b8bb26', 6 => '#83a598', ), ), 'base16-gruvbox-light-hard.css' => array ( 'label' => ' Gruvbox Light Hard ', 'colors' => array ( 0 => '#f9f5d7', 1 => '#504945', 2 => '#3c3836', 3 => '#9d0006', 4 => '#b57614', 5 => '#79740e', 6 => '#076678', ), ), 'base16-gruvbox-light-medium.css' => array ( 'label' => ' Gruvbox Light Medium ', 'colors' => array ( 0 => '#fbf1c7', 1 => '#504945', 2 => '#3c3836', 3 => '#9d0006', 4 => '#b57614', 5 => '#79740e', 6 => '#076678', ), ), 'base16-gruvbox-light-soft.css' => array ( 'label' => ' Gruvbox Light Soft ', 'colors' => array ( 0 => '#f2e5bc', 1 => '#504945', 2 => '#3c3836', 3 => '#9d0006', 4 => '#b57614', 5 => '#79740e', 6 => '#076678', ), ), 'base16-gruvbox-material-dark-hard.css' => array ( 'label' => ' Gruvbox Material Dark Hard ', 'colors' => array ( 0 => '#202020', 1 => '#ddc7a1', 2 => '#ebdbb2', 3 => '#ea6962', 4 => '#d8a657', 5 => '#a9b665', 6 => '#7daea3', ), ), 'base16-gruvbox-material-dark-medium.css' => array ( 'label' => ' Gruvbox Material Dark Medium ', 'colors' => array ( 0 => '#292828', 1 => '#ddc7a1', 2 => '#ebdbb2', 3 => '#ea6962', 4 => '#d8a657', 5 => '#a9b665', 6 => '#7daea3', ), ), 'base16-gruvbox-material-dark-soft.css' => array ( 'label' => ' Gruvbox Material Dark Soft ', 'colors' => array ( 0 => '#32302f', 1 => '#ddc7a1', 2 => '#ebdbb2', 3 => '#ea6962', 4 => '#d8a657', 5 => '#a9b665', 6 => '#7daea3', ), ), 'base16-gruvbox-material-light-hard.css' => array ( 'label' => ' Gruvbox Material Light Hard ', 'colors' => array ( 0 => '#f9f5d7', 1 => '#654735', 2 => '#3c3836', 3 => '#c14a4a', 4 => '#b47109', 5 => '#6c782e', 6 => '#45707a', ), ), 'base16-gruvbox-material-light-medium.css' => array ( 'label' => ' Gruvbox Material Light Medium ', 'colors' => array ( 0 => '#fbf1c7', 1 => '#654735', 2 => '#3c3836', 3 => '#c14a4a', 4 => '#b47109', 5 => '#6c782e', 6 => '#45707a', ), ), 'base16-gruvbox-material-light-soft.css' => array ( 'label' => ' Gruvbox Material Light Soft ', 'colors' => array ( 0 => '#f2e5bc', 1 => '#654735', 2 => '#3c3836', 3 => '#c14a4a', 4 => '#b47109', 5 => '#6c782e', 6 => '#45707a', ), ), 'base16-hackerman.css' => array ( 'label' => ' Hackerman ', 'colors' => array ( 0 => '#080808', 1 => '#00d7ff', 2 => '#FFFFFF', 3 => '#800000', 4 => '#ffff00', 5 => '#00d700', 6 => '#d700af', ), ), 'base16-hardcore.css' => array ( 'label' => ' Hardcore ', 'colors' => array ( 0 => '#212121', 1 => '#cdcdcd', 2 => '#e5e5e5', 3 => '#f92672', 4 => '#e6db74', 5 => '#a6e22e', 6 => '#66d9ef', ), ), 'base16-hardhacker.css' => array ( 'label' => ' Hardhacker ', 'colors' => array ( 0 => '#282433', 1 => '#eee9fc', 2 => '#eee9fc', 3 => '#e192ef', 4 => '#b3f4f3', 5 => '#b1f2a7', 6 => '#b1baf4', ), ), 'base16-harmonic16-dark.css' => array ( 'label' => ' Harmonic16 Dark ', 'colors' => array ( 0 => '#0b1c2c', 1 => '#cbd6e2', 2 => '#e5ebf1', 3 => '#bf8b56', 4 => '#8bbf56', 5 => '#56bf8b', 6 => '#8b56bf', ), ), 'base16-harmonic16-light.css' => array ( 'label' => ' Harmonic16 Light ', 'colors' => array ( 0 => '#f7f9fb', 1 => '#405c79', 2 => '#223b54', 3 => '#bf8b56', 4 => '#8bbf56', 5 => '#56bf8b', 6 => '#8b56bf', ), ), 'base16-heetch-light.css' => array ( 'label' => ' Heetch Light ', 'colors' => array ( 0 => '#feffff', 1 => '#5a496e', 2 => '#470546', 3 => '#27d9d5', 4 => '#5ba2b6', 5 => '#f80059', 6 => '#47f9f5', ), ), 'base16-heetch.css' => array ( 'label' => ' Heetch ', 'colors' => array ( 0 => '#190134', 1 => '#BDB6C5', 2 => '#DEDAE2', 3 => '#27D9D5', 4 => '#8F6C97', 5 => '#C33678', 6 => '#BD0152', ), ), 'base16-helios.css' => array ( 'label' => ' Helios ', 'colors' => array ( 0 => '#1d2021', 1 => '#d5d5d5', 2 => '#dddddd', 3 => '#d72638', 4 => '#f19d1a', 5 => '#88b92d', 6 => '#1e8bac', ), ), 'base16-hopscotch.css' => array ( 'label' => ' Hopscotch ', 'colors' => array ( 0 => '#322931', 1 => '#b9b5b8', 2 => '#d5d3d5', 3 => '#dd464c', 4 => '#fdcc59', 5 => '#8fc13e', 6 => '#1290bf', ), ), 'base16-horizon-dark.css' => array ( 'label' => ' Horizon Dark ', 'colors' => array ( 0 => '#1C1E26', 1 => '#CBCED0', 2 => '#DCDFE4', 3 => '#E93C58', 4 => '#EFB993', 5 => '#EFAF8E', 6 => '#DF5273', ), ), 'base16-horizon-light.css' => array ( 'label' => ' Horizon Light ', 'colors' => array ( 0 => '#FDF0ED', 1 => '#403C3D', 2 => '#302C2D', 3 => '#F7939B', 4 => '#FBE0D9', 5 => '#94E1B0', 6 => '#DA103F', ), ), 'base16-horizon-terminal-dark.css' => array ( 'label' => ' Horizon Terminal Dark ', 'colors' => array ( 0 => '#1C1E26', 1 => '#CBCED0', 2 => '#DCDFE4', 3 => '#E95678', 4 => '#FAC29A', 5 => '#29D398', 6 => '#26BBD9', ), ), 'base16-horizon-terminal-light.css' => array ( 'label' => ' Horizon Terminal Light ', 'colors' => array ( 0 => '#FDF0ED', 1 => '#403C3D', 2 => '#302C2D', 3 => '#E95678', 4 => '#FADAD1', 5 => '#29D398', 6 => '#26BBD9', ), ), 'base16-humanoid-dark.css' => array ( 'label' => ' Humanoid Dark ', 'colors' => array ( 0 => '#232629', 1 => '#f8f8f2', 2 => '#fcfcf6', 3 => '#f11235', 4 => '#ffb627', 5 => '#02d849', 6 => '#00a6fb', ), ), 'base16-humanoid-light.css' => array ( 'label' => ' Humanoid Light ', 'colors' => array ( 0 => '#f8f8f2', 1 => '#232629', 2 => '#2f3337', 3 => '#b0151a', 4 => '#ffb627', 5 => '#388e3c', 6 => '#0082c9', ), ), 'base16-hund.css' => array ( 'label' => ' Hund ', 'colors' => array ( 0 => '#161616', 1 => '#ffffff', 2 => '#dddddd', 3 => '#e84f4f', 4 => '#ffe863', 5 => '#b7ce42', 6 => '#66aabb', ), ), 'base16-hybrid.css' => array ( 'label' => ' Hybrid ', 'colors' => array ( 0 => '#1d1f21', 1 => '#c5c8c6', 2 => '#d8dad8', 3 => '#cc6666', 4 => '#f0c674', 5 => '#b5bd68', 6 => '#81a2be', ), ), 'base16-ia-dark.css' => array ( 'label' => ' Ia Dark ', 'colors' => array ( 0 => '#1a1a1a', 1 => '#cccccc', 2 => '#e8e8e8', 3 => '#d88568', 4 => '#b99353', 5 => '#83a471', 6 => '#8eccdd', ), ), 'base16-ia-light.css' => array ( 'label' => ' Ia Light ', 'colors' => array ( 0 => '#f6f6f6', 1 => '#181818', 2 => '#e8e8e8', 3 => '#9c5a02', 4 => '#c48218', 5 => '#38781c', 6 => '#48bac2', ), ), 'base16-icy.css' => array ( 'label' => ' Icy ', 'colors' => array ( 0 => '#021012', 1 => '#095b67', 2 => '#0c7c8c', 3 => '#16c1d9', 4 => '#80deea', 5 => '#4dd0e1', 6 => '#00bcd4', ), ), 'base16-ir-black.css' => array ( 'label' => ' Ir Black ', 'colors' => array ( 0 => '#000000', 1 => '#b5b3aa', 2 => '#d9d7cc', 3 => '#ff6c60', 4 => '#ffffb6', 5 => '#a8ff60', 6 => '#96cbfe', ), ), 'base16-isotope.css' => array ( 'label' => ' Isotope ', 'colors' => array ( 0 => '#000000', 1 => '#d0d0d0', 2 => '#e0e0e0', 3 => '#ff0000', 4 => '#ff0099', 5 => '#33ff00', 6 => '#0066ff', ), ), 'base16-kanagawa.css' => array ( 'label' => ' Kanagawa ', 'colors' => array ( 0 => '#1F1F28', 1 => '#DCD7BA', 2 => '#C8C093', 3 => '#C34043', 4 => '#C0A36E', 5 => '#76946A', 6 => '#7E9CD8', ), ), 'base16-katy.css' => array ( 'label' => ' Katy ', 'colors' => array ( 0 => '#292d3e', 1 => '#959dcb', 2 => '#959dcb', 3 => '#6e98e1', 4 => '#e0a557', 5 => '#78c06e', 6 => '#82aaff', ), ), 'base16-kimber.css' => array ( 'label' => ' Kimber ', 'colors' => array ( 0 => '#222222', 1 => '#DEDEE7', 2 => '#C3C3B4', 3 => '#C88C8C', 4 => '#D8B56D', 5 => '#99C899', 6 => '#537C9C', ), ), 'base16-lime.css' => array ( 'label' => ' Lime ', 'colors' => array ( 0 => '#1a1a2f', 1 => '#818175', 2 => '#fff2d1', 3 => '#ff662a', 4 => '#ffd15e', 5 => '#8cd97c', 6 => '#2b926f', ), ), 'base16-london-tube.css' => array ( 'label' => ' London Tube ', 'colors' => array ( 0 => '#231f20', 1 => '#d9d8d8', 2 => '#e7e7e8', 3 => '#ee2e24', 4 => '#ffd204', 5 => '#00853e', 6 => '#009ddc', ), ), 'base16-macintosh.css' => array ( 'label' => ' Macintosh ', 'colors' => array ( 0 => '#000000', 1 => '#c0c0c0', 2 => '#c0c0c0', 3 => '#dd0907', 4 => '#fbf305', 5 => '#1fb714', 6 => '#0000d3', ), ), 'base16-magical-girl.css' => array ( 'label' => ' Magical Girl ', 'colors' => array ( 0 => '#fbfbfb', 1 => '#6b6b6b', 2 => '#692fd5', 3 => '#ff2f6f', 4 => '#01c8ba', 5 => '#736ee9', 6 => '#2199ff', ), ), 'base16-marrakesh.css' => array ( 'label' => ' Marrakesh ', 'colors' => array ( 0 => '#201602', 1 => '#948e48', 2 => '#ccc37a', 3 => '#c35359', 4 => '#a88339', 5 => '#18974e', 6 => '#477ca1', ), ), 'base16-materia.css' => array ( 'label' => ' Materia ', 'colors' => array ( 0 => '#263238', 1 => '#CDD3DE', 2 => '#D5DBE5', 3 => '#EC5F67', 4 => '#FFCC00', 5 => '#8BD649', 6 => '#89DDFF', ), ), 'base16-material-darker.css' => array ( 'label' => ' Material Darker ', 'colors' => array ( 0 => '#212121', 1 => '#EEFFFF', 2 => '#EEFFFF', 3 => '#F07178', 4 => '#FFCB6B', 5 => '#C3E88D', 6 => '#82AAFF', ), ), 'base16-material-lighter.css' => array ( 'label' => ' Material Lighter ', 'colors' => array ( 0 => '#FAFAFA', 1 => '#80CBC4', 2 => '#80CBC4', 3 => '#FF5370', 4 => '#FFB62C', 5 => '#91B859', 6 => '#6182B8', ), ), 'base16-material-palenight.css' => array ( 'label' => ' Material Palenight ', 'colors' => array ( 0 => '#292D3E', 1 => '#959DCB', 2 => '#959DCB', 3 => '#F07178', 4 => '#FFCB6B', 5 => '#C3E88D', 6 => '#82AAFF', ), ), 'base16-material-v2.css' => array ( 'label' => ' Material V2 ', 'colors' => array ( 0 => '#263238', 1 => '#eceff1', 2 => '#eceff1', 3 => '#ff9800', 4 => '#ffc107', 5 => '#8bc34a', 6 => '#03a9f4', ), ), 'base16-material-vivid.css' => array ( 'label' => ' Material Vivid ', 'colors' => array ( 0 => '#202124', 1 => '#80868b', 2 => '#9e9e9e', 3 => '#f44336', 4 => '#ffeb3b', 5 => '#00e676', 6 => '#2196f3', ), ), 'base16-material.css' => array ( 'label' => ' Material ', 'colors' => array ( 0 => '#263238', 1 => '#EEFFFF', 2 => '#EEFFFF', 3 => '#F07178', 4 => '#FFCB6B', 5 => '#C3E88D', 6 => '#82AAFF', ), ), 'base16-mellow-purple.css' => array ( 'label' => ' Mellow Purple ', 'colors' => array ( 0 => '#1e0528', 1 => '#ffeeff', 2 => '#ffeeff', 3 => '#00d9e9', 4 => '#955ae7', 5 => '#05cb0d', 6 => '#550068', ), ), 'base16-mexico-light.css' => array ( 'label' => ' Mexico Light ', 'colors' => array ( 0 => '#f8f8f8', 1 => '#383838', 2 => '#282828', 3 => '#ab4642', 4 => '#f79a0e', 5 => '#538947', 6 => '#7cafc2', ), ), 'base16-mikuconsole-dark.css' => array ( 'label' => ' Mikuconsole Dark ', 'colors' => array ( 0 => '#1b2221', 1 => '#c2cccc', 2 => '#dbe1e1', 3 => '#f3670a', 4 => '#f3d807', 5 => '#01cbc5', 6 => '#3c8add', ), ), 'base16-mikuconsole-light.css' => array ( 'label' => ' Mikuconsole Light ', 'colors' => array ( 0 => '#ffffff', 1 => '#818181', 2 => '#364241', 3 => '#f3670a', 4 => '#d9a01b', 5 => '#0bc1c1', 6 => '#208fcf', ), ), 'base16-minty-melon.css' => array ( 'label' => ' Minty Melon ', 'colors' => array ( 0 => '#151515', 1 => '#B1B1B1', 2 => '#B1B1B1', 3 => '#CF5C5C', 4 => '#C6804E', 5 => '#267055', 6 => '#637EAA', ), ), 'base16-mocha.css' => array ( 'label' => ' Mocha ', 'colors' => array ( 0 => '#3B3228', 1 => '#d0c8c6', 2 => '#e9e1dd', 3 => '#cb6077', 4 => '#f4bc87', 5 => '#beb55b', 6 => '#8ab3b5', ), ), 'base16-molokai-terminal.css' => array ( 'label' => ' Molokai Terminal ', 'colors' => array ( 0 => '#272822', 1 => '#F8F8F2', 2 => '#f5f4f1', 3 => '#F92672', 4 => '#E6DB74', 5 => '#A6E22E', 6 => '#7070F0', ), ), 'base16-molokai.css' => array ( 'label' => ' Molokai ', 'colors' => array ( 0 => '#272822', 1 => '#F8F8F2', 2 => '#f5f4f1', 3 => '#FD971F', 4 => '#66D9EF', 5 => '#E6DB74', 6 => '#A6E22E', ), ), 'base16-monokai.css' => array ( 'label' => ' Monokai ', 'colors' => array ( 0 => '#272822', 1 => '#f8f8f2', 2 => '#f5f4f1', 3 => '#f92672', 4 => '#f4bf75', 5 => '#a6e22e', 6 => '#66d9ef', ), ), 'base16-mountain.css' => array ( 'label' => ' Mountain ', 'colors' => array ( 0 => '#0f0f0f', 1 => '#cacaca', 2 => '#e7e7e7', 3 => '#ac8a8c', 4 => '#aca98a', 5 => '#8aac8b', 6 => '#8f8aac', ), ), 'base16-nature-suede.css' => array ( 'label' => ' Nature Suede ', 'colors' => array ( 0 => '#170f0d', 1 => '#746c48', 2 => '#c3c13d', 3 => '#af652f', 4 => '#c3c13d', 5 => '#778725', 6 => '#908f32', ), ), 'base16-nebula.css' => array ( 'label' => ' Nebula ', 'colors' => array ( 0 => '#22273b', 1 => '#a4a6a9', 2 => '#c7c9cd', 3 => '#777abc', 4 => '#4f9062', 5 => '#6562a8', 6 => '#4d6bb6', ), ), 'base16-nord.css' => array ( 'label' => ' Nord ', 'colors' => array ( 0 => '#2E3440', 1 => '#E5E9F0', 2 => '#ECEFF4', 3 => '#88C0D0', 4 => '#5E81AC', 5 => '#BF616A', 6 => '#EBCB8B', ), ), 'base16-nova.css' => array ( 'label' => ' Nova ', 'colors' => array ( 0 => '#3C4C55', 1 => '#C5D4DD', 2 => '#899BA6', 3 => '#83AFE5', 4 => '#A8CE93', 5 => '#7FC1CA', 6 => '#83AFE5', ), ), 'base16-ocean.css' => array ( 'label' => ' Ocean ', 'colors' => array ( 0 => '#2b303b', 1 => '#c0c5ce', 2 => '#dfe1e8', 3 => '#bf616a', 4 => '#ebcb8b', 5 => '#a3be8c', 6 => '#8fa1b3', ), ), 'base16-oceanicnext.css' => array ( 'label' => ' Oceanicnext ', 'colors' => array ( 0 => '#1B2B34', 1 => '#C0C5CE', 2 => '#CDD3DE', 3 => '#EC5f67', 4 => '#FAC863', 5 => '#99C794', 6 => '#6699CC', ), ), 'base16-one-dark.css' => array ( 'label' => ' One Dark ', 'colors' => array ( 0 => '#282c34', 1 => '#abb2bf', 2 => '#b6bdca', 3 => '#e06c75', 4 => '#e5c07b', 5 => '#98c379', 6 => '#61afef', ), ), 'base16-one-light.css' => array ( 'label' => ' One Light ', 'colors' => array ( 0 => '#fafafa', 1 => '#383a42', 2 => '#202227', 3 => '#ca1243', 4 => '#c18401', 5 => '#50a14f', 6 => '#4078f2', ), ), 'base16-outrun-dark.css' => array ( 'label' => ' Outrun Dark ', 'colors' => array ( 0 => '#00002A', 1 => '#D0D0FA', 2 => '#E0E0FF', 3 => '#FF4242', 4 => '#F3E877', 5 => '#59F176', 6 => '#66B0FF', ), ), 'base16-pandora.css' => array ( 'label' => ' Pandora ', 'colors' => array ( 0 => '#131213', 1 => '#f15c99', 2 => '#81506a', 3 => '#b00b69', 4 => '#ffcc00', 5 => '#9ddf69', 6 => '#008080', ), ), 'base16-panels.css' => array ( 'label' => ' Panels ', 'colors' => array ( 0 => '#191927', 1 => '#d3d3d3', 2 => '#eaaf25', 3 => '#94431c', 4 => '#e1750f', 5 => '#eaaf25', 6 => '#9f582a', ), ), 'base16-paraiso.css' => array ( 'label' => ' Paraiso ', 'colors' => array ( 0 => '#2f1e2e', 1 => '#a39e9b', 2 => '#b9b6b0', 3 => '#ef6155', 4 => '#fec418', 5 => '#48b685', 6 => '#06b6ef', ), ), 'base16-pasque.css' => array ( 'label' => ' Pasque ', 'colors' => array ( 0 => '#271C3A', 1 => '#DEDCDF', 2 => '#EDEAEF', 3 => '#A92258', 4 => '#804ead', 5 => '#C6914B', 6 => '#8E7DC6', ), ), 'base16-phd.css' => array ( 'label' => ' Phd ', 'colors' => array ( 0 => '#061229', 1 => '#b8bbc2', 2 => '#dbdde0', 3 => '#d07346', 4 => '#fbd461', 5 => '#99bf52', 6 => '#5299bf', ), ), 'base16-pico.css' => array ( 'label' => ' Pico ', 'colors' => array ( 0 => '#000000', 1 => '#5f574f', 2 => '#c2c3c7', 3 => '#ff004d', 4 => '#fff024', 5 => '#00e756', 6 => '#83769c', ), ), 'base16-pinky.css' => array ( 'label' => ' Pinky ', 'colors' => array ( 0 => '#171517', 1 => '#f5f5f5', 2 => '#ffffff', 3 => '#ffa600', 4 => '#20df6c', 5 => '#ff0066', 6 => '#00ffff', ), ), 'base16-pop.css' => array ( 'label' => ' Pop ', 'colors' => array ( 0 => '#000000', 1 => '#d0d0d0', 2 => '#e0e0e0', 3 => '#eb008a', 4 => '#f8ca12', 5 => '#37b349', 6 => '#0e5a94', ), ), 'base16-porple.css' => array ( 'label' => ' Porple ', 'colors' => array ( 0 => '#292c36', 1 => '#d8d8d8', 2 => '#e8e8e8', 3 => '#f84547', 4 => '#efa16b', 5 => '#95c76f', 6 => '#8485ce', ), ), 'base16-primer-dark-dimmed.css' => array ( 'label' => ' Primer Dark Dimmed ', 'colors' => array ( 0 => '#1c2128', 1 => '#909dab', 2 => '#adbac7', 3 => '#f47067', 4 => '#c69026', 5 => '#57ab5a', 6 => '#539bf5', ), ), 'base16-primer-dark.css' => array ( 'label' => ' Primer Dark ', 'colors' => array ( 0 => '#010409', 1 => '#b1bac4', 2 => '#c9d1d9', 3 => '#ff7b72', 4 => '#d29922', 5 => '#3fb950', 6 => '#58a6ff', ), ), 'base16-primer-light.css' => array ( 'label' => ' Primer Light ', 'colors' => array ( 0 => '#fafbfc', 1 => '#2f363d', 2 => '#24292e', 3 => '#d73a49', 4 => '#ffd33d', 5 => '#28a745', 6 => '#0366d6', ), ), 'base16-purpledream.css' => array ( 'label' => ' Purpledream ', 'colors' => array ( 0 => '#100510', 1 => '#ddd0dd', 2 => '#eee0ee', 3 => '#FF1D0D', 4 => '#F000A0', 5 => '#14CC64', 6 => '#00A0F0', ), ), 'base16-qualia.css' => array ( 'label' => ' Qualia ', 'colors' => array ( 0 => '#101010', 1 => '#C0C0C0', 2 => '#C0C0C0', 3 => '#EFA6A2', 4 => '#E6A3DC', 5 => '#80C990', 6 => '#50CACD', ), ), 'base16-railscasts.css' => array ( 'label' => ' Railscasts ', 'colors' => array ( 0 => '#2b2b2b', 1 => '#e6e1dc', 2 => '#f4f1ed', 3 => '#da4939', 4 => '#ffc66d', 5 => '#a5c261', 6 => '#6d9cbe', ), ), 'base16-rebecca.css' => array ( 'label' => ' Rebecca ', 'colors' => array ( 0 => '#292a44', 1 => '#f1eff8', 2 => '#ccccff', 3 => '#a0a0c5', 4 => '#ae81ff', 5 => '#6dfedf', 6 => '#2de0a7', ), ), 'base16-red-phoenix.css' => array ( 'label' => ' Red Phoenix ', 'colors' => array ( 0 => '#111111', 1 => '#b1b1b1', 2 => '#d1d1d1', 3 => '#aaa998', 4 => '#df9767', 5 => '#d2c3ad', 6 => '#f2361e', ), ), 'base16-rose-pine-dawn.css' => array ( 'label' => ' Rose Pine Dawn ', 'colors' => array ( 0 => '#faf4ed', 1 => '#575279', 2 => '#555169', 3 => '#1f1d2e', 4 => '#ea9d34', 5 => '#d7827e', 6 => '#56949f', ), ), 'base16-rose-pine-moon.css' => array ( 'label' => ' Rose Pine Moon ', 'colors' => array ( 0 => '#232136', 1 => '#e0def4', 2 => '#f5f5f7', 3 => '#ecebf0', 4 => '#f6c177', 5 => '#ea9a97', 6 => '#9ccfd8', ), ), 'base16-rose-pine.css' => array ( 'label' => ' Rose Pine ', 'colors' => array ( 0 => '#191724', 1 => '#e0def4', 2 => '#f0f0f3', 3 => '#e2e1e7', 4 => '#f6c177', 5 => '#ebbcba', 6 => '#9ccfd8', ), ), 'base16-sacred-forest-terminal.css' => array ( 'label' => ' Sacred Forest Terminal ', 'colors' => array ( 0 => '#3c4c55', 1 => '#e0d7c3', 2 => '#c5d4dd', 3 => '#db6c6c', 4 => '#ddd668', 5 => '#94b380', 6 => '#3ba2cc', ), ), 'base16-sacred-forest.css' => array ( 'label' => ' Sacred Forest ', 'colors' => array ( 0 => '#3c4c55', 1 => '#e0d7c3', 2 => '#c5d4dd', 3 => '#db6c6c', 4 => '#3ba2cc', 5 => '#94b380', 6 => '#7fc1ca', ), ), 'base16-sagelight.css' => array ( 'label' => ' Sagelight ', 'colors' => array ( 0 => '#f8f8f8', 1 => '#383838', 2 => '#282828', 3 => '#fa8480', 4 => '#ffdc61', 5 => '#a0d2c8', 6 => '#a0a7d2', ), ), 'base16-sakura.css' => array ( 'label' => ' Sakura ', 'colors' => array ( 0 => '#feedf3', 1 => '#564448', 2 => '#42383a', 3 => '#df2d52', 4 => '#c29461', 5 => '#2e916d', 6 => '#006e93', ), ), 'base16-sandcastle.css' => array ( 'label' => ' Sandcastle ', 'colors' => array ( 0 => '#282c34', 1 => '#a89984', 2 => '#d5c4a1', 3 => '#83a598', 4 => '#a07e3b', 5 => '#528b8b', 6 => '#83a598', ), ), 'base16-seti-ui.css' => array ( 'label' => ' Seti Ui ', 'colors' => array ( 0 => '#151718', 1 => '#d6d6d6', 2 => '#eeeeee', 3 => '#Cd3f45', 4 => '#e6cd69', 5 => '#9fca56', 6 => '#55b5db', ), ), 'base16-seti.css' => array ( 'label' => ' Seti ', 'colors' => array ( 0 => '#151718', 1 => '#d6d6d6', 2 => '#eeeeee', 3 => '#Cd3f45', 4 => '#e6cd69', 5 => '#9fca56', 6 => '#55b5db', ), ), 'base16-shades-of-purple.css' => array ( 'label' => ' Shades Of Purple ', 'colors' => array ( 0 => '#1e1e3f', 1 => '#c7c7c7', 2 => '#ff77ff', 3 => '#d90429', 4 => '#ffe700', 5 => '#3ad900', 6 => '#6943ff', ), ), 'base16-shadesmear-dark.css' => array ( 'label' => ' Shadesmear Dark ', 'colors' => array ( 0 => '#232323', 1 => '#DBDBDB', 2 => '#E4E4E4', 3 => '#CC5450', 4 => '#307878', 5 => '#71983B', 6 => '#376388', ), ), 'base16-shadesmear-light.css' => array ( 'label' => ' Shadesmear Light ', 'colors' => array ( 0 => '#DBDBDB', 1 => '#232323', 2 => '#1C1C1C', 3 => '#CC5450', 4 => '#307878', 5 => '#71983B', 6 => '#376388', ), ), 'base16-shapeshifter.css' => array ( 'label' => ' Shapeshifter ', 'colors' => array ( 0 => '#f9f9f9', 1 => '#102015', 2 => '#040404', 3 => '#e92f2f', 4 => '#dddd13', 5 => '#0ed839', 6 => '#3b48e3', ), ), 'base16-silk-dark.css' => array ( 'label' => ' Silk Dark ', 'colors' => array ( 0 => '#0e3c46', 1 => '#C7DBDD', 2 => '#CBF2F7', 3 => '#fb6953', 4 => '#fce380', 5 => '#73d8ad', 6 => '#46bddd', ), ), 'base16-silk-light.css' => array ( 'label' => ' Silk Light ', 'colors' => array ( 0 => '#E9F1EF', 1 => '#385156', 2 => '#0e3c46', 3 => '#CF432E', 4 => '#CFAD25', 5 => '#6CA38C', 6 => '#39AAC9', ), ), 'base16-skull.css' => array ( 'label' => ' Skull ', 'colors' => array ( 0 => '#222222', 1 => '#A0A0A0', 2 => '#d3d3d3', 3 => '#A0A0A0', 4 => '#d3d3d3', 5 => '#d3d3d3', 6 => '#7eae81', ), ), 'base16-snazzy.css' => array ( 'label' => ' Snazzy ', 'colors' => array ( 0 => '#282a36', 1 => '#e2e4e5', 2 => '#eff0eb', 3 => '#ff5c57', 4 => '#f3f99d', 5 => '#5af78e', 6 => '#57c7ff', ), ), 'base16-snowtrek-terminal.css' => array ( 'label' => ' Snowtrek Terminal ', 'colors' => array ( 0 => '#fbfbfc', 1 => '#0c0c0c', 2 => '#505050', 3 => '#c00000', 4 => '#c29a16', 5 => '#00802d', 6 => '#2053b4', ), ), 'base16-snowtrek.css' => array ( 'label' => ' Snowtrek ', 'colors' => array ( 0 => '#fbfbfc', 1 => '#3b3341', 2 => '#3b3341', 3 => '#89ac08', 4 => '#2053b4', 5 => '#879da9', 6 => '#008700', ), ), 'base16-solar-flare.css' => array ( 'label' => ' Solar Flare ', 'colors' => array ( 0 => '#18262F', 1 => '#A6AFB8', 2 => '#E8E9ED', 3 => '#EF5253', 4 => '#E4B51C', 5 => '#7CC844', 6 => '#33B5E1', ), ), 'base16-solarflare-light.css' => array ( 'label' => ' Solarflare Light ', 'colors' => array ( 0 => '#F5F7FA', 1 => '#586875', 2 => '#222E38', 3 => '#EF5253', 4 => '#E4B51C', 5 => '#7CC844', 6 => '#33B5E1', ), ), 'base16-solarized-dark.css' => array ( 'label' => ' Solarized Dark ', 'colors' => array ( 0 => '#002b36', 1 => '#93a1a1', 2 => '#eee8d5', 3 => '#dc322f', 4 => '#b58900', 5 => '#859900', 6 => '#268bd2', ), ), 'base16-solarized-light.css' => array ( 'label' => ' Solarized Light ', 'colors' => array ( 0 => '#fdf6e3', 1 => '#586e75', 2 => '#073642', 3 => '#dc322f', 4 => '#b58900', 5 => '#859900', 6 => '#268bd2', ), ), 'base16-sonokai-andromeda.css' => array ( 'label' => ' Sonokai Andromeda ', 'colors' => array ( 0 => '#2b2d3a', 1 => '#e1e3e4', 2 => '#e1e3e4', 3 => '#fb617e', 4 => '#edc763', 5 => '#9ed06c', 6 => '#6dcae8', ), ), 'base16-sonokai-atlantis.css' => array ( 'label' => ' Sonokai Atlantis ', 'colors' => array ( 0 => '#2a2f38', 1 => '#e1e3e4', 2 => '#e1e3e4', 3 => '#ff6578', 4 => '#eacb64', 5 => '#9dd274', 6 => '#72cce8', ), ), 'base16-sonokai-espresso.css' => array ( 'label' => ' Sonokai Espresso ', 'colors' => array ( 0 => '#312c2b', 1 => '#e4e3e1', 2 => '#e4e3e1', 3 => '#f86882', 4 => '#f0c66f', 5 => '#a6cd77', 6 => '#81d0c9', ), ), 'base16-sonokai-maia.css' => array ( 'label' => ' Sonokai Maia ', 'colors' => array ( 0 => '#273136', 1 => '#e1e2e3', 2 => '#e1e2e3', 3 => '#f76c7c', 4 => '#e3d367', 5 => '#9cd57b', 6 => '#78cee9', ), ), 'base16-sonokai-shusia.css' => array ( 'label' => ' Sonokai Shusia ', 'colors' => array ( 0 => '#2d2a2e', 1 => '#e3e1e4', 2 => '#e3e1e4', 3 => '#f85e84', 4 => '#e5c463', 5 => '#9ecd6f', 6 => '#7accd7', ), ), 'base16-sonokai.css' => array ( 'label' => ' Sonokai ', 'colors' => array ( 0 => '#2c2e34', 1 => '#e2e2e3', 2 => '#e2e2e3', 3 => '#fc5d7c', 4 => '#e7c664', 5 => '#9ed072', 6 => '#76cce0', ), ), 'base16-spaceduck.css' => array ( 'label' => ' Spaceduck ', 'colors' => array ( 0 => '#16172d', 1 => '#ecf0c1', 2 => '#c1c3cc', 3 => '#e33400', 4 => '#f2ce00', 5 => '#5ccc96', 6 => '#7a5ccc', ), ), 'base16-spacemacs.css' => array ( 'label' => ' Spacemacs ', 'colors' => array ( 0 => '#1f2022', 1 => '#a3a3a3', 2 => '#e8e8e8', 3 => '#f2241f', 4 => '#b1951d', 5 => '#67b11d', 6 => '#4f97d7', ), ), 'base16-standardized-dark.css' => array ( 'label' => ' Standardized Dark ', 'colors' => array ( 0 => '#222222', 1 => '#c0c0c0', 2 => '#e0e0e0', 3 => '#e15d67', 4 => '#e1b31a', 5 => '#5db129', 6 => '#00a3f2', ), ), 'base16-standardized-light.css' => array ( 'label' => ' Standardized Light ', 'colors' => array ( 0 => '#ffffff', 1 => '#444444', 2 => '#333333', 3 => '#d03e3e', 4 => '#ad8200', 5 => '#31861f', 6 => '#3173c5', ), ), 'base16-stella.css' => array ( 'label' => ' Stella ', 'colors' => array ( 0 => '#2B213C', 1 => '#998BAD', 2 => '#B4A5C8', 3 => '#C79987', 4 => '#C7C691', 5 => '#ACC79B', 6 => '#A5AAD4', ), ), 'base16-summercamp.css' => array ( 'label' => ' Summercamp ', 'colors' => array ( 0 => '#1c1810', 1 => '#736e55', 2 => '#bab696', 3 => '#e35142', 4 => '#f2ff27', 5 => '#5ceb5a', 6 => '#489bf0', ), ), 'base16-summerfruit-dark.css' => array ( 'label' => ' Summerfruit Dark ', 'colors' => array ( 0 => '#151515', 1 => '#D0D0D0', 2 => '#E0E0E0', 3 => '#FF0086', 4 => '#ABA800', 5 => '#00C918', 6 => '#3777E6', ), ), 'base16-summerfruit-light.css' => array ( 'label' => ' Summerfruit Light ', 'colors' => array ( 0 => '#FFFFFF', 1 => '#101010', 2 => '#151515', 3 => '#FF0086', 4 => '#ABA800', 5 => '#00C918', 6 => '#3777E6', ), ), 'base16-synth-midnight-dark.css' => array ( 'label' => ' Synth Midnight Dark ', 'colors' => array ( 0 => '#050608', 1 => '#c1c3c4', 2 => '#cfd1d2', 3 => '#b53b50', 4 => '#c9d364', 5 => '#06ea61', 6 => '#03aeff', ), ), 'base16-synth-midnight-light.css' => array ( 'label' => ' Synth Midnight Light ', 'colors' => array ( 0 => '#dddfe0', 1 => '#28292a', 2 => '#1a1b1c', 3 => '#b53b50', 4 => '#c9d364', 5 => '#06ea61', 6 => '#03aeff', ), ), 'base16-synthwave-84.css' => array ( 'label' => ' Synthwave 84 ', 'colors' => array ( 0 => '#262335', 1 => '#ECEBED', 2 => '#ECEBED', 3 => '#E55A5E', 4 => '#D884C7', 5 => '#EA9652', 6 => '#EB8F82', ), ), 'base16-tango.css' => array ( 'label' => ' Tango ', 'colors' => array ( 0 => '#2e3436', 1 => '#d3d7cf', 2 => '#ad7fa8', 3 => '#cc0000', 4 => '#c4a000', 5 => '#4e9a06', 6 => '#3465a4', ), ), 'base16-tender.css' => array ( 'label' => ' Tender ', 'colors' => array ( 0 => '#282828', 1 => '#eeeeee', 2 => '#e8e8e8', 3 => '#f43753', 4 => '#ffc24b', 5 => '#c9d05c', 6 => '#b3deef', ), ), 'base16-term2base-canvased-pastel-p1.css' => array ( 'label' => ' Term2base Canvased Pastel P1 ', 'colors' => array ( 0 => '#170f0d', 1 => '#746c48', 2 => '#d6d3ac', 3 => '#323027', 4 => '#534d35', 5 => '#3d4339', 6 => '#534d35', ), ), 'base16-term2base-colorful-colors-p1.css' => array ( 'label' => ' Term2base Colorful Colors P1 ', 'colors' => array ( 0 => '#000000', 1 => '#ffffff', 2 => '#e2f1f6', 3 => '#ff8eaf', 4 => '#a6e2f0', 5 => '#a6e25f', 6 => '#a6e2f0', ), ), 'base16-term2base-hybrid-p2.css' => array ( 'label' => ' Term2base Hybrid P2 ', 'colors' => array ( 0 => '#1D1F21', 1 => '#C5C8C6', 2 => '#C5C8C6', 3 => '#CC6666', 4 => '#81A2BE', 5 => '#B5BD68', 6 => '#81A2BE', ), ), 'base16-term2base-ivory-light-p2.css' => array ( 'label' => ' Term2base Ivory Light P2 ', 'colors' => array ( 0 => '#fef9ec', 1 => '#6d727e', 2 => '#282c36', 3 => '#b22b31', 4 => '#0065ca', 5 => '#007427', 6 => '#0065ca', ), ), 'base16-term2base-matrix-p1.css' => array ( 'label' => ' Term2base Matrix P1 ', 'colors' => array ( 0 => '#000000', 1 => '#00cc00', 2 => '#00cc00', 3 => '#55ff55', 4 => '#005500', 5 => '#00cc00', 6 => '#005500', ), ), 'base16-term2base-mostly-bright-p2.css' => array ( 'label' => ' Term2base Mostly Bright P2 ', 'colors' => array ( 0 => '#F3F3F3', 1 => '#707070', 2 => '#909090', 3 => '#ED5466', 4 => '#5DC7EA', 5 => '#AFDB80', 6 => '#5DC7EA', ), ), 'base16-term2base-sos-p1.css' => array ( 'label' => ' Term2base Sos P1 ', 'colors' => array ( 0 => '#373b43', 1 => '#78796f', 2 => '#efdecb', 3 => '#fdcd39', 4 => '#afb171', 5 => '#fbfd59', 6 => '#afb171', ), ), 'base16-term2base-sweet-love-p1.css' => array ( 'label' => ' Term2base Sweet Love P1 ', 'colors' => array ( 0 => '#1F1F1F', 1 => '#C0B18B', 2 => '#978965', 3 => '#D17B49', 4 => '#535C5C', 5 => '#7B8748', 6 => '#535C5C', ), ), 'base16-term2base-trim-yer-beard-p2.css' => array ( 'label' => ' Term2base Trim Yer Beard P2 ', 'colors' => array ( 0 => '#191716', 1 => '#DABA8B', 2 => '#BC9D66', 3 => '#8C4F4A', 4 => '#65788F', 5 => '#898471', 6 => '#65788F', ), ), 'base16-term2base-yousai-p2.css' => array ( 'label' => ' Term2base Yousai P2 ', 'colors' => array ( 0 => '#F5E7DE', 1 => '#34302D', 2 => '#4C4742', 3 => '#B23636', 4 => '#5986B2', 5 => '#664233', 6 => '#5986B2', ), ), 'base16-tokyo-city-dark.css' => array ( 'label' => ' Tokyo City Dark ', 'colors' => array ( 0 => '#171D23', 1 => '#D8E2EC', 2 => '#F6F6F8', 3 => '#F7768E', 4 => '#B7C5D3', 5 => '#9ECE6A', 6 => '#7AA2F7', ), ), 'base16-tokyo-city-light.css' => array ( 'label' => ' Tokyo City Light ', 'colors' => array ( 0 => '#FBFBFD', 1 => '#343B59', 2 => '#1D252C', 3 => '#8C4351', 4 => '#4C505E', 5 => '#485E30', 6 => '#34548a', ), ), 'base16-tokyo-city-terminal-dark.css' => array ( 'label' => ' Tokyo City Terminal Dark ', 'colors' => array ( 0 => '#171D23', 1 => '#D8E2EC', 2 => '#F6F6F8', 3 => '#D95468', 4 => '#EBBF83', 5 => '#8BD49C', 6 => '#539AFC', ), ), 'base16-tokyo-city-terminal-light.css' => array ( 'label' => ' Tokyo City Terminal Light ', 'colors' => array ( 0 => '#FBFBFD', 1 => '#28323A', 2 => '#1D252C', 3 => '#8C4351', 4 => '#8f5E15', 5 => '#33635C', 6 => '#34548A', ), ), 'base16-tokyo-night-dark.css' => array ( 'label' => ' Tokyo Night Dark ', 'colors' => array ( 0 => '#1A1B26', 1 => '#A9B1D6', 2 => '#CBCCD1', 3 => '#C0CAF5', 4 => '#0DB9D7', 5 => '#9ECE6A', 6 => '#2AC3DE', ), ), 'base16-tokyo-night-light.css' => array ( 'label' => ' Tokyo Night Light ', 'colors' => array ( 0 => '#D5D6DB', 1 => '#343B59', 2 => '#1A1B26', 3 => '#343B58', 4 => '#166775', 5 => '#485E30', 6 => '#34548A', ), ), 'base16-tokyo-night-storm.css' => array ( 'label' => ' Tokyo Night Storm ', 'colors' => array ( 0 => '#24283B', 1 => '#A9B1D6', 2 => '#CBCCD1', 3 => '#C0CAF5', 4 => '#0DB9D7', 5 => '#9ECE6A', 6 => '#2AC3DE', ), ), 'base16-tokyo-night-terminal-dark.css' => array ( 'label' => ' Tokyo Night Terminal Dark ', 'colors' => array ( 0 => '#16161E', 1 => '#787C99', 2 => '#CBCCD1', 3 => '#F7768E', 4 => '#E0AF68', 5 => '#41A6B5', 6 => '#7AA2F7', ), ), 'base16-tokyo-night-terminal-light.css' => array ( 'label' => ' Tokyo Night Terminal Light ', 'colors' => array ( 0 => '#D5D6DB', 1 => '#4C505E', 2 => '#1A1B26', 3 => '#8C4351', 4 => '#8F5E15', 5 => '#33635C', 6 => '#34548A', ), ), 'base16-tokyo-night-terminal-storm.css' => array ( 'label' => ' Tokyo Night Terminal Storm ', 'colors' => array ( 0 => '#24283B', 1 => '#787C99', 2 => '#CBCCD1', 3 => '#F7768E', 4 => '#E0AF68', 5 => '#41A6B5', 6 => '#7AA2F7', ), ), 'base16-tokyodark-terminal.css' => array ( 'label' => ' Tokyodark Terminal ', 'colors' => array ( 0 => '#11121d', 1 => '#a0a8cd', 2 => '#a0a8cd', 3 => '#ee6d85', 4 => '#d7a65f', 5 => '#95c561', 6 => '#7199ee', ), ), 'base16-tokyodark.css' => array ( 'label' => ' Tokyodark ', 'colors' => array ( 0 => '#11121d', 1 => '#abb2bf', 2 => '#555661', 3 => '#a485dd', 4 => '#7199ee', 5 => '#d7A65f', 6 => '#95c561', ), ), 'base16-tomorrow-night-eighties.css' => array ( 'label' => ' Tomorrow Night Eighties ', 'colors' => array ( 0 => '#2d2d2d', 1 => '#cccccc', 2 => '#e0e0e0', 3 => '#f2777a', 4 => '#ffcc66', 5 => '#99cc99', 6 => '#6699cc', ), ), 'base16-tomorrow-night.css' => array ( 'label' => ' Tomorrow Night ', 'colors' => array ( 0 => '#1d1f21', 1 => '#c5c8c6', 2 => '#e0e0e0', 3 => '#cc6666', 4 => '#f0c674', 5 => '#b5bd68', 6 => '#81a2be', ), ), 'base16-tomorrow.css' => array ( 'label' => ' Tomorrow ', 'colors' => array ( 0 => '#ffffff', 1 => '#4d4d4c', 2 => '#282a2e', 3 => '#c82829', 4 => '#eab700', 5 => '#718c00', 6 => '#4271ae', ), ), 'base16-tube.css' => array ( 'label' => ' Tube ', 'colors' => array ( 0 => '#231f20', 1 => '#d9d8d8', 2 => '#e7e7e8', 3 => '#ee2e24', 4 => '#ffd204', 5 => '#00853e', 6 => '#009ddc', ), ), 'base16-twilight.css' => array ( 'label' => ' Twilight ', 'colors' => array ( 0 => '#1e1e1e', 1 => '#a7a7a7', 2 => '#c3c3c3', 3 => '#cf6a4c', 4 => '#f9ee98', 5 => '#8f9d6a', 6 => '#7587a6', ), ), 'base16-unikitty-dark.css' => array ( 'label' => ' Unikitty Dark ', 'colors' => array ( 0 => '#2e2a31', 1 => '#bcbabe', 2 => '#d8d7da', 3 => '#d8137f', 4 => '#dc8a0e', 5 => '#17ad98', 6 => '#796af5', ), ), 'base16-unikitty-light.css' => array ( 'label' => ' Unikitty Light ', 'colors' => array ( 0 => '#ffffff', 1 => '#6c696e', 2 => '#4f4b51', 3 => '#d8137f', 4 => '#dc8a0e', 5 => '#17ad98', 6 => '#775dff', ), ), 'base16-unikitty-reversible.css' => array ( 'label' => ' Unikitty Reversible ', 'colors' => array ( 0 => '#2e2a31', 1 => '#c3c2c4', 2 => '#e1e0e1', 3 => '#d8137f', 4 => '#dc8a0e', 5 => '#17ad98', 6 => '#7864fa', ), ), 'base16-uwunicorn.css' => array ( 'label' => ' Uwunicorn ', 'colors' => array ( 0 => '#241b26', 1 => '#eed5d9', 2 => '#d9c2c6', 3 => '#877bb6', 4 => '#a84a73', 5 => '#c965bf', 6 => '#6a9eb5', ), ), 'base16-vice.css' => array ( 'label' => ' Vice ', 'colors' => array ( 0 => '#17191E', 1 => '#8b9cbe', 2 => '#B2BFD9', 3 => '#ff29a8', 4 => '#f0ffaa', 5 => '#0badff', 6 => '#00eaff', ), ), 'base16-vulcan.css' => array ( 'label' => ' Vulcan ', 'colors' => array ( 0 => '#041523', 1 => '#5b778c', 2 => '#333238', 3 => '#818591', 4 => '#adb4b9', 5 => '#977d7c', 6 => '#977d7c', ), ), 'base16-vwbug-dark.css' => array ( 'label' => ' Vwbug Dark ', 'colors' => array ( 0 => '#170f0d', 1 => '#d9c9b6', 2 => '#e7ddd1', 3 => '#ad6042', 4 => '#927e7e', 5 => '#b48b6f', 6 => '#b48b6f', ), ), 'base16-vwbug-light.css' => array ( 'label' => ' Vwbug Light ', 'colors' => array ( 0 => '#faf7f2', 1 => '#746c48', 2 => '#312c38', 3 => '#ad6042', 4 => '#312c38', 5 => '#927e7e', 6 => '#503b43', ), ), 'base16-windows-10-light.css' => array ( 'label' => ' Windows 10 Light ', 'colors' => array ( 0 => '#f2f2f2', 1 => '#767676', 2 => '#414141', 3 => '#c50f1f', 4 => '#c19c00', 5 => '#13a10e', 6 => '#0037da', ), ), 'base16-windows-10.css' => array ( 'label' => ' Windows 10 ', 'colors' => array ( 0 => '#0c0c0c', 1 => '#cccccc', 2 => '#dfdfdf', 3 => '#e74856', 4 => '#f9f1a5', 5 => '#16c60c', 6 => '#3b78ff', ), ), 'base16-windows-95-light.css' => array ( 'label' => ' Windows 95 Light ', 'colors' => array ( 0 => '#fcfcfc', 1 => '#545454', 2 => '#2a2a2a', 3 => '#a80000', 4 => '#a85400', 5 => '#00a800', 6 => '#0000a8', ), ), 'base16-windows-95.css' => array ( 'label' => ' Windows 95 ', 'colors' => array ( 0 => '#000000', 1 => '#a8a8a8', 2 => '#d2d2d2', 3 => '#fc5454', 4 => '#fcfc54', 5 => '#54fc54', 6 => '#5454fc', ), ), 'base16-windows-highcontrast-light.css' => array ( 'label' => ' Windows Highcontrast Light ', 'colors' => array ( 0 => '#fcfcfc', 1 => '#545454', 2 => '#2a2a2a', 3 => '#800000', 4 => '#808000', 5 => '#008000', 6 => '#000080', ), ), 'base16-windows-highcontrast.css' => array ( 'label' => ' Windows Highcontrast ', 'colors' => array ( 0 => '#000000', 1 => '#c0c0c0', 2 => '#dedede', 3 => '#fc5454', 4 => '#fcfc54', 5 => '#54fc54', 6 => '#5454fc', ), ), 'base16-windows-nt-light.css' => array ( 'label' => ' Windows Nt Light ', 'colors' => array ( 0 => '#ffffff', 1 => '#808080', 2 => '#404040', 3 => '#800000', 4 => '#808000', 5 => '#008000', 6 => '#000080', ), ), 'base16-windows-nt.css' => array ( 'label' => ' Windows Nt ', 'colors' => array ( 0 => '#000000', 1 => '#c0c0c0', 2 => '#e0e0e0', 3 => '#ff0000', 4 => '#ffff00', 5 => '#00ff00', 6 => '#0000ff', ), ), 'base16-woodland.css' => array ( 'label' => ' Woodland ', 'colors' => array ( 0 => '#231e18', 1 => '#cabcb1', 2 => '#d7c8bc', 3 => '#d35c5c', 4 => '#e0ac16', 5 => '#b7ba53', 6 => '#88a4d3', ), ), 'base16-xcode-dusk.css' => array ( 'label' => ' Xcode Dusk ', 'colors' => array ( 0 => '#282B35', 1 => '#939599', 2 => '#A9AAAE', 3 => '#B21889', 4 => '#438288', 5 => '#DF0002', 6 => '#790EAD', ), ), 'base16-yuyuko-terminal.css' => array ( 'label' => ' Yuyuko Terminal ', 'colors' => array ( 0 => '#262626', 1 => '#ffffff', 2 => '#ffdfff', 3 => '#df5f87', 4 => '#dfaf00', 5 => '#ff87df', 6 => '#8787ff', ), ), 'base16-yuyuko.css' => array ( 'label' => ' Yuyuko ', 'colors' => array ( 0 => '#262626', 1 => '#ffffff', 2 => '#ffdfff', 3 => '#afafff', 4 => '#afafff', 5 => '#af87df', 6 => '#ffdfff', ), ), 'base16-zenbones.css' => array ( 'label' => ' Zenbones ', 'colors' => array ( 0 => '#191919', 1 => '#B279A7', 2 => '#66A5AD', 3 => '#3D3839', 4 => '#8BAE68', 5 => '#D68C67', 6 => '#CF86C1', ), ), 'base16-zenburn.css' => array ( 'label' => ' Zenburn ', 'colors' => array ( 0 => '#383838', 1 => '#dcdccc', 2 => '#c0c0c0', 3 => '#dca3a3', 4 => '#e0cf9f', 5 => '#5f7f5f', 6 => '#7cb8bb', ), ), ),
              'default' => 'base16-atelier-forest.css',
            ],
            'code_highlight_theme_light' => [
              'label' => '代码高亮配色（浅色模式）',
              'description' => '当切换成浅色模式时，会使用此处的代码高亮配色。具体颜色请参考上一项。',
              'type' => 'select',
              'choices' => array ( 'base16-3024.css' => ' 3024 ', 'base16-apathy.css' => ' Apathy ', 'base16-ashes.css' => ' Ashes ', 'base16-atelier-cave-light.css' => ' Atelier Cave Light ', 'base16-atelier-cave.css' => ' Atelier Cave ', 'base16-atelier-dune-light.css' => ' Atelier Dune Light ', 'base16-atelier-dune.css' => ' Atelier Dune ', 'base16-atelier-estuary-light.css' => ' Atelier Estuary Light ', 'base16-atelier-estuary.css' => ' Atelier Estuary ', 'base16-atelier-forest-light.css' => ' Atelier Forest Light ', 'base16-atelier-forest.css' => ' Atelier Forest ', 'base16-atelier-heath-light.css' => ' Atelier Heath Light ', 'base16-atelier-heath.css' => ' Atelier Heath ', 'base16-atelier-lakeside-light.css' => ' Atelier Lakeside Light ', 'base16-atelier-lakeside.css' => ' Atelier Lakeside ', 'base16-atelier-plateau-light.css' => ' Atelier Plateau Light ', 'base16-atelier-plateau.css' => ' Atelier Plateau ', 'base16-atelier-savanna-light.css' => ' Atelier Savanna Light ', 'base16-atelier-savanna.css' => ' Atelier Savanna ', 'base16-atelier-seaside-light.css' => ' Atelier Seaside Light ', 'base16-atelier-seaside.css' => ' Atelier Seaside ', 'base16-atelier-sulphurpool-light.css' => ' Atelier Sulphurpool Light ', 'base16-atelier-sulphurpool.css' => ' Atelier Sulphurpool ', 'base16-atlas.css' => ' Atlas ', 'base16-ayu-dark.css' => ' Ayu Dark ', 'base16-ayu-light.css' => ' Ayu Light ', 'base16-ayu-mirage.css' => ' Ayu Mirage ', 'base16-bespin.css' => ' Bespin ', 'base16-blueforest.css' => ' Blueforest ', 'base16-blueish.css' => ' Blueish ', 'base16-brewer.css' => ' Brewer ', 'base16-bright.css' => ' Bright ', 'base16-brushtrees-dark.css' => ' Brushtrees Dark ', 'base16-brushtrees.css' => ' Brushtrees ', 'base16-candid.css' => ' Candid ', 'base16-canvased-pastel.css' => ' Canvased Pastel ', 'base16-catppuccin-frappe.css' => ' Catppuccin Frappe ', 'base16-catppuccin-latte.css' => ' Catppuccin Latte ', 'base16-catppuccin-macchiato.css' => ' Catppuccin Macchiato ', 'base16-catppuccin-mocha.css' => ' Catppuccin Mocha ', 'base16-chalk.css' => ' Chalk ', 'base16-circus.css' => ' Circus ', 'base16-citrus-mist.css' => ' Citrus Mist ', 'base16-city-streets-dark.css' => ' City Streets Dark ', 'base16-city-streets-light.css' => ' City Streets Light ', 'base16-classic-dark.css' => ' Classic Dark ', 'base16-classic-light.css' => ' Classic Light ', 'base16-color-star.css' => ' Color Star ', 'base16-colors.css' => ' Colors ', 'base16-cupcake.css' => ' Cupcake ', 'base16-cupertino.css' => ' Cupertino ', 'base16-da-one-black.css' => ' Da One Black ', 'base16-da-one-gray.css' => ' Da One Gray ', 'base16-da-one-ocean.css' => ' Da One Ocean ', 'base16-da-one-paper.css' => ' Da One Paper ', 'base16-da-one-sea.css' => ' Da One Sea ', 'base16-da-one-white.css' => ' Da One White ', 'base16-danqing-light.css' => ' Danqing Light ', 'base16-danqing.css' => ' Danqing ', 'base16-darcula.css' => ' Darcula ', 'base16-darkmoss.css' => ' Darkmoss ', 'base16-darktooth.css' => ' Darktooth ', 'base16-darkviolet.css' => ' Darkviolet ', 'base16-decaf.css' => ' Decaf ', 'base16-default-dark.css' => ' Default Dark ', 'base16-default-light.css' => ' Default Light ', 'base16-dracula.css' => ' Dracula ', 'base16-edge-dark.css' => ' Edge Dark ', 'base16-edge-light.css' => ' Edge Light ', 'base16-eighties.css' => ' Eighties ', 'base16-embark-terminal.css' => ' Embark Terminal ', 'base16-embark.css' => ' Embark ', 'base16-embers.css' => ' Embers ', 'base16-emil.css' => ' Emil ', 'base16-equilibrium-dark.css' => ' Equilibrium Dark ', 'base16-equilibrium-gray-dark.css' => ' Equilibrium Gray Dark ', 'base16-equilibrium-gray-light.css' => ' Equilibrium Gray Light ', 'base16-equilibrium-light.css' => ' Equilibrium Light ', 'base16-espresso.css' => ' Espresso ', 'base16-eva-dim.css' => ' Eva Dim ', 'base16-eva.css' => ' Eva ', 'base16-everforest-light.css' => ' Everforest Light ', 'base16-everforest.css' => ' Everforest ', 'base16-evergarden.css' => ' Evergarden ', 'base16-fairyfloss.css' => ' Fairyfloss ', 'base16-flat.css' => ' Flat ', 'base16-flowershop.css' => ' Flowershop ', 'base16-framer.css' => ' Framer ', 'base16-fruit-soda.css' => ' Fruit Soda ', 'base16-gigavolt.css' => ' Gigavolt ', 'base16-github-dark.css' => ' Github Dark ', 'base16-github-light.css' => ' Github Light ', 'base16-google-dark.css' => ' Google Dark ', 'base16-google-light.css' => ' Google Light ', 'base16-gotham.css' => ' Gotham ', 'base16-grayscale-dark.css' => ' Grayscale Dark ', 'base16-grayscale-light.css' => ' Grayscale Light ', 'base16-green-screen.css' => ' Green Screen ', 'base16-gruber.css' => ' Gruber ', 'base16-gruvbox-dark-hard.css' => ' Gruvbox Dark Hard ', 'base16-gruvbox-dark-medium.css' => ' Gruvbox Dark Medium ', 'base16-gruvbox-dark-pale.css' => ' Gruvbox Dark Pale ', 'base16-gruvbox-dark-soft.css' => ' Gruvbox Dark Soft ', 'base16-gruvbox-light-hard.css' => ' Gruvbox Light Hard ', 'base16-gruvbox-light-medium.css' => ' Gruvbox Light Medium ', 'base16-gruvbox-light-soft.css' => ' Gruvbox Light Soft ', 'base16-gruvbox-material-dark-hard.css' => ' Gruvbox Material Dark Hard ', 'base16-gruvbox-material-dark-medium.css' => ' Gruvbox Material Dark Medium ', 'base16-gruvbox-material-dark-soft.css' => ' Gruvbox Material Dark Soft ', 'base16-gruvbox-material-light-hard.css' => ' Gruvbox Material Light Hard ', 'base16-gruvbox-material-light-medium.css' => ' Gruvbox Material Light Medium ', 'base16-gruvbox-material-light-soft.css' => ' Gruvbox Material Light Soft ', 'base16-hackerman.css' => ' Hackerman ', 'base16-hardcore.css' => ' Hardcore ', 'base16-hardhacker.css' => ' Hardhacker ', 'base16-harmonic16-dark.css' => ' Harmonic16 Dark ', 'base16-harmonic16-light.css' => ' Harmonic16 Light ', 'base16-heetch-light.css' => ' Heetch Light ', 'base16-heetch.css' => ' Heetch ', 'base16-helios.css' => ' Helios ', 'base16-hopscotch.css' => ' Hopscotch ', 'base16-horizon-dark.css' => ' Horizon Dark ', 'base16-horizon-light.css' => ' Horizon Light ', 'base16-horizon-terminal-dark.css' => ' Horizon Terminal Dark ', 'base16-horizon-terminal-light.css' => ' Horizon Terminal Light ', 'base16-humanoid-dark.css' => ' Humanoid Dark ', 'base16-humanoid-light.css' => ' Humanoid Light ', 'base16-hund.css' => ' Hund ', 'base16-hybrid.css' => ' Hybrid ', 'base16-ia-dark.css' => ' Ia Dark ', 'base16-ia-light.css' => ' Ia Light ', 'base16-icy.css' => ' Icy ', 'base16-ir-black.css' => ' Ir Black ', 'base16-isotope.css' => ' Isotope ', 'base16-kanagawa.css' => ' Kanagawa ', 'base16-katy.css' => ' Katy ', 'base16-kimber.css' => ' Kimber ', 'base16-lime.css' => ' Lime ', 'base16-london-tube.css' => ' London Tube ', 'base16-macintosh.css' => ' Macintosh ', 'base16-magical-girl.css' => ' Magical Girl ', 'base16-marrakesh.css' => ' Marrakesh ', 'base16-materia.css' => ' Materia ', 'base16-material-darker.css' => ' Material Darker ', 'base16-material-lighter.css' => ' Material Lighter ', 'base16-material-palenight.css' => ' Material Palenight ', 'base16-material-v2.css' => ' Material V2 ', 'base16-material-vivid.css' => ' Material Vivid ', 'base16-material.css' => ' Material ', 'base16-mellow-purple.css' => ' Mellow Purple ', 'base16-mexico-light.css' => ' Mexico Light ', 'base16-mikuconsole-dark.css' => ' Mikuconsole Dark ', 'base16-mikuconsole-light.css' => ' Mikuconsole Light ', 'base16-minty-melon.css' => ' Minty Melon ', 'base16-mocha.css' => ' Mocha ', 'base16-molokai-terminal.css' => ' Molokai Terminal ', 'base16-molokai.css' => ' Molokai ', 'base16-monokai.css' => ' Monokai ', 'base16-mountain.css' => ' Mountain ', 'base16-nature-suede.css' => ' Nature Suede ', 'base16-nebula.css' => ' Nebula ', 'base16-nord.css' => ' Nord ', 'base16-nova.css' => ' Nova ', 'base16-ocean.css' => ' Ocean ', 'base16-oceanicnext.css' => ' Oceanicnext ', 'base16-one-dark.css' => ' One Dark ', 'base16-one-light.css' => ' One Light ', 'base16-outrun-dark.css' => ' Outrun Dark ', 'base16-pandora.css' => ' Pandora ', 'base16-panels.css' => ' Panels ', 'base16-paraiso.css' => ' Paraiso ', 'base16-pasque.css' => ' Pasque ', 'base16-phd.css' => ' Phd ', 'base16-pico.css' => ' Pico ', 'base16-pinky.css' => ' Pinky ', 'base16-pop.css' => ' Pop ', 'base16-porple.css' => ' Porple ', 'base16-primer-dark-dimmed.css' => ' Primer Dark Dimmed ', 'base16-primer-dark.css' => ' Primer Dark ', 'base16-primer-light.css' => ' Primer Light ', 'base16-purpledream.css' => ' Purpledream ', 'base16-qualia.css' => ' Qualia ', 'base16-railscasts.css' => ' Railscasts ', 'base16-rebecca.css' => ' Rebecca ', 'base16-red-phoenix.css' => ' Red Phoenix ', 'base16-rose-pine-dawn.css' => ' Rose Pine Dawn ', 'base16-rose-pine-moon.css' => ' Rose Pine Moon ', 'base16-rose-pine.css' => ' Rose Pine ', 'base16-sacred-forest-terminal.css' => ' Sacred Forest Terminal ', 'base16-sacred-forest.css' => ' Sacred Forest ', 'base16-sagelight.css' => ' Sagelight ', 'base16-sakura.css' => ' Sakura ', 'base16-sandcastle.css' => ' Sandcastle ', 'base16-seti-ui.css' => ' Seti Ui ', 'base16-seti.css' => ' Seti ', 'base16-shades-of-purple.css' => ' Shades Of Purple ', 'base16-shadesmear-dark.css' => ' Shadesmear Dark ', 'base16-shadesmear-light.css' => ' Shadesmear Light ', 'base16-shapeshifter.css' => ' Shapeshifter ', 'base16-silk-dark.css' => ' Silk Dark ', 'base16-silk-light.css' => ' Silk Light ', 'base16-skull.css' => ' Skull ', 'base16-snazzy.css' => ' Snazzy ', 'base16-snowtrek-terminal.css' => ' Snowtrek Terminal ', 'base16-snowtrek.css' => ' Snowtrek ', 'base16-solar-flare.css' => ' Solar Flare ', 'base16-solarflare-light.css' => ' Solarflare Light ', 'base16-solarized-dark.css' => ' Solarized Dark ', 'base16-solarized-light.css' => ' Solarized Light ', 'base16-sonokai-andromeda.css' => ' Sonokai Andromeda ', 'base16-sonokai-atlantis.css' => ' Sonokai Atlantis ', 'base16-sonokai-espresso.css' => ' Sonokai Espresso ', 'base16-sonokai-maia.css' => ' Sonokai Maia ', 'base16-sonokai-shusia.css' => ' Sonokai Shusia ', 'base16-sonokai.css' => ' Sonokai ', 'base16-spaceduck.css' => ' Spaceduck ', 'base16-spacemacs.css' => ' Spacemacs ', 'base16-standardized-dark.css' => ' Standardized Dark ', 'base16-standardized-light.css' => ' Standardized Light ', 'base16-stella.css' => ' Stella ', 'base16-summercamp.css' => ' Summercamp ', 'base16-summerfruit-dark.css' => ' Summerfruit Dark ', 'base16-summerfruit-light.css' => ' Summerfruit Light ', 'base16-synth-midnight-dark.css' => ' Synth Midnight Dark ', 'base16-synth-midnight-light.css' => ' Synth Midnight Light ', 'base16-synthwave-84.css' => ' Synthwave 84 ', 'base16-tango.css' => ' Tango ', 'base16-tender.css' => ' Tender ', 'base16-term2base-canvased-pastel-p1.css' => ' Term2base Canvased Pastel P1 ', 'base16-term2base-colorful-colors-p1.css' => ' Term2base Colorful Colors P1 ', 'base16-term2base-hybrid-p2.css' => ' Term2base Hybrid P2 ', 'base16-term2base-ivory-light-p2.css' => ' Term2base Ivory Light P2 ', 'base16-term2base-matrix-p1.css' => ' Term2base Matrix P1 ', 'base16-term2base-mostly-bright-p2.css' => ' Term2base Mostly Bright P2 ', 'base16-term2base-sos-p1.css' => ' Term2base Sos P1 ', 'base16-term2base-sweet-love-p1.css' => ' Term2base Sweet Love P1 ', 'base16-term2base-trim-yer-beard-p2.css' => ' Term2base Trim Yer Beard P2 ', 'base16-term2base-yousai-p2.css' => ' Term2base Yousai P2 ', 'base16-tokyo-city-dark.css' => ' Tokyo City Dark ', 'base16-tokyo-city-light.css' => ' Tokyo City Light ', 'base16-tokyo-city-terminal-dark.css' => ' Tokyo City Terminal Dark ', 'base16-tokyo-city-terminal-light.css' => ' Tokyo City Terminal Light ', 'base16-tokyo-night-dark.css' => ' Tokyo Night Dark ', 'base16-tokyo-night-light.css' => ' Tokyo Night Light ', 'base16-tokyo-night-storm.css' => ' Tokyo Night Storm ', 'base16-tokyo-night-terminal-dark.css' => ' Tokyo Night Terminal Dark ', 'base16-tokyo-night-terminal-light.css' => ' Tokyo Night Terminal Light ', 'base16-tokyo-night-terminal-storm.css' => ' Tokyo Night Terminal Storm ', 'base16-tokyodark-terminal.css' => ' Tokyodark Terminal ', 'base16-tokyodark.css' => ' Tokyodark ', 'base16-tomorrow-night-eighties.css' => ' Tomorrow Night Eighties ', 'base16-tomorrow-night.css' => ' Tomorrow Night ', 'base16-tomorrow.css' => ' Tomorrow ', 'base16-tube.css' => ' Tube ', 'base16-twilight.css' => ' Twilight ', 'base16-unikitty-dark.css' => ' Unikitty Dark ', 'base16-unikitty-light.css' => ' Unikitty Light ', 'base16-unikitty-reversible.css' => ' Unikitty Reversible ', 'base16-uwunicorn.css' => ' Uwunicorn ', 'base16-vice.css' => ' Vice ', 'base16-vulcan.css' => ' Vulcan ', 'base16-vwbug-dark.css' => ' Vwbug Dark ', 'base16-vwbug-light.css' => ' Vwbug Light ', 'base16-windows-10-light.css' => ' Windows 10 Light ', 'base16-windows-10.css' => ' Windows 10 ', 'base16-windows-95-light.css' => ' Windows 95 Light ', 'base16-windows-95.css' => ' Windows 95 ', 'base16-windows-highcontrast-light.css' => ' Windows Highcontrast Light ', 'base16-windows-highcontrast.css' => ' Windows Highcontrast ', 'base16-windows-nt-light.css' => ' Windows Nt Light ', 'base16-windows-nt.css' => ' Windows Nt ', 'base16-woodland.css' => ' Woodland ', 'base16-xcode-dusk.css' => ' Xcode Dusk ', 'base16-yuyuko-terminal.css' => ' Yuyuko Terminal ', 'base16-yuyuko.css' => ' Yuyuko ', 'base16-zenbones.css' => ' Zenbones ', 'base16-zenburn.css' => ' Zenburn ', ),
              'default' => 'base16-atelier-forest-light.css',
            ]
          ],
        ],
        'thread_style_vintage_v1' => [
          'title' => '帖子详情-古董',
          '_group' => 'G4',
          'options' => [
            'show_user_statistics' => [
              'label' => '显示用户的统计信息？',
              'description' => '启用此设置将在帖子的和回帖的用户信息部分中显示对应用户的统计信息，如发帖数、回复数、点赞数等。需要注意，选择“所有楼层”可能会导致网站变慢。',
              'type' => 'radio',
              'default' => false,
              'choices' => [
                false => '关闭',
                'post_author' => '只有楼主',
                'all' => '所有楼层'
              ],
            ],
          ],
        ],
        'thread_style_blog_v2' => [
          'title' => '帖子详情-博客风格V2',
          '_group' => 'G4',
          'options' => [
            'header_section_style' => [
              'label' => '标题区域风格',
              'type' => 'radio-image',
              'default' => 'title-above-cover',
              'choices' => [
                'title-below-cover' => ['label' => '标题在封面图下方', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.header_section_style.title-below-cover.png'],
                'title-above-cover' => ['label' => '标题在封面图上方', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.header_section_style.title-above-cover.png'],
                'title-left-cover' => ['label' => '标题在封面图左侧', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.header_section_style.title-left-cover.png'],
                'title-right-cover' => ['label' => '标题在封面图右侧', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.header_section_style.title-right-cover.png'],
                'title-front-cover' => ['label' => '封面图作为标题的背景', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.header_section_style.title-front-cover.png'],
              ],
            ],
            'title_align' => [
              'label' => '标题对齐方式',
              'type' => 'radio-image',
              'default' => 'center',
              'choices' => [
                'left' => ['label' => '左对齐', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.title_align.left.png'],
                'center' => ['label' => '居中对齐', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.title_align.center.png'],
                'right' => ['label' => '右对齐', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.title_align.right.png'],
              ],
            ],
            'title_size' => [
              'label' => '标题字号',
              'type' => 'radio',
              'default' => 'medium',
              'choices' => [
                'smaller' => '更小',
                'medium' => '中等',
                'larger' => '更大',
              ],
            ],
            'title_shadow' => [
              'label' => '标题添加阴影？',
              'description' => '若在一些情况下（如复杂封面图等）看不清标题，请选“是”。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
          'cover_shadow' => [
              'label' => '封面图阴影风格',
              'description' => '当选择“标题在封面图下方”“标题在封面图上方”时可设置',
              'type' => 'radio-image',
              'default' => 'none',
              'choices' => [
                'none' => ['label' => '没有阴影', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.cover_shadow.none.png'],
                'normal' => ['label' => '有正常阴影', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.cover_shadow.normal.png'],
                'colorful' => ['label' => '有彩色阴影', 'url' => $stately_setting_img_url_prefix . 'ui_tweek.thread_style_blog_v2.cover_shadow.colorful.png'],
              ],
            ],
        ],
        'postlist' => [
          'title' => '回帖列表',
          '_group' => 'G4',
          'options' => [
            'show_avatar' => [
              'label' => '显示头像？',
              'description' => '选择“否”，隐藏头像。不影响“古董”风格。',
              'type' => 'toggle',
              'default' => true,
            ],
          ],
        ],
        'user' => [
          'title' => '用户页面',
          '_group' => 'G5',
          'options' => [
            'lv2_menu_location' => [
              'label' => '二级菜单位置',
              'type' => 'radio',
              'default' => 'top',
              'choices' => [
                'side' => '侧边',
                'top' => '顶部',
              ],
            ],
            'stats_style' => [
              'label' => '用户信息风格',
              'description' => '“经典”风格为Xiuno BBS原装风格（纯文本列表），“卡片”风格将重要的用户信息（如发帖数、回帖数等）展示为卡片，使页面看起来更加美观、易读。',
              'type' => 'select',
              'default' => 'classic_v1',
              'choices' => [
                'classic_v1' => '经典',
                'card_v1' => '卡片',
              ]
            ],
            'show_uid_on_hero' => [
              'label' => '显示UID？',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_usergroup_on_hero' => [
              'label' => '显示用户组？',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_stats_on_hero' => [
              'label' => '显示简略用户统计信息？',
              'description' => '显示如发帖数、回帖数等统计信息。',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_customizer' => [
              'label' => '显示“个性化”部分？',
              'description' => '选择“是”，将会在“个人中心”里增添“个性化”部分，可以让用户根据自己的喜好和需求进行个性化设置，如设置颜色模式等，提高用户体验。如果顶部菜单里没有颜色模式切换按钮的话，可以启用此项作为补充。',
              'type' => 'toggle',
              'default' => false,
            ],
            'default_signature_self' => [
              'label' => '默认签名（自己）',
              'description' => '用户查看自己资料时，如果签名为空则显示',
              'type' => 'text',
              'default' => '<a href=\'' . url('my-signature') . '\'>设置签名</a>'
            ],
            'default_signature_other' => [
              'label' => '默认签名（他人）',
              'description' => '查看帖子时，如果签名为空则显示',
              'type' => 'text',
              'default' => '这家伙太懒了，什么也没留下。'
            ],
          ],
        ],
        'user_cover' => [
          'title' => '用户页面-封面图',
          '_group' => 'G5',
          'options' => [
            'style' => [
              'label' => '风格',
              'type' => 'radio-image',
              'description' => 'V1风格的颜色会与主色调同步。',
              'default' => 'v1',
              'choices' => [
                'v1' => [
                  'label' => 'V1：JK格裙',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.style.v1.png'
                ],
                'v2' => [
                  'label' => 'V2：随机三角形',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.strong.png'
                ],
              ],
            ],
            'v2_color_scheme' => [
              'label' => '随机三角形配色',
              'type' => 'radio-image',
              'description' => 'Candy配色会与主色调同步。',
              'default' => 'neon_full',
              'choices' => [
                'bw' => [
                  'label' => 'B & W',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.bw.png'
                ],
                'monochrome' => [
                  'label' => 'Monochrome',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.monochrome.png'
                ],
                'candy' => [
                  'label' => 'Candy',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.candy.png'
                ],
                'strong' => [
                  'label' => 'Quad-color',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.strong.png'
                ],
                'neon' => [
                  'label' => 'Neon',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.neon.png'
                ],
                'neon_full' => [
                  'label' => 'Rainbow',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.neon_full.png'
                ],
                'tri_color' => [
                  'label' => 'Tri-color',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.tri_color.png'
                ],
                'coffee' => [
                  'label' => 'Coffee',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.coffee.png'
                ],
                'silk' => [
                  'label' => 'Silk',
                  'url' => $stately_setting_img_url_prefix . 'ui_tweek.user_cover.v2_color_scheme.silk.png'
                ],
              ],
            ],
          ],
        ],
      ],
    ],
    'custom_content' => [
      'title' => '自定义内容',
      'sections' => [
        'global' => [
          'title' => '全局',
          '_group' => 'G1',
          '_cols' => '2',
          'options' => [
            'footer_left_content' => [
              'label' => '页脚左侧文字',
              'description' => '可使用HTML',
              'type' => 'textarea_html',
              'default' => '&copy; 2022 - ' . date('Y ') . 'Theme: <a href=\'https://xiunobbs.cn/thread-3888.htm\' target=\'_blank\' class=\'footer-link\'>Stately</a> made by <em>Geticer</em>; Designed by <a href=\'https://themeselection.com\' target=\'_blank\' class=\'footer-link\'>ThemeSelection</a>'
            ],
            'footer_right_content' => [
              'label' => '页脚右侧文字',
              'description' => '可使用HTML',
              'type' => 'textarea_html',
              'default' => '<ul class="list-inline my-1 d-inline-block"><li class="list-inline-item">' . implode('</li><li class="list-inline-item">', [
                '<a href="' . url('about_us') . '">' . '关于本站</a>',
                '<a href="' . url('terms') . '">' . '网站规则</a>',
                '<a href="' . url('privacy') . '">' . '隐私政策</a>',
                '<a href="' . url('contact_us') . '">' . '联系我们</a>',
              ]) . '</li></ul>' . ' 自豪地采用Xiuno BBS'
            ],
            'footer_right_performance_info' => [
              'label' => '页脚右侧性能信息显示方式',
              'description' => '完整性能信息解释:🛢️（油桶）：数据库查询次数，⏰（闹钟）：服务器处理时间丨客户端加载时间，🍰（蛋糕）：服务器内存使用；非管理员看到的还是加载时间。此功能可以帮助网站管理员了解网站的性能表现，进而优化网站。',
              'type' => 'radio',
              'default' => 'full',
              'choices' => [
                false => '完全关闭',
                'only_time' => '仅加载时间',
                'full' => '完整信息（仅对管理员显示）'
              ],
            ],
          ],
        ],
        'global_cookie_notice' => [
          'title' => 'Cookie提醒',
          '_group' => 'G1',
          '_cols' => '2',
          'options' => [
            'enable' => [
              'label' => '启用Cookie提醒？',
              'type' => 'toggle',
              'default' => false,
            ],
            'style' => [
              'label' => 'Cookie提醒风格',
              'type' => 'radio-image',
              'default' => 'v1',
              'choices' => [
                'v1' => [
                  'label' => 'V1',
                  'url' => $stately_setting_img_url_prefix . 'special.global_cookie_notice.style.v1.png'
                ],
                'v2' => [
                  'label' => 'V2',
                  'url' => $stately_setting_img_url_prefix . 'special.global_cookie_notice.style.v2.png'
                ],
                'v3' => [
                  'label' => 'V3',
                  'url' => $stately_setting_img_url_prefix . 'special.global_cookie_notice.style.v3.png'
                ],
                'v4' => [
                  'label' => 'V4',
                  'url' => $stately_setting_img_url_prefix . 'special.global_cookie_notice.style.v4.png'
                ],
                'v5' => [
                  'label' => 'V5',
                  'url' => $stately_setting_img_url_prefix . 'special.global_cookie_notice.style.v5.png'
                ],
              ]
            ],
            'title' => [
              'label' => 'Cookie提醒标题',
              'type' => 'text',
              'default' => '本站使用Cookie',
            ],
            'content' => [
              'label' => 'Cookie提醒内容',
              'type' => 'text_html',
              'default' => '本网站使用Cookie来为您提供更好的体验。如果您继续使用本网站，即表示您同意我们使用Cookie。点击“了解更多”可了解有关我们使用Cookie的更多信息。'
            ],
          ],
        ],
        'homepage_cta' => [
          'title' => '主页-欢迎辞',
          '_group' => 'G2',
          'options' => [
            'enable' => [
              'label' => '启用欢迎辞？',
              'description' => '启用此设置可以在网站主页上展示一段欢迎用户的文字内容，也可以在需要的时候进行修改和更新。这可以让用户感受到网站的人性化和关怀，同时也可以增加用户对网站的信任感和满意度。',
              'type' => 'toggle',
              'default' => true,
            ],
            'style' => [
              'label' => '欢迎辞风格',
              'description' => '选择“头图风格—顶部”的话，可在后面的“主页-欢迎辞-头图风格设置”中设置更详细的内容。',
              'type' => 'select',
              'default' => 'pos_top__img_right',
              'choices' => [
                'pos_hero__img_back'   => '头图风格—顶部（图片作为背景）',
                'pos_top__img_left'    => '卡片风格—顶部（图片在左）',
                'pos_top__img_right'   => '卡片风格—顶部（图片在右）',
                'pos_side__img_top'    => '卡片风格—侧边（图片在顶）',
                'pos_side__img_bottom' => '卡片风格—侧边（图片在底）',
              ],
            ],
            'visibility' => [
              'label' => '欢迎辞可见度',
              'type' => 'radio',
              'default' => 'only_guest',
              'choices' => [
                'always' => '一直可见',
                'only_guest' => '只对游客可见',
              ],
            ],
            'title' => [
              'label' => '欢迎辞标题',
              'type' => 'text',
              'default' => '欢迎来到' . $conf['sitename'] . '！',
            ],
            'content' => [
              'label' => '欢迎辞内容',
              'type' => 'html',
              'default' => '<p>登录后探索更多精彩内容！</p>'
            ],
            'title_login' => [
              'label' => '欢迎辞标题 - 登录后状态',
              'type' => 'text',
              'default' => '__username__，欢迎回来！',
              'description' => '变量：__username__：用户名'
            ],
            'content_login' => [
              'label' => '欢迎辞内容 - 登录后状态',
              'type' => 'html',
              'default' => '祝你度过愉快的一天。'
            ],
            'image' => [
              'label' => '欢迎辞图片地址',
              'description' => '输入图片的网址包含“http(s)://”前缀。亦可输入相对路径。',
              'type' => 'text',
              'default' => $HTTP_TYPE . str_replace('/admin', '', WEBSITE_DIR) . PLUGIN_DIR . 'view/img/cta_women-with-laptop-light.png'
            ],
          ],
        ],
        'homepage_cta_button_1' => [
          'title' => '主页-欢迎辞按钮①',
          '_group' => 'G2',
          '_cols' => '2',
          'options' => [
            'style' => [
              'label' => '颜色风格',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '【实心】主题主色',
                'secondary' => '【实心】主题辅助色',
                'success' => '【实心】绿色（成功）',
                'info' => '【实心】青色（信息）',
                'warning' => '【实心】橙色（警告）',
                'danger' => '【实心】红色（危险）',
                'light' => '【实心】亮色',
                'dark' => '【实心】暗色',
                'outline-primary' => '（空心）主题主色',
                'outline-secondary' => '（空心）主题辅助色',
                'outline-success' => '（空心）绿色（成功）',
                'outline-info' => '（空心）青色（信息）',
                'outline-warning' => '（空心）橙色（警告）',
                'outline-danger' => '（空心）红色（危险）',
                'outline-light' => '（空心）亮色',
                'outline-dark' => '（空心）暗色',
              ],
            ],
            'visibility' => [
              'label' => '可见度',
              'type' => 'select',
              'default' => 'guest_only',
              'choices' => [
                'all' => '所有用户可见',
                'guest_only' => '仅游客可见',
                'login_only' => '仅登录用户可见'
              ],
              'description' => '若不需要显示，请清空地址。',
            ],
            'content' => [
              'label' => '文字',
              'type' => 'text',
              'default' => lang('login')
            ],
            'href' => [
              'label' => '地址',
              'type' => 'text',
              'description' => '可直接输入网址，也可使用：“__login__”：登录链接，“__register__”：注册链接，“__thread_create__”：发帖链接，“__my__”：个人中心链接',
              'default' => '__login__'
            ],
          ],
        ],
        'homepage_cta_button_2' => [
          'title' => '主页-欢迎辞按钮②',
          '_group' => 'G2',
          '_cols' => '2',
          'options' => [
            'style' => [
              'label' => '颜色风格',
              'type' => 'select',
              'default' => 'outline-primary',
              'choices' => [
                'primary' => '【实心】主题主色',
                'secondary' => '【实心】主题辅助色',
                'success' => '【实心】绿色（成功）',
                'info' => '【实心】青色（信息）',
                'warning' => '【实心】橙色（警告）',
                'danger' => '【实心】红色（危险）',
                'light' => '【实心】亮色',
                'dark' => '【实心】暗色',
                'outline-primary' => '（空心）主题主色',
                'outline-secondary' => '（空心）主题辅助色',
                'outline-success' => '（空心）绿色（成功）',
                'outline-info' => '（空心）青色（信息）',
                'outline-warning' => '（空心）橙色（警告）',
                'outline-danger' => '（空心）红色（危险）',
                'outline-light' => '（空心）亮色',
                'outline-dark' => '（空心）暗色',
              ],
            ],
            'visibility' => [
              'label' => '可见度',
              'type' => 'select',
              'default' => 'guest_only',
              'choices' => [
                'all' => '所有用户可见',
                'guest_only' => '仅游客可见',
                'login_only' => '仅登录用户可见'
              ],
              'description' => '若不需要显示，请清空地址。',
            ],
            'content' => [
              'label' => '文字',
              'type' => 'text',
              'default' => lang('register')
            ],
            'href' => [
              'label' => '地址',
              'description' => '可直接输入网址，也可使用：“__login__”：登录链接，“__register__”：注册链接，“__thread_create__”：发帖链接，“__my__”：个人中心链接',
              'type' => 'text',
              'default' => '__register__'
            ],
          ],
        ],
        'homepage_cta_button_3' => [
          'title' => '主页-欢迎辞按钮③',
          '_group' => 'G2',
          '_cols' => '2',
          'options' => [
            'style' => [
              'label' => '颜色风格',
              'type' => 'select',
              'default' => 'primary',
              'choices' => [
                'primary' => '【实心】主题主色',
                'secondary' => '【实心】主题辅助色',
                'success' => '【实心】绿色（成功）',
                'info' => '【实心】青色（信息）',
                'warning' => '【实心】橙色（警告）',
                'danger' => '【实心】红色（危险）',
                'light' => '【实心】亮色',
                'dark' => '【实心】暗色',
                'outline-primary' => '（空心）主题主色',
                'outline-secondary' => '（空心）主题辅助色',
                'outline-success' => '（空心）绿色（成功）',
                'outline-info' => '（空心）青色（信息）',
                'outline-warning' => '（空心）橙色（警告）',
                'outline-danger' => '（空心）红色（危险）',
                'outline-light' => '（空心）亮色',
                'outline-dark' => '（空心）暗色',
              ],
            ],
            'visibility' => [
              'label' => '可见度',
              'type' => 'select',
              'default' => 'login_only',
              'choices' => [
                'all' => '所有用户可见',
                'guest_only' => '仅游客可见',
                'login_only' => '仅登录用户可见'
              ],
              'description' => '若不需要显示，请清空地址。',
            ],
            'content' => [
              'label' => '文字',
              'type' => 'text',
              'default' => lang('create_thread')
            ],
            'href' => [
              'label' => '地址',
              'description' => '可直接输入网址，也可使用：“__login__”：登录链接，“__register__”：注册链接，“__thread_create__”：发帖链接，“__my__”：个人中心链接',
              'type' => 'text',
              'default' => '__thread_create__'
            ],
          ],
        ],
        'homepage_cta_button_4' => [
          'title' => '主页-欢迎辞按钮④',
          '_group' => 'G2',
          '_cols' => '2',
          'options' => [
            'style' => [
              'label' => '颜色风格',
              'type' => 'select',
              'default' => 'outline-primary',
              'choices' => [
                'primary' => '【实心】主题主色',
                'secondary' => '【实心】主题辅助色',
                'success' => '【实心】绿色（成功）',
                'info' => '【实心】青色（信息）',
                'warning' => '【实心】橙色（警告）',
                'danger' => '【实心】红色（危险）',
                'light' => '【实心】亮色',
                'dark' => '【实心】暗色',
                'outline-primary' => '（空心）主题主色',
                'outline-secondary' => '（空心）主题辅助色',
                'outline-success' => '（空心）绿色（成功）',
                'outline-info' => '（空心）青色（信息）',
                'outline-warning' => '（空心）橙色（警告）',
                'outline-danger' => '（空心）红色（危险）',
                'outline-light' => '（空心）亮色',
                'outline-dark' => '（空心）暗色',
              ],
            ],
            'visibility' => [
              'label' => '可见度',
              'type' => 'select',
              'default' => 'login_only',
              'choices' => [
                'all' => '所有用户可见',
                'guest_only' => '仅游客可见',
                'login_only' => '仅登录用户可见'
              ],
              'description' => '若不需要显示，请清空地址。',
            ],
            'content' => [
              'label' => '文字',
              'type' => 'text',
              'default' => lang('my_home')
            ],
            'href' => [
              'label' => '地址',
              'description' => '可直接输入网址，也可使用：“__login__”：登录链接，“__register__”：注册链接，“__thread_create__”：发帖链接，“__my__”：个人中心链接',
              'type' => 'text',
              'default' => '__my__'
            ],
          ],
        ],
        'homepage_cta_hero_setting' => [
          'title' => '主页-欢迎辞-头图风格 设置',
          '_group' => 'G2',
          'description' => '设置欢迎辞标题、文字、背景图见上方“主页-欢迎辞”部分。',
          'options' => [
            'text_color' => [
              'label' => '文字颜色',
              'type' => 'select',
              'default' => 'light',
              'choices' => [
                'dark' => '深色（适合浅色背景）',
                'light' => '浅色（适合深色背景）'
              ],
            ],
            'show_search_form' => [
              'label' => '显示搜索框？',
              'description' => '仅在安装搜索插件后可用。搜索框提示语可在“全局-搜索”部分中设置。',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_search_hot_keywords' => [
              'label' => '显示热门搜索词？',
              'description' => '仅在安装搜索插件后可用。热门搜索词可在“全局-搜索”部分中设置。',
              'type' => 'toggle',
              'default' => true,
            ],
            'show_site_stats' => [
              'label' => '显示网站统计？',
              'description' => '选择“是”，将会在搜索框之后显示网站的帖子数量及用户数量。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'thread' => [
          'title' => '帖子页',
          '_group' => 'G4',
          'options' => [
            'content_side' => [
              'label' => '帖子详情页右侧内容',
              'type' => 'textarea_html',
              'default' => '',
            ],
            'content_after_thread_body' => [
              'label' => '帖子正文下方内容',
              'description' => '可作为版权信息提示等。',
              'type' => 'textarea_html',
              'default' => '',
            ],
          ],
        ],
        'thread_fastreply_notlogin' => [
          'title' => '帖子页-回帖框-未登录状态',
          '_group' => 'G4',
          '_cols' => 2,
          'options' => [
            'content' => [
              'label' => '引导文案',
              'description' => '如：您需要登录后才可以回帖',
              'type' => 'text',
              'default' => '您需要登录后才可以回帖',
            ],
            'dummy' => [
              'label' => '...',
              'type' => 'hidden',
              'default' => '',
            ],
            'content_btn_login' => [
              'label' => '登录按钮文字',
              'description' => '如：立即登录；留空为不显示。',
              'type' => 'text',
              'default' => '立即登录',
            ],
            'content_btn_register' => [
              'label' => '注册按钮文字',
              'description' => '如：立即注册；留空为不显示。',
              'type' => 'text',
              'default' => '立即注册',
            ],
            'href_btn_login' => [
              'label' => '登录按钮地址',
              'default' => '__login__',
              'type' => 'text',
              'description' => '可直接输入网址，也可使用：“__login__”表示登录链接；除非有必要，建议不要随意修改该设置。',
            ],
            'href_btn_register' => [
              'label' => '注册按钮地址',
              'default' => '__register__',
              'type' => 'text',
              'description' => '可直接输入网址，也可使用：“__register__”表示注册链接；除非有必要，建议不要随意修改该设置。',
            ],
          ],
        ],
      ],
    ],
    'page' => [
      'title' => '自定义内容—页面',
      'sections' => [
        'user_login' => [
          'title' => '登录',
          '_group' => 'G6',
          'options' => [
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '欢迎来到' . $conf['sitename'] . '！',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => '请登录您的账号，开始你的旅途'
            ],
            'image' => [
              'label' => '主题图片',
              'description' => '用于V2风格，显示在表单的另一侧',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/img/auth-element.png',
            ],
            'background_image' => [
              'label' => '背景图片',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/img/auth-bg.png',
            ],
            'image_for_modal' => [
              'label' => '弹窗使用的图片',
              'description' => '用于“【特殊】ZB风格”，将显示在登录框的左侧。',
              'type' => 'text',
              'default' => str_replace('/admin', '', WEBSITE_DIR) . PLUGIN_DIR . 'view/img/anime-girl-with-toy-rabbit-design_24799604__Image_by_gstudioimagen1_on_Freepik.png',
            ],
            'goto_register_text' => [
              'label' => '转到注册文案',
              'description' => '可以使用部分HTML标签。 变量：%s——注册链接',
              'type' => 'text_html',
              'default' => '没有帐号？%s'
            ]
          ],
        ],
        'user_register' => [
          'title' => '注册',
          '_group' => 'G6',
          'options' => [
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '万里之行，始于足下',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => '注册一个账号，开始你的旅途'
            ],
            'image' => [
              'label' => '主题图片',
              'description' => '用于V2风格，显示在表单的另一侧',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/img/auth-element.png',
            ],
            'background_image' => [
              'label' => '背景图片',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/img/auth-bg.png',
            ],
            'content' => [
              'label' => '页面内容',
              'description' => '可用作注册须知等',
              'type' => 'html',
              'default' => '',
            ],
            'goto_login_text' => [
              'label' => '转到登录文案',
              'description' => '可以使用部分HTML标签。 变量：%s——登录链接',
              'type' => 'text_html',
              'default' => '已有帐号？%s'
            ]
          ],
        ],
        'user_forgetpw' => [
          'title' => '忘记密码',
          '_group' => 'G6',
          'options' => [
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '忘记密码',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => '找回密码'
            ],
            'image' => [
              'label' => '主题图片',
              'description' => '用于V2风格，显示在表单的另一侧',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/img/auth-element.png',
            ],
            'background_image' => [
              'label' => '背景图片',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/img/auth-bg.png',
            ],
            'goto_login_text' => [
              'label' => '转到登录文案',
              'description' => '可以使用部分HTML标签。 变量：%s——登录链接',
              'type' => 'text_html',
              'default' => '想起密码了？%s'
            ],
          ],
        ],
        'password_requirements' => [
          'title' => '密码要求',
          '_group' => 'G6',
          'description' => '将会在“注册”、“忘记密码”、个人中心的“密码”界面中展示。',
          'options' => [
            'show' => [
              'label' => '显示该部分？',
              'type' => 'toggle',
              'default' => true,
            ],
            'title' => [
              'label' => '标题',
              'type' => 'text',
              'default' => '密码要求：',
            ],
            'content' => [
              'label' => '内容',
              'type' => 'textarea',
              'default' => '最少8个字符-越多越好' . PHP_EOL . '至少一个大写字符' . PHP_EOL . '至少一个数字和/或符号字符',
              'description' => '一条一个，会以无序列表的形式展示。',
            ],
          ],
        ],
        'about' => [
          'title' => '关于本站',
          '_group' => 'G6',
          'description' => '<a href="../' . url('about_us') . '">进入页面</a>；因程序限制，暂无法实现“任意页面创建、编辑、删除”。若不希望某个页面对外展示，仅需清空内容并去掉链接即可。',
          'options' => [
            'icon' => [
              'label' => '页面图标',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>），留空则不显示图标',
              'type' => 'text',
              'default' => 'las la-edit',
            ],
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '关于本站',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => 'About Us',
            ],
            'content' => [
              'label' => '页面内容',
              'type' => 'html',
              'default' => '<p>正在施工……若您看到了这段话，请联系站长补充。</p>',
              'description' => '若希望整个页面使用短代码，请点击“源代码”按钮，然后粘贴内容，最后点击“保存”。',
            ],
            'use_shortcode' => [
              'label' => '解析短代码？',
              'description' => '一般情况下不需要修改这个选项。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'terms' => [
          'title' => '网站规则/使用协议/版权声明',
          '_group' => 'G6',
          'description' => '<a href="../' . url('terms') . '">进入页面</a>',
          'options' => [
            'icon' => [
              'label' => '页面图标',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>），留空则不显示图标',
              'type' => 'text',
              'default' => 'las la-edit',
            ],
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '网站规则',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => 'Site Rules',
            ],
            'content' => [
              'label' => '页面内容',
              'type' => 'html',
              'default' => '<p>本页面介绍了本站的网站规则/使用协议/版权声明。若您看到了这段话，请联系站长补充。</p>',
              'description' => '若希望整个页面使用短代码，请点击“源代码”按钮，然后粘贴内容，最后点击“保存”。',
            ],
            'use_shortcode' => [
              'label' => '解析短代码？',
              'description' => '一般情况下不需要修改这个选项。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'privacy' => [
          'title' => '隐私政策',
          '_group' => 'G6',
          'description' => '<a href="../' . url('privacy') . '">进入页面</a>',
          'options' => [
            'icon' => [
              'label' => '页面图标',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>），留空则不显示图标',
              'type' => 'text',
              'default' => 'las la-edit',
            ],
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '隐私政策',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => 'Privacy Policy',
            ],
            'content' => [
              'label' => '页面内容',
              'type' => 'html',
              'default' => '<p>本页面介绍本站的隐私政策。若您看到了这段话，请联系站长补充。</p>',
              'description' => '若希望整个页面使用短代码，请点击“源代码”按钮，然后粘贴内容，最后点击“保存”。',
            ],
            'use_shortcode' => [
              'label' => '解析短代码？',
              'description' => '一般情况下不需要修改这个选项。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'contact' => [
          'title' => '联系我们',
          '_group' => 'G6',
          'description' => '<a href="../' . url('contact_us') . '">进入页面</a>',
          'options' => [
            'icon' => [
              'label' => '页面图标',
              'description' => '输入 <a href="https://igoutu.cn/line-awesome">Line Awesome</a> 图标名称（中的<span class="text-success">标绿部分</span>），留空则不显示图标',
              'type' => 'text',
              'default' => 'las la-edit',
            ],
            'title' => [
              'label' => '页面标题',
              'type' => 'text',
              'default' => '联系我们',
            ],
            'subtitle' => [
              'label' => '页面副标题',
              'type' => 'text',
              'default' => 'Contact Us',
            ],
            'content' => [
              'label' => '页面内容',
              'type' => 'html',
              'default' => '<h3>网站问题、举报投诉、建议意见</h3><ul><li>Email：</li><li>QQ群：</li></ul><p>或者到建议以及意见反馈专区发帖。</p><h3>商务合作</h3><ul><li>联系人：</li><li>Email：</li><li>QQ：</li></ul><p>若您看到了这段话，请联系站长补充。</p>',
              'description' => '若希望整个页面使用短代码，请点击“源代码”按钮，然后粘贴内容，最后点击“保存”。',
            ],
            'use_shortcode' => [
              'label' => '解析短代码？',
              'description' => '一般情况下不需要修改这个选项。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
      ],
    ],
    'special' => [
      'title' => '特色功能',
      'sections' => [
        'the_modal' => [
          'title' => '全局-访问弹窗',
          '_group' => 'G1',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用后，访问网站的人会看到弹窗，可被关闭。适合用作网站公告等。',
              'type' => 'toggle',
              'default' => false
            ],
            'duration' => [
              'label' => '弹窗关闭后不再显示的时长',
              'type' => 'select',
              'default' => 168,
              'choices' => [
                0 => '一直显示',
                24 => '关闭后一天内不再显示',
                48 => '关闭后两天内不再显示',
                72 => '关闭后三天内不再显示',
                168 => '关闭后一周内不再显示',
                720 => '关闭后一个月（30天）内不再显示',
                2160 => '关闭后三个月（90天）内不再显示',
                8760 => '关闭后一年内不再显示',
                PHP_INT_MAX => '关闭后永远不再显示'
              ],
            ],
            'do_not_show_after_login' => [
              'label' => '登录后不显示',
              'description' => '启用此设置可以在用户登录后不再显示弹窗。如果您的网站需要平衡用户体验和营销效果，可以根据需要启用此功能。',
              'type' => 'toggle',
              'default' => false,
            ],
            'title' => [
              'label' => '弹窗标题',
              'type' => 'text',
              'default' => 'Hello, world!',
            ],
            'content' => [
              'label' => '弹窗内容',
              'type' => 'html',
              'default' => '<p>如果你看到了这个，请点击“确定”，然后联系站长。</p>',
            ],
            'content_btn_close' => [
              'label' => '关闭按钮内容',
              'type' => 'text',
              'default' => '我知道了'
            ]
          ],
        ],
        'new_context_menu' => [
          'title' => '全局-新版右键菜单',
          '_group' => 'G1',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'type' => 'radio-image',
              'description' => implode('<br>', [
                '新版右键菜单将为用户带来“前所未有”的浏览体验！它与主题的主题设计风格完美融合，不仅美观，而且也很实用。',
                '以下是所有可用的操作： ',
                ' ',
                '- 通用操作：会出现在菜单顶部',
                '- - 返回',
                '- - 前进',
                '- - 刷新',
                '- - 回到主页：返回网站主页 ',
                ' ',
                '- 文本操作：选中文字后，按右键',
                '- - 复制文本',
                '- - 站内搜索：在网站内搜索选中的文字',
                '- - 第三方搜索：直接在指定搜索引擎内进行搜索，节省时间',
                ' ',
                '- 超链接操作：在超链接上按右键',
                '- - 复制链接文字：复制链接所包含的文字',
                '- - 复制链接地址：复制链接的URL地址',
                '- - 打开链接：在当前标签页中打开链接 ',
                '- - 新窗口打开链接：在新标签页中打开链接',
                ' ',
                '- 图片操作：在图片上按右键',
                '- - 复制图片：复制选定的图片',
                '- - 复制图片地址：复制图片的URL地址',
                ' ',
                '- 文本操作：在文本输入框上按右键',
                '- - 全选',
                '- - 剪切',
                '- - 复制',
                '- - 粘贴',
                ' ',
                '- 其他操作：不在上述区域按右键',
                '- - 打印：方便快捷地打印当前页面。',
                '- - 收藏页面：将当前页面添加到书签收藏夹，方便以后访问。不是所有浏览器都支持这个操作。',
                '- - 关闭页面：关闭当前标签页。慎用。',
                '- - 自定义链接：如果你在使用菜单插件，可以在“右键菜单自定义链接”槽位中填写自己的链接。注意：该区域暂不支持二级菜单。',
                ' ',
                '按住Ctrl键再点击右键，就能打开浏览器右键菜单。在只在电脑端有效。'
              ]),
              'default' => 0,
              'choices' => [
                0 => [
                  'label' => '否，使用原版菜单',
                  'url' => $stately_setting_img_url_prefix . 'special.new_context_menu.style.classic.png'
                ],
                1 => [
                  'label' => '是，使用新版菜单',
                  'url' => $stately_setting_img_url_prefix . 'special.new_context_menu.style.modern.png'
                ],
              ]
            ],
          ],
        ],
        'quickthread_modal' => [
          'title' => '主页和论坛版块-快速发帖框',
          '_group' => 'G3',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用此设置可以在网站主页或论坛版块页的帖子列表顶部显示一个只有登录用户可以看到的“快速发帖框”弹窗，可以快速地在当前页面发帖，提高用户参与互动的积极性。',
              'type' => 'toggle',
              'default' => true,
            ],
          ]
        ],
        'thread_toc' => [
          'title' => '帖子详情-帖子内容目录',
          '_group' => 'G4',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '选择“是”，如果帖子里含有至少一个“二级标题”，则自动生成并显示目录。此功能可以帮助用户更好地浏览和理解帖子内容。',
              'type' => 'toggle',
              'default' => true
            ],
            'position' => [
              'label' => '显示位置',
              'type' => 'radio',
              'default' => 'auto',
              'choices' => [
                'side' => '侧边',
                'in_thread' => '帖子内（靠右）',
                'auto' => '自动决定（电脑端在侧边，移动端在帖子内）'
              ]
            ]
          ],
        ],
        'thread_charcount_read_time' => [
          'title' => '帖子详情-字数与阅读时间',
          '_group' => 'G4',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '选择“是”将在帖子正文之前显示字数与预估阅读时间。',
              'type' => 'toggle',
              'default' => true
            ],
            'reading_speed' => [
              'label' => '每分钟读多少字',
              'type' => 'number',
              'description' => '如果您觉得该数值不准确，可以按照以下步骤进行测试： 
              <br><br>1. 选择一段您感兴趣的文章或文本。 
              <br>2. 设置一分钟计时器并启动。 
              <br>3. 开始阅读选定的文章，并在一分钟结束时停止阅读。 
              <br>4. 记下您在一分钟内阅读的字数。
              <br><br>重复这个过程几次，然后计算平均值，这样您就可以知道自己一分钟大约能够阅读多少字了。
              <br><br>一分钟能读多少字取决于个人的阅读速度和能力。根据研究和统计数据，一般成年人的阅读速度在每分钟200到300个字之间。然而，有些人可能具有更快的阅读速度，可以达到每分钟400字甚至更多。',
              'default' => 250,
              'min' => 1,
              'max' => 1000,
              'step' => 1,
            ],
            'template' => [
              'label' => '显示内容',
              'type' => 'text_html',
              'description' => '变量：%1$s - 字数，%2$s - 阅读时间（分钟）。',
              'default' => '<p class=\'lead text-center text-muted\'>本文共计%1$s个字，预计阅读时长%2$s分钟。</p>',
            ],
          ],
        ],
        'share_card_modal' => [
          'title' => '帖子详情-分享弹窗',
          '_group' => 'G4',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用后，可在论坛帖子页面中使用分享功能。分享方式包含复制网址、QQ、QQ空间、微博、二维码。如果你已经安装了其他分享插件，可以将其关闭。',
              'type' => 'toggle',
              'default' => true
            ],
            'position' => [
              'label' => '显示位置',
              'type' => 'radio',
              'default' => 'thread_plugin_body',
              'choices' => [
                'thread_views_after' => '帖子正文之前，“访问数量”附近',
                'thread_plugin_body' => '帖子正文之后',
                'thread_fab' => '帖子左侧浮动按钮（确保“外观—板式微调→帖子详情-通用→显示悬浮按钮”为“是”，否则不显示）',
              ],
            ],
            'shows_on_reading_mode'  => [
              'label' => '出现在阅读模式中？',
              'type' => 'toggle',
              'default' => true,
            ],
          ],
        ],
        'print_btn' => [
          'title' => '帖子详情-打印按钮',
          '_group' => 'G4',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用后，可在论坛帖子页面中使用打印功能。使用这个按钮可以只打印帖子内容。',
              'type' => 'toggle',
              'default' => true
            ],
            'position' => [
              'label' => '显示位置',
              'type' => 'radio',
              'default' => 'thread_plugin_body',
              'choices' => [
                'thread_views_after' => '帖子正文之前，“访问数量”附近',
                'thread_plugin_body' => '帖子正文之后',
                'thread_fab' => '帖子左侧浮动按钮（确保“外观—板式微调→帖子详情-通用→显示悬浮按钮”为“是”，否则不显示）',
              ],
            ],
            'shows_on_reading_mode'  => [
              'label' => '出现在阅读模式中？',
              'type' => 'toggle',
              'default' => true,
            ]
          ],
        ],
        'thread_reading_mode' => [
          'title' => '帖子详情-阅读模式',
          '_group' => 'G4',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用阅读模式后，页面上会显示阅读模式按钮（具体位置见下设置）。当用户点击该按钮时，页面将只显示帖子主体，隐藏其他干扰性的元素，如导航栏。侧边栏等，提供更清晰的阅读环境。',
              'type' => 'toggle',
              'default' => true
            ],
            'position' => [
              'label' => '显示位置',
              'type' => 'radio',
              'default' => 'thread_plugin_body',
              'choices' => [
                'thread_views_after' => '帖子正文之前，“访问数量”附近',
                'thread_plugin_body' => '帖子正文之后',
                'thread_fab' => '帖子左侧浮动按钮（确保“外观—板式微调→帖子详情-通用→显示悬浮按钮”为“是”，否则不显示）',
              ],
            ],
          ],
        ],
        'quickpost_modal' => [
          'title' => '帖子详情-快速回帖框',
          '_group' => 'G4',
          '_cols' => 2,
          'options' => [
            'style' => [
              'label' => '快速回帖框风格',
              'description' => '实验性功能；标准：标准回帖框，一般在回帖列表下方；按钮：显示按钮，点击显示回帖框弹窗；固定：在屏幕底部固定显示回帖框。',
              'type' => 'select',
              'default' => 'default',
              'choices' => [
                'default' => '标准',
                'button' => '按钮',
                'fixed' => '固定'
              ]
            ],
            'text' => [
              'label' => '占位文字',
              'description' => '如“发表评论”；用于“按钮”风格的按钮文字和“固定”风格的占位文字。',
              'type' => 'text',
              'default' => '发表评论',
            ],
          ],
        ],
        'post_floor_replace' => [
          'title' => '帖子详情-楼层数替换',
          '_group' => 'G4',
          '_cols' => 2,
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用后，可替换最多十个回帖（含楼主）的显示内容，留空则不替换。此功能可增加网站的“趣味性”。',
              'type' => 'toggle',
              'default' => true,
            ],
            'floor_1' => [
              'label' => '1楼（楼主）',
              'type' => 'text',
              'default' => '楼主'
            ],
            'floor_2' => [
              'label' => '2楼',
              'type' => 'text',
              'default' => '沙发'
            ],
            'floor_3' => [
              'label' => '3楼',
              'type' => 'text',
              'default' => '藤椅'
            ],
            'floor_4' => [
              'label' => '4楼',
              'type' => 'text',
              'default' => '板凳'
            ],
            'floor_5' => [
              'label' => '5楼',
              'type' => 'text',
              'default' => '报纸'
            ],
            'floor_6' => [
              'label' => '6楼',
              'type' => 'text',
              'default' => '地板'
            ],
            'floor_7' => [
              'label' => '7楼',
              'type' => 'text',
              'default' => '站着吧'
            ],
            'floor_8' => [
              'label' => '8楼',
              'type' => 'text',
              'default' => '不许哭'
            ],
            'floor_9' => [
              'label' => '9楼',
              'type' => 'text',
              'default' => '哭也没用'
            ],
            'floor_10' => [
              'label' => '10楼',
              'type' => 'text',
              'default' => '再哭打你'
            ],
          ]
        ],
        'my_thread_search' => [
          'title' => '个人中心-论坛帖子搜索',
          '_group' => 'G5',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用后，可在个人中心的论坛帖子页面中搜索自己的帖子。仅在搜索插件安装并启用时可用。',
              'type' => 'toggle',
              'default' => false
            ],
          ],
        ],
        'new_notice_page' => [
          'title' => '个人中心-消息通知页面',
          '_group' => 'G5',
          'options' => [
            'enable' => [
              'label' => '模式',
              'type' => 'radio-image',
              'description' => '启用新版页面后，用户可以享受到更加丰富和整洁的通知管理体验。新版页面将通知将收纳至五大类：<br>回复我的（原版分类）<br>@ 我的（由“帖子增强”插件提供）<br>收到的赞（由“帖子点赞”插件提供）<br>系统消息（原版分类，现在包含更多类别的消息）<br>私信：显示联系过的用户（由“私信”插件提供）<br><br>如果看不到对应分类，可能是因为你没有安装并启用指定的插件。',
              'default' => 0,
              'choices' => [
                -1 => [
                  'label' => '使用原版页面，集成到个人中心里',
                  'url' => $stately_setting_img_url_prefix . 'special.new_notice_page.style.vintage.png'
                ],
                0 => [
                  'label' => '使用原版页面，独立页面',
                  'url' => $stately_setting_img_url_prefix . 'special.new_notice_page.style.classic.png'
                ],
                1 => [
                  'label' => '使用新版页面，独立页面',
                  'url' => $stately_setting_img_url_prefix . 'special.new_notice_page.style.modern.png'
                ],
              ]
            ],
          ]
        ],
        'notice_sound' => [
          'title' => '全局-消息通知提示音',
          '_group' => 'G1',
          'options' => [
            'enable' => [
              'label' => '启用？',
              'description' => '启用后，当用户有未读通知时会发出提示音。',
              'type' => 'toggle',
              'default' => false,
            ],
            'choice' => [
              'label' => '选择提示音',
              'type' => 'select',
              'default' => 'sound-01.ogg',
              'choices' => [
                'custom' => '自定义',
                'sound-01.ogg' => '01',
                'sound-02.ogg' => '02',
                'sound-03.ogg' => '03',
                'sound-04.ogg' => '04',
                'sound-05.ogg' => '05',
                'sound-06.ogg' => '06',
                'sound-07.ogg' => '07',
                'sound-08.ogg' => '08',
                'sound-09.ogg' => '09',
                'sound-10.ogg' => '10',
                'sound-11.ogg' => '11',
                'sound-12.ogg' => '12',
                'sound-13.ogg' => '13',
              ],
            ],
            'custom_sound_url' => [
              'label' => '自定义提示音URL',
              'description' => '上一项选择“自定义”时会使用这里输入的URL作为提示音。',
              'type' => 'text',
              'default' => './plugin/abs_theme_stately/view/sfx/sound-01.ogg'
            ]
          ]
        ],
      ],
    ],
    'custom_code' => [
      'title' => '自定义代码',
      'sections' => [
        'css' => [
          'title' => 'CSS',
          'options' => [
            'header' => [
              'label' => '自定义CSS',
              'description' => '对网站显示效果的个性化定制。',
              'type' => 'textarea_html',
              'default' => ''
            ],
          ]
        ],
        'javascript' => [
          'title' => 'JavaScript',
          'options' => [
            'before_body' => [
              'label' => 'body之前',
              'description' => '需要包含script标签；',
              'type' => 'textarea_html',
              'default' => ''
            ],
            'after_body' => [
              'label' => 'body之后',
              'description' => '需要包含script标签；统计代码放在这里',
              'type' => 'textarea_html',
              'default' => ''
            ],
          ]
        ],
      ],
    ],/*
    'wellcms_ui_style' => [
      'title' => 'WellCMS—板式',
      'description' => '<strong>本页面所有设置仅在安装了 WellCMS X 后才有意义！</strong><br>在安装好 WellCMS X 后，请删除或重命名<code>plugin\well_cms_x\view\css\wellcms_x.css</code>文件，否则某些主题设置将会失效。<br><br> “设置 - 网站 - 模板模式”必须设置为“自适应”，否则网站会坍塌！',
      'sections' => [
        'homepage_portal' => [
          'title' => '首页 - 门户模式',
          'description' => '<strong>本页面所有设置仅在安装了 WellCMS X 后才有意义！</strong><br>在安装好 WellCMS X 后，请删除或重命名<code>plugin\well_cms_x\view\css\wellcms_x.css</code>文件，否则某些主题设置将会失效。<br><br> “设置 - 网站 - 网站模式”设置为“门户”；<br><b>如何让栏目在门户模式出现？</b> 编辑栏目，选择“显示”选项卡，然后在“首页显示”里选择“是”，然后再将“首页最新”设置为一个合理的数字（比如10）即可。',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'default' => 'classic',
              'choices' => [
                'classic' => [
                  'label' => '经典',
                  'url' => $stately_setting_img_url_prefix . 'wellcms_ui_style.homepage_portal.layout.classic_2col.png'
                ],
              ],
            ],
          ],
        ],
        'homepage_flat' => [
          'title' => '首页 - 扁平模式',
          'description' => '“设置 - 网站 - 网站模式”设置为“扁平”',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'default' => 'classic_2col',
              'choices' => [
                'classic_2col' => [
                  'label' => '经典（双栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_2col.png'
                ],
                'classic_1col' => [
                  'label' => '经典（单栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_1col.png'
                ],
              ],
            ],
          ],
        ],
        'forum' => [
          'title' => '栏目/分类',
          'options' => [
            'layout' => [
              'label' => '板式',
              'type' => 'radio-image',
              'default' => 'classic_2col',
              'choices' => [
                'classic_2col' => [
                  'label' => '经典（双栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_2col.png'
                ],
                'classic_1col' => [
                  'label' => '经典（单栏）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.layout.classic_1col.png'

                ],
              ],
            ],
            'style_forum_info' => [
              'label' => '栏目/分类信息风格',
              'type' => 'radio-image',
              'default' => 'top_v1',
              'choices' => [
                'side_classic' => [
                  'label' => '经典（侧边）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.side_classic.png'
                ],
                'top_v1' => [
                  'label' => '现代V1（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_v1.png'
                ],
                'top_compact' => [
                  'label' => '紧凑（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_compact.png'
                ],
                'top_compact_v2' => [
                  'label' => '紧凑V2（顶部）',
                  'url' => $stately_setting_img_url_prefix . 'ui_style.forum.style_forum_info.top_compact_v2.png'
                ],
              ],
            ],
          ],
        ],
        'threadlist' => [
          'title' => '帖子列表',
          'options' => [
            'style_global' => [
              'label' => '帖子列表风格（全局）',
              'type' => 'radio-image',
              'default' => 'sns_v1',
              'choices' => [
                'blog_v2_top' => ['label' => '图文列表（宽松）（图在顶部）【博客风格】 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.blog_v2_top.png'],
                'blog_v1' => ['label' => '图文列表（宽松）（图在中间）【博客风格】 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.blog_v1.png'],
                'blog_v2_bottom' => ['label' => '图文列表（宽松）（图在底部）【博客风格】 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.blog_v2_bottom.png'],
                'graphic-list_v1_left' => ['label' => '图文列表（侧边）（图在左侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list_v1_left.png'],
                'graphic-list_v1_right' => ['label' => '图文列表（侧边）（图在右侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list_v1_right.png'],
                'graphic-list-overhang_v1_top' => ['label' => '图文列表（悬挂）（图在顶部） *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-overhang_v1_top.png'],
                'graphic-list-overhang_v1_left' => ['label' => '图文列表（悬挂）（图在左侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-overhang_v1_left.png'],
                'graphic-list-overhang_v1_right' => ['label' => '图文列表（悬挂）（图在右侧） *1/2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-overhang_v1_right.png'],
                'graphic-list-compact_v1_top' => ['label' => '图文列表（紧凑）（图在顶部） *1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-compact_v1_top.png'],
                'graphic-list-compact_v1_middle' => ['label' => '图文列表（紧凑）（图在中间）【大图样式】 *1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-compact_v1_middle.png'],
                'graphic-list-compact_v1_bottom' => ['label' => '图文列表（紧凑）（图在底部） *1/2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.graphic-list-compact_v1_bottom.png'],
                'image_v1' => ['label' => '图片列表 *2/3/4栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.image_v1.png'],
                'super-compact_v1' => ['label' => '超紧凑列表V1【线报】*1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.threadlist.super-compact_v1.png'],
              ],
            ],
            'cols_count_global' => [
              'label' => '栏数（全局）',
              'description' => '一行有几个帖子？',
              'type' => 'select',
              'default' => 12,
              'choices' => [
                12 => '1栏',
                6 => '2栏',
                4 => '3栏',
                3 => '4栏',
              ],
            ],
            'style_for_forum' => [
              'label' => '帖子列表风格（单独）',
              'description' => '覆盖上述设置。',
              'type' => 'dropdown_per_forum',
              'choices' => [
                '_inherit' => '使用全局设置',
                'blog_v2_top'                    => '图文列表（宽松）（图在顶部）【博客风格】 *2/3/4栏*',
                'blog_v1'                        => '图文列表（宽松）（图在中间）【博客风格】 *2/3/4栏*',
                'blog_v2_bottom'                 => '图文列表（宽松）（图在底部）【博客风格】 *2/3/4栏*',
                'graphic-list-overhang_v1_top'   => '图文列表（悬挂）（图在顶部） *2/3/4栏*',
                'graphic-list-overhang_v1_left'  => '图文列表（悬挂）（图在左侧） *1/2栏*',
                'graphic-list-overhang_v1_right' => '图文列表（悬挂）（图在右侧） *1/2栏*',
                'graphic-list_v1_left'           => '图文列表（侧边）（图在左侧） *1/2栏*',
                'graphic-list_v1_right'          => '图文列表（侧边）（图在右侧） *1/2栏*',
                'graphic-list-compact_v1_top'    => '图文列表（紧凑）（图在顶部） *1/2/3/4栏*',
                'graphic-list-compact_v1_middle' => '图文列表（紧凑）（图在中间）【大图样式】 *1/2/3/4栏*',
                'graphic-list-compact_v1_bottom' => '图文列表（紧凑）（图在底部） *1/2/3/4栏*',
                'image_v1'                       => '图片列表 *2/3/4栏*',
                'super-compact_v1'               => '超紧凑列表V1【线报】*1栏*',
              ],
            ],
            'cols_count_for_forum' => [
              'label' => '栏数（单独）',
              'description' => '覆盖上述设置。',
              'type' => 'dropdown_per_forum',
              'choices' => [
                '_inherit' => '使用全局设置',
                12 => '1栏',
                6 => '2栏',
                4 => '3栏',
                3 => '4栏',
              ],
            ],
          ],
        ],
        'thread' => [
          'title' => '帖子详情',
          'options' => [
            'style_global' => [
              'label' => '帖子详情风格（全局）',
              'type' => 'radio-image',
              'default' => 'top_default',
              'choices' => [
                'classic_v1' => ['label' => '经典V1 *2栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.classic_v1.png'],
                'blog' => ['label' => '博客 *1栏*', 'url' => $stately_setting_img_url_prefix . 'ui_style.thread.blog.png'],
              ],
            ],
            'style_for_forum' => [
              'label' => '帖子详情风格（单独）',
              'description' => '覆盖上述设置。',
              'type' => 'dropdown_per_forum',
              'choices' => [
                '_inherit'   => '使用全局设置',
                'classic_v1' => '经典V1 *2栏*',
                'blog'       => '博客 *1栏*',
              ],
            ],
          ],
        ],
      ],
    ],
    'wellcms_ui_tweek' => [
      'title' => 'WellCMS—板式微调',
      'description' => '<strong>本页面所有设置仅在安装了 WellCMS X 后才有意义！</strong><br>在安装好 WellCMS X 后，请删除或重命名<code>plugin\well_cms_x\view\css\wellcms_x.css</code>文件，否则某些主题设置将会失效。<br><br>',
      'sections' => []
    ],*/
    'advanced' => [
      'title' => '高级设置',
      'sections' => [
        'selftest_js' => [
          'title' => '前端JS自检',
          '_group' => '',
          'options' => [
            'enable' => [
              'label' => '启用JS自检？',
              'description' => '启用此设置可以自动检测网站前端的JS文件是否加载成功。如果发现加载失败，将会通过弹窗的形式和“开发者工具”的控制台输出具体哪个文件加载失败，以便用户向站长反馈问题或站长及时修复问题。但不建议一直启用此功能，以免影响网站性能。只涵盖了Xiuno BBS内置JS和主题使用的JS。',
              'type' => 'toggle',
              'default' => false,
            ],
            'why' => [
              'label' => '急速排查',
              'type' => 'label',
              'default' => implode('<br>', [
                '“加密后长度有问题” => md5.js加载失败，导致的“加密”失败。',
                '“加密后长度有问题” => jQuery被重复引用，造成冲突。',
                '新版消息页面在点击分类后，显示Undefined，开启Debug模式后显示-101错误（或类似的错误） => 伪静态没有正确设置，需要重新设置一遍。<a href=https://xiunobbs.cn/thread-2.htm>请参考该文章</a>',
              ])
            ],
          ],
        ],
        'minify' => [
          'title' => '页面压缩（Minify）',
          '_group' => '',
          'options' => [
            'enable' => [
              'label' => '启用页面压缩（Minify）功能？【总开关】',
              'description' => '该功能可以压缩HTML+CSS+JS代码，从而减少页面大小，提高页面加载速度。经过测试，页面大小分别会减少：<br>- HTML: 减少约10%至20%的大小<br>- CSS：减少约30%至40%的大小<br>- JavaScript：<abbr title="（JavaScript代码由于通常包含大量可优化的空白、注释和重复代码，因此压缩效果尤为显著）">减少约70%至90%的大小</abbr><br><br><b>重要提示：</b>虽然页面压缩功能可以带来显著的性能提升，但它也有可能影响页面的最终显示效果。<small>这是因为某些CSS或JS代码可能依赖于特定的格式或空白字符。</small>如果您在启用压缩功能后发现页面布局或功能出现问题，请禁用该功能。<br><br><b>重要提示2：</b>该功能不支持外部来源的CSS与JS代码。如果你更改过“危险区域”中的“插件自身位置(前端)”，请慎重考虑启用该功能。',
              'type' => 'toggle',
              'default' => false,
            ],
            'enable_html' => [
              'label' => '压缩HTML？',
              'type' => 'toggle',
              'default' => true,
            ],
            'enable_css' => [
              'label' => '压缩CSS？',
              'description' => '若遇到问题，可选“否”。',
              'type' => 'toggle',
              'default' => true,
            ],
            'enable_js' => [
              'label' => '压缩JS？',
              'description' => '若遇到问题，可选“否”。',
              'type' => 'toggle',
              'default' => true,
            ],
          ],
        ],
        'threadlist' => [
          'title' => '帖子列表 魔法菜单项',
          'options' => [
            'do_not_use_cache' => [
              'label' => '不使用缓存',
              'description' => '如果遇到帖子列表无法获取的问题，请选择“是”。可能会导致网站变慢。',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'fuck_you_hacker' => [
          'title' => '禁止打开浏览器控制台',
          'options' => [
            'enable' => [
              'label' => '启用功能？',
              'description' => '选择“是”，鼠标右击网页不会弹出任何东西，打开浏览器开发者工具会直接卡死或者自动关闭页面。<b>该功能特别强力，且十分不符合“<a href="https://baike.baidu.com/item/%E4%BA%92%E8%81%94%E7%BD%91%E7%B2%BE%E7%A5%9E/9867749">互联网精神</a>”，必定会干扰到正常的调试过程，请三思而后行。</b>',
              'type' => 'toggle',
              'default' => false,
            ],
          ],
        ],
        'pwa' => [
          'title' => 'PWA',
          'options' => [
            'enable' => [
              'label' => '启用PWA相关功能？',
              'description' => '包括ServiceWorker;实验性功能，可能无法使用',
              'type' => 'hidden',
              'default' => false,
            ],
          ],
        ],
      ],
    ],
  ],
  'kumquat_config' => [ /* 金桔框架——框架设置 */
    'allow_delete_plugin_settings' => true, /* 允许删除插件设置 */
    'allow_reset_settings' => false, /* 允许重置插件设置 */
    'show_all_vars_table' => false, /* 显示“全部变量”框，只在调试模式显示 */
  ],
  'kumquat_flag' => [ /* 金桔框架——FLAG；保存在插件设置中，除非有必要，否则勿动 */
    'delete_plugin_settings' => true, /* 删除插件设置，若为true则会在卸载时删除插件设置 */
    'reset_settings' => false, /* 重置插件设置，若为true则重置 */
  ],
);
/* 【结束】配置 */