@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-btn {
            display: block;
            background: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .add-btn:hover {
            background: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
            text-align: left;
        }

        th, td {
            padding: 10px;
        }

        th {
            background: #007bff;
            color: white;
        }

        .action-buttons a, .action-buttons button {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background: #ffc107;
        }

        .edit-btn:hover {
            background: #e0a800;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .view-btn {
            background: #17a2b8;
        }

        .view-btn:hover {
            background: #138496;
        }

        img {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Books</h2>

    <a href="{{ route('admin.products.add') }}" class="add-btn">+ Add New Book</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price (₹)</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td><img src="{{ asset('storage/images/' . $book->image) }}" alt="{{ $book->title }}"></td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>₹{{ $book->price }}</td>
                <td>{{ $book->stock }}</td>
                <td class="action-buttons">
                    <a href="{{ route('admin.products.edit', $book->id) }}" class="edit-btn">Edit</a>
                    <a href="{{ route('products.details', $book->id) }}" class="view-btn">View</a>
                    <form action="{{ route('admin.products.delete', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
@endsection
