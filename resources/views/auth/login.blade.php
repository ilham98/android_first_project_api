<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name').' | Login' }}</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="title">
        <div>Sistem Manajemen</div>
        <div>ASET TI</div>
    </div>
    <div class="container">
        <div class="input-container">
            <form class="input-form" action="{{ route('login') }}" method="POST">
                <div class="title-small">
                    <div>SISTEM MANAJEMEN</div>
                    <div>ASET TI</div>
                </div>
                <div class="logo-container">
                    <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                </div>
                @if(session()->has('message'))
                    <div class="error">{{ session()->get('message') }}</div>
                @endif
                <div class="form-group">
                    <input type="text" name="npk" placeholder="npk">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="password">
                </div>
                <div class="form-group">
                    <button type="submit">LOGIN</button>
                </div>
                @csrf
                @method('POST')
            </form>
        </div>
        <img class="left" src="{{ asset('/svg/left.svg') }}" alt="">
        <img class="right" src="{{ asset('/svg/right.svg') }}" alt="">
    </div>
</body>
</html>