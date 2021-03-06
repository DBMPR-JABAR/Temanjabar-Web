    <div class="container">
        @if (Session::has('msg'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ Session::get('color') }} alert-dismissible fade show"
                    role="alert">
                    {{ Session::get('msg') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        @endif
        <h1>4<div class="lock">
                <div class="top"></div>
                <div id="static_lock_bottom" class="bottom"></div>
            </div>3</h1>
        <p>Anda tidak memiliki izin akses</p>
        <p>Silahkan hubungi Administrator</p>
    </div>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Comfortaa");

        * {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        body {
            background-color: #00351a;
            font-family: sans-serif;
        }

        .container {
            z-index: 1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            padding: 10px;
            min-width: 300px;
        }

        .container div {
            display: inline-block;
        }

        .container .lock {
            opacity: 1;
        }

        .container h1 {
            font-family: "Comfortaa", cursive;
            font-size: 100px;
            text-align: center;
            color: #eee;
            font-weight: 100;
            margin: 0;
        }

        .container p {
            color: #fff;
        }

        .lock {
            transition: 0.5s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
        }

        .lock.generated {
            transform: scale(0.5);
            position: absolute;
            -webkit-animation: 2s move linear;
            animation: 2s move linear;
            -webkit-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
        }

        .lock ::after {
            content: "";
            background: #fffb00;
            opacity: 0.3;
            display: block;
            position: absolute;
            height: 100%;
            width: 50%;
            top: 0;
            left: 0;
        }

        .lock .bottom {
            background: #ffe600;
            height: 40px;
            width: 60px;
            display: block;
            position: relative;
            margin: 0 auto;
        }

        .lock .top {
            height: 60px;
            width: 50px;
            border-radius: 50%;
            border: 10px solid #fff;
            display: block;
            position: relative;
            top: 30px;
            margin: 0 auto;
        }

        .lock .top::after {
            padding: 10px;
            border-radius: 50%;
        }

        @-webkit-keyframes move {
            to {
                top: 100%;
            }
        }

        @keyframes move {
            to {
                top: 100%;
            }
        }

        @media (max-width: 420px) {
            .container {
                transform: translate(-50%, -50%) scale(0.8);
            }

            .lock.generated {
                transform: scale(0.3);
            }
        }

    </style>
    <script type="text/javascript">
        const interval = 500;

        const generateColor = () => {
            const randomColor = Math.floor(Math.random() * 16777215).toString(16);
            return `#${randomColor}`;
        }

        function generateLocks() {
            const lock = document.createElement('div'),
                position = generatePosition();
            lock.innerHTML = `<div class="top"></div><div class="bottom" id="${position[0]}_bottom"></div>`;
            lock.style.top = position[0];
            lock.style.left = position[1];
            lock.classList = 'lock' // generated';
            document.body.appendChild(lock);
            const lockBottom = document.getElementById(`${position[0]}_bottom`)
            lockBottom.style.background = generateColor();
            const staticLockBottom = document.getElementById("static_lock_bottom")
            staticLockBottom.style.background = generateColor();
            setTimeout(() => {
                lock.style.opacity = '1';
                lock.classList.add('generated');
            }, 100);
            setTimeout(() => {
                lock.parentElement.removeChild(lock);
            }, 2000);
        }

        function generatePosition() {
            const x = Math.round((Math.random() * 100) - 10) + '%';
            const y = Math.round(Math.random() * 100) + '%';
            return [x, y];
        }
        setInterval(() => {
            document.body.style.background = generateColor()
        }, interval * 3);
        setInterval(generateLocks, interval);
        generateLocks();

    </script>
