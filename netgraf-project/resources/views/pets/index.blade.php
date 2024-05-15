@extends('layout')

@section('content')
    <h1>Pets</h1>
    <form action="{{ route('pets.index') }}" method="GET">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status">
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ $status == request('status') ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </form>
    <a href="{{ route('pets.create') }}">Add New Pet</a>
    <ul>
        @foreach ($pets as $pet)
            @if (!isset($pet['name']))
                @continue
            @endif

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
