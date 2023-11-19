<x-guest-layout>

    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="row align-items-center text-center">
                    <div class="col-md-12">
                        <div class="card-body">

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                {{-- <img src="{{ asset('images/logo-dark.png') }}" alt="" class="img-fluid mb-4"> --}}
                                <h5 class="mb-3 f-w-900 text-primary">WASPS RATS</h5>
                                <h4 class="mb-3 f-w-400">Sign up</h4>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="feather icon-user"></i></span>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email address">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                                    @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <button class="btn btn-primary btn-block mt-2 mb-4">Sign up</button>
                                <p class="mb-2">Already have an account? 
                                    <a href="{{ route('login') }}" class="f-w-400">Signin</a>
                                </p>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- [ auth-signup ] end -->
</x-guest-layout>
