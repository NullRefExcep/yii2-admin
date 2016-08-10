<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\admin\widgets;


use Yii;
use yii\base\Widget;
use yii\bootstrap\Alert;
use yii\helpers\Html;

class Flash extends Widget
{
    public function run()
    {
        $this->view->registerCss(<<<CSS
.alert-wrap {
    padding-top: 10px;
}
.alert-wrap :last-child{
    margin-bottom: 0;
}
CSS
        );
        $content = [];
        $flashes = Yii::$app->session->getAllFlashes(true);
        foreach ($flashes as $key => $flash) {
            $content[] = Alert::widget([
                'body' => $flash,
                'options' => [
                    'class' => 'alert-' . $key,
                ],
            ]);
        }
        if (count($content)) {
            return Html::tag('div', implode(PHP_EOL, $content), ['class' => 'alert-wrap']);
        }
    }

}