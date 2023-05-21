@extends('admin.layouts.master')
@section('title', 'Users-List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">User List</h2>

                        </div>
                    </div>
                </div>

                <!--   ALERT MESSAGE -->
                @if (session('message'))
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                {{-- @if (count($orders) > 0) --}}
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody class="dataList">
                            @foreach ($users as $user)
                                <tr class="tr-shadow dataRow">
                                    <input type="hidden" value="{{ $user->id }}" class="userId">
                                    <td>
                                        @if ($user->image != null)
                                            <div style="background-size: contain ; background-repeat: no-repeat">
                                                <img src="{{ asset('storage/' . $user->image) }}" style="width: 40px">
                                            </div>
                                        @else
                                            <img src="@if ($user->gender == 'male') {{ asset('images/default/default-user-male.png') }}
                                        @else
                                        {{ asset('images/default/default-user-female.jpg') }} @endif "
                                                alt="" style="width: 40px">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>

                                    <td>
                                        <select name="role" id="" class="form-control userRole">
                                            <option value="admin" @if ($user->role == 'admin') selected @endif>Admin
                                            </option>
                                            <option value="user" @if ($user->role == 'user') selected @endif>User
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{-- <div class="fixed-bottom offset-4">
                        {{ $orders->appends(request()->query())->links() }}
                    </div> --}}
                </div>
                <!-- END DATA TABLE -->
                {{-- @else
                    <div class="d-block mt-4">
                        <h2 class="text-center text-secondary">No data ...</h2>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.userRole').change(function() {
                $role = $(this).val();
                $parentNode = $(this).parents('.dataRow');
                $userId = $parentNode.find('.userId').val();

                console.log($userId);
                console.log($role);
                $.ajax({
                    type: 'get',
                    url: '/admin/ajax/user/role/change',
                    data: {
                        'user_id': $userId,
                        'role': $role,
                    },
                    // dataType : 'json',

                    success: function(response) {
                        console.log(response);
                    }
                })
                location.reload();
            })
        })
    </script>
@endsection
