@extends('layouts.app')

@section('content')
<div class="container" id="books_listing">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books</h1></div>
        <div class="col-md-6"><a href="{{ route('books.create') }}" class="btn btn-success float-right">Add Book</a></div>
    </div>
<table class="table table-striped table-bordered" 
        id="books_table"
        data-books="{{ json_encode($books) }}" 
        data-index-route = "{{ route('books.index') }}">
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Categories</th>
            <th>Cover Page</th>
        </tr>
        <tr v-for="(book, index) in books" >
            <td> 
                <a :href = "'/knowledgecafe/library/books/' + book.id"> 
                    @{{ book.title }}
                </a>
            </td>
             <td> 
                @{{ book.author }} 
            </td>

            <td>
                <div v-show="!book.showCategory">
                    @{{ book.categories }}
                </div>
                <div v-show="book.showCategory">
                    <select name="categories" v-model="book.categories" v-on:change="updateCategory(index, book.id)">
                        <option value="">Select Category</option>
                        @foreach(config('constants.books.categories') ?:[] as $category) 
                            <option value="{{ $category }}"> {{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                @can('library_books.update')
                <button v-show="!book.showCategory" class="btn change-category-btn" @click="updateCategoryMode(index, 'edit')">Change</button>
                <button v-show="book.showCategory" class="btn change-category-btn" @click="updateCategoryMode(index, 'show')">Save</button>
                @endcan
            </td>
            
            <td> 
                <div class="w-25 h-75">
                    <img class="w-100" :src="book.thumbnail" alt="No Image"> 
                </div>
            </td> 
        </tr>

    </table>
</div>
@endsection