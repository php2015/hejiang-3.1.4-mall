<?php
/**

 * Date: 2018/10/16
 * Time: 17:05
 */

namespace app\modules\mch\models\diy;


use app\models\HomeBlock;
use app\modules\mch\models\MchModel;

class RubikForm extends MchModel
{
    public $id;

    public function search()
    {
        $rubik = HomeBlock::findOne(['id' => $this->id, 'store_id' => $this->store->id, 'is_delete' =>0]);
        $data = \Yii::$app->serializer->decode($rubik->data);
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => $data
        ];
    }
}