@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('message'))
<div class="todo__alert">
    <div class="todo__alert-success">{{ session('message') }}</div>
</div>
@endif
@if ($errors->any())
    <div class="todo__alert-error">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<div class="todo__content">
    <div class="create__form-ttl">
        <h2>新規作成</h2>
    </div>
    <form action="/todos" class="create__form" method='post'>
        @csrf
        <div class="create__form-item">
            <input type="text" class="create__form-item--input" name='content' value="{{ old('content') }}">
        </div>
        <!-- ここが問題点？ -->
        <div class="search__form-select">
            <select name="category_id" id="" class="search__form-item--select">
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <!-- ここまで？ -->
        <div class="create__form-button">
            <button class="create__form-button--submit" type='submit'>作成</button>
        </div>
    </form>
    <div class="search__form-ttl">
        <h2>Todo検索</h2>
    </div>
    <form action="/todos" class="search__form" method='post'>
        @csrf
        <div class="search__form-item">
            <input type="text" class="search__form-item--input" name='content'>
        </div>
        <div class="search__form-select">
            <select name="category_id" id="" class="search__form-item--select">
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="search__form-button">
            <button class="search__form-button--submit" type='submit'>検索</button>
        </div>
    </form>
    <div class="todo__table">
        <table class="todo__table-inner">
            <tr class="todo__table-row">
                <th class="todo__table-header">Todo</th>
            </tr>
            @foreach($todos as $todo)
            <tr class="todo__table-row">
                <td class="todo__table-item">
                    <form action="/todos/update" method="POST" class="todo__table-form--input">
                        @method('PATCH')
                        @csrf
                        <input class="todo__table-input" type="text" name="content" value="{{ $todo['content'] }}">
                        <input type="hidden" name="id" value="{{ $todo['id'] }}">
                        <p class="todo__table-category">{{ $todo['category']['name'] }}</p>
                        <button class="todo__table-button--update" type="submit">更新</button>
                    </form>
                </td>
                <td class="todo__table-item">
                    <form action="/todos/delete" method="post" class="todo__table-button">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="id" value="{{ $todo['id'] }}">
                        <button class="todo__table-button--delete" type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection