<?php exit;
/**
 * 压缩 HTML 代码
 * 
 * 使用`<!--<nocompress>-->...<!--</nocompress>-->`、`<nocompress>...</nocompress>`保持代码中的某些区域不被压缩，保持原样
 *
 * @param string $html_source 原始 HTML 代码
 * @return string 压缩后的 HTML 代码
 * 
 * @author unknown
 * @link http://xiuno.eu.org/thread-177.htm
 * @link https://blog.wm404.com/2022/05/17/98d03264.html
 */
function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}

/* 高版本PHP里才有的函数【开始】
-------------------------------------------------- */
if (!function_exists('array_key_first')) {
	/** 
	 * 获取指定数组的第一个键 
	 * 
	 * @param array $array 要操作的数组 
	 * @return int|string|null 如果数组不为空，返回第一个键，否则返回null 
	 */
	function array_key_first(array $arr) {
		foreach ($arr as $key => $unused) {
			gc_collect_cycles();
			return $key;
		}
		return NULL;
	}
}

if (!function_exists("array_key_last")) {
	/** 
	 * 获取指定数组的最后一个键 
	 * 
	 * @param array $array 要操作的数组 
	 * @return int|string|null 如果数组不为空，返回最后一个键，否则返回null 
	 */
	function array_key_last(array $array) {
		if (!empty($array)) {
			return key(array_slice($array, -1, 1, true));
		} else {
			return NULL;
		}
	}
}

if (!function_exists("str_starts_with")) {
	/**
	 * 这个函数会在$haystack字符串以$needle字符串开头时返回真，否则返回假哦~
	 * @param string $haystack 全文
	 * @param string $needle 要找的内容
	 * @return bool
	 * @since 8.0
	 */
	function str_starts_with($haystack, $needle) {
		return substr($haystack, 0, strlen($needle)) === $needle;
	}
}

if (!function_exists("str_ends_with")) {
	/**
	 * 这个函数会在$haystack字符串以$needle字符串结尾时返回真，否则返回假哦~
	 * @param string $haystack 全文
	 * @param string $needle 要找的内容
	 * @return bool
	 * @since 8.0
	 */
	function str_ends_with($haystack, $needle) {
		return substr($haystack, -strlen($needle)) === $needle;
	}
}

if (!function_exists('json_validate')) {
	/**  
	 * Validates a given string to be valid JSON.
	 * 
	 * @param string $json String to validate  
	 * @param int $depth Set the maximum depth. Must be greater than zero.  
	 * @param int $flags Bitmask of flags.  
	 * @return bool True if $json contains a valid JSON string, false otherwise.  
	 */
	function json_validate(string $json, int $depth = 512, int $flags = 0): bool {
		if ($flags !== 0 && $flags !== \JSON_INVALID_UTF8_IGNORE) {
			throw new \ValueError('json_validate(): Argument #3 ($flags) must be a valid flag (allowed flags: JSON_INVALID_UTF8_IGNORE)');
		}

		if ($depth <= 0) {
			throw new \ValueError('json_validate(): Argument #2 ($depth) must be greater than 0');
		}

		\json_decode($json, null, $depth, $flags);

		return \json_last_error() === \JSON_ERROR_NONE;
	}
}

/* 高版本PHP里才有的函数【结束】
-------------------------------------------------- */

/**
 * 更好的var_dump
 * 
 * 数组可以折叠，支持Bootstrap颜色变量
 * 
 * @param mixed $input 输入变量
 * @param bool $collapse 默认为折叠状态？
 * @return 将会Echo出结果
 */
function dump_debug($input, $collapse = false) {
	if (DEBUG == 0) {
		return;
	}
	$recursive = function ($data, $level = 0) use (&$recursive, $collapse) {
		global $argv;

		$isTerminal = isset($argv);

		if (!$isTerminal && $level == 0 && !defined("DUMP_DEBUG_SCRIPT")) {
			define("DUMP_DEBUG_SCRIPT", true);

			echo '<script language="Javascript">function toggleDisplay(id) {';
			echo 'var state = document.getElementById("container"+id).style.display;';
			echo 'document.getElementById("container"+id).style.display = state == "inline" ? "none" : "inline";';
			echo 'document.getElementById("plus"+id).style.display = state == "inline" ? "inline" : "none";';
			echo '}</script>' . "\n";
		}

		$type = !is_string($data) && is_callable($data) ? "Callable" : ucfirst(gettype($data));
		$type_data = null;
		$type_color = null;
		$type_length = null;

		switch ($type) {
			case "String":
				$type_color = "var(--base0B,var(--green,green))";
				$type_length = strlen($data);
				$type_data = "\"" . htmlentities($data) . "\"";
				break;

			case "Double":
			case "Float":
				$type = "Float";
				$type_color = "var(--base0D,var(--teal,#0099c5))";
				$type_length = strlen($data);
				$type_data = htmlentities($data);
				break;

			case "Integer":
				$type_color = "var(--base08,var(--red,red))";
				$type_length = strlen($data);
				$type_data = htmlentities($data);
				break;

			case "Boolean":
				$type_color = "var(--base0E,var(--purple,#92008d))";
				$type_length = strlen($data);
				$type_data = $data ? "TRUE" : "FALSE";
				break;

			case "NULL":
				$type_length = 0;
				break;

			case "Array":
				$type_length = count($data);
		}

		if (in_array($type, array("Object", "Array"))) {
			$notEmpty = false;

			foreach ($data as $key => $value) {
				if (!$notEmpty) {
					$notEmpty = true;

					if ($isTerminal) {
						echo $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "\n";
					} else {
						$id = substr(md5(rand() . ":" . $key . ":" . $level), 0, 8);

						echo "<a href=\"javascript:toggleDisplay('" . $id . "');\" style=\"text-decoration:none\">";
						echo "<span style='var(--base04,var(--secondary,#666))'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>";
						echo "</a>";
						echo "<span id=\"plus" . $id . "\" style=\"display: " . ($collapse ? "inline" : "none") . ";\">&nbsp;&#10549;</span>";
						echo "<div id=\"container" . $id . "\" style=\"display: " . ($collapse ? "" : "inline") . ";\">";
						echo "<br />";
					}

					for ($i = 0; $i <= $level; $i++) {
						echo $isTerminal ? "|    " : "<span style='color:var(--base02,var(--gray,silver))'>|</span>&emsp;&emsp;";
					}

					echo $isTerminal ? "\n" : "<br />";
				}

				for ($i = 0; $i <= $level; $i++) {
					echo $isTerminal ? "|    " : "<span style='color:color:var(--base02,var(--gray,silver))'>|</span>&emsp;&emsp;";
				}

				echo $isTerminal ? "[" . $key . "] => " : "<span style='color:var(--base06,var(--dark,black))'>[" . $key . "]&nbsp;=>&nbsp;</span>";

				call_user_func($recursive, $value, $level + 1);
			}

			if ($notEmpty) {
				for ($i = 0; $i <= $level; $i++) {
					echo $isTerminal ? "|    " : "<span style='var(--base02,var(--light,black))'>|</span>&emsp;&emsp;";
				}

				if (!$isTerminal) {
					echo "</div>";
				}
			} else {
				echo $isTerminal ?
					$type . ($type_length !== null ? "(" . $type_length . ")" : "") . "  " :
					"<span style='color:var(--base04,var(--secondary,#666))'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>&nbsp;&nbsp;";
			}
		} else {
			echo $isTerminal ?
				$type . ($type_length !== null ? "(" . $type_length . ")" : "") . "  " :
				"<span style='color:var(--base04,var(--secondary,#666))'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>&nbsp;&nbsp;";

			if ($type_data != null) {
				echo $isTerminal ? $type_data : "<span style='color:" . $type_color . "'>" . $type_data . "</span>";
			}
		}

		echo $isTerminal ? "\n" : "<br />";
	};

	call_user_func($recursive, $input);
}