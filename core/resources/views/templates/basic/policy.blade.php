@php
    $policys = getContent('policy_pages.element');
@endphp
@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="pt-120 pb-120">
	<div class="container">
        @php
            echo $description
        @endphp    
	</div>
</section>
@endsection