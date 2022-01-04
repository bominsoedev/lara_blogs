@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Edit Category
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.update',$category->id) }}" class="mb-3" method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-4">
                                    <div class="">
                                        <input type="text" name="title" value="{{ old('title',$category->title) }}" class="form-control @error('title') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            @error('title')
                            <p class="text-danger small mt-2">{{ $message }}</p>
                            @enderror

                        </form>

                        @if(session('status'))
                            <p class="alert alert-success">{{ session('status') }}</p>
                        @endif


                        @include('category.list')

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
