@extends('admin.layouts.app')
@section('panel')

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Team Members</h3>
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary">+ Add Member</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>S/N</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr>
                    <td>{{ $member->serial }}</td> <!-- Serial number -->
                    <td>
                        @if($member->photo)
                            <img src="{{ asset('public/storage/' . $member->photo) }}" width="60" height="60" class="rounded-circle" />
                        @endif
                    </td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->designation }}</td>
                    <td>
                        <a href="{{ route('admin.team.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No team members found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
