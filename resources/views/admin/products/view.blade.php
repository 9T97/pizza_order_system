@extends('admin.layouts.master')

@section('title', ' View Pizza Page')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="row mb-2">
            <div class="col-3 offset-7">
                @if (session('updateSuccess'))
                    <div class="">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{ session('updateSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class=" fs-4">
                                <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">{{ $pizza->category_name }}</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1">
                                    <img src="{{ asset('storage/'.$pizza->image) }}" alt="{{ $pizza->name }}" />
                                </div>
                                <div class="col-8">
                                    <div class="my-3 me-2 text-danger fs-3"> <i class="fa-solid fa-pizza-slice me-2"></i>{{ $pizza->name }}</div>
                                    <span class="btn btn-info my-3 me-2"> <i class="fa-solid fa-money-bill-1-wave me-1 fs-4"></i> {{ $pizza->price }} Kyat</span>
                                    <span class="btn btn-info my-3 me-2"> <i class="fa-solid fa-clock me-1 fs-4"></i>    {{ $pizza->waiting_time }} min</span>
                                    <span class="btn btn-info my-3 me-2"> <i class="fa-solid fa-eye me-1 fs-4"></i> {{ $pizza->view_count }}</span>
                                    <span class="btn btn-info my-3 me-2"> <i class="fa-solid fa-user-clock me-1 fs-4"></i> {{ $pizza->created_at->format('j/F/Y') }}</span>
                                    <div class="my-3 text-dark"> <i class="fa-solid fa-file-lines me-1 fs-4 text-info"></i> Details</div>
                                    <div class=" text-success fs-4">{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
