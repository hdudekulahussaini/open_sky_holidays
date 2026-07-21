@extends('admin.layouts.app')

@section('title', 'Edit Why Choose Section')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Edit Why Choose Section</h4>
            </div>

            <div class="card-body">
                <form
                    action="{{ route(
                        'admin.why-choose-sections.update',
                        $whyChooseSection
                    ) }}"
                    method="POST"
                >
                    @method('PUT')

                    @include(
                        'pages.why-choose-sections.form',
                        [
                            'buttonText' => 'Update Section',
                            'whyChooseSection' => $whyChooseSection
                        ]
                    )
                </form>
            </div>
        </div>
    </div>
@endsection