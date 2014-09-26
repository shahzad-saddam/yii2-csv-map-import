<?php

namespace backend\models;

use frontend\models\Job;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property string $columname
 * @property string $csvfield
 * @property string $created_at
 * @property string $updated_at
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public static function jobColumns()
    {
        $columns = Job::getTableSchema()->columnNames;
        $columns = array_combine($columns, $columns);
        unset($columns['id']);
        unset($columns['company_id']);
        unset($columns['created_at']);
        unset($columns['updated_at']);
        return $columns;

    }

    public static function csvColumns()
    {
        $output = [];
        $columns = Map::find()->select('csvfield')->asArray()->all();
        foreach ( $columns as $data ) {
            $output[] = $data['csvfield'];
        }
        return $output;
    }

    public static function csvSelected()
    {
        $output = [];
        $columns = Map::find()->select('csvfield, columname')->asArray()->all();
        foreach ( $columns as $data ) {
            $output[$data['csvfield']] = $data['columname'];
        }
        return $output;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['columname', 'csvfield'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['columname', 'csvfield'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'columname' => 'Column Name',
            'csvfield' => 'Csv Field',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function createOrUpdateMap($csvfield, $columnname)
    {
        $company_id = Yii::$app->request->get('company_id');
        $map = Map::find()
            ->where(['csvfield' => $csvfield])
            ->andWhere("company_id = $company_id")
            ->orderBy('id')
            ->one();

        if (!$map) {
            $map = new Map();
            $map->csvfield = $csvfield;
            $map->company_id = $company_id;
            $map->created_at = date('Y-m-d H:i:s');
        }
        $map->columname = $columnname;
        $map->updated_at = date('Y-m-d H:i:s');

        if (!$map->save()) {
            die(var_dump($map->getErrors()));
            return null;
        } else {
            return $map;
        }
    }
}
