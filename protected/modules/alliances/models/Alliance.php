<?php

namespace app\modules\alliances\models;

use Yii;
use app\modules\alliances\models\queries\AllianceQuery;
use app\modules\teams\models\Team;


/**
 * This is the model class for table `library_resources`
 *
 * @property integer $id
 * @property string  $string
 */
 class Alliance extends \yii\db\ActiveRecord
 {
   /**
    * @inheritdoc
    */
    public static function tablename()
    {
      return 'alliances';
    }

    /**
     * @inheritdoc
     */
     public function rules()
     {
       return [
         ['team_1', 'required'],
         ['team_1', 'unique', 'targetAttribute' => 'team_2'],
         ['team_2', 'required'],
         ['team_2', 'unique', 'targetAttribute' => 'team_1']
       ];
     }

     /**
      * @inheritdoc
      */
      public function attributeLabels()
      {
        return [
          'team_1' => Yii::t('AlliancesModule.base', 'Team 1'),
          'team_2' => Yii::t('AlliancesModule.base', 'Team 2'),
        ];
      }

      public static function find()
      {
          return new AllianceQuery(get_called_class());
      }

      /**
       *  Gets the ally for a given team
       * @return boolean
       */
       public function getAlly($team_id)
       {
         if ($this->team_1 == $team_id) {
           return Team::findOne($this->team_2);
         } elseif ($this->team_2 == $team_id) {
           return Team::findOne($this->team_1);
         } else {
           return false;
         }
       }

       public function getTeam1(){
          return $this->getAlly($this->team_2);
       }

       public function getTeam2(){
          return $this->getAlly($this->team_1);
       }

       /**
        *  returns true if the given id is an allied team and not the current user's team
        *  @return boolean
        */
       public function isAlly($team_id)
       {
         $current_user = Yii::$app->user->getIdentity();
         $user_team_id = Team::getUserTeam($current_user->id);

         if ($team_id == $user_team_id) { //this is the user's team
           return false;
         } elseif ($this->team_1 == $team_id || $this->team_2 == $team_id) {
           return true;
         } else {
           return false;
         }
       }
 }
