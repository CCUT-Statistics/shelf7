/**
 * @license
 * Copyright (C) 2009 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @fileoverview
 * 
 * PHP language handler for Google Code Prettify
 *
 * @author monicfenga (https://github.com/monicfenga) 2024
 */

PR['registerLangHandler'](
    PR['createSimpleLexer'](
        [// shortcutStylePatterns

            // Whitespace
            [PR['PR_PLAIN'], /^[ \t\n\r]+/, null, ' \t\n\r'],
            // A double or single quoted, possibly multi-line, string.
            [PR['PR_STRING'], /^(?:\"(?:[^\"\\\n\r]|\\.)*(?:\"|$)|\'(?:[^\'\\\n\r]|\\.)*(?:\'|$))/, null, '"\''],
            // A heredoc string.
            [PR['PR_STRING'], /^(?:<<<\w+)(?:[\w\d_]+\r?\n|[\w\d_]+\r\n)((?:.|\r?\n)*?)(?:\r?\n\1)/, null, '"""'],
            // A comment is either a line comment that starts with two dashes, or two dashes or a hash symbol preceding a long bracketed block.
            [PR['PR_COMMENT'], /^(?:\/\/.*|\/\*[\s\S]*?\*\/|\#.*$)/, null, '/*#'],
            // A long bracketed block not preceded by -- is a string.
            [PR['PR_STRING'], /^\[(=*)\[[\s\S]*?(?:\]\1\]|$)/],
            // A number is a hex integer literal, a decimal real literal, or in scientific notation.

            [PR['PR_LITERAL'], /^[+-]?(?:0x[\da-f]+|(?:(?:\.\d+|\d+(?:\.\d*)?)(?:e[+\-]?\d+)?))/i, null, '0123456789'],

        ],
        [// fallthroughStylePatterns

            // HTML doctype
            [PR['PR_DECLARATION'], /^<!\w[^>]*(?:>|$)/, null],
            // HTML Comment
            [PR['PR_COMMENT'], /^<\!--[\s\S]*?(?:-\->|$)/, null],
            // HTML Tag
            ['lang-in.tag', /^(<\/?[a-z][^<>]*>)/i],
            // JavaScript
            ['lang-js', /^<script\b[^>]*>([\s\S]*?)(<\/script\b[^>]*>)/i],
            // CSS
            ['lang-css', /^<style\b[^>]*>([\s\S]*?)(<\/style\b[^>]*>)/i],
            // PHP-specific Beginning
            ['opn', /^\<\?php/, null],
            ['opn', /^\<\?=/, null],
            // PHP-specific End
            ['clo', /^\?>/, null],

            // PHP Variables
            [PR['PR_DECLARATION'], /\$(this|GLOBALS|_SERVER|_GET|_POST|_FILES|_COOKIE|_SESSION|_REQUEST|_ENV)/i, null],
            ['var', /^(?:\$[A-Za-z0-9_]\w*)/i, null],

            // PHP Keywords
            [PR['PR_KEYWORD'], /^(?:and|break|case|catch|class|clone|const|continue|declare|default|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|final|for|foreach|function|global|goto|if|implements|interface|instanceof|namespace|new|or|private|protected|public|static|switch|throw|try|use|var|while|xor|__halt_compiler|abstract|as|echo|empty|exit|include|include_once|list|parent|require|require_once|return|self|unset)\b/, null],

            // PHP Types
            [PR['PR_TYPE'], /^(?:array|bool|boolean|callable|cfunction|const|double|float|int|integer|null|object|resource|string|boolval|doubleval|floatval|intval|strval)\b/, null],

            // Some Most Commonly Used PHP Functions
            [PR['PR_ATTRIB_NAME'], /^(?:echo|print|printf|sprintf|var_dump|print_r|isset|empty|count|in_array|array_key_exists|array_search|array_merge|array_intersect|array_diff|array_slice|array_splice|array_push|array_pop|array_shift|array_unshift|sort|rsort|asort|arsort|ksort|krsort|shuffle|rand|srand|mt_rand|mt_srand|time|date|mktime|strftime|gmdate|gmmktime|gmstrftime|fopen|fclose|fread|fwrite|fgets|fputs|fputcsv|fgetcsv|file_get_contents|file_put_contents|copy|rename|unlink|mkdir|rmdir|chdir|getcwd|exec|system|passthru|shell_exec|escapeshellcmd|escapeshellarg|md5|sha1|crypt|base64_encode|base64_decode|gzcompress|gzuncompress|serialize|unserialize|json_encode|json_decode|session_start|session_destroy|setcookie|getcookie|header|mail|mysqli_connect|mysqli_query|mysqli_fetch_array|mysqli_fetch_object|mysqli_close|preg_match|preg_replace|str_replace|substr|strlen|strpos|strrpos|strtolower|strtoupper|trim|ltrim|rtrim|implode|explode|is_​array|is_​bool|is_​callable|is_​countable|is_​double|is_​float|is_​int|is_​integer|is_​iterable|is_​long|is_​null|is_​numeric|is_​object|is_​real|is_​resource|is_​scalar|is_​string)\b/, null],

            // PHP-specific constants
            [PR['PR_LITERAL'], /^(?:true|false|null)\b/, null],

            // Some Most Commonly Used PHP Constants
            [PR['PR_BUILTIN'], /^(?:__CLASS__|__FILE__|__FUNCTION__|__LINE__|__METHOD__|__NAMESPACE__|__DIR__|__TRAIT__|PHP_VERSION|PHP_MAJOR_VERSION|PHP_MINOR_VERSION|PHP_RELEASE_VERSION|PHP_VERSION_ID|PHP_EXTRA_VERSION|ZEND_THREAD_SAFE|ZEND_DEBUG_BUILD|PHP_ZTS|PHP_DEBUG|PHP_MAXPATHLEN|PHP_OS|PHP_OS_FAMILY|PHP_SAPI|PHP_EOL|PHP_INT_MAX|PHP_INT_MIN|PHP_INT_SIZE|PHP_FLOAT_DIG|PHP_FLOAT_EPSILON|PHP_FLOAT_MIN|PHP_FLOAT_MAX|DEFAULT_INCLUDE_PATH|PEAR_INSTALL_DIR|PEAR_EXTENSION_DIR|PHP_EXTENSION_DIR|PHP_PREFIX|PHP_BINDIR|PHP_BINARY|PHP_MANDIR|PHP_LIBDIR|PHP_DATADIR|PHP_SYSCONFDIR|PHP_LOCALSTATEDIR|PHP_CONFIG_FILE_PATH|PHP_CONFIG_FILE_SCAN_DIR|PHP_SHLIB_SUFFIX|PHP_FD_SETSIZE|E_ERROR|E_WARNING|E_PARSE|E_NOTICE|E_CORE_ERROR|E_CORE_WARNING|E_COMPILE_ERROR|E_COMPILE_WARNING|E_USER_ERROR|E_USER_WARNING|E_USER_NOTICE|E_RECOVERABLE_ERROR|E_DEPRECATED|E_USER_DEPRECATED|E_ALL|E_STRICT|__COMPILER_HALT_OFFSET__)\b/, null],

            // PHP-specific built-in magic function
            [PR['PR_DECLARATION'], /(?:__construct|__destruct|__set|__get|__isset|__unset|__clone|__tostring|__call|__autoload|__sleep|__wakeup)\b/, null],

            // An identifier
            [PR['PR_PLAIN'], /^[a-z_$][a-z_$@0-9]*/i, null],
            // A run of punctuation
            [PR['PR_PUNCTUATION'], new RegExp('^.[^\\s\\w.$@\'"`/\\\\]*(?!\s*\/)'), null],

        ]
    ),
    ['php']
);