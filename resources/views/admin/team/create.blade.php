@extends('admin.layouts.app')
@section('panel')

<div class="container mt-4">
    <h3>Add New Member</h3>

    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Designation</label>
            <input type="text" name="designation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bio</label>
            <textarea name="bio" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
