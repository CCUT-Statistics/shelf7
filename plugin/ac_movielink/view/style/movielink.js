document.getElementById('video-title').innerText = '今天是'+<?php echo json_encode($weekdays[$dayOfWeek]); ?> +' 当前正在播放：'+<?php echo json_encode($name); ?> +'-'+ <?php echo json_encode($definition); ?>;
        var danmuapi1= 'https://bbs.kuaiyuanpan.com/api/dplayer/';
        // var danmuapi1= 'https://cs.66yunpan.com/danmu/';
        var playID = <?php echo json_encode($url); ?>;
        var danmuid = <?php echo json_encode($id); ?>;
        var playuser = <?php echo json_encode($username); ?>;
        var definition = <?php echo json_encode($definition); ?>;
        var dp = new DPlayer({
            container: document.getElementById('dplayer'),
            screenshot: false,
            autoplay: true,
            video: {
                url: playID, // 您的视频地址，可以是 M3U8、MP4 或 RTMP
                type: 'auto', // 设置为 'auto'，DPlayer 将自动检测视频类型
                customType: {
                    'customHls': function (video, player) {
                        const isHls = /(.m3u8?)$/.test(video.url);
                        if (isHls) {
                            const hls = new Hls();
                            hls.loadSource(video.url);
                            hls.attachMedia(video);
                        } else {
                            // 根据您的需求配置其他格式的播放方式，例如 MP4 和 RTMP
                            const isMp4 = /(.mp4?)$/.test(video.url);
                            const isRtmp = /^rtmp:\/\//.test(video.url);
        
                            if (isMp4) {
                                // 使用 HTML5 播放器播放 MP4
                                video.type = 'video/mp4';
                            } else if (isRtmp) {
                                // 使用 flv.js 播放 RTMP
                                const flvPlayer = flvjs.createPlayer({
                                    type: 'rtmp',
                                    url: video.url
                                });
                                flvPlayer.attachMediaElement(video);
                                flvPlayer.load();
                            }
                        }
                    }
                },
                quality: [
                    { name: definition, url: playID }
                ],
                defaultQuality: 0,
            },
            danmaku: {
                id: danmuid,
                api: danmuapi1,
                maximum:1000,
                user: playuser,
                unlimited: true,
                speedRate: 0.7,
            },
        });
        
        // 违禁词数组（包括大小写）
    var forbiddenWords = ["网站","网", "菠菜", "赌博", "赌博","a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]; // 请将这里的内容替换为你自己的违禁词数组

    // 监听发送弹幕的按钮点击事件
    document.getElementById('danmu-send').addEventListener('click', function () {
        // 获取弹幕文本和颜色
        var text = document.getElementById('danmu-text').value;
        var colorPicker = document.getElementById('color-picker');
        var color = colorPicker.value;

        // 转换弹幕文本和违禁词为小写，以进行大小写不敏感的比较
        var lowercaseText = text.toLowerCase();
        var lowercaseForbiddenWords = forbiddenWords.map(function(word) {
            return word.toLowerCase();
        });

        // 检查弹幕文本是否包含违禁词
        var forbiddenWord = "";
        var containsForbiddenWord = lowercaseForbiddenWords.some(function(word) {
            if (lowercaseText.includes(word)) {
                forbiddenWord = word;
                return true;
            }
            return false;
        });

        // 如果包含违禁词，显示弹窗提示，并阻止发送弹幕
        if (containsForbiddenWord) {
            alert("弹幕中包含违禁词 '" + forbiddenWord + "'，不能发送！");
            return;
        }

        // 构建弹幕数据并发送至弹幕服务器
        if (text) {
            var data = {
                id: danmuid,
                author: playuser,
                time: dp.video.currentTime,
                text: text,
                color: parseInt(color.replace('#', '0x')),
                type: 0 
            };

            fetch(danmuapi1 + 'v3/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(() => {
                // 清空输入框
                document.getElementById('danmu-text').value = '';
                // 调用 DPlayer API 添加弹幕
                dp.danmaku.draw(data);
                // console.log(dp.danmaku);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    });

     window.onload = function () {
    // 存储上一次获取的弹幕数据
    var lastDanmuData = [];
    
    // 标记是否正在获取数据
    var isFetching = false;

    // 函数用于获取并显示弹幕
    function getAndDisplayDanmu() {
        // 如果正在获取数据，则直接返回，避免重复请求
        if (isFetching) {
            console.log('Already fetching data, please wait.');
            return;
        }

        isFetching = true;
        fetch(danmuapi1 + 'v3/?id=' + danmuid)
            .then(response => response.json())
            .then(data => {
                isFetching = false;
                if (!data || !data.data) {
                    console.error('Error: Invalid data');
                    return;
                }

                var danmuList = document.getElementById('danmu-list');
                var newDanmuData = data.data;

                // 比较新旧弹幕数据，仅添加新增的弹幕
                var newDanmus = newDanmuData.filter(danmu => !lastDanmuData.some(d => d[0] === danmu[0] && d[3] === danmu[3] && d[4] === danmu[4]));
                newDanmus.forEach(danmu => {
                    var minutes = Math.floor(danmu[0] / 60);
                    var seconds = (danmu[0] % 60).toFixed(0);
                    var time = minutes + "分" + seconds + "秒";

                    var danmuItem = document.createElement('p');
                    danmuItem.textContent = '['+ danmu[3] + ']' + '发送弹幕:' + danmu[4];
                    var color = '#' + ('000000' + parseInt(danmu[2], 10).toString(16)).slice(-6);
                    danmuItem.style.color = color;
                    danmuList.appendChild(danmuItem);
                });

                // 更新上一次获取的弹幕数据
                lastDanmuData = newDanmuData;

                // 滚动到最底部以显示最新的弹幕
                danmuList.scrollTop = danmuList.scrollHeight;
            })
            .catch((error) => {
                isFetching = false;
                console.error('Error:', error);
            });
    }

    // 初始加载时获取并显示弹幕
    getAndDisplayDanmu();

    // 每隔2秒更新一次弹幕
    setInterval(getAndDisplayDanmu, 2000); // 2000毫秒等于2秒
};
    // 添加跳过片头片尾
    var skipIntroTime = 10; // 设定跳过片头的时间，单位为秒
    var skipOutroTime = 5; // 设定跳过片尾的时间，单位为秒

    // 获取上次观看的进度
    var lastWatchedTime = localStorage.getItem('lastWatchedTime') || 0;

    dp.on('ended', function () {
        var currentQualityIndex = dp.video.qualityIndex;
        if (currentQualityIndex < dp.video.quality.length - 1) {
            var nextQualityUrl = dp.video.quality[currentQualityIndex + 1].url;

            // 记录观看进度
            localStorage.setItem('lastWatchedTime', 0);

            dp.switchQuality(currentQualityIndex + 1);
            dp.video.url = nextQualityUrl;
            dp.play();
        } else {
            console.log('已经是最后一集');
        }
    });

    dp.on('timeupdate', function () {
        if (dp.video.currentTime < skipIntroTime) {
            dp.seek(skipIntroTime);
        }

        var totalDuration = dp.video.duration;
        if (totalDuration && dp.video.currentTime > totalDuration - skipOutroTime) {
            dp.seek(totalDuration - skipOutroTime);
        }

        // 记录当前观看的进度
        localStorage.setItem('lastWatchedTime', dp.video.currentTime);
    });

    // 恢复上次观看的进度
    dp.on('loadedmetadata', function () {
        dp.seek(lastWatchedTime);
    });
    // 加载深色模式
    function theme() {
        Theme = $.cookie('Theme');
        if (Theme == "" || Theme == "null" || Theme == null || Theme == undefined) {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                $.cookie("Theme", "1", { expires: 365 });
            }
        }
    
        if (Theme != "1") {
            loadjscssfile("/plugin/xiunobbs_cn_dark/css/darktheme.css", "css"); // 加载暗色主题
            $.cookie("Theme", "1", { expires: 365 }); // 设置主题为暗色
        } else {
            removejscssfile("/plugin/xiunobbs_cn_dark/css/darktheme.css", "css"); // 移除暗色主题
            $.cookie("Theme", "0", { expires: 365 }); // 设置主题为浅色
        }
    }
    
    // 添加按钮点击事件的监听器
    $('#theme-toggle').click(function() {
        theme(); // 调用 theme() 函数切换主题
    
        // 检查当前主题状态并设置按钮文本
        var themeText = ($.cookie('Theme') == "1") ? "开启观影模式" : "关闭观影模式";
        $(this).text(themeText);
    });