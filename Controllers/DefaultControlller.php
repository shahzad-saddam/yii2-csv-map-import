<?php

namespace frontend\controllers;
use Yii;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMap()
    {
        if ( isset($_POST['import']) ) {
            $file = UploadedFile::getInstanceByName('file');
            $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            if($extension == 'csv') {
                $csv = new \League\Csv\Reader($file->tempName);
                $headers = $csv->fetchOne();

                $model = new Map();
                $columns = $model->jobColumns();
                $columns['dump'] = 'None';
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    $model = $this->updateLogo($model);
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $model = $this->findModel($id);

                    $searchModel = new UserSearch;
                    $searchModel->company_id = $id;
                    $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

                    $map = Map::find()->where(['company_id' => $id])->all();
                    //return $this->render('view', ['model' => $model, 'dataProvider' => $dataProvider]);
                    return $this->render('view', [
                        'columns' => $columns,
                        'headers' => $headers,
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'map' => $map
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('error', "Wrong file type Uploaded!");
                return $this->redirect(['view', 'id' => $id]);
            }
        } else if( isset($_GET['edit']) &&  $_GET['edit'] == 'map'){

            $model = new Map();
            $headers = $model->csvColumns();
            $selected_columns = $model->csvSelected();
            //echo "<pre>"; die(print_r($selected_columns));
            $columns = $model->jobColumns();
            $columns['dump'] = 'None';
            $model = $this->findModel($id);

            $searchModel = new UserSearch;
            $searchModel->company_id = $id;
            $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

            $map = Map::find()->where(['company_id' => $id])->all();
            //return $this->render('view', ['model' => $model, 'dataProvider' => $dataProvider]);
            return $this->render('view', [
                'columns' => $columns,
                'headers' => $headers,
                'selected_columns' => $selected_columns,
                'model' => $model,
                'dataProvider' => $dataProvider,
                'map' => $map
            ]);
        }
    }


    public function actionImport(){
        if (isset($_POST['import'])) {
            $file = UploadedFile::getInstanceByName('file');
            $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            if($extension == 'csv') {
                $csv = new \League\Csv\Reader($file->tempName);
                $headers = $csv->fetchOne();
                $headers[0] = 'Service Window';
                $csv->setOffset(1);
                $data = $csv->fetchAssoc($headers);
                //echo "<pre>"; print_r($data);exit;
                $success = 0;
                $error = 0;


                foreach($data as $row) {
                    if(array_filter($row)) {
                        if(Job::createOrUpdateJob($this->company->id, $row)){
                            $success++;
                        } else {
                            $error++;
                        }
                    }
                }

                Yii::$app->session->setFlash('success', "$success records are imported successfully. Found errors in $error records.");
                $this->redirect(['jobs/index']);
            } else {
                Yii::$app->session->setFlash('error', "Wrong file type Uploaded!");
                $this->redirect(['jobs/import']);
            }
        }
        return $this->render('import');
    }



}