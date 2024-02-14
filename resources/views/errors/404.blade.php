@extends('layouts.dashboard.master')
@section('content')
<style>
    .page-content, .breadcrumb-bar{
        background:unset !important;
    }
</style>
<div class="breadcrumb-bar">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-12">
				<div class="breadcrumb-list">
					<nav aria-label="breadcrumb" class="page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">&nbsp;</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-content">
    <section class="section">
        <div class="container">


            <div class="main-wrapper">
                <div class="error-box">
                    <div class="error-logo">
                        <a href="{{ url('/') }}">
                            <img src="assets/img/logo.svg" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="error-box-img">
                        <img src="{{ url('assets/img/error-01.png') }}" alt="" class="img-fluid">
                    </div>
                    <h3 class="h2 mb-3"> Oh No! Error 404</h3>
                    <p class="h4 font-weight-normal">This page you requested counld not found. May the force be with you!</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>

        </div>
    </section>
</div>


@endsection
@push('script')

@endpush
