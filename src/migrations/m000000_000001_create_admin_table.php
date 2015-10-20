<?php

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
        if ($this->tableExist($this->tableName)) {
            $this->stdout("Table '{$this->tableName}' already exists\n");
            if ($this->confirm('Drop and create new?')) {
                $this->dropTable($this->tableName);
            } else {
                return true;
            }
        }
        /**
         * Create table
         */
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'firstName' => Schema::TYPE_STRING . ' NULL',
            'lastName' => Schema::TYPE_STRING . ' NULL',
            'role' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'passwordHash' => Schema::TYPE_STRING . ' NOT NULL',
            'passwordResetToken' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'passwordResetExpire' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'authKey' => Schema::TYPE_STRING . '(32) NULL DEFAULT NULL',
            'emailConfirmToken' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'data' => Schema::TYPE_TEXT,
        ], $this->getTableOptions());

        /**
         * Default admin values
         */
        $data = [
            'username' => 'admin',
            'email' => 'admin@test.com',
            'passwordHash' => \Yii::$app->security->generatePasswordHash('password'),
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'createdAt' => time(),
            'updatedAt' => time(),
            'status' => Admin::STATUS_ACTIVE,
        ];

        /** @var BaseManager $authManager */
        $authManager = \Yii::$app->getModule('admin')->get('authManager', false);
        $hasRbac = (($authManager !== null) && ($role = $authManager->getRole('admin')) !== null);

        if ($hasRbac) {
            $data['role'] = 'admin';
        }

        $this->stdout("New user was added:\n");
        $this->stdout("Username: '{$data['username']}'\n");
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
