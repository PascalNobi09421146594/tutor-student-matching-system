
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management | PascalEDU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f7f1eb;
            color: #482313;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #51220d;
            padding: 18px 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .page {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 18px;
        }

        .panel {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(60, 35, 20, .06);
        }

        .btn-pascal {
            background: #51220d;
            color: white;
            border: none;
        }

        .btn-pascal:hover {
            background: #713719;
            color: white;
        }

        .table th {
            color: #51220d;
            white-space: nowrap;
        }

        .role-form {
            display: flex;
            gap: 8px;
            min-width: 210px;
        }

        .role-form select {
            min-width: 110px;
        }

        .muted {
            color: #89766a;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.dashboard') }}"
           class="fw-bold fs-4 ms-0">PascalEDU Admin</a>

        <div>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users') }}">Users</a>

            <form action="{{ url('/logout') }}" method="POST"
                  class="d-inline">
                @csrf
                <button type="submit"
                        class="btn btn-sm btn-outline-light ms-3">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>

<main class="page">
    <div class="mb-4">
        <h1 class="fw-bold">User Management</h1>
        <p class="muted">
            View registered users and manage their account roles.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="panel">
        <form action="{{ route('admin.users') }}" method="GET"
              class="row g-2 mb-4">
            <div class="col-md-9">
                <input type="text"
                       name="search"
                       class="form-control"
                       value="{{ $search }}"
                       placeholder="Search by name or email">
            </div>

            <div class="col-md-3 d-grid">
                <button class="btn btn-pascal" type="submit">
                    Search Users
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Current Role</th>
                        <th>Change Role</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>

                            <td>
                                <strong>{{ $user->name }}</strong>
                                <div class="small muted">
                                    {{ $user->email }}
                                </div>
                            </td>

                            <td>
                                <span class="badge
                                    @if($user->role === 'admin')
                                        text-bg-danger
                                    @elseif($user->role === 'tutor')
                                        text-bg-primary
                                    @else
                                        text-bg-secondary
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>

                                @if($user->id === auth()->id())
                                    <div class="small muted">Your account</div>
                                @endif
                            </td>

                            <td>
                                @if($user->id === auth()->id())
                                    <span class="muted">
                                        Cannot change own role
                                    </span>
                                @else
                                    <form
                                        action="{{ route('admin.users.update-role', $user) }}"
                                        method="POST"
                                        class="role-form"
                                        onsubmit="return confirm('Are you sure you want to change this user role?');">

                                        @csrf
                                        @method('PATCH')

                                        <select name="role"
                                                class="form-select form-select-sm"
                                                required>
                                            <option value="student"
                                                @selected($user->role === 'student')>
                                                Student
                                            </option>

                                            <option value="tutor"
                                                @selected($user->role === 'tutor')>
                                                Tutor
                                            </option>

                                            <option value="admin"
                                                @selected($user->role === 'admin')>
                                                Admin
                                            </option>
                                        </select>

                                        <button type="submit"
                                                class="btn btn-pascal btn-sm">
                                            Save
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </section>
</main>

</body>
</html>
