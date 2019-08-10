<?php
class Users extends JsonDataArray
{
    public function displaySelectList($orders, $sortedField, $excludeName)
    {
        $resultQuery = $this->newQuery()->orderBy($sortedField)->getObjs();
        foreach ($resultQuery as $key) {
            if ($key->name !== $excludeName) {
                print '<option value="'.$key->name.'">'.$key->name.' - '.$this->determineWorkload($orders, $key->name, 'executor').'</option>';
            }
        }
    }

    public function determineWorkload($orders, $executorName, $param = 'executor')
    {
        $allOrders = $orders->newQuery()->find($param, $executorName)->count();
        $doneOrders = $orders->newQuery()->find($param, $executorName)->find('state', 'done')->count();
        $workload = $allOrders - $doneOrders;
        return $workload;
    }
}
