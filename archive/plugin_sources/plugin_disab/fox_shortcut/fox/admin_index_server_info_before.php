<?php !defined('DEBUG') AND exit('Access Denied.');?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">快捷管理 <a href="?plugin-setting-fox_shortcut.htm"><i class="icon-edit icon float-right"></i></a></h5>
        <hr>
        <div class="table-responsive">
            <table class="table">
                <?php 
                foreach($odd_shortcut_checked as $dir => $plugin){
                    $plugin['name'] = array_value($plugin, 'name');
                    $plugin['version_fmt'] = $action == 'local' ? $plugin['version'] : array_value($plugin, 'official_version');
                ?>
                <tr valign="top" dir="<?php echo $dir; ?>">
                    <td width="80" class="text-left hidden-sm pl-0"><a href="<?php echo url("plugin-read-$dir");?>" target="_blank"><img src="<?php echo $plugin['icon_url']; ?>" width="54" height="54" /></a></td>
                    <td class="pl-0">
                        <a href="<?php echo url("plugin-read-$dir");?>"><b><?php echo $plugin['name']; ?> </b></a>
                        <span class="small">v<?php echo $plugin['version_fmt']; ?> </span>
                        <?php if($plugin['have_upgrade']) { ?>
                        <span class="small text-danger font-weight-bold">v<?php echo array_value($plugin, 'official_version'); ?> </span>
                        <?php } ?>	
                        <br /><span class="small text-muted"><?php echo $dir; ?></span>								
                        <?php if(!empty($plugin['username'])) { ?>
                        <br />
                        <span class="small text-muted"><?php echo lang('author'); ?>：<a href="http://bbs.xiuno.com/user-<?php echo $plugin['uid'];?>.htm" target="_blank"><?php echo $plugin['username'];?></a></span>
                        <?php } ?>
                    </td>
                    <td width="180" align="right" class="pl-0 pr-0">							
                        <?php if($action == 'official_fee' && !$plugin['downloaded']) { ?>
                        <a role="button" class="btn btn-primary btn-sm buy" href="<?php echo url("plugin-read-$dir"); ?>"><?php echo lang('buy');?></a>
                        <?php } ?>

                        <?php if($action == 'official_free' && !$plugin['downloaded']) { ?>
                        <a role="button" class="btn btn-primary btn-sm download" href="<?php echo url("plugin-download-$dir"); ?>"><?php echo lang('download');?></a>
                        <?php } ?>
                        
                        <?php if($plugin['setting_url']) { ?>
                        <a role="button" class="btn btn-primary btn-sm setting" href="<?php echo url("plugin-setting-$dir"); ?>"><?php echo lang('setting');?></a>
                        <?php } ?>
                        
                        <?php if(!$plugin['installed'] && $plugin['downloaded']) { ?>
                        <a role="button" class="btn btn-primary btn-sm install" href="<?php echo url("plugin-install-$dir"); ?>"><?php echo lang('install');?></a>
                        <?php } ?>
                        
                        <?php if($plugin['installed'] && $plugin['enable']) { ?>
                        <a role="button" class="btn btn-secondary btn-sm disable" href="<?php echo url("plugin-disable-$dir"); ?>"><?php echo lang('disable');?></a>
                        <?php } ?>
                        
                        <?php if($plugin['installed'] && !$plugin['enable']) { ?>
                        <a role="button" class="btn btn-secondary btn-sm enable" href="<?php echo url("plugin-enable-$dir"); ?>"><?php echo lang('enable');?></a>
                        <?php } ?>
                        
                        <?php if($plugin['installed']) { ?>
                        <a role="button" class="btn btn-danger btn-sm unstall confirm" data-confirm-text="<?php echo lang('plugin_unstall_confirm_tips', array('name'=>$plugin['name']));?>" href="<?php echo url("plugin-unstall-$dir"); ?>"><?php echo lang('unstall');?></a>
                        <?php } ?>
                        
                        <?php if($plugin['have_upgrade']) { ?>
                        <a role="button" class="btn btn-primary btn-sm upgrade" href="<?php echo url("plugin-upgrade-$dir"); ?>"><?php echo lang('update');?></a>
                        <?php } ?>								
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>