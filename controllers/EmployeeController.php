<?php

namespace app\controllers;

use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use app\models\DeptoEmpregado;
use app\models\Department;
use app\models\Title;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'departments' => Department::find()->all()
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'managers' => $model->getManagers()
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();
        $model->getNextId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('feedback', 'Informações gerais salvas com sucesso! Navegue entre as abas para preencher mais informações');

            return $this->redirect(['update', 'id' => $model->emp_no]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('feedback', 'Informações gerais salvas com sucesso! Navegue entre as abas para preencher mais informações');
            return $this->redirect(['update', 'id' => $model->emp_no]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * realiza a associação entre departamentos e funcionários (tabela dept_emp)
     * @return void
     */
    public function actionCreateDepartments()
    {
        $post = Yii::$app->request->post();
        
        $delete = DeptoEmpregado::deleteRelation($post['emp_no']);

        $insert = DeptoEmpregado::insertBatch($post);

        if ($insert > 0) {
            \Yii::$app->getSession()->setFlash('feedback', 'Informações gerais salvas com sucesso! Navegue entre as abas para preencher mais informações');

            \Yii::$app->getSession()->setFlash('feedback_warning', 'Visualize a tela de visualização do colaborador para verificar os departamentos salvos');

            return $this->redirect(['update', 'id' => $post['emp_no']]);
        }

        \Yii::$app->getSession()->setFlash('feedback_error', 'Algo de errado ocorreu ao salvar as informações');

        return $this->redirect(['update', 'id' => $post['emp_no']]);
    }

    /**
     * realiza a associação entre títulos e funcionários (tabela titles)
     * @return void
     */
    public function actionCreateTitle()
    {
        $post = Yii::$app->request->post();
        
        $delete = Title::deleteRelation($post['emp_no']);

        $insert = Title::insertBatch($post);

        if ($insert > 0) {
            \Yii::$app->getSession()->setFlash('feedback', 'Informações gerais salvas com sucesso! Navegue entre as abas para preencher mais informações');

            \Yii::$app->getSession()->setFlash('feedback_warning', 'Visualize a tela de visualização do colaborador para verificar os títulos salvos');

            return $this->redirect(['update', 'id' => $post['emp_no']]);
        }

        \Yii::$app->getSession()->setFlash('feedback_error', 'Algo de errado ocorreu ao salvar as informações');

        return $this->redirect(['update', 'id' => $post['emp_no']]);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
