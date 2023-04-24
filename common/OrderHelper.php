<?php
/**
 * Created by IntelliJ IDEA.
 * User: cj
 * Date: 2019-05-19
 * Time: 21:08
 */

namespace app\common;


use app\models\Order;
use app\models\Store;

class OrderHelper
{

    /**
     * 返回商家id，销售额 map [parent_id1 => null, parent_id2 => 12.12]
     *
     * @param $sellerIds
     * @param $storeId
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getSellerSalesMap($sellerIds, $storeId) {
        if (!$sellerIds || !$storeId) {
            return [];
        }
//
//        $userIds = Order::find()->alias('o')->select(['o.user_id', 'sum(o.pay_price) order_money'])
//            ->where(['o.is_delete' => 0, 'o.store_id' => $this->store_id, 'o.is_confirm' => 1, 'o.is_send' => 1])
//            ->andWhere(['<=', 'o.confirm_time', $sale_time])
//            ->leftJoin(['r' => OrderRefund::tableName()], "r.order_id=o.id and r.is_delete = 0 and r.store_id = {$this->store_id}")
//            ->andWhere([
//                'or',
//                'isnull(r.id)',
//                ['r.type' => 2],
//                ['in', 'r.status', [2, 3]]
//            ])
//            ->groupBy('o.user_id');

        $orderTb = Order::tableName();

        /** @var Store $store */
        $store = Store::find()->where(['id' => $storeId])->one();

        $saleTime = time() - ($store->after_sale_time * 86400);
        $parentIds = implode(',', $sellerIds);

        $sql = "select o.parent_id, sum(o.pay_price) as order_money from $orderTb o 
where o.is_delete = 0 
and o.store_id = $storeId 
and o.is_confirm = 1 
and o.is_send = 1 
and o.confirm_time <= $saleTime 
and o.parent_id in ($parentIds)
group  by o.user_id
";

        $data = \Yii::$app->db->createCommand($sql)->queryAll();

        $map = [];
        foreach ($sellerIds as $sellerId) {
            $map[$sellerId] = null;
        }

        foreach ($data as $datum) {
            $map[$datum->parent_id] = $datum->order_money;
        }

        return $map;
    }
}