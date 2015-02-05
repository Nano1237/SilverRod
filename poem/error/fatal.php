<html>
    <head>
        <meta charset="utf-8" />
        <title>- FATAL -</title>
        <style>
            body {
                background-image: radial-gradient(1000px, #0000AA 0%, #000060 1000px, rgba(0, 0, 0, 0.3) 18px, transparent 19px);
                color: #FFFFFF;
                font-family: courier;
                font-size: 12pt;
                margin-bottom: 100px;
                margin-left: 100px;
                margin-right: 100px;
                margin-top: 100px;
                text-align: center;
            }
            div {
                margin-top: 50px;
            }
            .neg {
                background-attachment: scroll;
                background-clip: border-box;
                background-color: #FFFFFF;
                background-image: none;
                background-origin: padding-box;
                background-position: 0 0;
                background-repeat: repeat;
                background-size: auto auto;
                color: #0000AA;
                font-weight: bold;
                padding-bottom: 2px;
                padding-left: 8px;
                padding-right: 8px;
                padding-top: 2px;
            }
            p {
                margin-bottom: 30px;
                margin-left: 100px;
                margin-right: 100px;
                margin-top: 30px;
                text-align: center;
            }
            a, a:hover {
                -moz-font-feature-settings: inherit;
                -moz-font-language-override: inherit;
                -x-system-font: none;
                color: inherit;
                font-family: inherit;
                font-size: inherit;
                font-size-adjust: inherit;
                font-stretch: inherit;
                font-style: inherit;
                font-variant: inherit;
                font-weight: inherit;
                line-height: inherit;
            }
            a:hover {
                -moz-text-blink: none;
                -moz-text-decoration-color: -moz-use-text-color;
                -moz-text-decoration-line: none;
                -moz-text-decoration-style: solid;
            }
            .menu {
                margin-top: 50px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div>
            <span class="neg">FATAL ERROR</span>
            <p><?= $message; ?> on line [<?= $line; ?>] in <?= $file; ?></p>
            Press any link to continue
            <div class="menu">
                <a href="/">index</a>
            </div>
        </div>
    </body>
</html>
