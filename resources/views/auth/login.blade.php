<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <style>
        body {
           height: 100vh; 
           overflow: hidden;
        }

        .fullHeight {
            height: 100%;
        }

        .img-banner {
            background: linear-gradient(90deg, rgba(2,0,36,0.8) 0%, rgba(9,9,121,0.4) 100%), url('https://www.pupukkaltim.com/datas/HB%206_1.jpg?1519205111589');
            background-position: center;
        }

        .sistemManajemen {
            color: white;
                font-size: 40px;
        }

        .asetTi {
            color: white;
            font-size: 60px;
        }

        .img {
            width: 300px;
        }

        @media(max-width: 768px) {
            body {
                overflow: auto;
            }

            .fullHeight {
                height: auto;
            }

            .sistemManajemen {
                font-size: 24px;
            }

            .img-banner {
                height: 200px;
            }

            .asetTi {
                font-size: 30px;
            }
        }
        
    </style>
</head>
<body>
    <div class="fullHeight">
        <div class="row fullHeight">
            <div class="col-md-8 fullHeight img-banner d-flex align-items-center justify-content-center text-center">
                <div>
                    <img class="img" src="{{ asset('images/logo.png') }}" alt=""> <br>
                    <span class="sistemManajemen">SISTEM MANAJEMEN</span> <br>
                    <span class="asetTi">ASET TI</span>
                </div>
                
            </div>
            <div class="col-md-4 p-3 fullHeight">
                <div class="card m-0 fullHeight">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-right">NPK</label>
                                <input id="npk" class="form-control @error('npk') is-invalid @enderror" name="npk" value="{{ old('npk') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <div class="text-center">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>