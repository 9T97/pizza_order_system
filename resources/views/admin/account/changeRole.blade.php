@extends('admin.layouts.master')

@section('title', ' Admin Change Role')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="fs-4 col-1">
                                    <a href="{{ route('admin#list') }}">
                                        <i class="fa-solid fa-arrow-left text-dark"></i>
                                    </a>
                                </div>
                                <div class="col text-center title-2">Change Role</div>
                            </div>
                            <hr>
                            <form action="{{ route('admin#change',$account->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            @if ($account->gender == 'male')
                                                <img src="{{ asset('image/MaleLogo.png') }}" alt="{{ $account->name }}" class=" img-thumbnail shadow-sm w-100"/>
                                            @else
                                                <img src="{{ asset('image/FemaleLogo.png') }}" alt="{{ $account->name }}" class=" img-thumbnail shadow-sm w-100"/>
                                            @endif
                                        @else
                                        <img src="{{ asset('storage/'.$account->image) }}" alt="{{ $account->name }}" class=" img-thumbnail shadow-sm w-100 " />
                                        @endif

                                        <div class="form-group">
                                            <label class="control-label mb-1">Role</label>
                                            <select name="role" class="form-control">
                                                <option value="admin" @if($account->role == 'admin') selected @endif>Admin</option>
                                                <option value="user" @if($account->role == 'user') selected @endif>User</option>
                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn bg-dark text-white col-12" type="submit">
                                                Change <i class="fa-solid fa-circle-chevron-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input id="cc-pament" disabled name="name" type="text" value="{{ old('name', $account->name) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admmin Name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input id="cc-pament" disabled name="email" type="email" value="{{ old('email', $account->email) }}" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Admmin Email">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" disabled name="phone" type="text" value="{{ old('phone', $account->phone) }}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admmin Phone">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Gender</label>
                                            <select name="gender" disabled id="" class="form-control">
                                                <option value="male" @if($account->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if($account->gender == 'female') selected @endif>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" disabled id="" cols="30" rows="10" class="form-control" placeholder="Enter Admin Address">{{ old('address', $account->address) }}</textarea>
                                        </div>



                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
