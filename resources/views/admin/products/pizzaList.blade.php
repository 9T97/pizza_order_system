@extends('admin.layouts.master')

@section('title', 'Products List')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Products List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger"> {{ request('key') }}</span> </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('product#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..." value="{{ request('key') }}" autocomplete="off">
                                    <button class="btn btn-dark" type="submit"  data-toggle="tooltip" data-placement="bottom" title="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center" data-toggle="tooltip" title="Total Count" data-placement="bottom">
                            <h4><i class="fa-solid fa-database me-2"></i>  {{ $pizzas->total() }} </h4>
                        </div>
                    </div>
                    @if (count($pizzas) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pizzas as $p)
                                    <tr class="tr-shadow">
                                        <td class="col-2">
                                            <img src="{{ asset('storage/'.$p->image) }}" alt="" class=" img-thumbnail shadow-sm">
                                        </td>
                                        <td class="col-3 text-info font-weight-bold">
                                            {{ $p->name }}
                                        </td>
                                        <td class="col-2 text-info font-weight-bold">
                                            {{ $p->price }} MMK
                                        </td>
                                        <td class="col-2 text-info font-weight-bold">
                                            {{ $p->category_name }}
                                        </td>
                                        <td class="col-2 text-info font-weight-bold">
                                            <i class="fa-solid fa-eye"></i>
                                            {{ $p->view_count }}
                                        </td>
                                        <td class="col-2">
                                            <div class="table-data-feature">
                                                <a href="{{ route('product#view',$p->id) }}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="View">
                                                        <i class="fa-solid fa-eye text-info"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('product#edit',$p->id) }}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('product#delete',$p->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $pizzas->links() }}
                            </div>
                        </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-center text-secondary mt-5">There is no pazzas Here!</h3>
                @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
