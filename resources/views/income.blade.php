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
                <div class="card-header">

					<div class="container">
						<div class="row justify-content-center">
							<div class="col-md-12">
								<div class="text-center">
									<h4 class="card-title mt-2 " style="color: greenyellow;">
									@php
										$totalIncome = 0;
										foreach ($incomes as $income) {
											$totalIncome += $income->amount;
										}
									@endphp
										+RM {{ $totalIncome }}
									</h4>
								</div>
							</div>
						</div>
					</div>

				</div>

                <div class="card-body">

					<div class="row">
						<div class="col-3">

						<form action="{{ route('income.store') }}" method="POST">
							@csrf

							<div class="form-group my-2">
								<input name="source" type="text" class="form-control @error('source') is-invalid @enderror" id="source" value="{{ old('source')}}" placeholder="Source">
							
								@error('source')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>

							<div class="form-group my-2">
								<input name="amount" type="float" class="form-control @error('amount') is-invalid @enderror" id="amount" value="{{ old('amount')}}" placeholder="Amount">
								
								@error('amount')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>

							<div class="form-group my-2">
								<textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="2" placeholder="Reference">{{ old('description')}}</textarea>
							
								@error('description')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>

							<button class="btn btn-primary">Submit</button>
						</form>

						</div>

						<div class="col-9">
						@if(!empty($income->source))
							<div class="card">
								<div class="card-body">
								<div class="row">
									@foreach($incomes as $income)
									<div class="col-md-4 mb-3">
										<div class="card">
											<div class="card-body text-center">
												<h4 class="card-title" style="font-weight: bold;">{{ $income->source }}</h4>
												<h5 class="card-text">RM {{ $income->amount }}</h5>
												<p class="card-text">{{ $income->description }}</p>
												<form class="d-inline" action="{{ route('income.destroy', $income->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete? {{ $income->source}}')" >
													@method('delete')
													@csrf
													<button class="btn btn-danger btn-sm" type="submit">
														DELETE
													</button>
												</form>
											</div>
										</div>
									</div>
									@endforeach
								</div>
								</div>
							</div>
						@endif
						</div>

					</div>
						
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
