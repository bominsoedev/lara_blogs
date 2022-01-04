@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Create Post
                    </div>
                    <div class="card-body">
                        @if(session('status'))

                            <p class="alert alert-success">{{ session('status') }}</p>
                        @endif
                        <form action="{{ route('post.store') }}" class="mb-3" method="post" enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label>Post Title</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label>Post Title</label>
                                <select type="text" name="category"  class="form-select @error('category') is-invalid @enderror">
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category') ==  $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Photo</label>
                                <input type="file" name="photo[]" value="{{ old('photo') }}" class="form-control @error('photo') is-invalid @enderror" multiple>
                                @error('photo')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                                @error('photo.*')
                                <p class="text-danger small mt-2">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label>Description</label>
                                <textarea type="text" name="description" rows="10" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
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
                                <button class="btn btn-primary">Add Post</button>
                            </div>

                        </form>


                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif






                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


