@extends('admin.layouts.master')
@section('titile', 'Admin-List')
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
                        <div class="table-data__tool-right">
                            {{-- <a href="{{ route('user#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add item
                                </button>
                            </a> --}}
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>
                    {{--   ALERT MESSAGE --}}
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
                    <div class="row">
                        <div class="col-lg-8">
                            <h4>Total of <span class="text-danger">{{ $users->total() }}</span> Records</h4>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('admin#accountList') }}">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="key" value="{{ request('key') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <button>
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="tr-shadow dataRow">
                                        <input type="hidden" value="{{ $user->id }}" class="userId">
                                        <td>
                                            <div style="width:40px;background-size: contain" class="img-thumbnail">
                                                @if (isset($user->image))
                                                    <img src=" {{ asset('storage/' . $user->image) }}" alt="">
                                                @else
                                                    <img src="@if ($user->gender == 'male') {{ asset('images/default/default-user-male.png') }}
                                                        @else
                                                            {{ asset('images/default/default-user-female.jpg') }} @endif"
                                                        alt="">
                                                @endif

                                            </div>
                                        </td>
                                        <td class="desc">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            @if ($user->id != Auth::user()->id)
                                                <select name="role" id="" class="form-control userRole" title="Admin Role Change">
                                                    <option value="admin"
                                                        @if ($user->role == 'admin') selected @endif>Admin
                                                    </option>
                                                    <option value="user"
                                                        @if ($user->role == 'user') selected @endif>User
                                                    </option>
                                                </select>
                                            @else
                                                Admin
                                            @endif
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if (Auth::user()->id == $user->id)
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Current Admin Can't be deleted">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('admin#accountDelete', $user->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="fixed-bottom offset-4">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->

                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
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
                // location.reload();
            })
        })
    </script>
@endsection
