@extends('layouts.admin')
@section('content')
   <table class="table align-items-center table-flush">
      <thead class="thead-light">
         <tr>
         <th scope="col">Name</th>
         </tr>
      </thead>
      <tbody class="list">
         @foreach ($categories as $cat)
            <tr>
            <td>{{ $cat->title }}</td>
            </tr>
         @endforeach
      </tbody>
   </table>
@endsection