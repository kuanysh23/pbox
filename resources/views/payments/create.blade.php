@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Страница выставления счета</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
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

                        <form method="post" action="{{ route('payments.store') }}">
                            @csrf
                            <input type="text" name="amount" id="amount" placeholder="Введите сумму" class="form-control"><br>
                            <input type="text" name="phone" id="phone" placeholder="Введите телефон" class="form-control"><br>
                            <input type="text" name="email" id="email" placeholder="Введите email" class="form-control"><br>
                            <button type="submit" class="btn btn-success">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
