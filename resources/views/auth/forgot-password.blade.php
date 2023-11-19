<x-guest-layout>
    <!-- [ reset-password ] start -->
    <div class="auth-wrapper">	
        <div class="auth-content">
            <div class="card">
                <div class="row align-items-center text-center">
                    <div class="col-md-12">
                        <div class="card-body">

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                {{-- <img src="{{ asset('images/logo-dark.png') }}" alt="" class="img-fluid mb-4"> --}}
                                <h5 class="mb-3 f-w-900 text-primary">WASPS RATS</h5>
                                <h4 class="mb-3 f-w-400">Reset your password</h4>
                                <div class="input-group mb-4">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email address">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <button class="btn btn-block btn-primary mb-4">Email Password Reset Link</button>
                                <p class="mb-0 text-muted">Don’t have an account? 
                                    <a href="{{ route('register') }}" class="f-w-400">Signup</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- [ reset-password ] end -->
</x-guest-layout>
