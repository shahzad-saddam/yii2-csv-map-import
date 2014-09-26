<?php

namespace frontend\models;

use backend\models\Map;
use common\models\Company;
use frontend\models\User;
use frontend\components\TActiveRecord;
use Yii;

/**
 * This is the model class for table "jobs".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $area_id
 * @property integer $tech_id
 * @property string $job_type
 * @property string $job_number
 * @property string $account_number
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $home_phone
 * @property string $other_phone
 * @property string $job_date
 * @property string $status_id
 * @property string $time_frame
 * @property string $image1
 * @property string $image2
 * @property string $image3
 * @property string $latitude
 * @property string $longitude
 * @property string $date_taken
 * @property string $created_at
 * @property string $updated_at
 */
class Job extends TActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jobs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'area_id', 'tech_id',  'job_type', 'job_number', 'account_number', 'first_name', 'time_frame','status_id'], 'required'],
            [['company_id', 'area_id', 'tech_id'], 'integer'],
            [['first_name', 'last_name', 'zip', 'job_date', 'date_taken', 'created_at', 'updated_at'], 'safe'],
            [['time_frame'], 'string'],
            //[['job_number'], 'unique'],
            [['city', 'state', 'home_phone', 'other_phone', 'address'], 'string', 'max' => 255],
        ];
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'area_id' => 'Area ID',
            'tech_id' => 'Tech',
            'job_type' => 'Job Type ID',
            'job_number' => 'Job Number',
            'account_number' => 'Account Number',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'home_phone' => 'Home Phone',
            'other_phone' => 'Other Phone',
            'job_date' => 'Job Date',
            'status_id' => 'Status ID',
            'time_frame' => 'Time Frame',
            'image1' => 'Image1',
            'image2' => 'Image2',
            'image3' => 'Image3',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'date_taken' => 'Date Taken',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'areaName' => Yii::t('app', 'Area Name'),
            'techName' => Yii::t('app', 'Tech Name'),
            'statusName' => Yii::t('app', 'Status'),
            'typeName' => Yii::t('app', 'Job Type'),
            'jobInformation' => Yii::t('app', 'Job Information'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobInformation()
    {
        $job_info = '';
        $job_info_temp = unserialize($this->job_information);

        if( ((int) count($job_info_temp)) > 1 ){
            $job_info = '<ul class="job_info">';
            foreach($job_info_temp as $key => $value){
                $job_info .=  "<li><span class='job-info-head'>$key</span> = $value</li>";
            }
            $job_info .= '</ul>';
        }
        return $job_info;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage1Link()
    {

        if(!empty($this->image1)) {
            $image1_temp = explode('/', $this->image1);
            $path = Yii::$app->request->hostInfo .'/uploads/jobs/' . $image1_temp[count($image1_temp)-1];
            return '<a href="'. $path .'">'.$image1_temp[count($image1_temp)-1] . '</a>';
        }
        return '';

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage2Link()
    {

        if(!empty($this->image2)) {
            $image2_temp = explode('/', $this->image2);
            $path = Yii::$app->request->hostInfo .'/uploads/jobs/'  . $image2_temp[count($image2_temp)-1];
            return '<a href="' . $path . '">'.$image2_temp[count($image2_temp)-1] . '</a>';
        }
        return '';

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage3Link()
    {

        if(!empty($this->image3)) {
            $image3_temp = explode('/', $this->image3);
            $path = Yii::$app->request->hostInfo .'/uploads/jobs/'  . $image3_temp[count($image3_temp)-1];
            return '<a href="'. $path .'">'.$image3_temp[count($image3_temp)-1] . '</a>';
        }
        return '';

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(JobStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusName()
    {
        //die($this->status);
        return $this->status->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(JobType::className(), ['id' => 'job_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeName()
    {
        return $this->type->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyName()
    {
        return $this->company->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaName()
    {
        return $this->area->location;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTech()
    {
        return $this->hasOne(User::className(), ['id' => 'tech_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTechName()
    {
        if ($this->tech) {
            return $this->tech->first_name . ' ' . $this->tech->last_name;
        }
    }

    /**
     * All Techs/Users
     * Return array of all techs
     * @param $condition
     * @return array $users
     */
    public static function getAllTechs($condition = NULL)
    {
        $users = array();
        $users_raw = User::find()->select('id, first_name, last_name')
            ->andWhere(['company_id' => Company::getCompanyBySubdomain()->attributes['id']]);

        if(is_array($condition)){
            $users_raw = $users_raw->andWhere($condition);
        }
        $users_raw = $users_raw->asArray()->all();
        foreach ($users_raw as $user) {
            $users[$user['id']] = $user['first_name'] . ' ' . $user['last_name'];
        }

        return $users;
    }

    /**
     * Update or Create and Job
     * Create or update a job
     * @param $company_id
     * @param $row
     * @internal param $area_name
     * @internal param array $area_info
     * @return Area object
     */
    public static function createOrUpdateJob($company_id, $row)
    {
        if (isset($row['Addr/City/Zip'])) {
        } else  die(print_r($row));
        $job = Job::find()
            ->where(['work_order' => $row['Work Order']])
            ->andWhere(['company_id' => $company_id])
            ->orderBy('id')
            ->one();

        // mapping of csv fields based on map feature
        $map = Map::find()->select(['id', 'columname', 'csvfield'])
            ->where("company_id = $company_id")
            ->indexBy('id')->asArray()->all();


        // list of job table fields except id, company_id, created_at, updated_at
        $map_model = new Map();
        $columns = $map_model->jobColumns();

        //mapped fields
        foreach ($map as $mapitem) {
            $mapping[$mapitem['columname']] = str_replace('_', ' ', $mapitem['csvfield']);
        }
        unset($mapping['dump']);


        if (!$job) {
            $job = new Job();
            $job->company_id = $company_id;
            $job->work_order = $row[$mapping['work_order']];
        }

        $job_information = array();

        foreach ($columns as $column) {

            if (!in_array($column, ['work_done', 'area_id', 'tech_id', 'status_id', 'job_type'])) {

                if (isset($mapping[$column])) {

                    $job->$column = $row[$mapping[$column]];
                } else {
                    foreach ($row as $key => $item) {
                        if (!in_array($key, $mapping)) {
                            $job_information[$key] = $item;
                        }
                    }
                }
            } else {
                if ($column == 'area_id') {
                    $job->area_id = Area::findOrCreate("New York")->id;
                }
                if ($column == 'status_id') {
                    $job->status = JobStatus::findOrCreate($company_id, $row[$mapping[$column]])->id;
                }
                if ($column == 'job_type') {
                    $job->job_type = JobType::findOrCreate($company_id, $row[$mapping[$column]])->id;
                }
            }
        }

        $job->job_information = serialize($job_information);

        //$job->area_id = Area::findOrCreate("New York")->id;
        //$job->tech_id = User::findOne(['company_id' => $company_id])->id;
        //$job->job_type = $row['Type'];
        //$job->job_number = $row['Job Sequence Number'];
        //$job->account_number = $row['Account Number'];

        //$name = explode(' ', trim($row['Name']));
        //$first_name = $name[0];
        //$last_name = isset($name[1]) ? $name[1] : '';
        //$job->first_name = $first_name;
        //$job->last_name = $last_name;

        //$address = self::getAddress($row['Addr/City/Zip']);
        //$job->address = $address['Address'];
        //$job->city = $address['City'];
        //$job->state = $address['State'];
        //$job->zip = $address['Zip'];
        //$job->home_phone = '';
        //$job->other_phone = '';
        //$job->job_date = date(DATE_ATOM);
        //$job->status = $row['Status'];
        //$job->time_frame = $row['Service Window'];

//        $job->job_information = serialize([
//            'Start' => $row['Start'],
//            'End' => $row['End'],
//            'Node ID' => $row['Node ID'],
//            'Q Code' => $row['Q Code'],
//            'Map Number' => $row['Map Number'],
//            'Duration' => $row['Duration'],
//            'Points' => $row['Points'],
//            'ICOMS' => $row['ICOMS'],
//            'Manual ICOMS' => $row['Manual ICOMS'],
//            'Soft Closed?' => $row['Soft Closed?'],
//            'Problem Code 1' => $row['Problem Code 1'],
//            'Problem Code 2' => $row['Problem Code 2'],
//            'Problem Code 3' => $row['Problem Code 3'],
//            'Problem Code 4' => $row['Problem Code 4'],
//            'Problem Code 5' => $row['Problem Code 5'],
//            'Primary Locator' => $row['Primary Locator'],
//            'Secondary Locator' => $row['Secondary Locator'],
//            'Time Slot' => $row['Time Slot'],
//            'House Comments' => $row['House Comments'],
//            'W/O notes' => $row['W/O notes'],
//            'Work Skill' => $row['Work Skill'],
//            'Work Zone' => $row['Work Zone'],
//            'Campaign Code' => $row['Campaign Code'],
//            'Finding code' => $row['Finding code'],
//            'Solution code' => $row['Solution code'],
//            'Services Information' => $row['Services Information']
//        ]);

        // $job->image1
        // $job->image2
        // $job->image3
        // $job->latitude
        // $job->longitude
        // $job->date_taken

        if (!$job->save()) {
            die(var_dump($job->getErrors()));
            return null;
        } else {
            return $job;
        }
        //return ($job->save() ? $job : null);
    }

    public static function getAddress($rawAddress)
    {
        $addr = explode('|', $rawAddress);
        $result = [];
        $result['Address'] = trim($addr[0]);
        //if(!isset($addr[1])) die(print_r($rawAddress));
        $addr = explode(' ', $addr[1]);
        $result['Zip'] = array_pop($addr);
        $result['City'] = implode(' ', $addr);
        $result['State'] = '';
        return $result;
    }
}

?>
