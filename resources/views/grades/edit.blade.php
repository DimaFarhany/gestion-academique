@extends('layouts.academic')

@section('content')

<h1 class="fw-bold mb-4">
    Modifier la note
</h1>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="{{ route('grades.update', $grade) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('grades._form', ['grade' => $grade])

            <button type="submit"
                    class="btn btn-primary">
                Mettre à jour
            </button>

        </form>

    </div>

</div>

@endsection