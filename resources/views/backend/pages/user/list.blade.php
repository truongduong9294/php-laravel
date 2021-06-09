@extends('backend.master');
@section('content')
    <div class="heading">
        <h3>List User</h3>
    </div>
    <div class="btn-add">
        <a href="{{ route('user.create') }}" class="btn btn-primary add_data">Add</a>
    </div>
    @if(session()->has('success'))  
        <div class="alert-message">
            <div class="alert alert-success message-success">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="main">
        <table class="table-cate">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Role Name</th>
                    <th colspan="2">Function</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td style="width: 10%;"><img style="width: 100%;" src="{{ asset('uploads/' . $user->avatar) }}" alt=""></td>
                    <td>{{ $user->role_name }}</td>
                    <td><a href="{{ route('user.edit', ['id' => $user->id, 'current' => $users->currentPage()]) }}" class="edit" id = "{{ $user->id }}">Edit</a></td>
                    <td><a onclick="return confirm('Are you want to delete?')" href="{{ route('user.delete', ['id' => $user->id, 'current' => $users->currentPage()]) }}" class="delete" id = "{{ $user->id }}">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <?php
        $previous = $users->currentPage() - 1;
        $next     = $users->currentPage() + 1;
    ?>
    <div class="pagination">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php if ($users->currentPage() <= 1){ echo 'previos_disble'; } else{ echo 'previos_enable'; }  ?>"><a class="page-link" href="{{ route('user.list', ['page' => $previous]) }}">Previous</a></li>
              @for ($i = 1; $i <= $users->lastPage(); $i++)
                  <li class="page-item"><a class="page-link <?php if ($users->currentPage() === $i) {echo "selected"; } ?>" href="{{ route('user.list', ['page' => $i]) }}">{{ $i }}</a></li>
              @endfor
                <li class="page-item <?php if ($users->currentPage() >= $users->lastPage()) { echo 'next_disable'; } else { echo "next_enable"; } ?>"><a class="page-link" href="{{ route('user.list', ['page' => $next]) }}">Next</a></li>
            </ul>
        </nav>
    </div>
@endsection