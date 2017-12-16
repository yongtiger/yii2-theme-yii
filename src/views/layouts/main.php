<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use yii\widgets\Breadcrumbs;
use yongtiger\themeyii\ThemeAsset;
use yongtiger\timezone\TimeZone;

ThemeAsset::register($this);

// $i18n_The_content_can_not_be_blank = ThemeAsset::t('message', 'The content can not be blank.');
// $i18n_The_content_must_be_a_string = ThemeAsset::t('message', 'The content must be a string.');
// $i18n_The_content_can_only_contain_up_to_200_characters = ThemeAsset::t('message', 'The content can only contain up to 200 characters.');
// $this->registerJs(<<<JS
// $(".feed .nano").nanoScroller();
// var ias = jQuery.ias({container: ".feed .media-list", item: ".media", pagination: ".pagination", next: ".next a"});
// ias.on("rendered", function(items) { $(".feed .nano").nanoScroller(); emojify.run(); });
// ias.extension(new IASSpinnerExtension());
// ias.extension(new IASNoneLeftExtension());
// jQuery('#w0').yiiActiveForm([
//     {
//         "id":"feed-content","name":"content","container":".field-feed-content","input":"#feed-content",
//         "validate":function (attribute, value, messages, deferred, \$form) {
//             yii.validation.required(value, messages, {"message":"{$i18n_The_content_can_not_be_blank}"});
//             yii.validation.string(value, messages, {"message":"{$i18n_The_content_must_be_a_string}", "max":200, "tooLong":"{$i18n_The_content_can_only_contain_up_to_200_characters}", "skipOnEmpty":1});
//         }
//     }
// ], []);
// jQuery('#w6').modal({"show":false});
// JS
// );

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
<head>
    <meta charset="<?= \Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => ThemeAsset::format(isset(\Yii::$app->params['brandLabel']) ? \Yii::$app->params['brandLabel'] : \Yii::$app->name),
        'brandUrl' => isset(\Yii::$app->params['brandUrl']) ? \Yii::$app->params['brandUrl'] : \Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $leftMenuItems = [
        ['label' => \Yii::t('common', 'Home'), 'url' => ['/site/index']],
        ['label' => \Yii::t('app', 'About'), 'url' => ['/site/about']],
        ['label' => \Yii::t('app', 'Contact') . '<i class="fa fa-fire"></i>', 'url' => ['/site/contact'], 'encode' => false],   ///@see http://www.yiiframework.com/doc-2.0/yii-bootstrap-nav.html#$items-detail
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenuItems,
    ]);
    ?>

    <form class="navbar-form visible-lg-inline-block" action="/search" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="<?= ThemeAsset::t('message', 'Search')?>">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="fa fa-search"></span>
                </button>
            </span>
        </div>
    </form>

    <?php
    $rightMenuItems = [];
    if (\Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => \Yii::t('common', 'Signup'), 'url' => isset($this->params['signupUrl']) ? $this->params['signupUrl'] : ['/user/registration/signup']];
        $rightMenuItems[] = ['label' => \Yii::t('common', 'Login'), 'url' => \Yii::$app->user->loginUrl];
    } else {

        ///[v0.0.12 (ADD# ADD# avatarUrl)]///?????
        $profile = Yii::$app->user->identity->profile;
        $avatar = $profile->avatar;
        if (empty($avatar)) {
            // $directoryAsset = \Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');    ///e.g. `/[git]/yii2-brainblog/frontend/web/assets/574f730`
            // $directoryAsset = yongtiger\themeyii\ThemeAsset::getThemePath();    ///e.g. `@yongtiger/themeyii`
            $directoryAsset = ThemeAsset::getPublishedUrl(); ///e.g. `/frontend/web/assets/224ed38b`
            $avatarUrl = $directoryAsset . '/image/noavatar_small.gif';
        } else {
            $dstImageUri = '@web/upload/avatar';
            $avatarUrl = Url::to($dstImageUri . '/' . $avatar);
        }

        ///[v0.9.2 (frontend\views\layouts\main.php:Dropdown Logout by `a` tag)]
        ///@see http://www.yiiframework.com/doc-2.0/yii-bootstrap-dropdown.html
        ///@see http://v3.bootcss.com/components/#dropdowns
        $rightMenuItems[] = '<li class="dropdown">'
            . '<a href="#" class="avatar dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="' . \Yii::$app->user->identity->username . '"><img src="'. $avatarUrl .'" alt="' . \Yii::$app->user->identity->username . '"> <span class="caret"></span></a>' ///?????caret
            . Dropdown::widget([
                'items' => [
                    ['label' => \Yii::t('common', 'My Account'), 'url' => ['/user/account']],
                    ['label' => \Yii::t('common', 'User Profile'), 'url' => ['/user/profile/update', 'id' => \Yii::$app->user->id]],
                    
                    '<li class="divider"></li>',
                    '<li>'
                    . Html::a(
                        \Yii::t('common', 'Logout'),
                        isset($this->params['logoutUrl']) ? $this->params['logoutUrl'] : ['/site/logout'],
                        ['data-method' => 'post']
                    )
                    . '</li>'

                ],
            ])
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        
        <?= $content ?>
    </div>
    <a class="back-to-top btn btn-default"><span class="fa fa-arrow-up"></span></a>
</div>


<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <h2><i class="fa fa-info-circle"></i> 关于 Yii</h2>
                <ul>
                    <li><a href="http://www.yiichina.com/about">Yii 的简介</a></li>
                    <li><a href="http://www.yiichina.com/news">Yii 的动态</a></li>
                    <li><a href="http://www.yiichina.com/features">Yii 的特性</a></li>
                    <li><a href="http://www.yiichina.com/performance">Yii 的性能</a></li>
                    <li><a href="http://www.yiichina.com/license">Yii 的许可</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h2><i class="fa fa-book"></i> 文档手册</h2>
                <ul>
                    <li><a href="http://www.yiichina.com/doc">中文文档</a></li>
                    <li><a href="http://www.yiichina.com/download">框架下载</a></li>
                    <li><a href="http://www.yiichina.com/tutorial">中文教程</a></li>
                    <li><a href="http://www.yiichina.com/extension">安装扩展</a></li>
                    <li><a href="http://www.yiichina.com/code">优秀源码</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h2><i class="fa fa-commenting"></i> 社区资源</h2>
                <ul>
                    <li><a href="http://www.yiichina.com/question">社区问答</a></li>
                    <li><a href="http://www.yiichina.com/topic">社区讨论</a></li>
                    <li><a href="http://www.yiichina.com/case">用户案例</a></li>
                    <li><a href="http://www.yiichina.com/video">视频教程</a></li>
                    <li><a href="http://www.yiichina.com/top">会员排行</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h2><i class="fa fa-qq"></i> QQ交流群</h2>
                <ul class="list-unstyled">
                    <li>
                        ① <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=19f92b4525df025f856917537c4a6d9bb8dd6a0fc1c660b408d65cc21fef6c22">4241653</a> <font class="fast">(已满)</font>　
                        ② <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=38dee71f9bd97c37e131c0722e640fe7c12f459afc67ca34fb82d67dd1ab9b0c">4829703</a> <font class="secure">(未满)</font>
                    </li>
                    <li>
                        ③ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=215d55638b0eac69f25b68664d394579994b48b34789149855419c548a620d57">4958407</a> <font class="secure">(未满)</font>　
                        ④ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=7aa35873c42e820781a4822e7ba2c7352c3c85454ea9454009fe2c15a2797c5d">5476028</a> <font class="secure">(未满)</font>
                    </li>
                    <li>
                        ⑤ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=1a0c961d723cd24f98185b4a631f303efa05c2442f24022c3eb1ddb8b623a270">5478523</a> <font class="fast">(已满)</font>　
                        ⑥ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=f0ab6fcfcd0a431c53c0ef8e5538609a6920360c86b73dd401e7e88f1a2795b9">5604716</a> <font class="fast">(已满)</font>
                    </li>
                    <li>
                        ⑦ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=143aade31ff7a073a07bdc75d3c960b3f671a76f6f6de0c608c3702b6aac60a7">5629416</a> <font class="fast">(已满)</font>　
                        ⑧ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=57b5f15c3b1f35cd2721b45a6eb20fd63cc76a4776e5c1767b521f01c14dec9c">6419794</a> <font class="fast">(已满)</font>
                    </li>
                    <li>
                        ⑨ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=77e547190bdda1bac3d1fed071882b53585d63120f65ef656e7f4f0d3112cbdd">7415106</a> <font class="fast">(已满)</font>　
                        ⑩ <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=d626c01d0074072d2e01219259aab99d10d8691711a2882478c1dbf8a9b5e23e">7594839</a> <font class="fast">(已满)</font>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h2><i class="fa fa-share-alt"></i> 关注我们</h2>
                <dl>
                    <dt><i class="fa fa-weibo"></i> Yii 中文社区 官方微博</dt>
                    <dd><a href="http://weibo.com/yiichina">http://weibo.com/yiichina</a></dd>
                </dl>
                <dl>
                    <dt><i class="fa fa-github"></i> Yii China GitHub 仓库</dt>
                    <dd><a href="https://github.com/yiichina">https://github.com/yiichina</a></dd>
                </dl>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="clearfix">
            <span class="pull-left">Copyright © <?= \Yii::$app->params['CopyrightLabel'] ?> <?= date('Y') ?>. All Rights Reserved.</span>
            <span class="pull-right">
                Powered by 
                <a href="<?= \Yii::$app->params['poweredByUrl'] ?>" target="_blank"> <?= \Yii::$app->params['poweredByName'] ?>
                    <?= \Yii::$app->params['poweredByVersion'] ?> build <?= \Yii::$app->params['poweredByBuild'] ?>
                </a>
                <?= \Yii::$app->params['poweredBySourceLabel'] ?>
                <?= TimeZone::timezone_format(\Yii::$app->timeZone) ?>, <?= \Yii::$app->formatter->asDatetime(time()) ?>
            </span>
        </div>
    </div>
</footer>

<div id="w6" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>

<div class="panel panel-default online">
    <div class="panel-heading">在线<br><em>157</em>人</div>
    <div class="panel-body">
        <ul>
            <li><a href="http://www.yiichina.com/user/2190" rel="author"><img src="ff_files/90_avatar_small.jpg" alt="song100e"></a></li>
            <li><a href="http://www.yiichina.com/user/27171" rel="author"><img src="ff_files/71_avatar_small.jpg" alt="魔鬼"></a></li>
            <li><a href="http://www.yiichina.com/user/27825" rel="author"><img src="ff_files/25_avatar_small.jpg" alt="lionskys"></a></li>
            <li><a href="http://www.yiichina.com/user/39438" rel="author"><img src="ff_files/38_avatar_small.jpg" alt="diligentyang"></a></li>
            <li><a href="http://www.yiichina.com/user/40703" rel="author"><img src="ff_files/03_avatar_small.jpg" alt="易语晓乐"></a></li>
        </ul>
    </div>
    <div class="panel-footer">会员<br><em>5</em>人</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>