<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6">Edit User: {{ $user->name }}</h1>
        <form action="/admin/users/{{ $user->id }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $user->name }}" class="p-2 border rounded" required>
            <input type="email" name="email" value="{{ $user->email }}" class="p-2 border rounded" required>
            <select name="role" class="p-2 border rounded">
                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                <option value="lecturer" {{ $user->role == 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Update User</button>
        </form>
    </div>
</body>
</html>
