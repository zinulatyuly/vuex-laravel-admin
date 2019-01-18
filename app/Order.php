<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected static $statuses = [
        'CANSELED'        => 'Отказ',
        'USER_CANSELED'   => 'Отказ клиента',
        'ESHOP'           => 'Интернет-магазин',
        'SUCCESS'         => 'Выполнен',
        'PARTIAL_SUCCESS' => 'Частично выполнен',
        'FAILURE'         => 'Не выполнен',
        'IN_PROGRESS'     => 'В работе',
        'NOT_PROCESSED'   => 'Не обработан',
        'ACCEPTED'        => 'Принят',    
    ];
}
