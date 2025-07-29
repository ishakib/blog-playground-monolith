@extends('layouts.app')

@section('title', 'Blogs List')

@section('content')
<div class="container">
    <h2 class="mb-4">Blogs List</h2>
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
        $('#blogsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('blogs.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'content', name: 'content' },
                { data: 'author', name: 'author' }
            ],
            language: {
                search: "Search:"
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50]
        });
    });
</script>
@endpush
