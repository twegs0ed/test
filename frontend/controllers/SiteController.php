<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @inheritdoc
     */
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
     * @return mixed
     */
    public function actionIndex()     {
        $ingr_c = Yii::$app->request->post('ingr');
        if (count($ingr_c)<2) $mess='Выберите больше ингредиентов';
        $dish_ingr = \common\models\dish_ingr::findAll(['ingr_id' => $ingr_c]);//Находим все блюда, в которых упоминаются
                                                                                //введенные ингридиенты
        foreach ($dish_ingr as $dish_ingr_c)         {
            $dish_id[] = $dish_ingr_c->dish_id;//Сохраняем id этих блюд
        }
        $dish_id=array_unique($dish_id);
        //die(var_dump($dish_id));
        foreach($dish_id as $dish_id_c)
        {
            $dish_ingr_c = \common\models\dish_ingr::findAll(['dish_id' => $dish_id_c]);//все ингридиенты этого блюда
            if(count($ingr_c) == count($dish_ingr_c)) /*если количество введенных ингридиентов 
             * равно количеству игридиентов в блюде - сохраням в массив
             */
            {
               // die('qsd');
                $dish_id_f[] = $dish_id_c;
            }
            
        }
        
        if (!$dish_id_f) {
            foreach ($dish_id as $dish_id_c) {
                $mess='Ничего не найдено';
                $dish_ingr_c = \common\models\dish_ingr::findAll(['dish_id' => $dish_id_c]); //все ингридиенты этого блюда
                if (count($ingr_c) > count($dish_ingr_c)) /* если количество введенных ингридиентов 
                 * больше количества игридиентов в блюде - сохраням в массив
                 */ {
                    // die('qsd');
                    $dish_id_f[$dish_id_c] = $dish_ingr_c;
                }
                $count = count(\common\models\dish_ingr::findAll(['dish_id' => $dish_id_c, 'ingr_id' => $ingr_c]));
               if ($count > 2) {
                    unset($mess);
                }
            }
            
            uasort($dish_id_f, function($first, $second) {
                if (count($first) == count($second)) {
                    return 0;
                }
                return (count($first) < count($second) ? -1 : 1);

            });
        }
        
        $dish_id_f= array_keys($dish_id_f);
        $dish_id_f = array_unique($dish_id_f);
        $dish = \common\models\dish::findAll($dish_id_f);




        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\dish::find()->where(['id' => $dish_id_f]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $ingr = \common\models\Ingr::find()->all();
        return $this->render('index', [
                    'ingr' => $ingr,
                    'ingr_c' => $ingr_c,
                    'dish' => $dish,
                    'dataProvider' => $dataProvider,
                    'mess' => $mess
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
