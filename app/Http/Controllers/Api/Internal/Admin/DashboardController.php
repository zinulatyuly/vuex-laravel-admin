<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthsStat = [
            'total' => 0,
            'online' => 0,
            'successful' => 0,
            'canceled' => 0
        ];

        $allStat = [
            'total' => 0,
            'online' => 0,
            'successful' => 0,
            'canceled' => 0
        ];

        $amount = [
            'total' => 0,
            'year' => 0,
            'month' => 0,
            'week' => 0,
            'day' => 0
        ];

        for ($i=1; $i<=12; $i++) {
            $chart[$i] = 0;
        }

        $orders = Order::select('status', 'created_at', 'total_price')->get()->toArray();

//        $quantity_of_days = Carbon::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"))
//            ->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', (string)Order::oldest('created_at')->first()->created_at));
            $quantity_of_days = 365;

        $monthsStat['total'] = Order::whereYear('created_at', date('Y'))->whereMonth('created_at', date('n'))->count();
        $allStat['total'] = count($orders);

        foreach ($orders as $order) {
            if (in_array($order['status'], ['ESHOP', 'SUCCESS', 'ACCEPTED', 'NOT_PROCESSED'])) {
                $chart[date('n', strtotime((string)($order['created_at'])))] += floatval(str_replace(',', '', $order['total_price']));
                $amount['total'] += $this->getCorrectPrice($order['total_price']);
                $order['status'] == 'ESHOP' && $allStat['online']++;
                $allStat['successful']++;

                if (date('Y', strtotime($order['created_at'])) === date('Y')) {
                    $amount['year'] += $this->getCorrectPrice($order['total_price']);

                    if (date('n', strtotime($order['created_at'])) === date('n')) {
                        $amount['month'] += $this->getCorrectPrice($order['total_price']);
                        $order['status'] == 'ESHOP' && $monthsStat['online']++;
                        $monthsStat['successful']++;

                        if (date('W', strtotime($order['created_at'])) === date('W')) {
                            $amount['week'] += $this->getCorrectPrice($order['total_price']);

                            if (date('d', strtotime($order['created_at'])) === date('d')) {
                                $amount['day'] += $this->getCorrectPrice($order['total_price']);
                            }
                        }
                    }
                }
            } elseif (in_array($order['status'] , ['CANCELED', 'USER_CANCELED', 'FAILURE'])) {
                if (date('Y-n', strtotime($order['created_at'])) === date('Y-n')) $monthsStat['canceled']++;
                $allStat['canceled']++;
            }
        }

        return [
            'monthsStat' => $monthsStat,
            'avgMonthsStat' => $this->getAverage($allStat, $quantity_of_days / 30.42),
            'amount' => $amount,
            'avgAmount' => [
                'year' => $amount['total'] / max($quantity_of_days / 365, 1),
                'month' => $amount['total'] / $quantity_of_days * 30.42,
                'week' => $amount['total'] / $quantity_of_days * 7,
                'day' => $amount['total'] / $quantity_of_days,
            ],
            'chart' => $chart
        ];
    }

    private function getCorrectPrice($value) {
        return floatval(str_replace(',', '', $value ?? 0));
    }

    private function getAverage($filtered, $divisor) {
        return array_map(function ($value) use ($divisor) {
            return ($value / $divisor);
        }, $filtered);
    }
}
