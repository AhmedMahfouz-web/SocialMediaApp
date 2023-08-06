@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($boosts as $boost)
        <tr>
            <td>{{ $boost->name }}</td>
            <td>{{ $boost->desc }}</td>
            <td>{{ $boost->price }}</td>
            <td>{{ $boost->discount }}</td>
            <td>
                <a href="{{ route('boosts.edit', $boost->id) }}" class="btn btn-primary">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

