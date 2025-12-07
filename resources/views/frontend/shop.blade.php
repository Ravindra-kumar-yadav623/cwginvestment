@extends('frontend.layout')

@section('header-class') 
        <section id="header" class="main-header shop-header inner-header">
@endsection

@section('breadcrum')
        <div class="intro row">
            <div class="overlay"></div>
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Shop</li>
                </ol>
            </div>
        </div> <!-- /.intro.row -->
@endsection

@section('content')

 <!-- Shop -->
        <section class="shop">
            <div class="container page-bgc">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="title-box">
                            <p>Get our</p>
                            <h2 class="title mt0">Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="boxed">
                        <div class="col-sm-6">
                            <div class="shop-box">
                                <img class="img-full img-responsive" src="assets/images/shop-1.png" alt="shop">
                                <div class="shop-box-hover text-center">
                                    <div class="c-table">
                                        <div class="c-cell">
                                            <a href="#">
                                                <span class="ion-heart"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-search-strong"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-cart"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-box-title">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Package 1</h4>
                                        <h4>7.5% <span class="thin"> Return (Monthly)</span></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="shop-price">
                                            $100-$1000
                                        </p>
                                        <div class="star">
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star-half"></span>
                                            <span class="ion-ios-star-outline"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="shop-box">
                                <img class="img-full img-responsive" src="assets/images/shop-2.png" alt="shop">
                                <div class="shop-box-hover text-center">
                                    <div class="c-table">
                                        <div class="c-cell">
                                            <a href="#">
                                                <span class="ion-heart"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-search-strong"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-cart"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-box-title">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Package 2</h4>
                                        <h4>9.0% <span class="thin"> Mining Profit Sharing</span></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="shop-price">
                                            $1001-$5000
                                        </p>
                                        <div class="star">
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star-half"></span>
                                            <span class="ion-ios-star-outline"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="shop-box">
                                <img class="img-full img-responsive" src="assets/images/shop-3.png" alt="shop">
                                <div class="shop-box-hover text-center">
                                    <div class="c-table">
                                        <div class="c-cell">
                                            <a href="#">
                                                <span class="ion-heart"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-search-strong"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-cart"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-box-title">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Package 3</h4>
                                        <h4>10% <span class="thin"> Mining
												Profit Sharing </span></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="shop-price">
                                            $5001-$10000
                                        </p>
                                        <div class="star">
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star-half"></span>
                                            <span class="ion-ios-star-outline"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="shop-box">
                                <img class="img-full img-responsive" src="assets/images/shop-4.png" alt="shop">
                                <div class="shop-box-hover text-center">
                                    <div class="c-table">
                                        <div class="c-cell">
                                            <a href="#">
                                                <span class="ion-heart"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-search-strong"></span>
                                            </a>
                                            <a href="#">
                                                <span class="ion-ios-cart"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-box-title">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Package 4</h4>
                                        <h4>12% <span class="thin"> Mining
												Profit Sharing</span></h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="shop-price">
                                            $10000+
                                        </p>
                                        <div class="star">
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star"></span>
                                            <span class="ion-ios-star-half"></span>
                                            <span class="ion-ios-star-outline"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <nav>
                                <ul class="pager">
                                    <li class="previous disabled"><a href="#"><span aria-hidden="true" class="ion-chevron-left"></span></a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li class="next"><a href="#"><span aria-hidden="true" class="ion-chevron-right"></span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection