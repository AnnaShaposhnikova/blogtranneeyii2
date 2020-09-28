<?php

namespace app\controllers;

use app\models\PostsSearch;
use app\models\Reviews;
use app\models\SearchForm;
use app\models\Users;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Posts;
use app\models\Courses;

use app\models\RegisterForm;
use app\models\Sites;
use app\models\SiteForm;


class SiteController extends Controller
{
    public $layout = '@app/views/layouts/main';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'register'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register'],
                        'roles' => ['?'],
                    ],

                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $model = new SearchForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $q = Html::encode($model->q);
            return $this->redirect(['site/search', 'q' => $q]);
        }
        return true;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $query = Posts::find()->where(['is_release' => 1]);
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $posts = $query->orderBy(['date' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $active_page = Yii::$app->request->get('page', 1);

        return $this->render('index', [
            'posts' => $posts,
            'active_page' => $active_page,

            'pagination' => $pagination,
        ]);
    }

    public function actionAuthor()
    {
        return $this->render('author');
    }

    public function actionVideo()
    {
        $courses = Courses::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('video', [
            'courses' => $courses
        ]);
    }

    public function actionReviews()
    {
        $reviews = Reviews::find()->orderBy('rand()')->all();

        return $this->render('reviews', [
            'reviews' => $reviews,

        ]);
    }

    public function actionRelease()
    {
        return $this->render('release');
    }

    public function actionSites()
    {
        $sites = Sites::find()->where(['active' => 1])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('sites', [
            'sites' => $sites,
        ]);
    }

    public function actionAddsite()
    {
        $model = new SiteForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $site = new Sites();
            $site->address = $model->address;
            $site->description = $model->description;
            $site->save();

            return $this->render('addsite', [
                'model' => $model,
                'success' => true,
                'error' => false,
            ]);
        } else {
            if (isset($_POST["address"])) {
                $error = true;
            } else {
                $error = false;
            }
            return $this->render('addsite', [
                'model' => $model,
                'success' => true,
                'error' => $error,
            ]);
        }
    }

    public function actionPost($id)
    {
        $post = Posts::find()->where(['id' => $id])->one();
        $user = Yii::$app->user->identity;

        if (!$post->is_release && (!$user || $post->user_id != $user->id)){

            throw new NotFoundHttpException();
        }

        return $this->render("post", [
            'post' => $post,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->redirect(['site/index']);
        } else {
            return $this->render('login',
                ['model' => $model]);
        }
    }

    public function actionRegister()
    {
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['site/index']);
        }
        return $this->render('register',
            ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfile()
    {

        $user = Yii::$app->user->identity;

        $query = Posts::find()->where((['user_id' => $user->getId()]));
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('profile', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

}
