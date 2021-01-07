@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-left: 50px;">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <br>
                                <div class="row mx-auto">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>id:</strong>
                                            {{ $payment->id }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Сумма:</strong>
                                            {{ $payment->amount }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Статус:</strong>
                                            @switch ($payment->status ?? -1)
                                                @case(-1)
                                                не просмотрено
                                                @break
                                                @case(0)
                                                просмотрено
                                                @break
                                                @case(1)
                                                успешно
                                                @break
                                                @case(2)
                                                ошибка
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Телефон:</strong>
                                            {{ $payment->phone }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>E-mail:</strong>
                                            {{ $payment->email }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Номер карты:</strong>
                                            {{ $payment->card }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Дата создания:</strong>
                                            {{ $payment->created_at }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Дата оплаты:</strong>
                                            {{ $payment->date_paid }}
                                        </div>
                                    </div>
                                </div>


                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
