{{-- resources/views/admin/classes.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Class List</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="card-title">Available Classes</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($classes as $class)
                                    <li class="list-group-item">
                                        <a href="{{url('admin/attendance/classes/' . $class->id . '/attendance')}}">
                                            {{ $class->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer">
                            <!-- Optional footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
