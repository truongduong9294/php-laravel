@extends('backend.master');
@section('content')
    <div class="heading">
        <h3>List Product</h3>
    </div>
    <div class="btn-add">
        <a href="{{ route('product.export') }}" class="btn btn-primary export">Export Excel</a>
        <a href="{{ route('product.import') }}" class="btn btn-primary import">Import Excel</a>
        <a class="btn btn-primary add_data" href="{{ route('product.create') }}">Add</a>
    </div>
    <div class="search">
        <form class="form-inline" action="{{ route('product.list') }}" method="get">
            <div class="form-group mx-sm-3 mb-2">
              <input type="text" class="form-control input-search" name="search" id="search" placeholder="Enter Product Name">
            </div>
            <button type="submit" class="btn btn-primary mb-2 button-search">Search</button>
        </form>
    </div>
    @if(session()->has('success'))
        <div class="alert-message">
            <div class="alert alert-success message-success">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="main">
        <table class="table-cate">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Product Name</th>
                    <th>Image Name</th>
                    <th>Price</th>
                    <th colspan="2">Function</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td style="width: 10%;"><img style="width: 100%;" src="{{ asset('uploads/' . $product->image) }}" alt=""></td>
                    <td>{{ $product->price . '$' }}</td>
                    <td><a href="{{ route('product.edit', ['id' => $product->id, 'current' => $products->currentPage()]) }}" class="edit">Edit</a></td>
                    <td><a onclick="return confirm('Are you want to delete?')" href="{{ route('product.delete', ['id' => $product->id, 'current' => $products->currentPage()]) }}" class="delete">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <?php
        $previous = $products->currentPage() - 1;
        $next     = $products->currentPage() + 1;
    ?>
    <div class="pagination">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php if ($products->currentPage() <= 1){ echo 'previos_disble'; } else{ echo 'previos_enable'; }  ?>"><a class="page-link" href="{{ route('product.list', ['page' => $previous, 'search' => $search]) }}">Previous</a></li>
              @for ($i = 1; $i <= $products->lastPage(); $i++)
                  <li class="page-item"><a class="page-link <?php if ($products->currentPage() === $i) {echo "selected"; } ?>" href="{{ route('product.list', ['page' => $i, 'search' => $search]) }}">{{ $i }}</a></li>
              @endfor
                <li class="page-item <?php if ($products->currentPage() >= $products->lastPage()) { echo 'next_disable'; } else { echo "next_enable"; } ?>"><a class="page-link" href="{{ route('product.list', ['page' => $next, 'search' => $search]) }}">Next</a></li>
            </ul>
        </nav>
    </div>
@endsection