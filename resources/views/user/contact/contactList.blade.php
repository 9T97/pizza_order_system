@extends('user.layouts.master')

@section('title', 'User Contact List')

@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    <div class="row mb-3">

                        <a href="{{ route('user#home') }}" class="col text-decoration-none text-dark">
                            <i class="fa-solid fa-arrow-left" m1></i> back
                        </a>

                        <div class="col d-flex justify-content-end">
                            <a href="{{ route('user#userContact') }}" class="p-2 text-decoration-none text-dark" style="border-style: dashed;">

                                    <i class="fa-solid fa-plus me-2"></i>Sent New Contact

                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <h2>{{Auth::user()->name}} <span class="fs-5"> --> Contacts List</span></h2>
                        </div>
                        <div class="col offset-4">
                            <h4> Total Mail - {{ $contact->total() }}</h4>
                            </div>
                    </div>
                    @if (count($contact) != 0)
                        <div class="mt-5">
                            @foreach ($contact as $c )
                                <div class="border border-dark rounded mb-3 remove" id="">

                                    <div class="row fs-5 ms-3 mt-2" >
                                        <div class="col-3">{{ $c->name}} | <small>{{ $c->email}}</small></div>
                                        <div class="col-3 offset-5">{{$c->created_at->format('F-j-Y')}}</div>
                                        <div class="col ">
                                            <input type="hidden" class="contactId" value="{{ $c->id }}">
                                            <button class="btn btn-outline-danger btnRemove" id="" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="row mt-3 ms-3">
                                        <div class="col-2">Subject :</div>
                                        <div class="col"> {{ $c->subject }}</div>
                                    </div>
                                    <div class="row mb-3 ms-3">
                                        <div class="col-2">Message :</div>
                                        <div class="col"> {{ $c->message }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $contact->links() }}
                        </div>
                    @else
                        <h3 class="text-center text-secondary mt-5">There is no Contact Here!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scriptSource')

<script>
    $(document).ready(function(){

        $('.btnRemove').click(function(){
            $parentNode = $(this).parents('.remove');

            $contactId = $parentNode.find('.contactId').val();
            console.log($contactId);
            $.ajax({
                type : 'get',
                url : '/user/ajax/contactlist',
                data : {'contactId': $contactId },
                dataType : 'json',
            });

            $parentNode.remove();

        })
    })
</script>

@endsection


