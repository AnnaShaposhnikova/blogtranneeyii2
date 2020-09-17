<?php

namespace app\controllers;

use app\models\Reviews;
use app\models\SearchForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Posts;
use app\models\Courses;
use app\models\Minicourses;

use app\models\Sef;
use app\models\Sites;
use app\models\SiteForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
        if ($model -> load(Yii::$app->request->post()) && $model->validate()){
            $q = Html::encode($model->q);
            return $this->redirect(['site/search', 'q'=>$q]);
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
        $query = Posts::find();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $posts = $query->orderBy(['date' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        Posts::setNumber($posts);
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

    public function actionPost($id){
        $post = Posts::find()->where(['id'=> $id])->one();
        Posts::setNumber([$post]);

        return $this -> render ("post",[
            'post' => $post,
        ]);
    }

    public function actionSearch($q){
//        $q = Yii::$app->getRequest()->get('q');
        $query = Posts::find()->where(['like','full_text', $q]);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        Posts::setNumber($posts);
        $active_page = Yii::$app->request->get('page', 1);

        return $this-> render('search',[
            'posts'=> $posts,
            'q' =>$q,
            'pagination'=> $pagination,
            'active_page'=>$active_page,
        ]);
    }
}
