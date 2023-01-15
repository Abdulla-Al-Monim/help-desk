@extends("layouts.master")



@section('styles')

        <!-- INTERNAL owl-carousel css-->
        <link href="{{asset('assets/plugins/owl-carousel/owl-carousel.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />


@endsection

@section('content')

<!--Banner Section-->
<section>
    <div class="banner-1 cover-image sptb-tab bg-background-support" data-bs-image-src="{{asset('assets/images/photos/banner2.jpg')}}">
        <div class="header-text content-text mb-0">
            <div class="container">
                <div class="text-center text-white mb-7 mt-9">
                    <h1 class="mb-2">Looking For help?</h1>
                    <p class="fs-18">Type your query or submit your ticket</p>
                </div>
                <div class="row">
                    <div class="col-xl-7 col-lg-12 col-md-12 d-block mx-auto">
                        <div class="search-background p-0">
                            <input type="text" class="form-control input-lg" name="search_name" id="search_name"  placeholder="Ask your Questions.....">
                            <button class="btn"><i class="fe fe-search"></i></button>

                            <div id="searchList">
                                
                            </div>
                        </div>
                        @csrf

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Banner Section-->

<!--Feature Box Section-->
<section>
    <div class="cover-image sptb">
        <div class="container">
            <div class="section-title center-block text-center">
                <h2 class="wow fs-30" data-wow-delay="0.1s">Why Choose US?</h2>
                <p class="wow fs-18" data-wow-delay="0.15s">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
            <div class="row row-deck featureboxcenter">
                

                    <div class="col-lg-4 col-md-4">
                        <div class="support-card card text-center wow" data-wow-delay="0.2s">
                            <div class="suuport-body">
                                <div class="choose-icon">
                                   
                                    <img src="{{asset('uploads/featurebox/noimage/noimage.svg')}}" alt="img" class="noimage">
                                   

                                </div>
                                <div class="servic-data mt-3">
                                    <h4 class="font-weight-semibold mb-2">Secure Payment</h4>
                                    <p class="text-muted mb-0">Nam libero tempore, cum soluta nobis est eligendi cumque facere possimus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="support-card card text-center wow" data-wow-delay="0.2s">
                            <div class="suuport-body">
                                <div class="choose-icon">
                                    
                                    <img src="{{asset('uploads/featurebox/noimage/noimage.svg')}}" alt="img" class="noimage">
                                    

                                </div>
                                <div class="servic-data mt-3">
                                    <h4 class="font-weight-semibold mb-2">Quality Templates</h4>
                                    <p class="text-muted mb-0">Nam libero tempore, cum soluta nobis est eligendi cumque facere possimus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="support-card card text-center wow" data-wow-delay="0.2s">
                            <div class="suuport-body">
                                <div class="choose-icon">
                                    
                                    <img src="{{asset('uploads/featurebox/noimage/noimage.svg')}}" alt="img" class="noimage">
                                    

                                </div>
                                <div class="servic-data mt-3">
                                    <h4 class="font-weight-semibold mb-2">24/7 Support</h4>
                                    <p class="text-muted mb-0">Nam libero tempore, cum soluta nobis est eligendi cumque facere possimus</p>
                                </div>
                            </div>
                        </div>
                    </div>
                

            </div>
        </div>
    </div>
</section>
<!--Feature Box Section-->

<!--Call Action Section-->
<section>
    <div class="banner-2 cover-image" data-bs-image-src="{{asset('assets/images/pattern/pattern2.png')}}">
        <div class="header-text content-text mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 sptb">
                        <div class="text-white wow">
                            <h2 class="mb-2 fs-30 font-weight-semibold">Need Support & Response within 24 hours?</h2>
                            <p class="fs-18 text-white-50">Excepteur sint occaecat cupidatat non proident mollit anim id est laborum</p>
                            <a href="" class="btn btn-secondary btn-lg" target="_blank">Open Ticket</a>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center justify-content-center">
                            

                            <img src="{{asset('uploads/callaction/noimage/noimage.png')}}" alt="img" class="header-text3 img-fluid">
                           

                    </div>
                </div>
            </div>
        </div><!-- /header-text -->
    </div>
</section>
<!--Call Action Section-->
<!--Article Section-->
<section>
    <div class="cover-image sptb">
        <div class="container">
            <div class="section-title center-block text-center">
                <h2 class="wow fs-30" data-wow-delay="0.1s">Check Out Recent Articles</h2>
                <p class="wow fs-18" data-wow-delay="0.15s">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
            <div class="row row-deck">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header border-bottom-0">
                            <h4 class="fs-25 card-title">Recent Articles</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-article mb-0">
                                
                                
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Recusandae quia qui magnam rerum.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Iusto occaecati voluptatibus et minima aut minus distinctio.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Quos error occaecati asperiores aut accusamus impedit aut.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Et maiores alias aliquam.</span></a>
                                </li>

                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Aut ipsa quidem provident sit.</span></a>
                                </li>
                                

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header border-bottom-0">
                            <h4 class="fs-25 card-title">Popular Articles</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-article mb-0">
                               

                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Aut ipsa quidem provident sit.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Aut ipsa quidem provident sit.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Aut ipsa quidem provident sit.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Aut ipsa quidem provident sit.</span></a>
                                </li>
                                <li>
                                    <a class="" href=""><i class="typcn typcn-document-text"></i><span class="categ-text">Aut ipsa quidem provident sit.</span></a>
                                </li>
                                

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Testimonial Section-->
<section>
    <div class="cover-image sptb bg-white">
        <div class="container">
            <div class="section-title center-block text-center">
                <h2 class="wow fs-30" data-wow-delay="0.1s">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h2>
                <p class="wow fs-18" data-wow-delay="0.15s">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div id="myCarousel1" class="owl-carousel testimonial-owl-carousel">

                            <div class="item text-center">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-8 col-md-12 d-block mx-auto">
                                            <div class="testimonia">
                                                <div class="testimonia-img mx-auto mb-3">
                                                    
                                                    <img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-xxl brround text-center mx-auto" alt="default">
                                                   

                                                </div>
                                                <p>
                                                    <i class="fa fa-quote-left"></i>  Recusandae non qui et et id cum quo. Autem repellendus quibusdam sequi sit neque. Iusto excepturi beatae dolores ea quibusdam quaerat alias dolor. Ad minus architecto quo perferendis deserunt. Eveniet et inventore asperiores est laboriosam dolorem. Dolorem est autem vel illum rem. Quos voluptas molestiae fuga ipsum ratione omnis in. Non excepturi error quis commodi quia rerum quia. Sapiente fugit sit voluptate et dolorem iste incidunt. Et perferendis atque commodi dolor excepturi qui eveniet. Voluptate sed dolorum veniam est perspiciatis placeat eum.
                                                                            
                                                </p>
                                                <div class="testimonia-data">
                                                    <h4 class="fs-20 mb-1">Vita Mraz</h4>
                                                    <p>Designer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item text-center">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-8 col-md-12 d-block mx-auto">
                                            <div class="testimonia">
                                                <div class="testimonia-img mx-auto mb-3">
                                                    
                                                    <img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-xxl brround text-center mx-auto" alt="default">
                                                   

                                                </div>
                                                <p>
                                                    <i class="fa fa-quote-left"></i>  Recusandae non qui et et id cum quo. Autem repellendus quibusdam sequi sit neque. Iusto excepturi beatae dolores ea quibusdam quaerat alias dolor. Ad minus architecto quo perferendis deserunt. Eveniet et inventore asperiores est laboriosam dolorem. Dolorem est autem vel illum rem. Quos voluptas molestiae fuga ipsum ratione omnis in. Non excepturi error quis commodi quia rerum quia. Sapiente fugit sit voluptate et dolorem iste incidunt. Et perferendis atque commodi dolor excepturi qui eveniet. Voluptate sed dolorum veniam est perspiciatis placeat eum.
                                                                            
                                                </p>
                                                <div class="testimonia-data">
                                                    <h4 class="fs-20 mb-1">Vita Mraz</h4>
                                                    <p>Designer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item text-center">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-8 col-md-12 d-block mx-auto">
                                            <div class="testimonia">
                                                <div class="testimonia-img mx-auto mb-3">
                                                    
                                                    <img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-xxl brround text-center mx-auto" alt="default">
                                                   

                                                </div>
                                                <p>
                                                    <i class="fa fa-quote-left"></i>  Recusandae non qui et et id cum quo. Autem repellendus quibusdam sequi sit neque. Iusto excepturi beatae dolores ea quibusdam quaerat alias dolor. Ad minus architecto quo perferendis deserunt. Eveniet et inventore asperiores est laboriosam dolorem. Dolorem est autem vel illum rem. Quos voluptas molestiae fuga ipsum ratione omnis in. Non excepturi error quis commodi quia rerum quia. Sapiente fugit sit voluptate et dolorem iste incidunt. Et perferendis atque commodi dolor excepturi qui eveniet. Voluptate sed dolorum veniam est perspiciatis placeat eum.
                                                                            
                                                </p>
                                                <div class="testimonia-data">
                                                    <h4 class="fs-20 mb-1">Vita Mraz</h4>
                                                    <p>Designer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Testimonial Section-->
 <!--FAQ Section-->
<section>
    <div class="cover-image sptb">
        <div class="container">
            <div class="section-title center-block text-center">
                <h2 class="wow fs-30" data-wow-delay="0.1s">Check Out FAQ’s</h2>
                <p class="wow fs-18" data-wow-delay="0.15s">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
            </div>
            <div class="accordion suuport-accordion" id="accordion" >
                
                <div class="row">
                    <div class="col-md-12 d-block mx-auto mb-2">
                        <div class="acc-card wow fadeInUp" data-wow-delay="0.2s">
                            <div class="acc-header" id="heading" role="tablist">
                                <h5 class="mb-0">
                                    <a aria-controls="collapse" aria-expanded="false" data-bs-toggle="collapse" href="#collapse">
                                        Ullam et facilis id magnam sit mollitia. <span class="float-end acc-angle"><i class="fe fe-chevron-right"></i></span>
                                    </a>
                                </h5>
                            </div>
                            <div aria-labelledby="heading{" class="collapse" data-bs-parent="#accordion" id="collapse" role="tabpanel">
                                <div class="acc-body bg-white p-5">
                                   

                                    <div class="alert alert-light-warning">
                                        <p class="privatearticle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        You must be logged in and have valid account to access this content.
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              

            </div>
        </div>
    </div>
</section>
<!--FAQ Section-->              
@endsection

@section('scripts')

        <!--INTERNAL Owl-carousel js -->
        <script src="{{asset('assets/plugins/owl-carousel/owl-carousel.js')}}?v=<?php echo time(); ?>"></script>

        <!-- INTERNAL Index js-->
        <script src="{{asset('assets/js/support/support-landing.js')}}?v=<?php echo time(); ?>"></script>

        <!-- INTERNAL Index js-->
        <script src="{{asset('assets/plugins/jquery/jquery-ui.js')}}?v=<?php echo time(); ?>"></script>

        <script type="text/javascript">
            "use strict";
            
            (function($){

                // close the data search
                document.querySelector('.page-main').addEventListener('click', ()=>{ 
                    $('#searchList').fadeOut();
                    $('#searchList').html(''); 
                });

                // search the data
                $('#search_name').keyup(function () {

                    var data = $(this).val();
                    if (data != '') {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{ url('/search') }}",
                            method: "POST",
                            data: {data: data, _token: _token},

                            dataType:"json",

                            success: function (data) {

                                $('#searchList').fadeIn();
                                $('#searchList').html(data);
                                const ps3 = new PerfectScrollbar('.sprukohomesearch', {
                                    useBothWheelAxes:true,
                                    suppressScrollX:true,
                                });
                            },
                            error: function (data) {

                            }
                        });
                    }
                });

            })(jQuery);

        </script>

@endsection

