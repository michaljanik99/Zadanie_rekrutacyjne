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
            <input type="text" name="status" id="status" value="{{ old('status') }}">
        </div>
        <button type="submit">Add Pet</button>
    </form>
@endsection
