<?php !defined('DEBUG') and exit('Access Denied.');
include _include(APP_PATH . 'view/htm/header.inc.htm'); ?>

<style>
    .spinwin {
        width: 600px;
        height: 600px;
        background-image: url(plugin/fox_luckdraw/oddfox/static/img/disk.png);
        background-repeat: no-repeat;
        overflow: hidden;
    }

    .spinwin img {
        cursor: pointer;
        border-radius: 50%;
    }

    .spinwin_end {
        width: 600px;
        height: 100%;
        overflow: hidden;
        margin-top: -70px;
        text-align: center;
    }

    @media (max-width:767px) {

        .spinwin {
            background-size: 100% 100%;
            width: auto;
            height: auto;
        }

        .spinwin img {
            width: 100%;
            height: 100%;
        }

        .spinwin_end {
            width: auto;
            height: auto;
            margin-top: -40px;
        }

        .spinwin_end img {
            width: 100%;
            height: 100%;
        }
    }

    .xzif {
        width: 100%;
        text-align: center;
        height: 900px;
        border: 0;
        margin-left: 0px;
    }

    @media only screen and (min-width : 320px) and (max-width : 480px) {
        .xzif {
            width: 100%;
            text-align: center;
            height: 610px;
            border: 0;
            margin-left: 0px;
        }
    }

    @media screen and (min-width : 480px) and (max-width: 768px) {
        .xzif {
            width: 100%;
            text-align: center;
            height: 820px;
            border: 0;
            margin-left: 0px;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 1024px) {
        .xzif {
            width: 100%;
            text-align: center;
            height: 920px;
            border: 0;
            margin-left: 0px;
        }
    }
</style>

<h1 class="sr-only">幸运抽奖</h1>

<section class="row">
    <div class="col-lg-6">
        <article class="card ">
            <iframe frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes" src="<?php echo url('xzraffle-cjy'); ?>" style="width: 100%;" class="xzif rounded"></iframe>
        </article>
    </div>
    <div class="col-lg-6">
        <aside class="row">
        <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        抽奖规则
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">每日最多抽奖次数：<?php echo $jcpz['mrzdcjcs']; ?> 次</li>
                        <li class="list-group-item">每日免费抽奖次数：<?php echo $jcpz['mrmfcjcs']; ?> 次</li>
                        <li class="list-group-item bg-label-primary text-center"> <a href="<?php echo url('my-xzraffle'); ?>">购买抽奖码</a> </li>

                    </ul>

                </div>
            </div>
            <?php if ($user) { ?>

                <div class="col-md-6">

                    <div class="card">

                        <div class="card-header">
                            您的积分
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><?= $credits1_name ?></p>
                                    <p class="lead fs-4 mb-0"><b><?php echo $user['golds']; ?></b></p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><?= $credits2_name ?></p>
                                    <p class="lead fs-4 mb-0"><b><?php echo $user['credits']; ?></b></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            <div class="col-md-6 ">
                <div class="card">

                    <div class="card-header ">
                        抽奖日志
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($cjinfo as $item) { ?>
                            <li class="list-group-item"><span class="float-right text-grey hidden-lg"></span> 用户 <span class="text-danger"><?php echo getUsername($item['uid']); ?></span> 抽中 <span class="text-danger"><?php echo $item['jpname']; ?></span></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php }/*endif*/  ?>

        </aside>
    </div>
</section>

<?php include _include(APP_PATH . 'view/htm/footer.inc.htm'); ?>