<?php

/**
 * Класс для работы с записями из файла users.json
 */
class Users extends JsonDataArray
{
    /**
     * Вывод списка переводчиков в поле выбора исполнителя заказа,
     * исключает пользователя с ролью 'manager', пользователя с определенным именем
     * а так же с помощью функции уазывает количество заказов на исполнении
     * @param  string $orders      номер заказа
     * @param  string $sortedField свойство по которому будет происходить сортировка
     * @param  string $excludeName имя, которее исключается из списка
     */
    public function displaySelectList($orders, $sortedField, $excludeName)
    {
        $resultQuery = $this->newQuery()->orderBy($sortedField)->getObjs();
        foreach ($resultQuery as $key) {
            if ($key->name !== $excludeName && $key->role !== Config::MANAGER_ROLE) {
                print '<option value="'.$key->name.'">'.$key->name.' - ';
                print $this->determineWorkload($orders, $key->name, 'executor').'</option>';
            }
        }
    }

    /**
     * Определение количества заказов в работе у каждого переводчика
     * @param   object $orders       Объект класса Orders с записями заказов
     * @param  string $executorName имя исполлнителя
     * @param  string $param        тип исполнителя по умолчанию 'executor'
     * @return integer $workload    разница между числом взятых переводчиком заказов и принятых менеджером
     */
    public function determineWorkload($orders, $executorName, $param = 'executor')
    {
        $allOrders = $orders->newQuery()->find($param, $executorName)->count();
        $doneOrders = $orders->newQuery()->find($param, $executorName)->find('state', 'done')->count();
        $workload = $allOrders - $doneOrders;
        return $workload;
    }
}
