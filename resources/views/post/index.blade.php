@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Post List
                    </div>
                    <div class="card-body">

                        @if(session('status'))

                            <p class="alert alert-success">{{ session('status') }}</p>

                        @endif




                            <div class="d-flex justify-content-between">
                                {{ $posts->appends(request()->all())->links() }}
                                <div class="">
                                    <form>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search Anything" name="search">
                                            <button class="btn btn-primary" id="button-addon2">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <table class="table  align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="w-25">Title</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Control</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>

                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ Str::words($post->title,15) }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $post->category->title }}
                                            </span>
                                        </td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('post.show',$post->id) }}">
                                                    <i class="fas fa-info fa-fw"></i>
                                                </a>
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('post.edit',$post->id) }}">
                                                    <i class="fas fa-pencil-alt fa-fw"></i>
                                                </a>
                                                <button form="deletePost{{$post->id}}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-trash-alt fa-fw"></i>
                                                </button>
                                            </div>
                                            <form action="{{ route('post.destroy',$post->id) }}" id="deletePost{{ $post->id }}" method="post" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                        <td>
                                            <p class="mb-0 small">
                                                <i class="fas fa-calendar fa-fw"></i>
                                                {{ $post->created_at->format('d / m / Y') }}
                                            </p>
                                            <p class="mb-0 small">
                                                <i class="fas fa-clock fa-fw"></i>
                                                {{ $post->created_at->format("h:i a") }}
                                            </p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There is no Post</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>





                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
