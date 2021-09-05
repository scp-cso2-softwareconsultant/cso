<style>
    /* Made with love by Mutiullah Samim*/

    @import url('https://fonts.googleapis.com/css?family=Numans');

    html,
    body {
        background-image: url('img/Login-background.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        font-family: 'Numans', sans-serif;
        margin: 0;
        height: 100%;
        overflow: hidden;
    }

    .container {
        height: 100%;
        align-content: center;
    }

    .card {
        height: 250px;
        margin-top: auto;
        margin-bottom: auto;
        width: 400px;
  
    }

    .social_icon span {
        font-size: 60px;
        margin-left: 10px;
        color: #FFC312;
    }

    .card-header h3 {
        color: white;
    }

    .input-group-prepend span {
        opacity: 1;
        width: 50px;
        background-color: #FFC312;
        color: black;
        border: 0 !important;
    }

    input:focus {
        outline: 0 0 0 0 !important;
        box-shadow: 0 0 0 0 !important;

    }

    .login_btn {
        color: black;
        background-color: #FFC312;
        width: 100px;
    }

    .login_btn:hover {
        color: black;
        background-color: white;
    }

    .modal_desu {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        z-index: 198259812;
    }

    .model_show{ display : flex }

    .modal_desu_formBox{
        border: 1px solid #3E3E3E;
        height: auto;
    }   

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>


@extends('layouts.app')
@section('content')
<div class="container">
    <div id="modal_desu" class="modal_desu justify-content-center h-100">
        <div class="card modal_desu_formBox w-25">
            <div class="align-middle bg-light">
                <div class="card-header d-flex flex-row border-0 mt-3 bg-transparent">
                    <img class='w-25 pr-4' src="img/wind_art.png">
                    <p>Please Contact Administrator To Change Your Password</p>
                </div>
                <div class="card-body">
                    <div class="form-group mt-4">
                        <button type="button" onclick="actModalDesu()" class="btn btn-block btn-info">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center h-75">
        <div class="card  w-50">
            <div class="align-middle bg-light">

                <div class="card-header border-0 mt-3 bg-transparent">
                    <img src="img/usaid_logo.png" class="w-50 p-3">
                    <img src="img/save_the_children_logo.jpg" class="w-25 p-3">
                </div>

                <div class="card-body">
                    <form method="POST" class="px-4" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group form-group pt-2">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <div class="input-group form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mt-2 d-flex justify-content-between">
                            <a href="#" onclick="actModalDesu()" class="card-link">Forgot Password</a>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-block text-white login_btn bg-primary font-weight-bold">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/php_modal.js') }}"></script>
</div>
@endsection