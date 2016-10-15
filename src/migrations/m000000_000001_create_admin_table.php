<?php

use dektrium\user\models\User;
use nullref\admin\models\Admin;
use yii\db\Migration;
use yii\db\Schema;
use yii\rbac\BaseManager;

class m000000_000001_create_admin_table extends Migration
{
    use \nullref\core\traits\MigrationTrait;

    protected $tableName = '{{%admin}}';

    public function up()
    {
        $user = Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
            'email'    => 'admin@test.com',
            'username' => 'admin',
            'password' => 'password',
        ]);

        if ($user->create()) {
            $this->stdout(Yii::t('user', 'User has been created') . "!\n", Console::FG_GREEN);
        }

        $this->stdout("New user was added:\n");
        $this->stdout("Username: 'admin'\n");
        $this->stdout("Password: 'password'\n");

        /**
         * Create default admin
         */
        $this->db->createCommand()->insert($this->tableName, $data)->execute();


        if ($hasRbac) {
            $id = $this->db->getLastInsertID();
            try {
                $authManager->assign($role, $id);
            } catch (\Exception $e) {
                $this->stdout($e->getMessage() . "\n");
            }
        };
    }

    public function down()
    {
        $this->dropTable($this->tableName);
        return true;
    }

}
