@extends('frontend.layout')

@section('header-class') 
 <section id="header" class="main-header faq-header inner-header">
@endsection

@section('breadcrum')
    <div class="intro row">
            <div class="overlay"></div>
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">FAQ</li>
                </ol>
            </div>
        </div> <!-- /.intro.row -->
@endsection

@section('content')
   <section class="faq">
            <div class="container page-bgc">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="title-box">
                            <p>Frequently asked</p>
                            <h2 class="title mt0">Questions</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <p class="inner-p">
                            Capital wealth growth refers to an increase in the value of an asset over time, such as stocks, real estate, or mutual funds. Investors seeking capital growth are generally looking for long-term wealth accumulation rather than immediate income. 
                        </p>
                        <div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group">
                            <div class="panel panel-default">
                                <div id="headingOne" role="tab" class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">Risk Management?</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <p>This is paramount. Implement strict risk management rules, such as setting stop-loss and take-profit limits, and diversify your holdings across various assets.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div id="headingTwo" role="tab" class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="">Security and Transparency</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" class="panel-collapse collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <p>Choose a platform with a good reputation and strong security measures (e.g., Capital wealth growth).</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div id="headingThree" role="tab" class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="collapsed">How much money can I make &amp Avoid Scams?</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree" class="panel-collapse collapse" aria-expanded="false">
                                    <div class="panel-body">
                                        <p>Be wary of tools, especially those with high-pressure sales tactics or long-term commitments, that "scream scam". There are many free or low-cost ways to learn about AI trading and build your own tools using established platforms.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div id="headingFour" role="tab" class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour" class="collapsed">Continuous Learning?</a>
                                    </h4>
                                </div>
                                <div id="collapseFour" role="tabpanel" aria-labelledby="headingFour" class="panel-collapse collapse" aria-expanded="false">
                                    <div class="panel-body">
                                        <p>Markets evolve constantly. Regularly review your AI bot's performance and update its parameters monthly to remain effective.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection