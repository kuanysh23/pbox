@extends('layouts.app')

@section('content')
    <!--div class="container"-->
        <div class="row" style="margin-left: 20px;">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">История платежей</div>
                    <form method="get">
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <br>
                            {{ $payments->onEachSide(5)->links() }}
                            <br>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th>Дата создания</th>
                                        <th>Даты оплаты</th>
                                        <th>Телефон</th>
                                        <th>E-mail</th>
                                        <th>Номер карты</th>
                                        <th>Ссылка</th>
                                        <th><a class="btn btn-danger" data-toggle="modal" id="smallButton" data-target="#smallModal"
                                               data-attr="{{ route('payments.create') }}" title="create">
                                                Создать счет
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="id" style="width:70px;" placeholder="id" value="{{ request()->get('id') }}" class="form-control"></td>
                                        <td><input type="text" name="amount" style="width:120px;" placeholder="Сумма" value="{{ request()->get('amount') }}" class="form-control"></td>
                                        <td><select name="status" style="width:110px;" placeholder="Статус" class="form-control">
                                                <option value="-2" {{ (request()->get('status')=='-2')?'selected="selected"':'' }}>Все</option>
                                                <option value="-1" {{ (request()->get('status')=='-1')?'selected="selected"':'' }}>Не просморено</option>
                                                <option value="0" {{ (request()->get('status')=='0')?'selected="selected"':'' }}>Просморено</option>
                                                <option value="1" {{ (request()->get('status')=='1')?'selected="selected"':'' }}>Успешно</option>
                                                <option value="2" {{ (request()->get('status')=='2')?'selected="selected"':'' }}>Ошибка</option>
                                            </select></td>
                                        <td><input type="text" name="created_at" style="width:155px;" value="{{ request()->get('created_at') }}" placeholder="гггг-мм-дд чч:мм:сс" class="form-control"></td>
                                        <td><input type="text" name="date_paid" style="width:155px;" value="{{ request()->get('date_paid') }}" placeholder="гггг-мм-дд чч:мм:сс" class="form-control"></td>
                                        <td><input type="text" name="phone" style="width:130px;" value="{{ request()->get('phone') }}" placeholder="Телефон" class="form-control"></td>
                                        <td><input type="text" name="email" style="width:200px;" value="{{ request()->get('email') }}" placeholder="E-mail" class="form-control"></td>
                                        <td><input type="text" name="card" style="width:155px;" value="{{ request()->get('card') }}" placeholder="Номер карты" class="form-control"></td>
                                        <td></td>
                                        <td><button type="submit" class="btn btn-success">Фильтровать</button></td>
                                    </tr>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>{{$payment->id}}</td>
                                        <td>{{$payment->amount}}</td>
                                        <td>
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
                                        </td>
                                        <td>{{$payment->created_at}}</td>
                                        <td>{{$payment->date_paid}}</td>
                                        <td>{{$payment->phone}}</td>
                                        <td>{{$payment->email}}</td>
                                        <td>{{$payment->card}}</td>
                                        <td><a href="{{url('/').'/pay/'.$payment->link}}">Ссылка</a></td>
                                        <td>
                                            <a class="btn btn-secondary" data-toggle="modal" id="smallButton" data-target="#smallModal"
                                               data-attr="{{ route('payments.show', $payment->id) }}" title="show">
                                                Посмотреть
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!--/div-->

    <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Детали платежа
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // display a modal (small modal)
        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });

    </script>

@endsection

