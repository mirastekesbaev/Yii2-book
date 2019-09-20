<?php
/**
 *
 */

namespace common\models;

use admin\models\CrudAction;
use admin\models\Status;
use Yii;
use yii\base\BootstrapInterface;

class Settings implements BootstrapInterface
{

    private $db;

    public function __construct()
    {
        $this->db = Yii::$app->db;
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * Loads all the settings into the Yii::$app->params array
     * @param Application $app the application currently running
     */

    public function bootstrap($app)
    {
        // Get status from database
        $status = Status::find()->select(['id', 'status'])->asArray()->all();
        foreach ($status as $s) {
            Yii::$app->params['status'][$s['status']] = $s['id'];
        }

        // Get crud actions from database
        /*$status = CrudAction::find()->select(['id', 'action'])->asArray()->all();
        foreach ($status as $s) {
            Yii::$app->params['crud_action'][$s['action']] = $s['id'];
        }*/
    }
}