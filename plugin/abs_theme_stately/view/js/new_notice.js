/**
 * 全新私信页面业务JS
 * @copyright Geticer 2023
 * 禁止将Xiuno BBS用于搭建诈骗、赌博、色情等违法违规站点
 * 本主题仅仅负责外观部分，无法控制展示的内容。任何用户输入和/或展示的内容由用户自行承担风险和责任。本主题的作者不对任何因为使用不当造成的任何直接或间接的损失（包括但不限于数据丢失、停机、业务中断等）负责。
 */

// 更新角标
function notice_update_unread_notices_badge(ele, mode = 'minus', amount = 1) {
	var unread_notices_badge = document.querySelectorAll(ele); //角标元素
	if (unread_notices_badge == null) {
		return 0; //如果角标不存在，提前返回
	}
	unread_notices_badge.forEach(element => {

		var unread_notices = Number(element.innerText); //角标元素里的数字
		switch (mode) {
			case 'plus':   //增加
				element.innerText = unread_notices + amount;
				return unread_notices + amount;
			case 'minus':   //减少
				element.innerText = unread_notices - amount;
				if (Number(element.innerText) == 0) {
					element.remove(this);
					return 0;
				} else {
					return unread_notices - amount;
				}
			case 'clear':  //删掉角标
				element.remove(this);
				return 0;
			default:
				// do nothing
				break;

		}
	});
}

// 标记已读
$(document).on('click', '.noticelist .notice .readbtn', function () {
	var jthis = $(this);
	var jnid = jthis.data('nid');


	// function notice_mark_read 开始
	var postdata = { act: 'readone', nid: jnid };
	$.xpost(xn.url('my-notice'), postdata, function (code, message) {
		if (code == -1) {
			// 更新失败，可能已经是已读了
			$.toast({
				title: lang.tips_title,
				content: message,
				type: 'info',
				pause_on_hover: true,
				delay: 5000
			});
			return false;
		} else if (code == 0) {
			jthis.removeClass('readbtn');
			notice_update_unread_notices_badge('#nav-usernotice-unread-notices', 'minus');
			jthis.attr('disabled', true);
			jthis.attr('class', 'btn btn-xs badge-center text-muted mr-2');
			jthis.parents('.chat-message').find('.avatar.avatar-busy').removeClass('avatar-busy');
			if (typeof (jthis.attr('aria-describedby')) == 'string') {
				document.getElementById(jthis.attr('aria-describedby')).remove(this);
			}
			return true;
		} else {
			// 其他错误情况
			$.toast({
				title: lang.tips_title,
				content: message,
				type: 'warning',
				pause_on_hover: true,
				delay: 5000
			});
			return false;
		}
	});
	// function notice_mark_read 结束
});

// 点击a标签设置已读

$(document).on('click', '.noticelist .notice .message > a', function () {
	var jthis = $(this);
	var isread_btn = jthis.parents('.notice').find('.readbtn');
	if (isread_btn.length > 0) {
		isread_btn.trigger("click");
	}
});

//删除单条
$(document).on('click', '.noticelist .notice .deletebtn', function () {
	var jthis = $(this);
	var jnid = jthis.data('nid');
	//var result = notice_delete(jnid);

	// function notice_delete 开始
	var postdata = { act: 'delete', nid: jnid, ajax: 1 };

	$.xpost(xn.url('my-notice'), postdata, function (code, message) {
		if (code == 0) {
			if (jthis.parent().find('.readbtn').length > 0
				&& jthis.parent().find('.readbtn')[0].getAttribute('disabled') == null) {
				notice_update_unread_notices_badge('#nav-usernotice-unread-notices', 'minus');
			}
			if (typeof (jthis.attr('aria-describedby')) == 'string') {
				document.getElementById(jthis.attr('aria-describedby')).remove(this);
			}
			jthis.parents('.chat-message').remove();
			return true;
		} else {
			$.toast({
				title: lang.tips_title,
				content: message,
				type: 'warning',
				pause_on_hover: true,
				delay: 5000
			});
			return false;
		}

	});
	// function notice_delete 结束
});

// 全部已读
$('#readall').on('click', function () {
	var jthis = $(this);

	// function notice_mark_read_all 开始
	var postdata = { act: 'readall' };
	$.xpost(xn.url('my-notice'), postdata, function (code, message) {
		console.log(code, message);
		if (code == 0 || code == -1) {
			$('.noticelist .notice').addClass('isread');
			$('.noticelist .notice').find('.readbtn').attr('class', 'btn btn-xs badge-center text-muted mr-2').attr('disabled', true);
			$('.noticelist .chat-message .user-avatar').find('.avatar.avatar-busy').removeClass('avatar-busy');
			$('.chat-contact-list').find('.avatar.avatar-busy').removeClass('avatar-busy');
			//jthis.addClass('btn-outline-primary').attr('disabled',true).text(message.b);
			jthis.addClass('btn-outline-primary').attr('disabled', true);
			notice_update_unread_notices_badge('#nav-usernotice-unread-notices', 'clear');
			$.toast({
				title: lang.tips_title,
				content: message.b,
				type: 'success',
				pause_on_hover: false,
				delay: 2000
			});
		} else {
			$.toast({
				title: lang.tips_title,
				content: message,
				type: 'warning',
				pause_on_hover: true,
				delay: 5000
			});
		}
	});
	// function notice_mark_read_all 结束
});
// 删除本页信息
var jdelete = $('#delete');
jdelete.on('click', function () {

	// function notice_delete_all 开始
	var text = $(this).data('confirm-text');
	$.confirm(text, function () {

		var nidarr = $('.noticelist').data('nidarr');
		var postdata = { act: 'deletearr', nidarr: nidarr };

		$.xpost(xn.url('my-notice'), postdata, function (code, message) {
			if (code == 0) {
				$.toast({
					title: lang.tips_title,
					content: message,
					type: 'success',
					pause_on_hover: false,
					delay: 2000
				});
				setTimeout(function () {
					window.location.reload();
				}, 1000);
			} else {
				$.toast({
					title: lang.tips_title,
					content: message,
					type: 'warning',
					pause_on_hover: true,
					delay: 5000
				});
			}
		});
	});
	// function notice_delete_all 结束
})
