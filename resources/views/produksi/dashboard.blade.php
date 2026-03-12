@extends('layouts.app')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ auth()->user()->department_id ? auth()->user()->department->name : 'No Department'    }}  Dashboard
    </h2>
@endsection
