@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="admin-product-container">
    <div class="admin-header">
        <h2>🛒 Manage Products</h2>
        <a href="{{ route('admin.products.add') }}" class="btn btn-glass add-btn">+ Add Product</a>
    </div>

    {{-- 🔍 Search Bar --}}
    {{-- <form method="GET" action="{{ route('admin.products.index') }}" class="search-form">
        <input type="text" name="search" placeholder="🔍 Search by name, author, or title..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-glass">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-glass">✖ Clear</a>
        @endif
    </form> --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="search-form">
        <input type="text" name="search" placeholder="🔍 Search..." value="{{ request('search') }}">

        <select name="sort" class="sort-dropdown">
            <option value="">Sort by</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
        </select>

        <button type="submit" class="btn btn-glass">Apply</button>

        @if(request('search') || request('sort'))
            <a href="{{ route('admin.products.index') }}" class="btn btn-glass">✖ Clear</a>
        @endif
    </form>


    {{-- ⚡ Bulk Delete Form --}}
    <form action="{{ route('admin.products.bulkDelete') }}" method="POST" id="bulkDeleteForm">
        @csrf
        @method('DELETE')

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="glass-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>₹ Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $product->id }}"></td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ optional($product->category)->name ?? 'General' }}</td>
                    <td>
                        @if($product->image && file_exists(public_path('images/' . $product->image)))
                            <img src="{{ asset('images/' . $product->image) }}" alt="Product" class="product-img">
                        @else
                            <span class="no-img">No Image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-glass btn-edit">Edit</a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="inline-form">
                            @csrf
                            <button type="submit" class="btn btn-glass btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button type="submit" class="btn btn-glass btn-danger mt-3">🗑️ Delete Selected</button>
    </form>
</div>

{{-- ✅ Select All Checkbox Logic --}}
<script>
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>

{{-- 🌈 NeonGlassPage Styling --}}
<style>

  .pagination {
  list-style: none; /* 🔥 this removes the black bullets */
  padding: 0;
  margin-top: 25px;
  display: flex;
  justify-content: center;
  gap: 10px;
}

.pagination li {
  list-style: none; /* also ensures no bullets on li */
}

  .pagination .page-link {
    padding: 8px 12px;
    background: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
  }

  .pagination .active .page-link {
    background: #28a745;
  }

  .pagination .disabled .page-link {
    background: #ccc;
    cursor: not-allowed;
  }
    body {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        background-attachment: fixed;
        color: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-product-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        backdrop-filter: blur(15px);
        box-shadow: 0 0 30px rgba(0, 255, 204, 0.1);
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 15px;
    }

    .admin-header h2 {
        font-size: 28px;
        background: linear-gradient(to right, #00ffd5, #00bfff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-glass {
        background: rgba(0, 255, 204, 0.1);
        color: #00ffd5;
        border: 1px solid #00ffd5;
        padding: 8px 14px;
        font-weight: bold;
        border-radius: 12px;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-glass:hover {
        background: rgba(0, 255, 204, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 0 10px #00ffd5;
    }

    .btn-edit {
        color: #28ff99;
        border-color: #28ff99;
    }

    .btn-delete {
        color: #ff4d6d;
        border-color: #ff4d6d;
    }

    .btn-danger {
        background: rgba(255, 77, 109, 0.1);
        color: #ff4d6d;
        border: 1px solid #ff4d6d;
    }

    .btn-edit:hover {
        box-shadow: 0 0 10px #28ff99;
    }

    .btn-delete:hover,
    .btn-danger:hover {
        box-shadow: 0 0 10px #ff4d6d;
    }

    .inline-form {
        display: inline;
    }

    .add-btn {
        float: right;
    }

    .glass-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .glass-table th, .glass-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .glass-table th {
        background: rgba(0, 255, 204, 0.1);
        color: #00ffd5;
    }

    .glass-table td {
        background: rgba(255, 255, 255, 0.02);
    }

    .product-img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 0 5px rgba(0, 255, 204, 0.5);
    }

    .no-img {
        color: #999;
        font-size: 0.85em;
    }
    .sort-dropdown {
    padding: 8px 14px;
    border-radius: 12px;
    border: 1px solid #00ffd5;
    background: rgba(0, 255, 204, 0.05);
    color: #00ffd5;
    outline: none;
}

    .alert {
        padding: 12px;
        border-radius: 8px;
        margin: 15px 0;
        font-size: 0.95em;
    }

    .alert-success {
        background: rgba(40, 255, 153, 0.1);
        color: #28ff99;
        border: 1px solid #28ff99;
    }

    .alert-danger {
        background: rgba(255, 77, 109, 0.1);
        color: #ff4d6d;
        border: 1px solid #ff4d6d;
    }

    .search-form {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 20px 0;
        flex-wrap: wrap;
    }

    .search-form input {
        padding: 8px 14px;
        border-radius: 12px;
        border: 1px solid #00ffd5;
        background: rgba(0, 255, 204, 0.05);
        color: #00ffd5;
        outline: none;
        width: 250px;
    }

    .search-form input::placeholder {
        color: #77ffe3;
        font-size: 0.95em;
    }

    @media screen and (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .add-btn {
            width: 100%;
        }

        .search-form {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-form input {
            width: 100%;
        }
        input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #00ffd5; /* Optional: match neon theme */
    cursor: pointer;
    transform: scale(1.1);
}
input[type="checkbox"] {
    box-shadow: 0 0 5px #00ffd5, 0 0 10px #00ffd5;
    border-radius: 4px;
}
input[type="checkbox"]:hover {
    box-shadow: 0 0 10px #00fff2, 0 0 15px #00fff2;
}


        .glass-table th, .glass-table td {
            font-size: 0.9em;
            padding: 10px 6px;
        }
    }
</style>

<div class="pagination">
    {!! $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') !!}
  </div>

@endsection
