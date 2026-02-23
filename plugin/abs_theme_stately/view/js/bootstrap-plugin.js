/**
 * bootstrap-plugin.js
 * Xiuno BBS为Bootstrap 4所做的扩展
 * (C) 2018 axiuno <http://bbs.xiuno.com/>
 * 
 * 由Geticer为Stately主题改进：
 * 为了兼容Bootstrap 5，重写$.alert、$.confirm、$.ajax_modal
 */
/**
 * 用于显示一般信息的模态框（兼容写法）
 * @param {string} subject 内容
 * @param {string} timeout 自动隐藏时间（秒）；0 表示不隐藏。
 * @param {string} options 自定义Modal设置
 * size: 弹窗大小
 * @returns 一个Modal
 */
$.alert = function (subject, timeout, options) {
	var options = options || { size: 'md', backdrop: true, focus: true, tips_title: lang.tips_title };
	var modal_uuid = new Date().getTime().toString().slice(-4);
	var mymodal = new BSModal('myAlertModal' + modal_uuid, options.tips_title, subject);
	if (options.size != 'md') {
		mymodal.changeSize(options.size);
	}
	var jmodal = new bootstrap.Modal(document.getElementById('myAlertModal' + modal_uuid), options);
	jmodal.show();
	if (typeof timeout != 'undefined' && timeout >= 0) {
		setTimeout(function () {
			jmodal.dispose();
		}, timeout * 1000);
	}
	return $(jmodal._element);
}

/**
 * 用于确认用户操作的模态框（兼容写法）
 * @param {string} subject 弹窗内容
 * @param {function} ok_callback 点击确定按钮后的回调函数
 * @param {object} options 自定义Modal设置
 * backdrop: bool 带背景？
 * focus: bool 聚焦到弹窗上？
 * size: 弹窗大小
 * title: string 弹窗标题
 * body: string 弹窗内容
 * btn_title: string 按钮文字
 * 
 * @returns 一个Modal
 */
$.confirm = function (subject, ok_callback, options) {
	var the_options = {};
	var options_default = { 
		backdrop: true, 
		focus: true, 
		size: "md",
		title: lang.confirm_title, 
		body: subject,
		btn_title: ((window.lang !== null) && !Array.isArray(window.lang) && (typeof window.lang === 'object') ) ? window.lang.confirm : "Confirm"
	};
	if (typeof(options)=="object") {
		the_options = Object.assign(the_options, options_default, options);
	} else {
		the_options = options_default;
	}
	console.log(the_options);
	//var options = options || options_default;
	var modal_uuid = new Date().getTime().toString().slice(-4);
	var mymodal = new BSModal('myConfirmModal' + modal_uuid, the_options.title, the_options.body, ok_callback);
	mymodal.confirmBtn.innerText = the_options.btn_title;
	if (the_options.size != 'md') {
		mymodal.changeSize(the_options.size);
	}
	var jmodal = new bootstrap.Modal(document.getElementById('myConfirmModal' + modal_uuid), the_options);
	jmodal.show();
	return $(jmodal._element);
}

/**
 * AJAX获取模态框内容
 * @param {string} url 要获取的页面地址
 * @param {string} title Modal标题
 * @param {string} size Modal大小（未用到）
 * @param {function} callback 回调函数
 * @param {object} arg 其他参数
 * @returns 一个Modal
 */
$.ajax_modal = function (url, title, size, callback, arg) {
	//var jmodal = $.alert('Loading...', -1, { size: size });
	//jmodal.find('.modal-title').html(title);
	var options = options || { backdrop: true, focus: true };
	var modal_uuid = new Date().getTime().toString().slice(-4);
	var mymodal = new BSModal('myModal' + modal_uuid, title, '<div class="text-center"><span class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></span></div>', function () { }, size);
	var jmodal = new bootstrap.Modal(document.getElementById('myModal' + modal_uuid), options);
	jmodal.show();
	// ajax 加载内容
	$.xget(url, function (code, message) {
		// 对页面 html 进行解析
		if (code == -101) {
			var r = xn.get_title_body_script_css(message);
			$(jmodal._element).find('.modal-body').html(r.body);
			$(jmodal._element).find('.modal-footer').hide();
		} else {
			$(jmodal._element).find('.modal-body').html(message);
			return;
		}
		//console.log(r);
		// eval script, css
		//xn.eval_stylesheet(r.stylesheet_links);
		jmodal.script_sections = r.script_sections;

		/*
		if (r.script_srcs.length > 0) {
			$.require(r.script_srcs, function () {
				xn.eval_script(r.script_sections, { jmodal: jmodal, callback: callback, arg: arg });
			});
		} else {
			xn.eval_script(r.script_sections, { jmodal: jmodal, callback: callback, arg: arg });
		}
		/*/
		xn.eval_script(r.script_sections, { jmodal: jmodal, callback: callback, arg: arg });
		//*/

	});
	return $(jmodal._element);
}

$(function () {
	$('[data-modal-title]').each(function () {
		var jthis = $(this);
		jthis.on('click', function () {
			var url = jthis.data('modal-url') || jthis.attr('href');
			var title = jthis.data('modal-title');
			var arg = jthis.data('modal-arg');
			var callback_str = jthis.data('modal-callback');
			callback = window[callback_str];
			var size = jthis.data('modal-size'); // 对话框的尺寸

			// 弹出对话框
			if (this.ajax_modal) this.ajax_modal.modal('dispose');
			this.ajax_modal = $.ajax_modal(url, title, size, callback, arg);

			return false;
		});
	});
});



// --------------------- eval script start ---------------------------------

// 获取当前已经加载的 js
xn.get_loaded_script = function () {
	var arr = [];
	$('script[src]').each(function () {
		arr.push($(this).attr('src'));
	});
	return arr;
}
xn.get_stylesheet_link = function (s) {
	var arr = [];
	var r = s.match(/<link[^>]*?href=\s*\"([^"]+)\"[^>]*>/ig);
	if (!r) return arr;
	for (var i = 0; i < r.length; i++) {
		var r2 = r[i].match(/<link[^>]*?href=\s*\"([^"]+)\"[^>]*>/i);
		arr.push(r2[1]);
	}
	return arr;
}
xn.get_script_src = function (s) {
	var arr = [];
	var r = s.match(/<script[^>]*?src=\s*\"([^"]+)\"[^>]*><\/script>/ig);
	if (!r) return arr;
	for (var i = 0; i < r.length; i++) {
		var r2 = r[i].match(/<script[^>]*?src=\s*\"([^"]+)\"[^>]*><\/script>/i);
		arr.push(r2[1]);
	}
	return arr;
}
xn.get_script_section = function (s) {
	var r = '';
	var arr = s.match(/<script[^>]+ajax-eval="true"[^>]*>([\s\S]+?)<\/script>/ig);
	return arr ? arr : [];
}
xn.strip_script_src = function (s) {
	s = s.replace(/<script[^>]*?src=\s*\"([^"]+)\"[^>]*><\/script>/ig, '');
	return s;
}
xn.strip_script_section = function (s) {
	s = s.replace(/<script([^>]*)>([\s\S]+?)<\/script>/ig, '');
	return s;
}
xn.strip_stylesheet_link = function (s) {
	s = s.replace(/<link[^>]*?href=\s*\"([^"]+)\"[^>]*>/ig, '');
	return s;
}
xn.eval_script = function (arr, args) {
	if (!arr) return;
	for (var i = 0; i < arr.length; i++) {
		var s = arr[i].replace(/<script([^>]*)>([\s\S]+?)<\/script>/i, '$2');
		try {
			var func = new Function('args', s);
			func(args);
			//func = null;
			//func.call(window, 'aaa'); // 放到 windows 上执行会有内存泄露!!!
		} catch (e) {
			console.log("eval_script() error: %o, script: %s", e, s);
			alert(s);
		}
	}
}
xn.eval_stylesheet = function (arr) {
	if (!arr) return;
	if (!$.required_css) $.required_css = {};
	for (var i = 0; i < arr.length; i++) {
		if ($.required_css[arr[i]]) continue;
		$.require_css(arr[i]);
	}
}

xn.get_title_body_script_css = function (s) {
	var s = $.trim(s);

	/* 过滤掉 IE 兼容代码
		<!--[if lt IE 9]>
		<script>window.location = '<?= url('browser');?>';</script>
		<![endif]-->
	*/
	s = s.replace(/<!--\[if\slt\sIE\s9\]>([\s\S]+?)<\!\[endif\]-->/ig, '');

	var title = '';
	var body = '';
	var script_sections = xn.get_script_section(s);
	var stylesheet_links = xn.get_stylesheet_link(s);

	var arr1 = xn.get_loaded_script();
	var arr2 = xn.get_script_src(s);
	var script_srcs = xn.array_diff(arr2, arr1); // 避免重复加载 js

	s = xn.strip_script_src(s);
	s = xn.strip_script_section(s);
	s = xn.strip_stylesheet_link(s);

	var r = s.match(/<title>([^<]+?)<\/title>/i);
	if (r && r[1]) title = r[1];

	var r = s.match(/<body[^>]*>([\s\S]+?)<\/body>/i);
	if (r && r[1]) body = r[1];

	// jquery 更方便
	var jtmp = $('<div>' + body + '</div>');
	var t = jtmp.find('div.ajax-body');
	if (t.length == 0) t = jtmp.find('#body'); // 查找 id="body"
	if (t.length > 0) body = t.html();

	if (!body) body = s;
	if (body.indexOf('<meta ') != -1) {
		console.log('加载的数据有问题：body: %s: ', body);
		body = '';
	}
	jtmp.remove();

	return { title: title, body: body, script_sections: script_sections, script_srcs: script_srcs, stylesheet_links: stylesheet_links };
}
// --------------------- eval script end ---------------------------------

/*
	--------------------------------------------------------------
	index.htm
	--------------------------------------------------------------
	<button id="button1" data-modal-url="user-login.htm" data-modal-title="用户登录" data-modal-arg="xxx" data-modal-callback="login_success_callback" data-modal-size="md"></button>
	<a id="button1" href="user-login.htm" data-modal-title="用户登录" data-modal-arg="xxx" data-modal-callback="login_success_callback" data-modal-size="md">link</a>
	<a href="user-login.htm" data-modal-title="用户登录" data-modal-size="md">link</a>
	<script>
	function login_success_callback(code, message) {
		alert(message);
	}
	</script>
	--------------------------------------------------------------



	--------------------------------------------------------------
	route/user.php
	--------------------------------------------------------------
	if($action == 'login') {
		if($method == 'GET') {
			include './view/user_login.htm';
		} else {
			$email = param('email');
			$password = param('password');
			// ...
			message(0, '登陆成功');
		}
	}
	--------------------------------------------------------------



	--------------------------------------------------------------
	view/user_login.htm
	--------------------------------------------------------------
	<?php include './view/header.inc.htm';?>
	<div class="card">
		<div class="card-header">登陆</div>
		<div class="card-body ajax_modal_body">
			<form action="user-login.htm" method="post" id="login_form">
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="icon-user"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Email" name="email">
					<div class="invalid-feedback"></div>
				</div>
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="icon-lock"></i></span>
					</div>
					<input type="password" class="form-control" placeholder="密码" name="password">
					<div class="invalid-feedback"></div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block" data-loading-text="正在提交...">登陆</button>
				</div>
			</form>
		</div>
	</div>
	<?php include './view/footer.inc.htm';?>
	<script>

	// 模态对话框的脚本将会在父窗口，被闭包起来执行。

	// 接受传参
	var args = args || {jmodal: null, callback: null, arg: null};
	var jmodal = args.jmodal;  // 对应当前模态对话框
	var callback = args.callback;  // 对应 data-callback=""
	var arg = args.arg; // 对应 data-arg=""

	var jform = $('#login_form');
	var jsubmit = jform.find('input[type="submit"]');
	var jemail = jform.find('input[name="email"]');
	var jpassword = jform.find('input[name="password"]');
	jform.on('submit', function() {
		jform.reset();
		jsubmit.button('loading');
		var postdata = jform.serializeObject();
		$.xpost(jform.attr('action'), postdata, function(code, message) {
			if(code == 0) {
				jsubmit.button(message);

				// 关闭当前对话框
				if(jmodal) jmodal.dispose();
				// 回调父窗口
				if(callback) callback(message);

			} else if(code == 'email') {
				jemail.alert(message).focus();
				jsubmit.button('reset');
			} else if(code == 'password') {
				jpassword.alert(message).focus();
				jsubmit.button('reset');
			} else {
				alert(message);
				jsubmit.button('reset');
			}
		});
		return false;
	});
	</script>
	--------------------------------------------------------------
*/

// <button id="button1" class="btn btn-primary" data-modal-url="user-login.htm" data-modal-title="用户登录" data-modal-arg="xxx" data-modal-callback="login_success_callback" data-modal-size="md">登陆</button>

