@extends('frontend.layout')

@section('header-class') 
          <section id="header" class="main-header contact-header inner-header">
@endsection

@section('breadcrum')
        <div class="intro row">
            <div class="overlay"></div>
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">Contact</li>
                </ol>
            </div>
        </div> <!-- /.intro.row -->
@endsection

@section('content')
 <!-- Contact -->
        <section class="contact">
            <div class="container page-bgc">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="title-box">
                            <p>Get in touch</p>
                            <h2 class="title mt0">With us</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="boxed">
                        <div class="col-sm-12">
                            <p class="inner-p">
                                Capital Wealth Counsel is an investment banking and finance company. Their services generally involve providing financial advice and managing investments for clients to achieve long-term capital growth, similar to other wealth management firms in the region. Specific details on their growth strategies would be found in their client documentation or direct consultations.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="map" class="col-sm-12">
                        <iframe class="map_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3106.278875347398!2d-77.05845558511638!3d38.87186095605503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7b6df29ed2c27%3A0xaf83d0f8c013532f!2sThe+Pentagon!5e0!3m2!1sen!2sbd!4v1463572803138" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="row">
                    <div class="boxed">
                        <div class="col-sm-8">
                            <h4>Message for us</h4>
                            <form action="contact.php" class="contact-form" id="contactForm" method="post">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="First Name*" id="fname" name="fname" required>
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-sm-6 -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Last Name" id="lname" name="lname">
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-sm-6 -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email*" id="email" name="email" required>
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-sm-6 -->
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Phone Number" id="phone" name="phone">
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-sm-6 -->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="6" placeholder="Write something..." name="message"></textarea>
                                        </div> <!-- /.form-group -->
                                    </div> <!-- /.col-sm-12 -->
                                    <div class="text-center mt20 col-sm-12">
                                        <button type="submit" class="btn btn-robot pull-left" id="cfsubmit">Send Message</button>
                                    </div>
                                </div>
                            </form>
                            <div id="contactFormResponse"></div>
                        </div> <!-- /.col-sm-8 -->
                        <div class="col-sm-4">
                            <h4>Contact details</h4>
                            <div class="row">
                                <div class="col-xs-3">
                                    <img class="imgresponsive" src="assets/images/address.png" alt="con">
                                </div>
                                <div class="col-xs-9">
                                    <h5>Address</h5>
                                    <p class="contact-detail">
                                        44 new design street, melbourne 005<br>
                                        South Africa
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <img class="imgresponsive" src="assets/images/phone.png" alt="con">
                                </div>
                                <div class="col-xs-9">
                                    <h5>Phone</h5>
                                    <p class="contact-detail">
                                        +27 (021) 433 744<br>
                                        +27 (011) 433 633
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <img class="imgresponsive" src="assets/images/support.png" alt="con">
                                </div>
                                <div class="col-xs-9">
                                    <h5>Support</h5>
                                    <p class="contact-detail">
                                        support@cwg.za
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection