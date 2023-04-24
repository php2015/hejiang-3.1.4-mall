<?php
/**
 * Created by IntelliJ IDEA.
 * User: cj
 * Date: 2019-05-19
 * Time: 21:10
 */

namespace app\common;


use app\models\Level;
use app\models\User;

class UserHelper
{


    public static function getUserLevelMap($storeId, $userIds, $returnText = false)
    {
        if (!$userIds) {
            return [];
        }

        $map = [];
        foreach ($userIds as $userId) {
            $map[$userId] = -1;
        }

        $userTb = User::tableName();
        $userIdStr = implode(',', $userIds);

        $sql = "select * from $userTb where id in ($userIdStr)";

        $data = \Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($data as $datum) {
            /** @var User $datum */
            $map[$datum->id] = $datum->level;
        }

        // level映射成 文本
        if ($returnText) {
            /** @var Level[] $levels */
            $levels = Level::find()->where([
                'store_id'  => $storeId,
                'is_delete' => 0,
                'status'    => 1
            ])->orderBy([
                'level' => SORT_ASC
            ])->all();

            $levelMap = [];
            foreach ($levels as $level) {
                $levelMap[$level->level] = $level->name;
            }

            foreach ($map as &$value) {
                $value = isset($levelMap[$value]) ? $levelMap[$value] : $value;
            }
        }

        return $map;
    }
}