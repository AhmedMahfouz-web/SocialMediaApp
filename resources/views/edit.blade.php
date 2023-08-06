<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Boost</title>
</head>
<body>
    <form method="post" action="{{ route('boosts.update', $boost->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ $boost->name }}" required>
        </div>

        <div>
            <label for="desc">Desc:</label>
            <input type="text" name="desc" value="{{ $boost->desc }}" required>
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="text" name="price" value="{{ $boost->price }}" required>
        </div>

        <div>
            <label for="discount">Discount:</label>
            <input type="text" name="discount" value="{{ $boost->discount }}" required>
        </div>

        <button type="submit">Update</button>
    </form>
</body>
</html>
