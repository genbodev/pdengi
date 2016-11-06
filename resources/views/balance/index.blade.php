@extends('app')
dd($users);
@section('content')
    <div class="jumbotron">
        @foreach($users as $user)
            <div class="well" id="recipient-{{$user->user_id}}">
                <div class="user-wrapper">
                    <div class="user-data">
                        <h2>{{$user->name}}</h2>
                        <div><span class="label label-success">Баланс</span>{{$user->balance}}</div>
                    </div>
                    <div class="comment">{{$user->comment}}<p>{{$user->date}}</p></div>
                    <div class="button-wrapper">
                        <div class="sum-wrapper" id="sum-div-{{$user->user_id}}">
                            <p>Перечисление средств</p>
                            <div class="select-wrapper">
                                <div class="input-text">Введите сумму:</div>
                                <input type="text" maxlength="11" class="input-wrapper" id="input-{{$user->user_id}}">
                            </div>
                            <button type="button" class="btn btn-primary btn-lg btn-block" id="send-{{$user->user_id}}" data-sender="{{$user->user_id}}">Продолжить</button>
                        </div>
                        <div class="users-wrapper" id="users-div-{{$user->user_id}}">
                            <p>Выберите получателя</p>
                            @foreach($users as $aUser)
                                <div>{{$aUser->name}}</div>
                            @endforeach
                            <a type="button" class="btn btn-warning btn-xs" id="cancel-{{$user->user_id}}" data-id-sender="{{$user->user_id}}">Отменить</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop