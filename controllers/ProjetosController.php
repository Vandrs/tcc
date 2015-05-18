<?php

namespace app\controllers;

use Yii;
use app\models\negocio\Projeto;
use app\models\search\ProjetoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjetosController implements the CRUD actions for Projeto model.
 */
class ProjetosController extends Controller
{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Projeto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjetoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Projeto model.
     * @param integer $_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionVisualizar($slug){
        $this->layout = "projeto";
        $projeto = Projeto::findBySlug($slug);
        return $this->render('visualizar',[
            'projeto' => $projeto
        ]);
    }

    /**
          * Creates a new Projeto model.
          * If creation is successful, the browser will be redirected to the 'view' page.
          * @return mixed
          */
    public function actionNovo()
    {
        $this->layout = "projeto";
        
        $model = new Projeto();
        $model->setScenario('novoProjeto');
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->uploadFile('foto_capa');
            $model->uploadFile('anexo');
            $model->setOwner(Yii::$app->user->identity);
            if(!$model->hasErrors()){
                if($model->save()){
                    return $this->redirect(['visualizar', 'slug' => $model->slug]);
                }
            } 
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }
 
   /**
     * Updates an existing Projeto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        
        if(Yii::$app->user->isGuest || empty($model) || !$model->userBelongsToProject(Yii::$app->user->identity)){
            return $this->render('/site/error',["message"=>"Você não tem permissão para acessar esta página.","name" => "Acesso negado"]);
        }
        
        $this->layout = "projeto";
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => (string)$model->_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Projeto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Projeto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Projeto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projeto::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }

}