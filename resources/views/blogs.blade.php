@extends('layouts.app')

@section('title', 'Blogs')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Blogs</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3 align-items-center">
                <div class="col-md-4">
                    <label for="authorFilter" class="form-label fw-semibold">Filter by Author:</label>
                    <select id="authorFilter" class="form-select form-select-sm">
                        <option value="">All Authors</option>
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="blogsTable" style="min-width: 600px;">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Title</th>
                        <th style="width: 50%;">Content</th>
                        <th style="width: 20%;">Author</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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
                    d.user = $('#authorFilter').val();
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
            order: [[0, 'desc']]
        });

        // Add placeholder to the global search input
        $('.dataTables_filter input[type="search"]').attr('placeholder', 'Blog title or content...');

        // Reload table on author filter change
        $('#authorFilter').on('change', function() {
            table.ajax.reload();
        });
    });
</script>
@endpush
