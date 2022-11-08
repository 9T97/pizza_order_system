@extends('admin.layouts.master')

@section('title', 'Users Account List')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                        <div class="table-responsive table-responsive-data2">
                            <div class="row">
                                <div class="col-6">
                                    <h2> Users List Table</h2>
                                </div>
                                <div class="col offset-5">
                                    <h4> Total - {{ $users->total() }}</h4>
                                </div>
                            </div>
                            @if (session('deleteSuccess'))
                                <div class="col-4 offset-8">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif


                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th text-info fs-3>Image</th>
                                        <th text-primary font-weight-bold>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id='datalist'>
                                    @foreach ($users as $user)

                                            <tr class="tr-shadow">
                                                <td class=" ">
                                                    @if ($user->image == null)
                                                        <div class="" style="height: 100px">
                                                            @if ($user->gender == 'male')
                                                                <img src="{{ asset('image/MaleLogo.png') }}" alt="{{ $user->name }}" class=" img-thumbnail shadow-sm h-100"/>
                                                            @else
                                                                <img src="{{ asset('image/FemaleLogo.png') }}" alt="{{ $user->name }}" class=" img-thumbnail shadow-sm h-100"/>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="" style="height: 100px">
                                                            <img src="{{ asset('storage/'.$user->image) }}" alt="{{ $user->name }}" class=" img-thumbnail shadow-sm h-100 " />
                                                        </div>
                                                    @endif
                                                </td>
                                                <input type="hidden" name="" class="userId" value="{{ $user->id }} ">
                                                <td class=" text-info font-weight-bold"> {{ $user->name }} </td>
                                                <td class=" text-info font-weight-bold"> {{ $user->email }} </td>
                                                <td class=" text-info font-weight-bold"> {{ $user->gender }} </td>
                                                <td class=" text-info font-weight-bold"> {{ $user->phone }} </td>
                                                <td class=" text-info font-weight-bold"> {{ $user->address }} </td>
                                                <td class=" ">
                                                    <select name="role" id="" class="text-primary font-weight-bold form-control roleChange">
                                                        <option value="admin" @if ($user->role == "admin" ) selected @endif>Admin</option>
                                                        <option value="user" @if ($user->role == "user" ) selected @endif>User</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('admn#userDetail',$user->id) }}" class="btn btn-outline-secondary deletebtn" id="" title="Detail">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </a>
                                                        <a href="{{ route('admin#userDelete',$user->id) }}" class="btn btn-outline-danger deletebtn" id="" title="Delete">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="spacer"></tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $users->links() }}
                            </div>
                        </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('scriptSection')
<script>
    $(document).ready(function(){
        // change role status
        $('.roleChange').change(function(){

            $currentRole = $(this).val();
            // console.log($currentRole);
            $parentNode = $(this).parents("tr");
            $userId = $parentNode.find('.userId').val();

            $data = { 'userId' : $userId ,'role': $currentRole};
            console.log($data);
            $.ajax({
                type : 'get',
                url : '/user/ajax/userlist',
                data : $data ,
                dataType : 'json',

            });
            location.reload();


        })
    })
</script>


@endsection
