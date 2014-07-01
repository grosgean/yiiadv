<?php

namespace backend\components;


use yii\helpers\Url;
use yii\grid\ActionColumn;


class MyActionColumn extends ActionColumn
{

    public function createUrl($action, $model, $key, $index)
    {
        if ($this->urlCreator instanceof Closure) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = 'product/'.$action;

            return Url::toRoute($params);
        }
    }

}
