//<?php
restore_error_handler();
ob_start();

// 中断流程很危险！可能会导致数据问题，线上模式不允许中断流程！
function stately_error_handle($errno, $errstr, $errfile, $errline) {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
	// PHP 内部默认处理
	if (DEBUG == 0) {

		$time = $_SERVER['time'];
		$ajax = $_SERVER['ajax'];
		IN_CMD and $errstr = str_replace('<br>', PHP_EOL, $errstr);

		$subject = "Error[$errno]: $errstr, File: $errfile, Line: $errline";

		xn_log($subject, 'php_error');
		ob_start();
		    // 输出错误信息
			echo <<<EFO
			<html class="light-style layout-wide " dir="ltr" data-theme="theme-default" data-style="light"><head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		
			<title>Error</title>
			
			<!-- Core CSS -->
			<link rel="stylesheet" href="./plugin/abs_theme_stately/view/css/core.css" class="template-customizer-core-css">
			<link rel="stylesheet" href="./plugin/abs_theme_stately/view/css/theme-default.css" class="template-customizer-theme-css">
			
			
			<style type="text/css">
			.misc-wrapper {
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				min-height: calc(100vh - 1.5rem*2);
				text-align: center;
			}
		.layout-menu-fixed .layout-navbar-full .layout-menu,
		.layout-page {
		  padding-top: 0px !important;
		}
		.content-wrapper {
		  padding-bottom: 0px !important;
		}</style>

		<body>
		
		  <!-- Content -->
		
		<!-- Error -->
		<div class="container-xxl container-p-y">
		  <div class="misc-wrapper">
			<h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">500</h1>
			<h4 class="mb-2 mx-2 line-heigh-4">服务器君不小心绊了一跤，导致这次请求没能顺利完成。</h4>
			<p class="lead">别担心，这绝不是您的错，而是我们后台的小伙伴需要赶紧来修复的小bug。</p>
			<p class="mb-6 mx-2">$errstr/$errno/$errline</p>
			<a href="index.htm" class="btn btn-primary">回到首页 Back to home</a>
			<div class="mt-6">
			  <img src="./plugin/abs_theme_stately/view/img/page-misc-error-light.png" alt="page-misc-error-light" width="500" class="img-fluid" >
			</div>
		  </div>
		</div>
		<!-- /Error -->
		</body></html>
EFO;
		ob_end_flush();
			// 结束脚本执行
			exit;

		return true;
	} else {

		// 如果放在 register_shutdown_function 里面，文件句柄会被关闭，然后这里就写入不了文件了！
		// if(strpos($s, 'error_log(') !== FALSE) return TRUE;
		$time = $_SERVER['time'];
		$ajax = $_SERVER['ajax'];
		IN_CMD and $errstr = str_replace('<br>', PHP_EOL, $errstr);

		$subject = "Error[$errno]: $errstr, File: $errfile, Line: $errline";
		$message = array();
		xn_log($subject, 'php_error'); // 所有PHP错误报告都记录日志

		$arr = debug_backtrace();
		array_shift($arr);
		foreach ($arr as $v) {
			$args = '';
			if (!empty($v['args']) && is_array($v['args'])) foreach ($v['args'] as $v2) $args .= ($args ? ' , ' : '') . (is_array($v2) ? 'array(' . count($v2) . ')' : (is_object($v2) ? 'object' : $v2));
			!isset($v['file']) and $v['file'] = '';
			!isset($v['line']) and $v['line'] = '';
			$message[] = "File: $v[file], Line: $v[line], $v[function]($args) ";
		}
		$txt = $subject . "\r\n" . implode("\r\n", $message);
		$html = $s = "<fieldset class=\"fieldset border-danger small notice\">
			<b>$subject</b>
			<div>" . implode("<br>\r\n", $message) . "</div>
		</fieldset>";
		echo ($ajax || IN_CMD) ? $txt : $html;
		DEBUG == 2 and xn_log($txt, 'debug_error');
		return TRUE;
	}
}
set_error_handler('stately_error_handle', -1);
