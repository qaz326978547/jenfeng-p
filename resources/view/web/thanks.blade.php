@extends('web.includes.layout',[
    'page_title' => '',
    'main_id' => 'thanks',
    'seo' => true,
    'seo_title' => '',
    'seo_description' => '',
    'seo_keyword' => '',
    'seo_image'=> '',
    'seo_type' => 'website',
])

@push('head')
@endpush

@push('script')

@endpush

@section('main')

<article class="position-relative">
    <section class="position-relative">
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center text-center fs-30 my-8">
                <i class="far fa-check-circle fs-80 mb-4 text-primary"></i>
                <div >我們已收到您的報名資訊<br>感謝您的報名</div>
            </div>
        </div>
    </section>
</article>


@endsection



