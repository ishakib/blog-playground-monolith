@extends('layouts.app')

@section('title', 'Blogs List')

@section('content')
<div class="container">
    <h2 class="mb-4">Blogs List</h2>

    <!-- Author filter dropdown outside the table -->
    <div class="mb-3">
        <label for="authorFilter" class="form-label">Filter by Author:</label>
        <select id="authorFilter" class="form-control form-control-sm" style="width: 200px;">
            <option value="">All Authors</option>
            @foreach($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>

    </div>

    <table class="table table-bordered" id="blogsTable">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
        </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#blogsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('blogs.data') }}",
                data: function(d) {
                    // Send author filter value from external dropdown
                    d.user = $('#authorFilter').val();
                    console.log('Sending user filter:', d.user);
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'content', name: 'content' },
                { data: 'author', name: 'author' }
            ],
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: "Search:"
            },
        });

        $('.dataTables_filter input[type="search"]').attr('placeholder', 'Blog title or content...');

        $('#authorFilter').on('change', function() {
            table.ajax.reload(); // reload data with new user param
        });
    });
</script>
@endpush
