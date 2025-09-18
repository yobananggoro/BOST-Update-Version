@extends('layouts.app')
@section('title', 'User List')
@section('content')
<div class="card card-default">
    <form method="post" action="{{ url('users/isAction') }}">
        @csrf
        <div class="card-body">
            <table id="dtTables1" class="table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" onchange="checkAll(this)"></th>
                        @if(in_array(auth()->user()->profile->rolename, ['SUPER ADMIN', 'Staf ITS ', 'Staf IT']))
                        <th>Aksi</th>
                        @endif
                        <th>No.</th>
                        <th>Login</th>
                        <th>User ID</th>
                        <th>Nama</th>
                        <th>Nip</th>
                        <th>Unit Kerja</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                        <td><input type="checkbox" name='id[]' id="checkItem" value="{{ $d->id }}"></td>
                        @if(in_array(auth()->user()->profile->rolename, ['SUPER ADMIN', 'Staf ITS ', 'Staf IT']))
                        <td><a href="{{ route('users.edit', $d->id) }}" type="button" class="btn btn-sm btn-default"><i class="fa fa-pencil-alt"></i></a></td>
                        @endif
                        <td>{{ $loop->iteration }}.</td>
                        <td class="text-center">
                            {{-- @if(!is_null($d->session_id) && $d->status == 1)
                            <span class="badge badge-success">Online</span>
                            @else 
                            <span class="badge badge-danger">Offline</span>
                            @endif --}}
                            @if (Cache::has('user-is-online-' . $d->id))
                            <span class="badge badge-success">Online</span>
                            @else
                            <span class="badge badge-danger">Offline</span>
                            @endif
                        </td>
                        <td>{{ $d->username }}</td>
                        <td>{{ $d->profile->nama }}</td>
                        <td>{{ $d->profile->nip }}</td>
                        <td>{{ $d->profile->unitKerja->nama }}</td>
                        <td>{{ $d->profile->rolename }}</td>
                        <td>{{ $d->status == 1 ? 'Opened' : 'Locked' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{-- <input class="btn btn-sm btn-info" type="submit" name="submit" value="Open" style="width: 80px">
            <input class="btn btn-sm btn-danger" type="submit" name="submit" value="Lock" style="width: 80px"> --}}
            <button type="submit" class="btn btn-sm btn-info" name="submit" value="Open" style="width: 80px"><i class="fa fa-key"></i> Open</button>
            <button type="submit" class="btn btn-sm btn-danger" name="submit" value="Lock" style="width: 80px"><i class="fa fa-lock"></i> Lock</button>
        </div>
    </form>
</div>
@endsection
