@extends('layout')

@section('content')
    <h1>Pets</h1>
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
