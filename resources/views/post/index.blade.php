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
                                <th>photo</th>
                                <th>Category</th>
                                @if(Auth::user()->role == 0)
                                <th>Owner</th>
                                @endif
                                <th>Control</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>

                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            @forelse($post->photos()->latest('id')->limit(3)->get() as $photo)
                                                <a class="my-link" data-gall="gall{{ $post->id }}" href="{{ asset('storage/photo/'.$photo->name) }}">
                                                    <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" height="40" alt="image alt"/>
                                                </a>

                                            @empty
                                               <p class="text-muted small">No Photo</p>
                                            @endforelse
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $post->category->title }}
                                            </span>
                                        </td>
                                        @if(Auth::user()->role == 0)
                                        <td>{{ $post->user->name }}</td>
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('post.show',$post->id) }}">
                                                    <i class="fas fa-info fa-fw"></i>
                                                </a>
                                                @can('view',$post)
                                                <a class="btn btn-sm btn-outline-primary" href="{{ route('post.edit',$post->id) }}">
                                                    <i class="fas fa-pencil-alt fa-fw"></i>
                                                </a>
                                                @endcan
                                                @can('delete',$post)
                                                <button form="deletePost{{$post->id}}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-trash-alt fa-fw"></i>
                                                </button>
                                                @endcan
                                            </div>
                                            @can('delete',$post)
                                            <form action="{{ route('post.destroy',$post->id) }}" id="deletePost{{ $post->id }}" method="post" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            @endcan
                                        </td>
                                        <td>
                                            {!! $post->show_created_at !!}
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
