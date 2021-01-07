@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class=" card-header">Страница оплаты</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="post" action="/pay/process">
                            @csrf
                            Сумма: {{$payment->amount}} KZT<br><br>
                            <div class="form-group custom-control-inline">
                                <input name="card" type="text" maxlength="19" placeholder="Введите номер карты" style="width:200px" class="form-control" />
                                <input name="month" type="text" maxlength="2" placeholder="ММ" style="width:50px" class="form-control" />
                                <input name="year" type="text" maxlength="4" placeholder="ГГГГ" style="width:70px" class="form-control" />
                            </div>
                            <br><br>
                            <div class="form-group custom-control-inline">
                                <input name="email" type="text" placeholder="Введите email" value="{{$payment->email}}" style="width:200px" class="form-control" />
                                <input name="phone" type="text" placeholder="Введите номер телефона" value="{{$payment->phone}}" style="width:200px" class="form-control" />
                            </div>
                            <input type="hidden" name="id" value="{{$payment->id}}" />
                            <br><br>
                            <input type="submit" value="Оплатить">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
