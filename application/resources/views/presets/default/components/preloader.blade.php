<style>
    .trace-bg {
        stroke: #0070df;
        stroke-width: 1.8;
        fill: none;
    }

    .trace-flow {
        stroke-width: 1.8;
        fill: none;
        stroke-dasharray: 40 400;
        stroke-dashoffset: 438;
        filter: drop-shadow(0 0 6px currentColor);
        animation: flow 1s cubic-bezier(0.5, 0, 0.9, 1) infinite;
    }

    .yellow {
        stroke: #080197;
        color: #001d9c;
    }

    .blue {
        stroke: #00ccff;
        color: #00ccff;
    }

    .green {
        stroke: #00ff15;
        color: #00ff15;
    }

    .purple {
        stroke: #9900ff;
        color: #9900ff;
    }

    .red {
        stroke: #ff3300;
        color: #ff3300;
    }

    @keyframes flow {
        to {
            stroke-dashoffset: 0;
        }
    }

    /* Čip */
    .chip-body {
        rx: 20;
        ry: 20;
    }

    /* Text uvnitř čipu */
    .chip-text {
        font-weight: bold;
        letter-spacing: 1px;
    }

    /* Piny */
    .chip-pin {
        stroke: #444;
        stroke-width: 0.5;
        filter: drop-shadow(0 0 2px rgba(0, 0, 0, 0.6));
    }


    #loading{
        z-index: 999999999;
    }
    
    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
        overflow: hidden;
    }
    .main-container{
        width: 100%;
        height: 80%;
        margin: 100px auto;
    }
    .loader {
        width: 100%;
        height: 100%;
    }

    .base-loader.main-container{
        position: relative;
    }
    .base-loader-animator{
        max-width: 700px;
        max-height: 170px;
        position: absolute;
        top: 100px;
        left: 50%;
        /* margin-left: -100px; */
        z-index: 1;
    }
    #loader-center-base-logo{
        width: 300px;
        max-height: 270px;
        position: absolute;
        top: 100px;
        left: 50%;
        margin-left: -160px;
        z-index: 2;

    }
    
    @media (max-width:500px){
        .base-loader-animator{
            max-width: 300px;
            max-height: 170px;
            top: 350px;
            left: 50%;
            /* margin-left: -100px; */
            z-index: 1;
        }
        #loader-center-base-logo{
            width: 130px;
            max-height: 120px;
            top: 310px;
            left: 50%;
            margin-left: -70px;
            z-index: 2;

        }
    }
</style>

<!--==================== Preloader Start ====================-->
<div id="loading">
    <div id="loading-center">
        <span class="loader">
            {{-- <img src="{{ asset($activeTemplateTrue . "images/preloader.gif") }}" alt=""> --}}

            <div class="base-loader main-container">
                <div class="loader base-loader-animator">
                    <svg viewBox="0 0 800 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="chipGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#2d2d2d"></stop>
                                <stop offset="100%" stop-color="#0f0f0f"></stop>
                            </linearGradient>

                            <linearGradient id="textGradient" x1="0" y1="0" x2="0"
                                y2="1">
                                <stop offset="0%" stop-color="#eeeeee"></stop>
                                <stop offset="100%" stop-color="#888888"></stop>
                            </linearGradient>

                            <linearGradient id="pinGradient" x1="1" y1="0" x2="0"
                                y2="0">
                                <stop offset="0%" stop-color="#bbbbbb"></stop>
                                <stop offset="50%" stop-color="#888888"></stop>
                                <stop offset="100%" stop-color="#555555"></stop>
                            </linearGradient>
                        </defs>

                        <g id="traces">
                            <path d="M100 100 H200 V210 H326" class="trace-bg"></path>
                            <path d="M100 100 H200 V210 H326" class="trace-flow purple"></path>

                            <path d="M80 180 H180 V230 H326" class="trace-bg"></path>
                            <path d="M80 180 H180 V230 H326" class="trace-flow blue"></path>

                            <path d="M60 260 H150 V250 H326" class="trace-bg"></path>
                            <path d="M60 260 H150 V250 H326" class="trace-flow yellow"></path>

                            <path d="M100 350 H200 V270 H326" class="trace-bg"></path>
                            <path d="M100 350 H200 V270 H326" class="trace-flow green"></path>

                            <path d="M700 90 H560 V210 H474" class="trace-bg"></path>
                            <path d="M700 90 H560 V210 H474" class="trace-flow blue"></path>

                            <path d="M740 160 H580 V230 H474" class="trace-bg"></path>
                            <path d="M740 160 H580 V230 H474" class="trace-flow green"></path>

                            <path d="M720 250 H590 V250 H474" class="trace-bg"></path>
                            <path d="M720 250 H590 V250 H474" class="trace-flow red"></path>

                            <path d="M680 340 H570 V270 H474" class="trace-bg"></path>
                            <path d="M680 340 H570 V270 H474" class="trace-flow yellow"></path>
                        </g>

                        {{-- <rect x="330" y="190" width="140" height="100" rx="20" ry="20"
                            fill="url(#chipGradient)" stroke="#222" stroke-width="3"
                            filter="drop-shadow(0 0 6px rgba(0,0,0,0.8))"></rect> --}}
                            
                        

                        <g>
                            <rect x="322" y="205" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                            <rect x="322" y="225" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                            <rect x="322" y="245" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                            <rect x="322" y="265" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                        </g>

                        <g>
                            <rect x="470" y="205" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                            <rect x="470" y="225" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                            <rect x="470" y="245" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                            <rect x="470" y="265" width="8" height="10" fill="url(#pinGradient)" rx="2">
                            </rect>
                        </g>

                        {{-- <text x="400" y="240" font-family="Arial, sans-serif" font-size="22" fill="url(#textGradient)"
                            text-anchor="middle" alignment-baseline="middle">
                            <!-- logo start -->
                            @include($activeTemplate . 'components.logo')
                            <!-- logo end -->
                        </text> --}}

                        <circle cx="100" cy="100" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                        <circle cx="80" cy="180" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                        <circle cx="60" cy="260" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                        <circle cx="100" cy="350" r="5" fill="white" stroke="black" stroke-width="2"></circle>

                        <circle cx="700" cy="90" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                        <circle cx="740" cy="160" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                        <circle cx="720" cy="250" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                        <circle cx="680" cy="340" r="5" fill="white" stroke="black" stroke-width="2"></circle>
                    </svg>
                </div>


                <img id="loader-center-base-logo" src="{{ asset(getFilePath('logoIcon') . '/loader-center.png') }}"
                    alt="{{ config('app.name') }}">
            </div>
        </span>
    </div>
</div>

<!--==================== Preloader End ====================-->


