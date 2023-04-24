<?php
/**

 * Date: 2018/11/22
 * Time: 17:56
 */

namespace app\modules\mch\models;


use app\models\Task;
use yii\data\Pagination;

class SystemTaskForm extends MchModel
{
    public $page;
    public $limit;
    public $startTime;
    public $endTime;

    public function rules()
    {
        return [
            [['page', 'limit'], 'integer'],
            [['limit'], 'default', 'value' => 20],
            [['startTime', 'endTime'],'string']
        ];
    }
    public function search()
    {
        $query = Task::find();
        if($this->startTime) {
            $query->andWhere(['>=', 'addtime', strtotime($this->startTime)]);
        }
        if($this->endTime) {
            $query->andWhere(['<=', 'addtime', strtotime($this->endTime)+86400]);
        }

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit]);
        $list = $query->limit($pagination->limit)->offset($pagination->offset)->orderBy(['addtime' => SORT_DESC])->all();

        return [
            'list' => $list,
            'pagination' => $pagination
        ];
    }
}