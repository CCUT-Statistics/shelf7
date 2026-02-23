/**
 * 全新私信页面业务JS
 * @copyright Geticer 2023
 * 禁止将Xiuno BBS用于搭建诈骗、赌博、色情等违法违规站点
 * 本主题仅仅负责外观部分，无法控制展示的内容。任何用户输入和/或展示的内容由用户自行承担风险和责任。本主题的作者不对任何因为使用不当造成的任何直接或间接的损失（包括但不限于数据丢失、停机、业务中断等）负责。
 */

/*=============================================
=                   常量定义                   =
=============================================*/
var chat_btn_mainmenu = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']");
var chat_btn_back_to_chat = document.querySelector(".app-chat-contacts [data-target='#app-chat-contacts']");
var chat_btn_fullscreen = document.querySelector("#chat_fullscreen");
var chat_overlay = document.querySelector(".app-overlay");
var chat_panel_contacts = document.querySelector(".app-chat-contacts");
var chat_panel_history_body = document.querySelector('.chat-history-body');
var chat_panel_history_list = document.querySelector('.chat-history-body>.chat-history');
// 下一页按钮
var chat_btn_load_next_page = document.querySelector('#chat_load_next_page_btn');
// 消息列表
var lis = document.querySelectorAll(".app-chat-contacts .sidebar-body li.chat-contact-list-item:not(.chat-contact-list-item-title");
// 私信表单
var jform = $('.form-send-message');
var jsubmit = $('.send-msg-btn');

/*============  End of 常量定义  =============*/

/*=============================================
=                   业务函数                   =
=============================================*/

chat_btn_mainmenu.addEventListener("click", e => {
	chat_overlay.classList.toggle('show');
	chat_panel_contacts.classList.toggle('show');
});
chat_btn_back_to_chat.addEventListener("click", e => {
	if (chat_panel_contacts.classList.contains('show')) {
		chat_overlay.classList.remove('show');
	} else {
		chat_overlay.classList.add('show');
	}
	chat_panel_contacts.classList.toggle('show');
});
chat_overlay.addEventListener("click", e => {
	if (chat_panel_contacts.classList.contains('show')) {
		chat_overlay.classList.remove('show');
	} else {
		chat_overlay.classList.add('show');
	}
	chat_panel_contacts.classList.toggle('show');
});
chat_btn_fullscreen.addEventListener("click", e => {
	document.querySelector('.app-chat').classList.toggle('fullscreen');
});
if (isMobileDevice()) {
	chat_overlay.classList.toggle('show');
	chat_panel_contacts.classList.toggle('show');
}
chat_btn_load_next_page.addEventListener("click", e => {
	var notice_menu = $(chat_panel_contacts).find('.chat-contact-list-item.active').attr('data-notice-menu');
	if (notice_menu == null) {
		notice_menu = 0;
	}
	var next_page = Number(e.target.getAttribute('data-current_page')) + 1;
	var max_page = Number(e.target.getAttribute('data-max_page'));
	if (next_page > max_page) {
		e.target.setAttribute('hidden', true);
		return false;
	} else {

		$.xget(
			url_build('my-notice-' + notice_menu + '-' + next_page, { 'ajax': 1, 'return_html': 1 }, url_rewrite_on),
			function (code, message) {
				if (code == 0) {
					e.target.setAttribute('data-max_page', message.max_page);
					e.target.setAttribute('data-current_page', next_page);
					chat_panel_history_list.innerHTML += message.notice_message_list;
				} else {
					chat_panel_history_list.innerHTML = message.notice_message_list;
					chat_panel_history_list.setAttribute('data-nidarr', '[]');
					if (DEBUG) {
						$.toast({
							title: lang.tips_title,
							subtitle: code,
							content: message.error_message,
							type: 'warning',
							pause_on_hover: true,
							delay: 5000
						});
					}
				}
			}
		);
	}
});

lis.forEach(function (li) {
	li.addEventListener('click', function () {
		// 为消息列表里的项目注册单击事件 
		var activeElements = document.querySelectorAll(".chat-contact-list-item.active");
		// 将之前选中的li上的类active移除 
		activeElements.forEach(function (element) {
			element.classList.remove('active');
		});
		// 为单击的li添加active类 
		this.classList.add('active');

		if (chat_panel_contacts.classList.contains('show')) {
			chat_panel_contacts.classList.remove('show');
			chat_overlay.classList.remove('show');
		}

		chat_panel_history_list.innerHTML = '<div class="text-center"><span class="spinner-border"></span></div>';
		document.querySelector('.chat-history-footer').setAttribute('hidden', true);
		chat_btn_load_next_page.setAttribute('hidden', true);
		$.xget(
			url_build('my-notice-' + this.getAttribute('data-notice-menu'), { 'ajax': 1, 'return_html': 1 }, url_rewrite_on),
			function (code, message) {
				if (typeof message !== 'object') {
					/* 返回的不是JSON格式内容，显示错误提示 */
					$.toast({
						title: lang.tips_title,
						content: '遇到内部错误，请反馈给管理员',
						type: 'error',
						pause_on_hover: true,
						delay: 5000
					});
					return;
				}
				if (code == 0) {
					chat_panel_history_list.innerHTML = message.notice_message_list;
					document.querySelector('.chat-history-header .flex-shrink-0.avatar').innerHTML = message.notice_header_icon_html;
					document.querySelector('.chat-history-header .chat-contact-info > h6').innerHTML = message.notice_header_name;
					chat_panel_history_list.setAttribute('data-nidarr', message.notice_nidarr);
					chat_btn_load_next_page.setAttribute('data-current_page', 1);
					if (message.notice_category == 7 || message.notice_category == 89757) {
						// 7是私信,89757是聊天室
						document.querySelector('.chat-history-footer').removeAttribute('hidden');
						document.querySelector('.chat-history-footer form > input[name="pm_to_uid"]').setAttribute('value', message.pm_to_uid);
						chat_panel_history_body_scroll_to_bottom();
					}

					if (message.notice_category != 7 && message.max_page > 1) {
						chat_btn_load_next_page.removeAttribute('hidden');
					}

				} else {
					chat_panel_history_list.innerHTML = message.notice_message_list;
					chat_panel_history_list.setAttribute('data-nidarr', '[]');
					if (DEBUG) {
						$.toast({
							title: lang.tips_title,
							subtitle: code,
							content: message.error_message,
							type: 'warning',
							pause_on_hover: true,
							delay: 5000
						});
					}

				}
			}
		);
	});
});

jform.on('submit', function () {
	// 回复私信
	jform.reset();
	jsubmit.button('loading');
	var postdata = jform.serialize();
	$.xpost(jform.attr('action'), postdata, function (code, message) {
		/*console.log(code, message);*/
		var s = '<ul>' + message.html + '</ul>';
		var jNewMessage = $(s).find('li');
		$('.chat-history').append(jNewMessage);
		chat_panel_history_body_scroll_to_bottom();
		$('[name="pm_message"]').val('');
		jsubmit.button('reset');
	});
	return false;
});

/*============  End of 业务函数  =============*/

/*=============================================
=                   实用函数                   =
=============================================*/

/**
 * 是否为移动端设备
 * 简单版
 * @returns {boolean}
 */
function isMobileDevice() {
	return (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
}

/**
 * 构造URL
 * @param url 基础URL
 * @param params Get请求参数
 * @param url_rewrite_on 伪静态状态
 * @returns {string}
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
 * 设置滚动条到最底部
 */
function chat_panel_history_body_scroll_to_bottom() {
	if (chat_panel_history_body.scrollHeight > chat_panel_history_body.clientHeight) {
		setTimeout(function () {
			chat_panel_history_body.scrollTop = chat_panel_history_body.scrollHeight;
		}, 0);
	}
}

/*============  End of 实用函数  =============*/