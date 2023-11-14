<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @vite(['resources/css/app.css'])

    <style>
      .pile {
         position: absolute;
         left: 0;
         bottom: -1px;
         width: 100%;
         height: 0;
         padding-bottom: 5%;
         background-image: url(/img/snow.svg);
         background-repeat: repeat-x;
         background-size: cover;
         animation: pile 60s linear;
         animation-fill-mode: forwards;
      }

      @media screen and (min-width: 800px) {
         .pile {
            right: 0;
            left: auto;
            height: 40px;
            padding-bottom: 0;
            background-size: contain;
         }
      }

      @keyframes pile {
         from {
            transform: translateY(50%);
         }
         to {
            transform: translateY(0%);
         }
      }
    </style>
</head>
<body>
    <div class="relative overflow-hidden w-full pt-[20vh] bg-gradient-to-b from-sky-300 to-sky-100">
        <img src="/img/snowman.svg" width="224" height="auto" class="relative block mx-auto w-56" alt="SnowbodyKnows">
        <div class="pile"></div>
        <canvas id="snow" class="absolute inset-0"></canvas>
    </div>
    <div class="mx-auto mt-12 px-4 max-w-sm">
        <p class="text-center text-gray-600 text-lg">Choose your adventure:</p>
    </div>
    <div class="mt-12 text-center w-full">
        <x-button-primary href="{{ route('register', ['adventure' => 'create_party']) }}">Create a Party</x-button-primary>
        <x-button-primary href="{{ route('register', ['adventure' => 'create_wishlist']) }}">Create a Single Wishlist</x-button-primary>
    </div>
</div>
<script>
var canvas = document.getElementById('snow');
var bounds = canvas.parentElement;
var context = canvas.getContext('2d');
var width = bounds.offsetWidth || 0;
var height = bounds.offsetHeight || 0;
var flakes = [];
var resizeTimer = null

function resize(e) {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        width = bounds.offsetWidth || 0;
        height = bounds.offsetHeight || 0;
        canvas.width = width;
        canvas.height = height;
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';
    }, 250)
};

function generate(total) {
    for (var i = 0; i < total; ++i) {
        flakes.push(new Flake());
    }
};

function animate() {
    requestAnimationFrame(animate);
    context.clearRect(0, 0, width, height);

    for (var i = 0; i < flakes.length; ++i) {
        flakes[i].update();
        flakes[i].draw();
    }
};

function rand(min, max, round) {
    if (round) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    return Math.random() * (max - min) + min;
};

class Flake {
    constructor() {
        this.x = 0;
        this.y = 0;
        this.factor = 0;
        this.count = 0;
        this.speed = 5;
        this.size = 5;
        this.wind = 2;
        this.init();
    }

    init() {
        this.x = rand(0, width, true) - (this.wind * 200);
        this.y = rand(-height, -10, true);
        this.factor = rand(0.2, 1.0);
        this.count = rand(0, 1000, true);
        this.speed = this.speed * this.factor;
    }

    update() {
        this.x += this.wind + Math.cos(this.count / 20);
        this.y += this.factor * (Math.sin(this.count / 100) + this.speed);

        if (this.y > height) {
            this.init();
        }
        this.count++;
    }

    draw() {
        var size = this.size * this.factor;
        var grad = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, size);

        if (this.factor > .9) { // background
            size = this.size * (this.factor * 6);
            grad = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, size);
            grad.addColorStop(0, 'rgba( 250, 250, 255, .1 )');
            grad.addColorStop(.5, 'rgba( 250, 250, 255, .05 )');
            grad.addColorStop(1, 'rgba( 250, 250, 255, 0 )');
        } else if (this.factor > .8) { // middle ground
            size = this.size * (this.factor * 2);
            grad = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, size);
            grad.addColorStop(0, 'rgba( 250, 250, 255, .2 )');
            grad.addColorStop(.6, 'rgba( 250, 250, 255, .08 )');
            grad.addColorStop(1, 'rgba( 250, 250, 255, 0 )');
        } else { // foreground
            grad.addColorStop(0, 'rgba( 250, 250, 255, 1 )');
            grad.addColorStop(.5, 'rgba( 250, 250, 255, .8 )');
            grad.addColorStop(1, 'rgba( 250, 250, 255, 0 )');
        }

        context.beginPath();
        context.fillStyle = grad;
        context.arc(this.x, this.y, size, 0, 2 * Math.PI, false);
        context.fill();
        context.closePath();
    }
};

window.addEventListener('resize', resize);
document.addEventListener('DOMContentLoaded', () => {
    if (window.matchMedia(`(prefers-reduced-motion: reduce)`) === true || window.matchMedia(`(prefers-reduced-motion: reduce)`).matches === true) {
        return;
    }
    resize();
    generate(500);
    animate();
})
</script>
</body>
</html>
