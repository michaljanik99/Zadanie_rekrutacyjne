@extends('layout')

@section('content')
    <h1>Edit Pet</h1>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $pet['name']) }}">
        </div>
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ $status == $pet['status'] ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Update Pet</button>
    </form>
@endsection
