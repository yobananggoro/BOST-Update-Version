@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    {{ Form::open(['route' => 'login', 'method' => 'post', 'name' => 'form-login', 'autocomplete' => 'off']) }}
    <div class="input-group mb-3">
        {{ Form::text('username', null, ['class' => 'form-control ucase', 'placeholder' => 'User ID', 'maxlength' => '4']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>

    <div class="input-group mb-3">
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" id="login-submit-btn">
                {{ __('button.login') }}
            </button>
        </div>
    </div>
    {{ Form::close() }}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.querySelector('form[name="form-login"]');
            const submitButton = document.getElementById('login-submit-btn');
            const storageKey = 'login-submit-in-progress';

            if (!loginForm || !submitButton) {
                return;
            }

            const resetButton = function () {
                submitButton.disabled = false;
                submitButton.innerText = '{{ __('button.login') }}';
                sessionStorage.removeItem(storageKey);
            };

            const startSubmit = function () {
                if (submitButton.disabled) {
                    return false;
                }

                submitButton.disabled = true;
                submitButton.innerText = 'Processing...';
                sessionStorage.setItem(storageKey, '1');
            };

            if (sessionStorage.getItem(storageKey) === '1') {
                resetButton();
            }

            loginForm.addEventListener('submit', startSubmit);

            loginForm.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });

            window.addEventListener('pageshow', function () {
                resetButton();
            });

            window.addEventListener('beforeunload', function () {
                sessionStorage.removeItem(storageKey);
            });
        });
    </script>
@endsection
