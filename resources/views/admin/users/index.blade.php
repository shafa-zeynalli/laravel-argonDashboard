@extends('layout.admin')


@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{route('admin.users')}}">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Users</li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Users</h6>
    </nav>
@endsection



    @section('content')

        <div class="text-white">

            <form action="{{route('admin.users.filter')}}" method="post">
                @csrf
                <label for="" class="text-white">Name
                    <input type="text" name="name" class="form-control form-control-lg">
                </label>
                <label for="" class="text-white">Email
                    <input type="email" name="email" class="form-control form-control-lg">
                </label>

                <button type="submit" class="btn btn-success py-3 mx-2 mt-2">Search</button>
            </form>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Authors table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table  mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>

                                </tr>
                                </thead>
                                <tbody>
{{--                                {{$usersForm ?? ''}}--}}
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                              <p>{{$user->id}}</p>
                                        </td>
                                        <td>
                                              <p>{{$user->name}}</p>
                                        </td>
                                        <td>
                                              <p>{{$user->email}}</p>
                                        </td>
                                        <td>
                                            <p>{{ $user->created_at?$user->created_at->format('Y/m/d'):'' }}</p>
                                        </td>

                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection


