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
                    ['label' => 'Рабочий стол', 'icon' => 'share-alt', 'options' => ['class' => 'header']/*, 'url' => ['/office/desctop']*/],
                    ['label' => 'Моя организация', 'icon' => 'fa fa-id-card', 'url' => ['/office/my-organization']],
                    ['label' => 'Организации', 'icon' => 'fa fa-handshake-o', 'url' => ['/office/company']],
                    ['label' => 'Дома', 'icon' => 'fa fa-file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/buildings']*/],
                    ['label' => 'Квартплата', 'icon' => 'fa fa-file-code-o', 'options' => ['class' => 'header']],
                    ['label' => 'Диспетчерская', 'icon' => 'fa fa-tty', 'url' => ['/office/dispatching']],
                    [
                        'label' => 'Работа с должниками',
                        'icon' => 'fa fa-users',
                        'url' => ['/office/debtor'],
                    ],
                    /*[
                        'label' => 'Задолженности',
                        'icon' => 'list-alt',
                        'url' => ['/office/debtors/debt-verification'],
//                        'url' => ['#'],
//                        'items' => [
//                            ['label' => 'Работа с Должниками', 'icon' => 'file-code-o', 'url' => ['/office/debtors/debt-verification'],],
//                            ['label' => 'Список Должников', 'icon' => 'dashboard', 'url' => ['/debtor'],],
//                        ],
//                        'items' => [
//                            ['label' => 'Досудебная работа', 'icon' => 'file-code-o', 'url' => ['/office/debtors/verify-registration'],],
//                            ['label' => 'Судебная работа', 'icon' => 'dashboard', 'url' => ['/office/debtors/debt-verification'],],
//                            ['label' => 'Работа с приставами', 'icon' => 'dashboard', 'url' => ['/office/debtors/calculation-of-duty'],],
//                        ],
                    ],*/
                    ['label' => 'Справочник судов', 'icon' => 'fa fa-bank', 'url' => ['/court']],
                    /*[
                        //'label' => 'Заявление в суд',
                        'label' => 'Квартплата',
                        'icon' => 'dashboard',
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Курьер', 'icon' => 'file-code-o', 'options' => ['class' => 'header'], 'url' => ['/office/court/courier'],],
                        ],
                    ],*/
                    //['label' => 'Заявление приставам', 'icon' => 'file-code-o', 'url' => ['/office/statement-to-bailiffs']],
                    ['label' => 'Рассылки', 'icon' => 'file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/newsletters']*/],
                    ['label' => 'Отчеты', 'icon' => 'file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/reports']*/],
                    ['label' => 'Аналитика', 'icon' => 'file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/analytics']*/],
                    ['label' => 'Настройка', 'icon' => 'file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/customize']*/],
                    ['label' => 'Новости', 'icon' => 'file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/news']*/],
                    ['label' => 'Панель управления', 'icon' => 'file-code-o', 'options' => ['class' => 'header']/*, 'url' => ['/office/control-panel']*/],
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
