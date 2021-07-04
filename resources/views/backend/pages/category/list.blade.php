@extends('backend.master');
@section('content')
    <div class="heading">
        <h3>List Category</h3>
    </div>
    <div class="btn-add">
        <button class="btn btn-primary add_data">Add</button>
    </div>
    <div class="main">
        <table class="table-cate">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th colspan="2">Function</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cate)
                <tr id ="cate{{$cate->id}}">
                    <td>{{ $cate->id }}</td>
                    <td>{{ $cate->category_name }}</td>
                    <td><a href="" class="edit" id = "{{ $cate->id }}">Edit</a></td>
                    <?php
                    // dd($checkProduct->all());
                        if (in_array($cate->id,$checkProduct->all())) {} else { 
                    ?>
                    <td><a href="" class="delete" id = "{{ $cate->id }}">Delete</a></td>
                    <?php } ?>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <?php
        $previous = $categories->currentPage() - 1;
        $next     = $categories->currentPage() + 1;
    ?>
    <div class="pagination">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item <?php if ($categories->currentPage() <= 1){ echo 'previos_disble'; } else{ echo 'previos_enable'; }  ?>"><a class="page-link" href="{{ route('category.list', ['page' => $previous]) }}">Previous</a></li>
            @for ($i = 1; $i <= $categories->lastPage(); $i++)
                <li class="page-item"><a class="page-link <?php if ($categories->currentPage() === $i) {echo "selected"; } ?>" href="{{ route('category.list', ['page' => $i]) }}">{{ $i }}</a></li>
            @endfor
              <li class="page-item <?php if ($categories->currentPage() >= $categories->lastPage()) { echo 'next_disable'; } else { echo "next_enable"; } ?>"><a class="page-link" href="{{ route('category.list', ['page' => $next]) }}">Next</a></li>
            </ul>
        </nav>
    </div>
    <div id="categoryModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="category_form">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                       <h4 class="modal-title">Add Category</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label class="lab-category-name">Category Name</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="category_id" id="category_id" value="" />
                        <input type="hidden" name="button_action" id="button_action" value="insert" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.add_data').click(function(){
            $('#categoryModal').modal('show');
            $('#category_form')[0].reset();
            $('#form_output').html('');
            $('#button_action').val('insert');
            $('#action').val('Add');
            $('modal-title').text('Add Category');
        });
 
        $('#category_form').on('submit', function(e){
            var html = '';
            e.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "{{ route('ajax.process') }}",
                method: "POST",
                data: form_data,
                dataType: "json",
                success: function(data)
                {
                    if (data.error.length > 0) {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++) {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }else {
                        $('#form_output').html(data.success);
                        $('#category_form')[0].reset();
                        $('#action').val('Add');
                        $('.modal-title').text('Add Data');
                        $('#button_action').val('insert');
                        if (data.dataMode == 'insert') {
                            var url = window.location.href.split('?')[0];
                            window.location.href = url
                            // $('.table-cate tbody').prepend('<tr><td>' + data.data.id + '</td><td>' + data.data.category_name + '</td><td><a class ="edit"> Edit </a></td>'+ '<td><a class ="delete"> Delete </a></td>' +'</tr>');
                        }else if (data.dataMode == 'update') {
                            // console.log(data.data.id);
                            $('#cate' + data.data.id + ' td:nth-child(2)').text(data.data.category_name);
                        }
                    }
                }
            });
        });

        $('.edit').click(function(e){
            e.preventDefault();
            var id = $(this).attr("id");
            $('#form_output').html('');
            $.ajax({
                url: "{{ route('ajax.getdata') }}",
                method: 'get',
                data: {id:id},
                dataType: 'json',
                success:function(data)
                {
                    $('#category_name').val(data.category_name);
                    $('#category_id').val(id);
                    $('#categoryModal').modal('show');
                    $('#action').val('Edit');
                    $('.modal-title').text('Edit Data');
                    $('#button_action').val('update');
                }
            })
        });

        $('.delete').click(function(e){
            e.preventDefault();
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to Delete this data?")) {
                $.ajax({
                    url:"{{route('ajax.delete')}}",
                    mehtod:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        $('#cate' + id).remove();
                    }
                })
            }else {
                return false;
            }
        });
    });
</script>
<style>
    .next_disable , .previos_disble {
        pointer-events: none;
    }
    .next_enable , .previos_enable {
        pointer-events: unset;
    }
</style>
@endsection
