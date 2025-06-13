@extends('layouts.admin')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        font-family: 'Inter', sans-serif;
    }

    .upload-wrapper {
        max-width: 600px;
        margin: 60px auto;
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 0 30px rgba(0, 255, 255, 0.15);
        color: #e0f7fa;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .upload-wrapper h2 {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .upload-wrapper p.description {
        text-align: center;
        font-size: 14px;
        color: #b2ebf2;
        margin-bottom: 25px;
    }

    .info-box {
        background: rgba(0, 255, 255, 0.05);
        border-left: 4px solid #00e6e6;
        padding: 15px;
        font-size: 14px;
        margin-bottom: 30px;
        border-radius: 10px;
        color: #ccfaff;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .form-group input[type="file"] {
        width: 100%;
        padding: 14px;
        background: rgba(255, 255, 255, 0.06);
        border: none;
        border-radius: 10px;
        color: #00fff2;
        font-size: 14px;
        cursor: pointer;
        box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.2);
    }

    .btn-upload {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #00ffe7, #00b0ff);
        color: #000;
        font-weight: bold;
        font-size: 16px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
        transition: all 0.3s ease;
    }

    .btn-upload:hover {
        transform: scale(1.03);
        box-shadow: 0 0 25px rgba(0, 255, 255, 0.6);
    }

    .alert {
        padding: 12px 16px;
        font-size: 14px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(0, 255, 150, 0.1);
        color: #00ff95;
        border-left: 4px solid #00ff95;
    }

    .alert-danger {
        background: rgba(255, 50, 50, 0.1);
        color: #ff6b6b;
        border-left: 4px solid #ff6b6b;
    }

    .file-name {
        margin-top: 8px;
        font-size: 13px;
        color: #90eeff;
    }

    .sample-preview-trigger {
        margin-top: 20px;
        text-align: center;
        font-weight: 500;
        color: #00ffe7;
        text-decoration: underline;
        cursor: pointer;
    }

    .sample-table {
        margin-top: 20px;
        display: none;
        overflow-x: auto;
    }

    table.csv-preview {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-top: 10px;
        color: #e0f7fa;
    }

    table.csv-preview th,
    table.csv-preview td {
        border: 1px solid #00ffff33;
        padding: 10px;
        text-align: left;
    }

    table.csv-preview th {
        background-color: rgba(0, 255, 255, 0.1);
        color: #00fff2;
    }

    table.csv-preview td {
        background-color: rgba(255, 255, 255, 0.03);
    }
</style>

<div class="upload-wrapper">
    <h2>Upload Product List</h2>
    <p class="description">Easily import multiple products using a single file</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="info-box">
        <strong>How it works:</strong><br>
        Upload a product list in CSV format (Excel-compatible). You can add many products at once — including name, price, description, and more.<br><br>
        <strong>Required Columns:</strong> Title, Author, Price, Description<br><br>

        <span class="sample-preview-trigger" onclick="toggleSampleTable()">Need Example ?</span>
    </div>

    <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">Choose Your Product List File (.csv)</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
            <div class="file-name" id="file-name-display"></div>
        </div>
        <button type="submit" class="btn-upload">Upload & Import</button>
    </form>

    <div class="sample-table" id="sample-table">
       <table class="csv-preview">
    <thead>
        <tr>
            <th>title</th>
            <th>name</th>
            <th>author</th>
            <th>price</th>
            <th>category_id</th>
            <th>description</th>
            <th>category</th>
            <th>image</th>
            <th>stock</th>
            <th>best_seller</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>The Great Book</td>
            <td>Great Book</td>
            <td>John Doe</td>
            <td>19.99</td>
            <td>1</td>
            <td>A fascinating book</td>
            <td>Fiction</td>
            <td>cover1.jpg</td>
            <td>100</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Another Story</td>
            <td>Story Book</td>
            <td>Jane Smith</td>
            <td>29.99</td>
            <td>2</td>
            <td>A thrilling novel</td>
            <td>Non-fiction</td>
            <td>cover2.jpg</td>
            <td>50</td>
            <td>0</td>
        </tr>
        <tr>
            <td>Mystery Tales</td>
            <td>The Mystery</td>
            <td>Robert Black</td>
            <td>9.99</td>
            <td>1</td>
            <td>An intriguing mystery</td>
            <td>Fiction</td>
            <td>cover3.jpg</td>
            <td>200</td>
            <td>1</td>
        </tr>
    </tbody>
</table>

    </div>
</div>

<script>
    document.getElementById('csv_file').addEventListener('change', function (e) {
        const fileName = e.target.files[0]?.name || 'No file selected';
        document.getElementById('file-name-display').innerText = "📂 " + fileName;
    });

    function toggleSampleTable() {
        const table = document.getElementById('sample-table');
        table.style.display = table.style.display === 'none' || table.style.display === '' ? 'block' : 'none';
    }
</script>
@endsection
