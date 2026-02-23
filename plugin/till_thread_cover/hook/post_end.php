//<?php

if ($action == 'thread_cover') {
    empty($user) and message(-1, '请登录后再操作');
    empty($group['allow_attach']) and $gid != 1 and message(-1, '您无权上传附件！');

    if ($method != 'POST') {
        exit('Bad Request');
    }

    $till_thread_cover_setting = setting_get('till_thread_cover_setting');


    $data = param('data', '', false); // 图片数据
    $the_tid = param('tid', 0); // 要编辑的帖子ID（0表示发新帖子）
    if($the_tid === 0) {
        $the_tid = intval(thread_maxid()) + 1;
    }

    if (empty($data)) {
        message(1, '数据为空');
        die;
    }

    $data = base64_decode_file_data($data);
    $size = strlen($data);

    $maxSize = intval(!empty($till_thread_cover_setting['max_size_mb']) ? $till_thread_cover_setting['max_size_mb'] : 2) * 1048576;

    if ($size > $maxSize) {
        message(1, lang('filesize_too_large', array('maxsize' => humansize($maxSize), 'size' => humansize($size))));
    }

    $filename = $the_tid . '_' . xn_rand(15) . '.png';
    $path = $conf['upload_path'] . 'thread_cover/';
    $url = $conf['upload_url'] . 'thread_cover/' . $filename;

    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    } else {
        message(-1, '目录创建失败');
    }

    $saveFile = file_put_contents($path . $filename, $data);
    if ($saveFile === false) {

        message(-1, '写入文件失败');
    }

    if (!is_file($path . $filename)) {

        message(-1, '上传失败');
    }

    message(0, array('text' => '封面图上传成功', 'url' => $url));
}
