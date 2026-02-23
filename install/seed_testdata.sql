-- ============================================
-- Shelf-5 Sample Test Data
-- Content sourced from reference forum sites
-- for design/layout testing purposes.
-- ============================================

-- Sample forums (boards)
INSERT INTO `bbs_forum` (`fid`, `name`, `rank`, `threads`, `todayposts`, `brief`) VALUES
(2, '站务公告', 99, 11, 0, '站点公告、版主管理办公交流处'),
(3, '综合交流', 90, 277, 5, '自由交流、灌水闲聊、新手报到'),
(4, '技术分享', 80, 488, 20, '编程开发、系统运维、网络安全技术交流'),
(5, '资源分享', 70, 256, 3, '软件工具、学习资料、实用资源分享'),
(6, '游戏专区', 60, 65, 2, '游戏攻略、游戏讨论、电竞交流'),
(7, '数码科技', 50, 17, 0, '手机电脑、数码产品、科技资讯讨论')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `rank`=VALUES(`rank`), `threads`=VALUES(`threads`), `todayposts`=VALUES(`todayposts`), `brief`=VALUES(`brief`);

-- Sample users
INSERT INTO `bbs_user` (`uid`, `gid`, `email`, `username`, `password`, `salt`, `threads`, `posts`, `credits`, `create_date`) VALUES
(2, 101, 'test1@example.com', '技术大牛', 'd98bb50e808918dd45a8d92feafc4fa3', '123456', 45, 230, 1500, UNIX_TIMESTAMP()-86400*60),
(3, 101, 'test2@example.com', '资源搬运工', 'd98bb50e808918dd45a8d92feafc4fa3', '123456', 88, 156, 2200, UNIX_TIMESTAMP()-86400*45),
(4, 101, 'test3@example.com', '游戏玩家', 'd98bb50e808918dd45a8d92feafc4fa3', '123456', 22, 340, 980, UNIX_TIMESTAMP()-86400*30),
(5, 101, 'test4@example.com', '新手小白', 'd98bb50e808918dd45a8d92feafc4fa3', '123456', 5, 42, 120, UNIX_TIMESTAMP()-86400*7),
(6, 101, 'test5@example.com', '科技爱好者', 'd98bb50e808918dd45a8d92feafc4fa3', '123456', 33, 189, 1800, UNIX_TIMESTAMP()-86400*90)
ON DUPLICATE KEY UPDATE `username`=VALUES(`username`), `threads`=VALUES(`threads`), `posts`=VALUES(`posts`);

-- Sample threads (content inspired by reference forums)
INSERT INTO `bbs_thread` (`fid`, `tid`, `top`, `uid`, `subject`, `create_date`, `last_date`, `views`, `posts`, `firstpid`, `lastuid`, `lastpid`) VALUES
-- 站务公告
(2, 1, 3, 1, '社区规则与发帖须知（新手必读）', UNIX_TIMESTAMP()-86400*90, UNIX_TIMESTAMP()-86400*1, 20918, 86, 1, 5, 15),
(2, 2, 2, 1, '关于赞助本站和开发支持，以及一些想对大家说的话', UNIX_TIMESTAMP()-86400*60, UNIX_TIMESTAMP()-86400*2, 33160, 38, 2, 3, 16),
(2, 3, 1, 1, '新手发帖教程与赚币攻略', UNIX_TIMESTAMP()-86400*45, UNIX_TIMESTAMP()-86400*5, 14180, 207, 3, 4, 17),

-- 综合交流
(3, 4, 0, 2, '鉴于来我们社区的朋友越来越多，特意建一个交流群', UNIX_TIMESTAMP()-86400*30, UNIX_TIMESTAMP()-86400*1, 14180, 278, 4, 5, 18),
(3, 5, 0, 4, '大家平时都在用什么浏览器？推荐一下', UNIX_TIMESTAMP()-86400*15, UNIX_TIMESTAMP()-86400*0, 8880, 137, 5, 2, 19),
(3, 6, 0, 5, '今天注册的新人，请多关照！', UNIX_TIMESTAMP()-86400*3, UNIX_TIMESTAMP()-86400*0, 550, 12, 6, 3, 20),
(3, 7, 0, 3, '分享一个超好用的在线图床，完全免费', UNIX_TIMESTAMP()-86400*7, UNIX_TIMESTAMP()-86400*1, 6090, 31, 7, 6, 21),
(3, 8, 0, 6, '2026年值得关注的开源项目盘点', UNIX_TIMESTAMP()-86400*5, UNIX_TIMESTAMP()-86400*0, 4130, 16, 8, 2, 22),

-- 技术分享
(4, 9, 0, 2, 'PHP 8.4 新特性详解与实战应用', UNIX_TIMESTAMP()-86400*20, UNIX_TIMESTAMP()-86400*2, 15300, 44, 9, 6, 23),
(4, 10, 0, 6, 'Docker容器化部署Xiuno BBS完整教程', UNIX_TIMESTAMP()-86400*14, UNIX_TIMESTAMP()-86400*1, 21290, 31, 10, 2, 24),
(4, 11, 0, 2, 'Nginx反向代理配置优化笔记', UNIX_TIMESTAMP()-86400*10, UNIX_TIMESTAMP()-86400*3, 7920, 18, 11, 3, 25),
(4, 12, 0, 6, 'MySQL 性能优化实战：从慢查询到索引调优', UNIX_TIMESTAMP()-86400*8, UNIX_TIMESTAMP()-86400*0, 12450, 28, 12, 5, 26),
(4, 13, 0, 3, 'Git工作流最佳实践与团队协作指南', UNIX_TIMESTAMP()-86400*6, UNIX_TIMESTAMP()-86400*1, 5670, 15, 13, 2, 27),
(4, 14, 0, 2, 'Linux服务器安全加固实操手册', UNIX_TIMESTAMP()-86400*4, UNIX_TIMESTAMP()-86400*0, 9340, 22, 14, 6, 28),
(4, 15, 0, 6, 'Redis缓存策略与高并发场景实践', UNIX_TIMESTAMP()-86400*2, UNIX_TIMESTAMP()-86400*0, 3200, 9, 15, 3, 29),

-- 资源分享
(5, 16, 0, 3, '万能青年旅店两张专辑 [Hi-Res/无损音质/FLAC]', UNIX_TIMESTAMP()-86400*12, UNIX_TIMESTAMP()-86400*1, 17920, 156, 16, 4, 30),
(5, 17, 0, 3, '2026年全风格高质量资源合集共331首320Kbps', UNIX_TIMESTAMP()-86400*8, UNIX_TIMESTAMP()-86400*0, 8650, 72, 17, 5, 31),
(5, 18, 0, 2, 'JetBrains 全家桶教程与配置技巧合集', UNIX_TIMESTAMP()-86400*6, UNIX_TIMESTAMP()-86400*2, 11230, 45, 18, 6, 32),
(5, 19, 0, 6, 'VS Code 必装插件推荐（2026版）', UNIX_TIMESTAMP()-86400*4, UNIX_TIMESTAMP()-86400*0, 6780, 33, 19, 2, 33),
(5, 20, 0, 3, '免费商用字体合集，设计师必备', UNIX_TIMESTAMP()-86400*2, UNIX_TIMESTAMP()-86400*0, 4560, 21, 20, 5, 34),

-- 游戏专区
(6, 21, 0, 4, '逃离塔科夫新手入门完整攻略（2026赛季）', UNIX_TIMESTAMP()-86400*15, UNIX_TIMESTAMP()-86400*1, 38880, 159, 21, 5, 35),
(6, 22, 0, 4, '常见问题及使用方法视频教程', UNIX_TIMESTAMP()-86400*10, UNIX_TIMESTAMP()-86400*2, 24560, 87, 22, 2, 36),
(6, 23, 0, 5, '好像有点bug，开启后游戏卡顿严重', UNIX_TIMESTAMP()-86400*1, UNIX_TIMESTAMP()-86400*0, 550, 5, 23, 4, 37),
(6, 24, 0, 4, '完整高资配置文件分享', UNIX_TIMESTAMP()-86400*7, UNIX_TIMESTAMP()-86400*1, 8880, 811, 24, 3, 38),

-- 数码科技
(7, 25, 0, 6, 'M4 MacBook Pro 深度体验：值不值得升级？', UNIX_TIMESTAMP()-86400*5, UNIX_TIMESTAMP()-86400*1, 7230, 42, 25, 2, 39),
(7, 26, 0, 2, '2026年最值得买的机械键盘推荐', UNIX_TIMESTAMP()-86400*3, UNIX_TIMESTAMP()-86400*0, 3450, 18, 26, 4, 40),
(7, 27, 0, 5, '求推荐一个4K显示器，预算3000以内', UNIX_TIMESTAMP()-86400*1, UNIX_TIMESTAMP()-86400*0, 890, 8, 27, 6, 41)
ON DUPLICATE KEY UPDATE `subject`=VALUES(`subject`), `views`=VALUES(`views`), `posts`=VALUES(`posts`);

-- Sample posts (first posts for each thread)
INSERT INTO `bbs_post` (`tid`, `pid`, `uid`, `isfirst`, `create_date`, `message`, `message_fmt`) VALUES
(1, 1, 1, 1, UNIX_TIMESTAMP()-86400*90, '欢迎来到社区！请在发帖前阅读以下规则...', '<p>欢迎来到社区！请在发帖前阅读以下规则...</p>'),
(2, 2, 1, 1, UNIX_TIMESTAMP()-86400*60, '首先，在帖子的开头，我代表所有成员向赞助过的朋友表示最真挚的感谢！', '<p>首先，在帖子的开头，我代表所有成员向赞助过的朋友表示最真挚的感谢！</p>'),
(3, 3, 1, 1, UNIX_TIMESTAMP()-86400*45, '新手发帖教程，如何获取积分和金币...', '<p>新手发帖教程，如何获取积分和金币...</p>'),
(4, 4, 2, 1, UNIX_TIMESTAMP()-86400*30, '加群请输入你在社区的昵称或者UID，否则不予通过。群内只做技术交流和解决问题（禁止打广告！）', '<p>加群请输入你在社区的昵称或者UID，否则不予通过。群内只做技术交流和解决问题（禁止打广告！）</p>'),
(5, 5, 4, 1, UNIX_TIMESTAMP()-86400*15, '最近想换个浏览器，大家有什么推荐的吗？Chrome太吃内存了...', '<p>最近想换个浏览器，大家有什么推荐的吗？Chrome太吃内存了...</p>'),
(6, 6, 5, 1, UNIX_TIMESTAMP()-86400*3, '大家好，今天刚注册，以后请多多关照！', '<p>大家好，今天刚注册，以后请多多关照！</p>'),
(7, 7, 3, 1, UNIX_TIMESTAMP()-86400*7, '推荐一个免费图床，上传速度快，支持外链。', '<p>推荐一个免费图床，上传速度快，支持外链。</p>'),
(8, 8, 6, 1, UNIX_TIMESTAMP()-86400*5, '2026年有很多值得关注的开源项目，让我来给大家盘点一下...', '<p>2026年有很多值得关注的开源项目，让我来给大家盘点一下...</p>'),
(9, 9, 2, 1, UNIX_TIMESTAMP()-86400*20, 'PHP 8.4 带来了很多新特性，本文将详细介绍并给出实战示例。', '<p>PHP 8.4 带来了很多新特性，本文将详细介绍并给出实战示例。</p>'),
(10, 10, 6, 1, UNIX_TIMESTAMP()-86400*14, '本教程将带你从零开始使用Docker部署Xiuno BBS，包含完整的docker-compose配置。', '<p>本教程将带你从零开始使用Docker部署Xiuno BBS，包含完整的docker-compose配置。</p>'),
(11, 11, 2, 1, UNIX_TIMESTAMP()-86400*10, 'Nginx反向代理的配置其实不难，关键是理解几个核心指令...', '<p>Nginx反向代理的配置其实不难，关键是理解几个核心指令...</p>'),
(12, 12, 6, 1, UNIX_TIMESTAMP()-86400*8, '慢查询是MySQL性能问题的常见原因，本文将从实战角度分析如何优化。', '<p>慢查询是MySQL性能问题的常见原因，本文将从实战角度分析如何优化。</p>'),
(13, 13, 3, 1, UNIX_TIMESTAMP()-86400*6, 'Git工作流有很多种，本文总结了适合团队协作的最佳实践。', '<p>Git工作流有很多种，本文总结了适合团队协作的最佳实践。</p>'),
(14, 14, 2, 1, UNIX_TIMESTAMP()-86400*4, 'Linux服务器的安全加固是运维的重要工作，本文提供完整的操作手册。', '<p>Linux服务器的安全加固是运维的重要工作，本文提供完整的操作手册。</p>'),
(15, 15, 6, 1, UNIX_TIMESTAMP()-86400*2, 'Redis在高并发场景下的缓存策略选择非常重要，我来分享一些实践经验。', '<p>Redis在高并发场景下的缓存策略选择非常重要，我来分享一些实践经验。</p>'),
(16, 16, 3, 1, UNIX_TIMESTAMP()-86400*12, '万能青年旅店两张专辑高质量无损资源分享', '<p>万能青年旅店两张专辑高质量无损资源分享</p>'),
(17, 17, 3, 1, UNIX_TIMESTAMP()-86400*8, '2026年第一期全风格高质量资源合集', '<p>2026年第一期全风格高质量资源合集</p>'),
(18, 18, 2, 1, UNIX_TIMESTAMP()-86400*6, 'JetBrains全家桶使用技巧大全，包含IDEA、PyCharm、WebStorm等。', '<p>JetBrains全家桶使用技巧大全，包含IDEA、PyCharm、WebStorm等。</p>'),
(19, 19, 6, 1, UNIX_TIMESTAMP()-86400*4, 'VS Code 2026年必装插件推荐，提升开发效率的利器。', '<p>VS Code 2026年必装插件推荐，提升开发效率的利器。</p>'),
(20, 20, 3, 1, UNIX_TIMESTAMP()-86400*2, '精选免费商用字体，设计师必备资源。', '<p>精选免费商用字体，设计师必备资源。</p>'),
(21, 21, 4, 1, UNIX_TIMESTAMP()-86400*15, '逃离塔科夫新手入门完整攻略，从零开始教你玩转塔科夫。', '<p>逃离塔科夫新手入门完整攻略，从零开始教你玩转塔科夫。</p>'),
(22, 22, 4, 1, UNIX_TIMESTAMP()-86400*10, '常见问题汇总及视频使用教程。', '<p>常见问题汇总及视频使用教程。</p>'),
(23, 23, 5, 1, UNIX_TIMESTAMP()-86400*1, '开启工具之后塔科夫有室外图的地方跑步会卡顿，不知道是什么情况。', '<p>开启工具之后塔科夫有室外图的地方跑步会卡顿，不知道是什么情况。内存32G显存8G都没吃满。</p>'),
(24, 24, 4, 1, UNIX_TIMESTAMP()-86400*7, '分享一套完整的高资配置文件，已调试优化。', '<p>分享一套完整的高资配置文件，已调试优化。</p>'),
(25, 25, 6, 1, UNIX_TIMESTAMP()-86400*5, 'M4芯片的MacBook Pro使用了两周，来谈谈真实体验。', '<p>M4芯片的MacBook Pro使用了两周，来谈谈真实体验。</p>'),
(26, 26, 2, 1, UNIX_TIMESTAMP()-86400*3, '2026年各价位段最值得买的机械键盘推荐清单。', '<p>2026年各价位段最值得买的机械键盘推荐清单。</p>'),
(27, 27, 5, 1, UNIX_TIMESTAMP()-86400*1, '求推荐一个4K显示器，主要用来写代码和看视频，预算3000以内。', '<p>求推荐一个4K显示器，主要用来写代码和看视频，预算3000以内。</p>')
ON DUPLICATE KEY UPDATE `message`=VALUES(`message`), `message_fmt`=VALUES(`message_fmt`);

-- Update thread firstpid references
UPDATE `bbs_thread` SET `firstpid`=`tid` WHERE `tid` BETWEEN 1 AND 27;

-- Some reply posts
INSERT INTO `bbs_post` (`tid`, `pid`, `uid`, `isfirst`, `create_date`, `message`, `message_fmt`) VALUES
(1, 28, 5, 0, UNIX_TIMESTAMP()-86400*1, '已阅读，感谢管理员！', '<p>已阅读，感谢管理员！</p>'),
(4, 29, 3, 0, UNIX_TIMESTAMP()-86400*1, '已加群，感谢分享！', '<p>已加群，感谢分享！</p>'),
(5, 30, 6, 0, UNIX_TIMESTAMP()-86400*0, '推荐Firefox，内存占用小很多', '<p>推荐Firefox，内存占用小很多</p>'),
(5, 31, 2, 0, UNIX_TIMESTAMP()-86400*0, 'Edge也不错，基于Chromium但优化了内存', '<p>Edge也不错，基于Chromium但优化了内存</p>'),
(9, 32, 3, 0, UNIX_TIMESTAMP()-86400*2, '属性钩子这个特性太好用了！', '<p>属性钩子这个特性太好用了！</p>'),
(10, 33, 2, 0, UNIX_TIMESTAMP()-86400*1, '这个教程写得很详细，感谢作者！', '<p>这个教程写得很详细，感谢作者！</p>'),
(21, 34, 5, 0, UNIX_TIMESTAMP()-86400*1, '作为新手看完受益匪浅，谢谢大佬！', '<p>作为新手看完受益匪浅，谢谢大佬！</p>'),
(23, 35, 4, 0, UNIX_TIMESTAMP()-86400*0, '这个问题我也遇到了，可能是驱动兼容性问题', '<p>这个问题我也遇到了，可能是驱动兼容性问题</p>'),
(25, 36, 2, 0, UNIX_TIMESTAMP()-86400*1, 'M4确实很强，但价格也不便宜啊', '<p>M4确实很强，但价格也不便宜啊</p>'),
(27, 37, 6, 0, UNIX_TIMESTAMP()-86400*0, '推荐Dell U2723QE，色彩准确适合写代码', '<p>推荐Dell U2723QE，色彩准确适合写代码</p>')
ON DUPLICATE KEY UPDATE `message`=VALUES(`message`);
