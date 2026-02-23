<?php !defined('DEBUG') and exit('Access Denied.');
if ($isfirst && $group['allowsell'] == 1) {?>
<div class="form-group input-group" id="form-group-radio">
    <div class="input-group-prepend"><span class="input-group-text">收费项目：</span></div>
    <div class="custom-input form-control">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sell_type" value="0" id="sell_type_0" <?= ($sell_type == 0 ) ? 'checked' : '' ?>>
            <label class="form-check-label" for="sell_type_0">无</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sell_type" value="1" id="sell_type_1" <?= ($sell_type == 1 ) ? 'checked' : '' ?>>
            <label class="form-check-label" for="sell_type_1">附件收费</label>
        </div>

        <div class="form-check form-check-inline" hidden>
            <input class="form-check-input" type="radio" name="sell_type" value="2" id="sell_type_2" <?= ($sell_type == 2 ) ? 'checked' : '' ?>>
            <label class="form-check-label" for="sell_type_2">链接收费</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sell_type" value="3" id="sell_type_3" <?= ($sell_type == 3 ) ? 'checked' : '' ?>>
            <label class="form-check-label" for="sell_type_3">收费内容</label>
        </div>

        
        <button type="button" id="buy_cotent_button" data-bs-toggle="modal" data-bs-target="#fox_buy_modal" class="btn btn-sm bg-label-success" style="display:none">插入收费内容</button>
        <button type="button" id="buy_links_button" data-bs-toggle="modal" data-bs-target="#fox_link_modal" class="btn btn-sm bg-label-success" style="display:none">插入收费链接</button>
    </div>
</div>
<div class="form-group input-group" id="buy_price_input" style="display:none">
    <div class="input-group-prepend">
        <span class="input-group-text">收取费用：</span>
    </div>
    <input type="number" name="buy_price" id="buy_price" placeholder="0" value="<?php echo $buy_price; ?>" min="0" maxlength="5" class="form-control">
    <select name="buy_price_type" id="buy_price_type" class="form-select flex-grow-0 flex-shrink-1 w-auto">
        <option value="1" <?= ($buy_price_type == 1 ) ? 'checked' : '' ?> ><?php echo $conf['exp_unit']; ?> <?php echo $conf['exp_name']; ?></option>
        <option value="2" <?= ($buy_price_type == 2 ) ? 'checked' : '' ?> ><?php echo $conf['gold_unit']; ?> <?php echo $conf['gold_name']; ?></option>
        <option value="3" <?= ($buy_price_type == 3 ) ? 'checked' : '' ?> ><?php echo $conf['rmb_unit']; ?> <?php echo $conf['rmb_name']; ?></option>
    </select>
</div>
<div class="modal fade" id="fox_buy_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">插入收费内容</h5>
            </div>
            <div class="modal-body">
                <textarea name="fox_buy" id="fox_buy" class="form-control w-100 h-px-100"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="fox_buy_submit_modal()">确定</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="fox_link_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:600px!important;margin-top:150px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">插入链接网址</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="min-width:92px;">链接网址</span>
                            </div>
                            <input type="text" name="fox_link" id="fox_link" class="form-control" placeholder="https://">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="min-width:92px;letter-spacing:1px;">提取码</span>
                            </div>
                            <input type="text" name="fox_code" id="fox_code" class="form-control" placeholder="有则填写，无则留空" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="min-width:92px;">解压密码</span>
                            </div>
                            <input type="text" name="fox_deco" id="fox_deco" placeholder="有则填写，无则留空" class="form-control" />
                        </div>
                    </div>
                </div>
                
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="fox_link_submit_modal()">确定</button>
            </div>
        </div>
    </div>
</div> <?php if ($conf['vip_on'] && $conf['vip_check_on'] && vip_isvip($uid)) {?> <div class="form-group input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">是否启用vip限制：</span>
    </div>
    <div class="custom-input form-control"> <?php echo form_radio_yes_no('vip_leave_on', isset($thread) ? ($thread['vip_leave_look'] > 0 ? 1 : 0) : 0); 
        /* 以上三目运算符的转写：
        if(isset($thread)) {
            if($thread['vip_leave_look'] > 0) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        } */
        ?> </div>
</div>
<div id="vip_leave_box" class="rounded border p-2" style="display:<?php echo isset($thread) ? ($thread['vip_leave_look'] > 0 ? 'block' : 'none') : 'none'; ?>">
    <div class="row">
        <div class="col-md-3">
            设置可见vip等级
        </div>
        <div class="col-md-9">
            <div class="d-flex">
                <select name="buy_vip_leave" id="buy_vip_leave" class="form-select flex-grow-1 flex-shrink-1"> 
                    <?php foreach ($conf['leave_exp'] as $key => $v) {?> 
                        <option value="<?php echo $key ?>" <?= isset($thread) ? ($thread['vip_leave_look'] == $key ? 'selected' : '') : '' ?>>
                            <?php echo '等级' . $key; ?>
                        </option> 
                        <?php }/* endforeach */ ?> 
                    </select>
                    <button type="button" id="buy_vip_button" data-bs-toggle="modal" data-bs-target="#fox_link_modal" class="btn btn-success flex-grow-1 flex-shrink-0">插入vip可见内容</button>
                </div>
        </div>
        <div class="col-md-3 pt-2">
            整贴<?php echo lang('VIPonly'); ?> : 
        </div>
        <div class="col-md-9 pt-2">
            <?php echo form_radio_yes_no('vip_only_thread', isset($thread) ? ($thread['vip_only_thread'] > 0 ? 1 : 0) : 0); ?>
        </div>
        <div class="col-md-3 pt-2">
            附件<?php echo lang('VIPonly'); ?> : 
        </div>
        <div class="col-md-9 pt-2">
            <?php echo form_radio_yes_no('vip_only_attach', isset($thread) ? ($thread['vip_only_attach'] > 0 ? 1 : 0) : 0); ?>
        </div>

    </div>

</div>
<div class="modal fade" id="fox_vip_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">插入vip可见内容</h5>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0">
                    <div class="col-sm-12">
                        <textarea name="fox_vip_context" id="fox_vip_context" class="form-control w-100 h-px-100"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="fox_vip_submit_modal()">确定</button>
            </div>
        </div>
    </div>
</div> <?php }?> <?php }?>