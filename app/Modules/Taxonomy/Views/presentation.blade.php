@extends('layouts.user')

@section('content')
<section class="taxonomy-list-wrapper">
    <div class="taxonomy-list-table">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div id="taxonomy-tree">
                        @include('partials.taxonomy')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
