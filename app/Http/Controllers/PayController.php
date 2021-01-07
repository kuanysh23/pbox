<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

class PayController extends Controller
{
    public function index($code)
    {
        $payment = DB::table('payments')->where('link', $code)->first();

        if($payment && (is_null($payment->status) || $payment->status == 0)){
            //Если счет существует и нефинальный статус то показать страницу оплаты
            if(is_null($payment->status))
                DB::table('payments')
                    ->where('id', $payment->id)
                    ->update(['status' => 0]);
            return view('pay.index', compact('payment'));

        }else{
            //Если финальный статус то показать страницу результата
            if($payment->status == 1)
                $result = 'Оплаты прошла успешно!';
            elseif($payment->status == 2)
                $result = 'Произошла ошибка во время оплаты!';

            return view('pay.result', compact('result'));
        }
    }

    public function process(Request $request)
    {
        $valid = $request->validate([
            'card'=>'required|digits_between:15,19',
            'month'=>'digits:2|min:1|max:12',
            'year'=>'digits:4',
            'phone'=>'digits_between:10,15',
            'email'=>'email:rfc,dns'
        ]);

        $payment = DB::table('payments')->where('id', $request->id)->first();
        $result = 'Произошла ошибка во время оплаты!';

        if($payment && (is_null($payment->status) || $payment->status == 0)){
            //проверить по Луну и срок действия карты
            $expires = DateTime::createFromFormat('mY', $request->month.$request->year);
            $now     = new DateTime();

            if($this->luhnAlgorithm($request->card) && $expires >= $now){
                DB::table('payments')
                    ->where('id', $payment->id)
                    ->update(['status' => 1, 'date_paid' => $now, 'card' => $this->maskCard($request->card)]);

                $result = 'Оплата прошла успешно!';
            }else{
                DB::table('payments')
                    ->where('id', $payment->id)
                    ->update(['status' => 2, 'date_paid' => $now, 'card' => $this->maskCard($request->card)]);
            }
        }

        return view('pay.result', compact('result'));
    }

    private function maskCard($card, $maskingCharacter = 'X')
    {
        return substr($card, 0, 6) . str_repeat($maskingCharacter, strlen($card) - 10) . substr($card, -4);
    }

    private function luhnAlgorithm($digit)
    {
        $number = strrev(preg_replace('/[^\d]+/', '', $digit));
        $sum = 0;
        for ($i = 0, $j = strlen($number); $i < $j; $i++) {
            if (($i % 2) == 0) {
                $val = $number[$i];
            } else {
                $val = $number[$i] * 2;
                if ($val > 9)  {
                    $val -= 9;
                }
            }
            $sum += $val;
        }
        return (($sum % 10) === 0);
    }
}
