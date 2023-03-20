<?php

namespace app\controllers;

use app\models\Post;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->redirect(['dashboard/1']);

    }
    public function actionDashboard($page)
    {
        $diarys = \app\models\Diary::find()->with('user')->orderBy(["id" => SORT_DESC])->limit(5)->offset(($page - 1) * 5);
        $count = $diarys->count();
        $diarys = $diarys->all();
        $pages = ($count % 5 === 0) ? $count / 5 : $count / 5 + 1;
        return $this->render('index', compact("diarys", "pages", "page"));
    }

    public function actionDiary($id)
    {
        $posts = \app\models\Post::find()->with(["diary", "user"])->where(["diary_id" => $id])->asArray()->all();
        $replys = \app\service\BBCode::replyShit($posts);
        $posts = array_map(function ($item) {
            $item['message'] = \app\service\BBCode::parseBB($item['message'], $item["id"]);
            return $item;
        }, $posts);

        return $this->render('diary', compact("posts", "replys"));

    }
    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['dashboard/1']);
    }

    public function actionRegister()
    {
        $login = Yii::$app->request->post()["login"];
        $email = Yii::$app->request->post()["email"];
        $password = Yii::$app->request->post()["password"];
        $exist = User::find()->where(['email' => $email])->exists();
        if (!$exist) {
            $_password = \Yii::$app->security->generatePasswordHash($password);
            $user = new User();
            $user->name = $login;
            $user->email = $email;
            $user->password = $_password;
            $user->save();
        }

        $user = User::findOne(['email' => $email]);
        $check = Yii::$app->security->validatePassword($password, $user->password);
        if (!$check) {
            return $this->redirect(['login']);
        }
        Yii::$app->user->login($user, 1337 * 100);
        return $this->redirect(['dashboard/1']);

    }
    public function actionPost($id)
    {
        $post = new Post();
        $post->message = Yii::$app->request->post()["message"];
        $post->user_id = Yii::$app->user->identity->id;
        $post->diary_id = $id;
        if ($post->validate()) {
            $post->save();
            return $this->redirect('/diary/' . $id);
        } else {
            var_dump("error");
            die;
        }

    }
    public function actionEditpost($post)
    {
        $post = Post::findOne($post);
        return $this->render('editpost', compact("post"));


    }
    public function actionEditpostupdate($post)
    {
        $post = Post::findOne($post);
        if ($post->user_id != Yii::$app->user->identity->id) {
            return;
        }
        $post->message = Yii::$app->request->post()["message"];
        $post->save();
        return $this->redirect('/diary/' . $post->diary->id);


    }
    public function actionEditpostdelete($post)
    {
        $post = Post::findOne($post);
        if ($post->user_id != Yii::$app->user->identity->id) {
            return;
        }
        if ($post->diary->post[0]->id == $post->id) {
            $post->diary->delete();
            return $this->redirect('/dashboard/1');
        }
        $post->delete();
        return $this->redirect('/diary/' . $post->diary->id);

    }
}