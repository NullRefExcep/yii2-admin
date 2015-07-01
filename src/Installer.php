<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\admin;


use nullref\core\components\ModuleInstaller;
use yii\db\Schema;

class Installer extends ModuleInstaller
{
    protected $tableName = '{{%admin}}';

    /**
     * Create table
     */
    public function install()
    {
        if (!$this->tableExist($this->tableName)) {
            $tableOptions = null;
            if (\Yii::$app->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id' => Schema::TYPE_PK,
                'email' => Schema::TYPE_STRING . ' NOT NULL',
                'firstName' => Schema::TYPE_STRING . ' NULL',
                'lastName' => Schema::TYPE_STRING . ' NULL',
                'role' => Schema::TYPE_INTEGER,
                'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'passwordHash' => Schema::TYPE_STRING . ' NOT NULL',
                'passwordResetToken' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
                'passwordResetExpire' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
                'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
                'authKey' => Schema::TYPE_STRING . '(32) NULL DEFAULT NULL',
                'emailConfirmToken' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            ], $tableOptions);
        }

        parent::install();
    }

    /**
     * Drop table
     */
    public function uninstall()
    {
        if ($this->tableExist($this->tableName)) {
            $this->dropTable('{{%product}}');
        }
        parent::uninstall();
    }


} 