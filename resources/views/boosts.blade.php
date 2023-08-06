<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Boosts</title>
    <link rel="stylesheet" href="{{ asset('css/boosts.css') }}">
</head>
<body>
<div id="container">
    <div class="form-wrap">
      <form method="POST">
        @csrf
        <div class="form-group">
          <label for="Name">Name</label>
          <input type="text" name="name" required>
        </div>
        <div class="form-group">
          <label for="desc">Description</label>
          <input type="text" name="desc" required>
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="text" name="price" required>
        </div>
        <div class="form-group">
          <label for="disc">Discount</label>
          <input type="text" name="discount" required>
        </div>

        <button type="submit" class="btn">Send</button>

      </form>
    </div>
  </div>
</body>
