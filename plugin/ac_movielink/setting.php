
<?php
!defined('DEBUG') AND exit('Access Denied.');

$action = param(3);

if (empty($action)) {
    // 获取数据列表
    $movielink_linklist = db_find('movielink', array(), array(), 1, 1000, 'linkid');
    $maxid = db_maxid('movielink', 'linkid');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        include _include(APP_PATH.'plugin/ac_movielink/setting.htm');
    } else {
        // 获取表单提交的数据
        $rowidarr = param('rowid', array(0));
        $namearr = param('name', array(''));
        $urlarr = param('url', array(''));
        $imgurlarr = param('imgurl', array(''));
        $nametypearr = param('nametype', array(''));
        // 获取开始时间和结束时间数据
        $start_time_arr = param('start_time', array(''));
        $end_time_arr = param('end_time', array(''));

        $arrlist = array();

        foreach ($rowidarr as $k => $v) {
            // 如果名称和地址都为空，则跳过这条记录
            if (empty($namearr[$k]) && empty($urlarr[$k])) continue;

            $start_time = isset($start_time_arr[$k])? $start_time_arr[$k] : '00:00';
            $end_time = isset($end_time_arr[$k])? $end_time_arr[$k] : '00:00';

            $arr = array(
                'linkid' => $k,
                'name' => isset($namearr[$k])? $namearr[$k] : 'Undefined',
                'url' => isset($urlarr[$k])? $urlarr[$k] : '#',
                'imgurl' => isset($imgurlarr[$k])? $imgurlarr[$k] : 'view/img/logo.png',
                'nametype' => isset($nametypearr[$k])? $nametypearr[$k] : 1,
                // 设置开始时间和结束时间字段值
                'start_time' => $start_time,
                'end_time' => $end_time
            );

            try {
                // 如果记录不存在，则创建新记录
                if (!isset($movielink_linklist[$k])) {
                    db_create('movielink', $arr);
                } else {
                    // 如果记录存在，则更新记录
                    db_update('movielink', array('linkid' => $k), $arr);
                }
            } catch (\Exception $e) {
                // 数据库操作失败时的错误处理
                error_log("数据库操作失败：". $e->getMessage());
            }
        }

        // 删除操作
        $deletearr = array_diff_key($movielink_linklist, $rowidarr);

        foreach ($deletearr as $k => $v) {
            try {
                db_delete('movielink', array('linkid' => $k));
            } catch (\Exception $e) {
                // 删除操作失败时的错误处理
                error_log("删除记录失败：". $e->getMessage());
            }
        }

        message(0, '保存成功');
    }
}
?>