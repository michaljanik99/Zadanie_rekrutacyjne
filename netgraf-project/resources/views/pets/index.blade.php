@extends('layout')

@section('content')
    <h1>Pets</h1>
    <form action="{{ route('pets.index') }}" method="GET">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status">
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <a href="{{ route('pets.create') }}">Add New Pet</a>
    <ul>
        @foreach ($pets as $pet)
            <li>
                {{ $pet['name'] }}
                <a href="{{ route('pets.edit', $pet['id']) }}">Edit</a>
                <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
