@extends('admin.layouts.master')

@section('title', 'Users Account Detail')

@section('content')
<div class="main-content">
    {{-- <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12"> --}}
    {{-- <div class="page-content page-container" id="page-content">
        <div class="padding"> --}}
            <div class="row container d-flex justify-content-center">
                <div class="col-xl-6 col-md-12">
                    <div class="card user-card-full">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-25">
                                        {{-- <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> --}}
                                        @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/MaleLogo.png') }}" alt="{{ $user->name }}" class=" img-radius"/>
                                                @else
                                                    <img src="{{ asset('image/FemaleLogo.png') }}" alt="{{ $user->name }}" class=" img-radius"/>
                                                @endif
                                        @else
                                            <div class="" style="height: 100px">
                                                <img src="{{ asset('storage/'.$user->image) }}" alt="{{ $user->name }}" class=" rounded-circle shadow-sm h-100 " />
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="f-w-600">{{ $user->name }}</h4>
                                    <p class="mt-3 b-b-default m-b-20"> Role : {{ $user->role }}</p>
                                    <a href="{{ route("admin#userList") }}" class=" m-t-20 p-b-5 f-w-400 text-dark"><i class="fa-solid fa-backward me-2"></i></i>Back User Lsit</a>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block parentCard">
                                    <h4 class="m-b-20 p-b-5 b-b-default f-w-600">{{ $user->name }} | <small class="text-primary">Information</small></h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Email</p>
                                            <h6 class="text-muted f-w-400">{{ $user->email }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Phone</p>
                                            <h6 class="text-muted f-w-400"><i class="fa-solid fa-phone me-2"></i>{{ $user->phone }}</h6>
                                        </div>
                                    </div>
                                    <h6 class="m-b-20 p-b-5 b-b-default"></h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Gender</p>
                                            <h6 class="text-muted f-w-400">
                                                @if ($user->gender == 'male')
                                                    <i class="fa-solid fa-mars me-2"></i>
                                                @else
                                                <i class="fa-solid fa-venus me-2"></i>
                                                @endif
                                                {{ $user->gender }}
                                            </h6>
                                        </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Address</p>
                                        <h6 class="text-muted f-w-400"><i class="fa-solid fa-location-dot me-2"></i>{{ $user->address }}</h6>
                                    </div>
                                    <h6 class=" p-b-5 b-b-default"></h6>
                                    <h6 class="m-b-20 m-t-20 p-b-5 b-b-default f-w-600">Change Role</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Role</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">
                                                <select name="role" id="" class="text-primary roleChange">
                                                    <option value="admin" @if ($user->role == "admin" ) selected @endif>Admin</option>
                                                    <option value="user" @if ($user->role == "user" ) selected @endif>User</option>
                                                </select>
                                            </p>
                                            <input type="hidden" name="" class="userId" value="{{ $user->id }} ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div></div></div></div>
@endsection

@section('scriptSection')
<script>
    $(document).ready(function(){
        // change role status
        $('.roleChange').change(function(){

            $currentRole = $(this).val();
            console.log($currentRole);
            $parentNode = $(this).parents(".parentCard");
            $userId = $parentNode.find('.userId').val();

            $data = { 'userId' : $userId ,'role': $currentRole};
            console.log($data);
            $.ajax({
                type : 'get',
                url : '/user/ajax/userlist',
                data : $data ,
                dataType : 'json',

            });
            window.location.href = '/user/list';


        })
    })
</script>

@endsection
