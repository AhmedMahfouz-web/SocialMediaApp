<div id="container">
    <div class="form-wrap">
      <form method="POST" action="{{ route('boosts.update', $boost->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" value="{{ $boost->name }}" required>
        </div>
        <div class="form-group">
          <label for="desc">Description</label>
          <input type="text" name="desc" value="{{ $boost->desc }}" required>
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="text" name="price" value="{{ $boost->price }}" required>
        </div>
        <div class="form-group">
          <label for="discount">Discount</label>
          <input type="text" name="discount" value="{{ $boost->discount }}" required>
        </div>

        <button type="submit" class="btn">Update</button>
      </form>
    </div>
</div>
