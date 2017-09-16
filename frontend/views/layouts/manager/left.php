<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!--<div class="user-panel">
            <div class="pull-left image">
                <img src="<? /*= $directoryAsset */ ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>-->

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    //['label' => 'Меню Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Рабочий стол', 'icon' => 'share-alt', 'url' => ['/manager/desctop']],
                    ['label' => 'Моя организация', 'icon' => 'file-code-o', 'url' => ['/manager/my-organization']],
                    ['label' => 'Организации', 'icon' => 'users', 'url' => ['/manager/organizations']],
                    ['label' => 'Дома', 'icon' => 'file-code-o', 'url' => ['/manager/buildings']],
                    [
                        'label' => 'Должники',
                        'icon' => 'dashboard',
                        //'url' => ['/manager/debtors'],
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Проверка регистрации', 'icon' => 'file-code-o', 'url' => ['/manager/debtors/verify-registration'],],
                            ['label' => 'Проверка задолженности', 'icon' => 'dashboard', 'url' => ['/manager/debtors/debt-verification'],],
                            ['label' => 'Расчет пошлины', 'icon' => 'dashboard', 'url' => ['/manager/debtors/calculation-of-duty'],],
                        ],
                    ],
                    [
                        'label' => 'Заявление в суд',
                        'icon' => 'dashboard',
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Курьер', 'icon' => 'file-code-o', 'url' => ['/manager/court/courier'],],
                        ],
                    ],
                    ['label' => 'Заявление приставам', 'icon' => 'file-code-o', 'url' => ['/manager/statement-to-bailiffs']],
                    ['label' => 'Рассылки', 'icon' => 'file-code-o', 'url' => ['/manager/newsletters']],
                    ['label' => 'Отчеты', 'icon' => 'file-code-o', 'url' => ['/manager/reports']],
                    ['label' => 'Аналитика', 'icon' => 'file-code-o', 'url' => ['/manager/analytics']],
                    ['label' => 'Настройка', 'icon' => 'file-code-o', 'url' => ['/manager/customize']],
                    ['label' => 'Новости', 'icon' => 'file-code-o', 'url' => ['/manager/news']],
                    ['label' => 'Панель управления', 'icon' => 'file-code-o', 'url' => ['/manager/control-panel']],
                    /*['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/
                ],
            ]
        ) ?>

    </section>

</aside>
