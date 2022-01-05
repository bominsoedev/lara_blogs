@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Edit Post
                    </div>
                    <div class="card-body">

{{--                        {{ $post }}--}}

                        @if(session('status'))

                            <p class="alert alert-success">{{ session('status') }}</p>
                        @endif
                        <form action="{{ route('post.update',$post->id) }}" class="mb-3" method="post">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label>Post Title</label>
                                <input type="text" name="title" value="{{ old('title',$post->title) }}" class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label>Post Title</label>
                                <select type="text" name="category"  class="form-select @error('category') is-invalid @enderror">
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category',$post->category_id) ==  $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label>Description</label>
                                <textarea type="text" name="description" rows="10" class="form-control @error('description') is-invalid @enderror">{{ old('description',$post->description) }}</textarea>
                                @error('description')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="isConfirm">
                                    <label class="form-check-label" for="isConfirm">
                                        Confirm
                                    </label>
                                </div>
                                <button class="btn btn-primary">Update Post</button>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Manage Photo</div>
                    <div class="card-body">
                        <form action="{{ route('photo.store') }}" method="post" enctype="multipart/form-data" id="uploaderForm" class="d-none">
                            @csrf
                            <input type="hidden" value="{{ $post->id }}" name="post_id">
                            <input type="file" name="photo[]" accept="image/jpeg,image/png" class="form-control" id="uploaderInput" multiple>
                            <button class="btn btn-primary">Upload</button>
                        </form>


                        <div class="mb-3 d-flex">
                            <div class="d-inline-flex justify-content-center align-items-center border border-dark border-3 px-3 rounded" id="uploaderUi">
                                <i class="fas fa-plus-circle fa-2x"></i>
                            </div>
                            @forelse($post->photo as $photo)
                                <div class="d-inline-block position-relative" style="width: 100px;height: 100px">
                                    <img src="{{ asset('storage/thumbnail/'.$photo->name) }}" class="position-absolute" height="100" alt="">
                                    <form action="{{ route('photo.destroy',$photo->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm position-absolute" style="bottom: 5px;right: 5px">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        let uploaderUi = document.getElementById('uploaderUi');
        let uploaderInput = document.getElementById('uploaderInput');
        let uploaderForm = document.getElementById('uploaderForm');

        uploaderUi.addEventListener('click',function (){
            uploaderInput.click();
        })

        uploaderInput.addEventListener('change',function (){
            uploaderForm.submit();
        })

    </script>

@endsection


