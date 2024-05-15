@extends('layout')

@section('content')
    <h1>Add New Pet</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>
        <button type="submit">Add Pet</button>
    </form>
@endsection
