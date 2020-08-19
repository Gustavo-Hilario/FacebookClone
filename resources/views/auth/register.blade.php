@extends('layouts.app')

@section('content')

<div class="w-full flex h-full bg-black">
    <div class="w-4/5 flex justify-center mx-auto my-20 bg-black">
        <div class="w-full my-auto max-w-xs">
            <form method="POST" action="{{ route('register') }}" class="bg-white shadow-md rounded px-6 py-4">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ __('Name') }}
                    </label>
                    <input id="name" type="text" class="@error('name') is-invalid @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Username" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ __('E-Mail Address') }}
                    </label>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Your Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ __('Password') }}
                    </label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Password" name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <p class="text-red-500 text-xs italic">Please choose a password.</p>
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">
                        {{ __('Confirm Password') }}
                    </label>
                    <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" placeholder="Password" name="password_confirmation" required autocomplete="new-password">
                    <p class="text-red-500 text-xs italic">Please confirm your password.</p>
                </div>

                <div class="flex items-center justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                        {{ __('Register') }}
                    </button>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <p class="w-3/5 text-gray-700 text-xs italic">Do you have an account?</p>
                    <a onclick="goBack()" class="mr-2 inline-block align-baseline font-bold text-sm text-gray-700 hover:text-black" >
                        Go Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

@endsection
