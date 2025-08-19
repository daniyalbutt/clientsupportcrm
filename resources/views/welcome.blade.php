@extends('layouts.app-front')
@section('content')
<section class="Index-Slider">
    <div class="container">
        <div class="css-slider-wrapper">
            <input type="radio" class="slide-radio1" name="slider" id="slider_1" checked="checked">
            <input type="radio" class="slide-radio2" name="slider" id="slider_2">
            <input type="radio" class="slide-radio3" name="slider" id="slider_3">
            <input type="radio" class="slide-radio4" name="slider" id="slider_4">
            <div class="slider-pegination">
                <label for="slider_1" class="page1"></label>
                <label for="slider_2" class="page2"></label>
                <label for="slider_3" class="page3"></label>
                <label for="slider_4" class="page4"></label>
            </div>
            <div class="next control">
                <label for="slider_1" class="numb1"><i class="fa fa-arrow-circle-right"></i></label>
                <label for="slider_2" class="numb2"><i class="fa fa-arrow-circle-right"></i></label>
                <label for="slider_3" class="numb3"><i class="fa fa-arrow-circle-right"></i></label>
                <label for="slider_4" class="numb4"><i class="fa fa-arrow-circle-right"></i></label>
            </div>
            <div class="previous control">
                <label for="slider_1" class="numb1"><i class="fa fa-arrow-circle-left"></i></label>
                <label for="slider_2" class="numb2"><i class="fa fa-arrow-circle-left"></i></label>
                <label for="slider_3" class="numb3"><i class="fa fa-arrow-circle-left"></i></label>
                <label for="slider_4" class="numb4"><i class="fa fa-arrow-circle-left"></i></label>
            </div>
            <div class="slider slide1">
                <div class="CustomSLiderStyle">
                    <h2><a href="#">213.884.6974</a></h2>
                    <h6><a href="#">email@daytraderalgorithm.com</a></h6>
                    <h3>WELCOME TO</h3>
                    <h1>DAY TRADER ALGORITHM</h1>
                    <p>
                        DayTraderAlgorithm.com promises awareness to the true dynamics of the stock market. Whether a short term trader or a long-term investor, we possess the collective wisdom to anticipate success and failure. We are a fully integrated solution tracking a simple premise follow big money and decide why and where it's going. 
                    </p>
                    <a href="about.php" class="btn btnStarted">Get Started</a>
                </div>
            </div>
            <div class="slider slide2">
                <div class="CustomSLiderStyle">
                    <h2><a href="#">213.884.6974</a></h2>
                    <h6><a href="#">email@daytraderalgorithm.com</a></h6>
                    <h3>WELCOME TO</h3>
                    <h1>DAY TRADER ALGORITHM</h1>
                    <p>
                        DayTraderAlgorithm.com promises awareness to the true dynamics of the stock market. Whether a short term trader or a long-term investor, we possess the collective wisdom to anticipate success and failure. We are a fully integrated solution tracking a simple premise follow big money and decide why and where it's going. 
                    </p>
                    <a href="about.php" class="btn btnStarted">Get Started</a>
                </div>
            </div>
            <div class="slider slide3">
                <div class="CustomSLiderStyle">
                    <h2><a href="#">213.884.6974</a></h2>
                    <h6><a href="#">email@daytraderalgorithm.com</a></h6>
                    <h3>WELCOME TO</h3>
                    <h1>DAY TRADER ALGORITHM</h1>
                    <p>
                        DayTraderAlgorithm.com promises awareness to the true dynamics of the stock market. Whether a short term trader or a long-term investor, we possess the collective wisdom to anticipate success and failure. We are a fully integrated solution tracking a simple premise follow big money and decide why and where it's going. 
                    </p>
                    <a href="about.php" class="btn btnStarted">Get Started</a>
                </div>
            </div>
            <div class="slider slide4">
                <div class="CustomSLiderStyle">
                    <h2><a href="#">213.884.6974</a></h2>
                    <h6><a href="#">email@daytraderalgorithm.com</a></h6>
                    <h3>WELCOME TO</h3>
                    <h1>DAY TRADER ALGORITHM</h1>
                    <p>
                        DayTraderAlgorithm.com promises awareness to the true dynamics of the stock market. Whether a short term trader or a long-term investor, we possess the collective wisdom to anticipate success and failure. We are a fully integrated solution tracking a simple premise follow big money and decide why and where it's going. 
                    </p>
                    <a href="about.php" class="btn btnStarted">Get Started</a>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
@push('custom-scripts')
    
@endpush
