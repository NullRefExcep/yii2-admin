<?php

namespace nullref\admin\generators\stuff;

use yii\gii\CodeFile;
use yii\gii\Generator as BaseGenerator;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Generator extends BaseGenerator
{
    public $file;

    public $files = [
        'menuBuilder'=>[
            'name' => 'MenuBuilder',
            'template' => 'MenuBuilder.php',
            'destination' => '@app/components',
        ],
        'roleContainer'=>[
            'name' => 'RoleContainer',
            'template' => 'RoleContainer.php',
            'destination' => '@app/components',
        ],
    ];

    public function getDropDownList()
    {
        $list = $this->files;
        foreach ($this->files as $id => $file) {
            $list[$id]=$file['name'];
        }
        return $list;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['file'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Generator for different admin components';
    }


    public function generate()
    {
        $file = $this->files[$this->file];

        $code = $this->render($file['template']);

        return [
            new CodeFile(
                \Yii::getAlias($file['destination']) . '/' . $file['name'] . '.php',
                $code
            )
        ];
    }

    public function getName()
    {
        return 'Admin Stuff Generator';
    }

}