@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        
	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success')}}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

		<div class="col-md-2">
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- End of Sidebar -->
        </div>

		<div class="col-md-10">
			<div class="card">
				<div class="row">
					<div class="col-3">

					<form method="POST" action="{{ route('user-profile-information.update') }}">
						@csrf
						@method('PUT')

						<div class="form-group mx-3 my-2">
							<label>{{ __('Name') }}</label>
							<input type="text" name="name" id="name" class="@error('source') is-invalid @enderror" value="{{ old('name') ?? auth()->user()->name }}" required autofocus autocomplete="name" />

							@error('name')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>

						<div class="form-group mx-3 my-2">
							<label>{{ __('Email') }}</label>
							<input type="email" name="email" disabled value="{{ old('email') ?? auth()->user()->email }}" required autofocus />
						</div>

						<div class="form-group mx-3 my-2">
							<button class="btn btn-success" type="submit">
								{{ __('Update Profile') }}
							</button>
						</div>
					</form>

					</div>
				</div>
			</div>

			<br>

			<div class="card">
				<div class="row">
					<div class="col-3">

					<form method="POST" action="{{ route('user-password.update') }}">
						@csrf
						@method('PUT')

						<div class="form-group mx-3 my-2">
							<label>{{ __('Current Password') }}</label>
							<input type="password" name="current_password" required autocomplete="current-password" />
						</div>

						<div class="form-group mx-3 my-2">
							<label>{{ __('New Password') }}</label>
							<input type="password" name="password" required autocomplete="new-password" />
						</div>

						<div class="form-group mx-3 my-2">
							<label>{{ __('Confirm Password') }}</label>
							<input type="password" name="password_confirmation" required autocomplete="new-password" />
						</div>

						<div class="form-group mx-3 my-2">
							<button class="btn btn-success" type="submit">
								{{ __('Save') }}
							</button>
						</div>
					</form>

					</div>
				</div>
			</div>

			<div class="card my-2">
				<div class="row">
					<div class="col">
						<div class="form-group mx-3 my-2">
						@if(! auth()->user()->two_factor_secret)
							{{-- Enable 2FA --}}
							<form method="POST" action="{{ route('two-factor.enable') }}">
								@csrf

								<button class="btn btn-success" type="submit">
									{{ __('Enable Two-Factor') }}
								</button>
							</form>
						@else
							{{-- Disable 2FA --}}
							<form method="POST" action="{{ route('two-factor.disable') }}">
								@csrf
								@method('DELETE')

								<button class="btn btn-success" type="submit">
									{{ __('Disable Two-Factor') }}
								</button>
							</form>

							@if(session('status') == 'two-factor-authentication-enabled')
								{{-- Show SVG QR Code, After Enabling 2FA --}}
								<div class="my-2">
									{{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
								</div>

								<div>
									{!! auth()->user()->twoFactorQrCodeSvg() !!}
								</div>
							@endif

							{{-- Show 2FA Recovery Codes --}}
							<div class="my-2">
								{{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
							</div>

							<div>
								<ul>
									@foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
										<li>{{ $code }}</li>
									@endforeach
								</ul>
							</div>


							{{-- Regenerate 2FA Recovery Codes --}}
							<form method="POST" action="{{ route('two-factor.recovery-codes') }}">
								@csrf

								<button class="btn btn-success" type="submit">
									{{ __('Regenerate Recovery Codes') }}
								</button>
							</form>
						@endif
						</div>
					

					</div>
				</div>
			</div>
			
		</div>

	</div>

</div>

@endsection
