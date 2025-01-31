<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users, Roles & Permissions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
        $("#remove-role-form").filter(function() {
                    $(this).toggle()
                });
        $('#remove-role-form').submit(function(e) {
                e.preventDefault();

                var formData = new  FormData(this);
                console.log(formData);
                const url =
                    '{{Route::currentRouteName() === 'users.showremoveroles' ? route('users.removeroles') : route('users.showremoveroles') }}';
                const method = '{{ Route::currentRouteName() === 'forms.edit' ? 'PATCH' : 'POST' }}';
                console.log(method);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content'),
                        _method: method,
                        inputdata: data,
                    },

                    success: function(response) {

                        console.log(response.message);


                        $('#input').trigger("reset");


                        window.location.href =
                            "{{ route('forms.index') }}";
                    },

                });
            });
        });
    </script>
</head>

<body>

    <h2>Users, Roles & Permissions</h2>
   
        <a href="{{ route('users.index') }}">index</a><br>
    
    <a href="{{ route('users.create') }}">create roles</a>
    <table>
        <thead>
            <tr>
                <th>Users</th>
                <th>Roles</th>
                <th>Permissions</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>

                    {{ $user->getRoleNames()->implode(', ') }}

                </td>
                <td>{{ $user->getPermissionsViaRoles()->pluck('name')->implode(', ') }}</td>
                <td>

                    <form
                        id="remove-role-form"
                        action="{{ Route::currentRouteName() === 'users.showremoveroles' ? route('users.removeroles') : route('users.showremoveroles') }}"
                        method="{{ Route::currentRouteName() === 'users.showremoveroles' ? 'POST' : 'GET' }}">
                        @csrf
                        @if (Route::currentRouteName() === 'users.showremoveroles')
                            <div id="permissions" class="form-group">
                                @foreach ($user->roles as $role)
                                    <div class="form-check">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}" id="user_id">
                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                            value="{{ $role->id }}" id="remove-role">
                                        <label class="form-check-label" for="remove-role">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" id="remove-submit" class="btn btn-danger">Remove Role</button>
                    </form>

                    <form 
                        id="set-role-form"
                        action="{{ Route::currentRouteName() === 'users.showsetroles' ? route('users.setroles') : route('users.showsetroles') }}"
                        method="{{ Route::currentRouteName() === 'users.showsetroles' ? 'POST' : 'GET' }}">
                        @csrf
                        @if (Route::currentRouteName() === 'users.showsetroles')
                            <div id="permissions" class="form-group">
                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                            value="{{ $role->id }}" id="set-role">
                                        <label class="form-check-label" for="set-role">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" class="btn btn-danger" id="set-submit">Set Role</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

</body>

</html>
