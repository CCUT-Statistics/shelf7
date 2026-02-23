/**
 * At提及用户助手 业务JS
 * 
 * @copyright Tillreetree(https://xiunobbs.cn/user-thread-1109.htm)
 * 
 * Good luck figure it out!
 */

/*=============================================
=                   常量定义                   =
=============================================*/
var TQA_ActiveItemLi = null;
const messageTextarea = document.getElementById("message");
const TQA = document.getElementById("till_quick_at");
const TQA_ResultUl = document.querySelector('#till_quick_at_result');
const TQA_InputUsername = document.getElementById("input_username");
const TQA_PanelResult = document.getElementById('till_quick_at_panel_result');
const TQA_PanelMessage = document.getElementById('till_quick_at_panel_message');
const TQA_PanelPlaceholder = document.getElementById('till_quick_at_panel_placeholder');
const TQA_PanelInitial = document.getElementById('till_quick_at_panel_initial');

let searchDebounceTimer;
let tempInput = null;

/*============  End of 常量定义  =============*/

/*=============================================
=                   业务代码                   =
=============================================*/

// 创建临时的input元素  别问为啥，就是好使
function createTempInput() {
    if (!tempInput) {
        tempInput = document.createElement('input');
        tempInput.id = 'tmpinpt';
        tempInput.type = 'text';
        tempInput.style.position = 'fixed';
        tempInput.style.left = '-9999px';
        tempInput.style.top = '-9999px';
        document.body.appendChild(tempInput);
    }
}

// 销毁临时的input元素  别问为啥，就是好使
function destroyTempInput() {
    if (tempInput) {
        document.body.removeChild(tempInput);
        tempInput = null;
    }
}

// 监听textarea的keydown事件  终极加强版
let timeoutId;

messageTextarea.addEventListener('keydown', function (event) {
    if (event.shiftKey && !event.ctrlKey && !event.altKey && !event.metaKey) {
        createTempInput();
        tempInput.focus();

        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        timeoutId = setTimeout(function () {
            destroyTempInput();
            messageTextarea.focus();
        }, 1000);

        function handleTempInputEvents() {
            tempInput.addEventListener('input', function (inputEvent) {
                if (inputEvent.target.value === '@') {
                    destroyTempInput();
                    clearTimeout(timeoutId);
                    TQA_Invoke();
                } else {
                    insertTextAtCursor(messageTextarea,document.getElementById('tmpinpt').value);
                    destroyTempInput();
                    clearTimeout(timeoutId);
                    messageTextarea.focus();
                }
            }, { once: true });

            tempInput.addEventListener('keydown', function (keyDownEvent) {
                const isArrowKey = ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(keyDownEvent.key);
                if (isArrowKey) {
                    destroyTempInput();
                    clearTimeout(timeoutId);
                    messageTextarea.focus();
                }
            });

            tempInput.addEventListener('keyup', function (keyUpEvent) {
                if (keyUpEvent.key === 'Shift') {
                    destroyTempInput();
                    clearTimeout(timeoutId);
                    messageTextarea.focus();
                }
            });
        }

        handleTempInputEvents();
    }
});



// messageTextarea监听键盘事件 Shift+2=@
messageTextarea.addEventListener('keydown', function (event) {
    let keyCode = event.key || event.keyCode || event.which;
    let keyPressed = String.fromCharCode(keyCode);
    if (event.shiftKey && keyPressed === '2') {
        event.preventDefault();
        TQA_Invoke();
    }
});

// messageTextarea监听键盘事件 直接按下@
messageTextarea.addEventListener("keydown", function (event) {
    if (event.key === "@" || event.key === "＠") {
        event.preventDefault();
        TQA_Invoke();
    }
});

// messageTextarea聚焦时隐藏
messageTextarea.addEventListener("focus", function () {
    TQA_Dispose();
});


// 点击 li 时，写入textarea，隐藏 till_quick_at，聚焦回 textarea
TQA.addEventListener("click", function (e) {
    if (e.target.tagName === "LI") {
        e.preventDefault();
        if (typeof TQA_ActiveItemLi === 'undefined') {
            TQA_ActiveItemLi = e.target;
            TQA_SetActiveItem(TQA_ActiveItemLi);
        }
        TQA_InputIntoMessageTextarea();
    }
});



// 输入用户名的操作，压发
TQA_InputUsername.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        // 按Esc取消操作
        event.preventDefault();
        TQA.style.display = "none";
        messageTextarea.focus();
        return;
    } else if (event.key === 'Backspace' || event.keyCode === 8) {
        // 当没有内容时按退格键，隐藏 till_quick_at，聚焦回 textarea
        if (TQA_InputUsername.value.length === 0) {
            event.preventDefault();
            TQA_Dispose();
        }
        return;

    } else if (event.key === 'ArrowUp') {
        // 按上箭头移动选择项
        event.preventDefault();
        if (typeof TQA_ActiveItemLi === 'undefined') {
            TQA_ActiveItemLi = document.querySelector('#till_quick_at_result li.active');
        }
        let previousLi = TQA_ActiveItemLi.previousElementSibling;
        if (previousLi !== null) {
            while (previousLi && previousLi.style.display === 'none') {
                previousLi = previousLi.previousElementSibling;
            }
            TQA_SetActiveItem(previousLi);
        }
        return;

    } else if (event.key === 'ArrowDown') {
        // 按下箭头移动选择项
        event.preventDefault();
        if (typeof TQA_ActiveItemLi === 'undefined') {
            TQA_ActiveItemLi = document.querySelector('#till_quick_at_result li.active');
        }
        let nextLi = TQA_ActiveItemLi.nextElementSibling;
        if (nextLi !== null) {
            while (nextLi && nextLi.style.display === 'none') {
                nextLi = nextLi.nextElementSibling;
            }
            TQA_SetActiveItem(nextLi);
        }
        return;

    } else if (event.key === 'Enter') {
        // 按回车键选择，写入textarea，隐藏 till_quick_at，聚焦回 textarea
        event.preventDefault();

        if (typeof TQA_ActiveItemLi === 'undefined') {
            TQA_ActiveItemLi = document.querySelector('#till_quick_at_result li.active');
        }
        if (TQA_ActiveItemLi) {
            TQA_InputIntoMessageTextarea();
        } else if (TQA_InputUsername.value.length === 0) {
            event.preventDefault();
            TQA_Dispose();
        }
        return;

    } else {
        // 其他按键，则进行搜索
        TQA_TogglePanel(TQA_PanelPlaceholder.id);
        // 清除之前的定时器
        clearTimeout(searchDebounceTimer);

        // 设置新的定时器
        searchDebounceTimer = setTimeout(function () {
            if (TQA_InputUsername.value.length <= 0) {
                TQA_ResultUl.innerHTML = "";
                return;
            }
            TQA_SearchUsers(TQA_InputUsername.value);
        }, 1000);
    }
});

// 输入用户名的操作，松发
TQA_InputUsername.addEventListener("keyup", function (event) {
    if (event.key === 'Backspace' || event.keyCode === 8) {
        if (TQA_InputUsername.value.length > 0) {
            TQA_TogglePanel(TQA_PanelPlaceholder.id);
            TQA_SearchUsers(TQA_InputUsername.value);
        } else if (TQA_InputUsername.value.length === 0) { 
            TQA_ResultUl.innerHTML = "";
            TQA_TogglePanel(TQA_PanelInitial.id);
        }
    }
});


/**
 * 显示选择框
 * @return {void}
 */
function TQA_Invoke() {

    TQA.style.display = "block";
    TQA_TogglePanel(TQA_PanelInitial.id);

    // 获取光标位置  
    var cursorPosition = messageTextarea.selectionStart;

    // 计算光标所在行的索引  
    var lines = messageTextarea.value.split('\n');
    var lineIndex = 0;
    var charCount = 0;
    while (lineIndex < lines.length - 1 && charCount + lines[lineIndex].length < cursorPosition) {
        charCount += lines[lineIndex].length + 1; // 加1是为了计算换行符  
        lineIndex++;
    }

    // 计算光标相对于textarea顶部的偏移量  
    var lineHeight = parseInt(getComputedStyle(messageTextarea).lineHeight, 10);
    var scrollTop = messageTextarea.scrollTop;
    var paddingTop = parseInt(getComputedStyle(messageTextarea).paddingTop, 10);
    var cursorTop = scrollTop + lineHeight * lineIndex + paddingTop;

    // 计算光标相对于textarea左侧的偏移量  
    var fontSize = parseInt(getComputedStyle(messageTextarea).fontSize, 10);
    var paddingLeft = parseInt(getComputedStyle(messageTextarea).paddingLeft, 10);
    var cursorLeft = 0;
    for (var i = 0; i < cursorPosition; i++) {
        if (messageTextarea.value.charCodeAt(i) === 10) { // 换行符  
            cursorLeft = 0; // 重置cursorLeft，因为新行从左侧开始  
        } else {
            cursorLeft += fontSize * 0.5; // 假设平均字符宽度是字体大小的50%  
        }
    }
    cursorLeft += paddingLeft;

    // 显示选择框并设置其位置  
    TQA.style.top = messageTextarea.offsetTop + cursorTop + 20 + 'px';
    TQA.style.left = messageTextarea.offsetLeft + cursorLeft + 'px';
    TQA.style.display = 'block';
    TQA_InputUsername.focus();
}

/**
 * 写入选择框选中的内容
 * @return {void}
 */
function TQA_InputIntoMessageTextarea() {
    if (TQA_ActiveItemLi !== null) {
        const username = TQA_ActiveItemLi.getAttribute('data-username');
        insertTextAtCursor(messageTextarea, '@' + username + ' ');
    }
    TQA_Dispose();
}

/**
 * 隐藏选择框
 * @return {void}
 */
function TQA_Dispose() {
    TQA.style.display = 'none';
    TQA_TogglePanel(TQA_PanelInitial.id);
    TQA_InputUsername.value = '';
    TQA_ResultUl.innerHTML = '';
    TQA_ActiveItemLi = null;
    messageTextarea.focus();
}

/**
 * 去服务器模糊搜索用户名，并显示在结果列表里
 * @param {string} userKeyword 要搜索的用户名的一部分
 */
function TQA_SearchUsers(userKeyword) {
    const xhr = new XMLHttpRequest();

    let userSearchUrl = url_build('user-atsearch', {
        'ajax': 1,
        'who': encodeURIComponent(userKeyword)
    }, url_rewrite_on);
    xhr.open("GET", userSearchUrl, true);

    xhr.onload = function () {
        if (xhr.status === 200) {

            const response = JSON.parse(xhr.responseText);
            if (Number(response.code) === 0) {
                TQA_TogglePanel(TQA_PanelResult.id);
                TQA_SearchUsersHandleResponse(response);
            } else {
                TQA_TogglePanel(TQA_PanelMessage.id);
                console.warn(response.message.message);

                TQA_PanelMessage.innerText = response.message.message;
            }
        } else {
            console.error('请求失败');
        }
    };
    xhr.send();
}

/**  
 * 将找到的用户放进列表里  
 * @param {object} response   
 */
function TQA_SearchUsersHandleResponse(response) {
    if (Object.keys(response.message.users_list).length > 0) {
        const usersList = Object.values(response.message.users_list); // 获取users_list对象的值数组  
        let html = "";
        usersList.forEach(function (_user) {
            html += '<li data-username="' + _user.username + '">' + _user.username + '</li>';
        });
        document.querySelector("#till_quick_at_result").innerHTML = html;

        document.querySelectorAll("#till_quick_at_result li").forEach(function (li) {
            li.classList.add("dropdown-item");
        });
        // 确保li元素存在再添加active类  
        const firstLi = document.querySelector("#till_quick_at_result li");
        if (firstLi) {
            firstLi.classList.add("active");
            TQA_SetActiveItem(firstLi);
        }
    } else {
        console.warn(response.message.message);
        document.querySelector("#till_quick_at_panel_result_message").innerText = response.message.message;
    }
}

/*============  End of 业务代码  =============*/

/*=============================================
=                   实用函数                   =
=============================================*/

/**
 * 设置激活的HTML元素
 * @param {HTMLElement} li 新的激活项目HTML元素
 * @param {boolean} scrollIntoView 是否直接滚动到对应位置？
 */
function TQA_SetActiveItem(li, scrollIntoView = false) {
    if (TQA_ActiveItemLi) {
        TQA_ActiveItemLi.classList.remove('active');
    }
    TQA_ActiveItemLi = li;
    if (TQA_ActiveItemLi) {
        TQA_ActiveItemLi.classList.add('active');
    }
    if (typeof TQA_ActiveItemLi === 'object') {
        if (scrollIntoView) {
            TQA_ActiveItemLi.scrollIntoView();
        }
    }
}

/**
 * 在光标处插入内容
 * @param {object} textarea 文本框元素
 * @param {any} text 要插入的内容
 * @return {void}
 */
function insertTextAtCursor(textarea, text) {
    if (textarea.selectionStart || textarea.selectionStart === '0') {
        var startPos = textarea.selectionStart;
        var endPos = textarea.selectionEnd;
        var scrollTop = textarea.scrollTop;
        textarea.value = textarea.value.substring(0, startPos) + text + textarea.value.substring(endPos, textarea.value.length);
        textarea.selectionStart = startPos + text.length;
        textarea.selectionEnd = startPos + text.length;
        textarea.scrollTop = scrollTop;
    } else {
        // 如果不支持，则简单地追加到末尾  
        textarea.value += text;
    }
}

/**
 * 构造URL
 * @param {string} url 基础URL
 * @param {object} params Get请求参数
 * @param {int} url_rewrite_on 伪静态状态
 * @return {string}
 */
function url_build(url = '', params = {}, url_rewrite_on = 0) {
    if (url.length === 0) {
        return '';
    }
    var the_url = xn.url(url, url_rewrite_on);
    the_url = the_url.replace(".htm", "|||||xyz|||||");
    for (var key in params) {
        the_url = xn.url_add_arg(the_url, key, params[key]);
    }
    the_url = the_url.replace("|||||xyz||||", ".htm").replace('|', '');
    return the_url;
}

/**
 * 切换显示哪部分
 * @param {string} panel 要显示的部分的id，用`TQA_PanelResult.id`获得
 */
function TQA_TogglePanel(panel) {
    const panels = [
        TQA_PanelResult,
        TQA_PanelMessage,
        TQA_PanelPlaceholder,
        TQA_PanelInitial,
    ];

    panels.forEach((p) => {
        const element = document.getElementById(p.id);
        if (p.id === panel) {
            element.removeAttribute('hidden');
        } else {
            element.setAttribute('hidden', 'true');
        }
    });
}

/*============  End of 实用函数  =============*/