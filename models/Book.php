<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%book_info}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $contact_name
 * @property string $contact_surname
 * @property string $contact_patronymic
 * @property string $address
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Book extends \yii\db\ActiveRecord
{
    public $phones;

    const STATUS_ACTIVE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book_info}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_name'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['status'], 'integer', 'message' => 'Неверный тип данных'],
            [['address'], 'string', 'message' => 'Неверный тип данных'],
            [
                ['contact_name', 'contact_surname', 'contact_patronymic'],
                'string', 'max' => 255,
                'message' => 'Максимальная длина 255 символов'
            ],
            [
                'phones',
                'each', 'rule' => [
                'match', 'pattern' => '/^\+38\(0\d{2}\)-\d{3}-\d{2}-\d{2}$|^$/',
                'message' => 'Не верно введен телефон, например +38XXXXXXXXXX, где X - номер вашего телефона'],
            ],
        ];
    }

    /*
     * get phone list
     * @return array
     */
    public function getPhoneList(){
        $data = $this->phone ;
        foreach ($data as &$phoneData) $phoneData->phone = substr($phoneData->phone, 3);
        return array_merge($this->phone, [new Phone()]);
    }

    /*
     * Relation for Phone
     * @return object|null
     */
    public function getPhone(){
        return $this->hasMany(Phone::className(), ['book_id' => 'id']);
    }

    /*
     * Create contact
     *  @return bool
     */
    public function createContact(){

        $this->user_id = Yii::$app->user->identity->getId();
        $this->status = self::STATUS_ACTIVE;

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $rows = [];
            $this->save();
            foreach ($this->phones as $phone){
                $rows[] = [
                    'phone' => trim(preg_replace('/[^0-9]+/', '', $phone)),
                    'book_id' => $this->id
                ];
            }

            Yii::$app->db->createCommand()->batchInsert(Phone::tableName(), ['phone', 'book_id'], $rows)->execute();

            $transaction->commit();
            return true;
        }catch (\Exception $ex){
            $transaction->rollBack();
        }
        return false;
    }

    /*
     * Update contact
     *  @return bool
     */
    public function updateContact(){
        $transaction = Yii::$app->db->beginTransaction();

        $oldPhones = array_map(function($value){ return $value->phone; }, $this->phone);

        $newPhones = array_map(function($phone){
            return trim(preg_replace('/[^0-9]+/', '', $phone));
        }, array_filter($this->phones));

        $delPhones = array_diff($oldPhones, $newPhones);
        try{
            $this->save();
            $rowSql = "INSERT INTO ".Phone::tableName()." (phone, book_id) VALUES ";

            foreach ($newPhones as $item) $rowSql .= "('{$item}',{$this->id}), ";
            $rowSql  = trim($rowSql, ', ');
            $rowSql .= " ON DUPLICATE KEY UPDATE phone=VALUES(phone),book_id=VALUES(book_id)";
            Yii::$app->db->createCommand($rowSql)->execute();
            Phone::deleteAll(['in', 'phone', implode(',', $delPhones)]);

            $transaction->commit();
            return true;
        }catch (\Exception $ex){
            $transaction->rollBack();
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID Пользователя',
            'contact_name' => 'Имя контакта',
            'contact_surname' => 'Фамилия контакта',
            'contact_patronymic' => 'Отчество контакта',
            'phones' => 'Телефоны',
            'address' => 'Адресс',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }
}
