@extends('admin.layouts.app')
@section('panel')

<div class="container mt-4">
    <h3>Edit Member</h3>

    <form action="{{ route('admin.team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $team->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Designation</label>
            <input type="text" name="designation" value="{{ $team->designation }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bio</label>
            <textarea name="bio" class="form-control">{{ $team->bio }}</textarea>
        </div>

        <div class="mb-3">
            <label>Photo</label><br>
            @if($team->photo)
                <img src="{{ asset('storage/' . $team->photo) }}" width="80" height="80" class="mb-2 rounded">
            @endif
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
