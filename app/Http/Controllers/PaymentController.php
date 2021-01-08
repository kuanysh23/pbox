<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ROLE_ADMIN');
    }

    public function index(Request $request)
    {
        $paymentsQuery = Payment::query();

        if($request->filled('id'))
            $paymentsQuery->where('id','=',$request->id);
        if($request->filled('amount'))
            $paymentsQuery->where('amount','=',$request->amount);
        if($request->filled('status') && $request->status!=-2){
            if($request->status == -1)
                $paymentsQuery->where('status','=',null);
            else
                $paymentsQuery->where('status','=',$request->status);
        }
        if($request->filled('created_at'))
            $paymentsQuery->where('created_at','LIKE','%'.$request->created_at.'%');
        if($request->filled('amount'))
            $paymentsQuery->where('date_paid','LIKE','%'.$request->date_paid.'%');
        if($request->filled('amount'))
            $paymentsQuery->where('phone','LIKE','%'.$request->phone.'%');
        if($request->filled('amount'))
            $paymentsQuery->where('email','LIKE','%'.$request->email.'%');
        if($request->filled('amount'))
            $paymentsQuery->where('card','LIKE','%'.$request->card.'%');

        $payments = $paymentsQuery->orderBy("id", "desc")->paginate(10)->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'amount'=>'required|numeric',//regex:/^\d+(\.\d{1,2})?$/
            'phone'=>'max:15',
            'email'=>'max:100'
        ]);

        $payment = new Payment();
        $payment->amount = $this->cutAmount($request->input('amount'), 2);
        $payment->phone = $request->input('phone');
        $payment->email = $request->input('email');
        $payment->save();

        $link = substr(md5(rand()), 0, 32).$payment->id;

        DB::table('payments')
            ->where('id', $payment->id)
            ->update(['link' => $link]);

        //return 'Ссылка для оплаты: '.url('/').'/?code='.$link;
        return redirect()->route('payments.index')
            ->with('success', ' Ссылка для оплаты: '.url('/').'/pay/'.$link);
    }

    public function show(Payment $payment){
        return view('payments.show', compact('payment'));
    }

    private function cutAmount(float $amount, int $len){
        $power = pow(10, $len);
        if($amount > 0){
            return floor($amount * $power) / $power;
        } else {
            return ceil($amount * $power) / $power;
        }
    }
}
