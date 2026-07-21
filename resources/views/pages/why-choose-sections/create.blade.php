@extends('admin.layouts.app')

@section('title', 'Create Why Choose Section')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Create Why Choose Section</h4>
            </div>

            <div class="card-body">
                <form
                    action="{{ route('admin.why-choose-sections.store') }}"
                    method="POST"
                >
                    @include(
                        'pages.why-choose-sections.form',
                        ['buttonText' => 'Create Section']
                    )
                </form>
            </div>
        </div>
    </div>
@endsection