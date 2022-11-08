@extends('admin.layouts.master')

@section('title', 'Admin List')

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
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }} {{$user->name}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-2 bg-white shadow-sm p-2 text-center">
                            <h4><i class="fa-solid fa-database me-3"></i>{{ $admin->total() }}</h4>
                        </div>
                        <div class="col-3 offset-1 text-center">
                            <h4 class="text-secondary">Search Key : <span class="text-danger"> {{ request('key') }}</span> </h4>
                        </div>
                        <div class="col-3 offset-3">
                            <form action="{{ route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..." value="{{ request('key') }}">
                                    <button class="btn btn-dark" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th class="">image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($admin as $a)
                                    <tr class="tr-shadow">
                                        <td class="">
                                            @if ($a->image == null)
                                                <div class="" style="height: 100px">
                                                    @if ($a->gender == 'male')
                                                        <img src="{{ asset('image/MaleLogo.png') }}" alt="{{ $a->name }}" class=" img-thumbnail shadow-sm h-100"/>
                                                    @else
                                                        <img src="{{ asset('image/FemaleLogo.png') }}" alt="{{ $a->name }}" class=" img-thumbnail shadow-sm h-100"/>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="" style="height: 100px">
                                                    <img src="{{ asset('storage/'.$a->image) }}" alt="{{ $a->name }}" class=" img-thumbnail shadow-sm h-100 " />
                                                </div>
                                            @endif
                                        </td>
                                        <input type="hidden" name="" class="adminId" value="{{ $a->id }} ">
                                        <td class=" text-info font-weight-bold"> {{ $a->name }} </td>
                                        <td class=" text-info font-weight-bold"> {{ $a->email }} </td>
                                        <td class=" text-info font-weight-bold"> {{ $a->gender }} </td>
                                        <td class=" text-info font-weight-bold"> {{ $a->phone }} </td>
                                        <td class=" text-info font-weight-bold"> {{ $a->address }} </td>
                                        <td class=" text-info font-weight-bold">
                                            @if (Auth::user()->id != $a->id)
                                                <select name="role" id="" class="text-info font-weight-bold form-control roleChange">
                                                    <option value="admin" @if ($a->role == "admin" ) selected @endif>Admin</option>
                                                    <option value="user" @if ($a->role == "user" ) selected @endif>User</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if (Auth::user()->id != $a->id)
                                                    <a href="{{ route('admin#changeRole',$a->id) }}">
                                                        <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Change Admin Role">
                                                            <i class="fa-solid fa-dice"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('admin#delete',$a->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $admin->links() }}
                            {{-- {{ $categories->appends(request()->querry())->links() }} --}}
                        </div>
                    </div>
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
            console.log($currentRole);
            $parentNode = $(this).parents("tr");
            $adminId = $parentNode.find('.adminId').val();

            $data = {
                'currentRole' : $currentRole,
                'adminId' : $adminId
            };
            console.log($data);
            $.ajax({
                type : 'get',
                url : '/admin/ajax/adminlist',
                data : $data ,
                dataType : 'json',
                success : function(response){
                    if(response.status == 'true'){
                        window.location.href = '/admin/list';
                    }
                }
            });


        })
    })
</script>

@endsection
