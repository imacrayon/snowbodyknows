<x-layout.marketing>
{{-- Start snow --}}
<section class="px-4 relative overflow-hidden bg-linear-to-b from-sky-200 to-sky-100">
    <canvas id="snow" class="absolute inset-0"></canvas>
    <div class="pile"></div>
    <div class="relative container mx-auto max-w-6xl">
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="text-center text-sky-900 lg:text-left space-y-6 pt-12 lg:pb-24">
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">Stop <span class="text-sky-600">guessing</span>,<br>start <span class="text-red-600">gifting</span></h1>
        <p class="text-xl md:text-2xl text-sky-800 max-w-2xl mx-auto">The easiest way to create and share wishlists with your family and friends. No more stress, just perfect presents.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
            <x-button-danger href="{{ route('guests.wishlists.show') }}" class="py-3! px-4! text-base!">Start Your Wishlist</x-button-danger>
            <p class="text-sm text-sky-800 self-center">No account needed!</p>
        </div>
        </div>
        <img src="/img/snowman.svg" width="224" height="auto" class="relative top-2 block mx-auto self-end w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96" alt="SnowbodyKnows">
    </div>
    </div>
</section>
@push('css')
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
@endpush

@push('js')
<script>
(function () {
    var canvas, bounds, context, width, height, resizeTimer;
    var flakes = []

    function resize() {
        clearTimeout(resizeTimer)
        resizeTimer = setTimeout(() => {
            width = bounds.offsetWidth || 0
            height = bounds.offsetHeight || 0
            canvas.width = width
            canvas.height = height
            canvas.style.width = width + 'px'
            canvas.style.height = height + 'px'
        }, 250)
    }

    function generate(total) {
        for (var i = 0; i < total; ++i) {
            flakes.push(new Flake())
        }
    }

    function animate() {
        requestAnimationFrame(animate)
        context.clearRect(0, 0, width, height)

        for (var i = 0; i < flakes.length; ++i) {
            flakes[i].update()
            flakes[i].draw()
        }
    }

    function rand(min, max, round) {
        if (round) {
            return Math.floor(Math.random() * (max - min + 1)) + min
        }
        return Math.random() * (max - min) + min
    }

    class Flake {
        constructor() {
            this.x = 0
            this.y = 0
            this.factor = 0
            this.count = 0
            this.speed = 5
            this.size = 5
            this.wind = 2
            this.init()
        }

        init() {
            this.x = rand(0, width, true) - (this.wind * 200)
            this.y = rand(-height, -10, true)
            this.factor = rand(0.2, 1.0)
            this.count = rand(0, 1000, true)
            this.speed = this.speed * this.factor
        }

        update() {
            this.x += this.wind + Math.cos(this.count / 20)
            this.y += this.factor * (Math.sin(this.count / 100) + this.speed)

            if (this.y > height) {
                this.init()
            }
            this.count++
        }

        draw() {
            var size = this.size * this.factor
            var grad = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, size)

            if (this.factor > .9) { // background
                size = this.size * (this.factor * 6)
                grad = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, size)
                grad.addColorStop(0, 'rgba( 250, 250, 255, .1 )')
                grad.addColorStop(.5, 'rgba( 250, 250, 255, .05 )')
                grad.addColorStop(1, 'rgba( 250, 250, 255, 0 )')
            } else if (this.factor > .8) { // middle ground
                size = this.size * (this.factor * 2)
                grad = context.createRadialGradient(this.x, this.y, 0, this.x, this.y, size)
                grad.addColorStop(0, 'rgba( 250, 250, 255, .2 )')
                grad.addColorStop(.6, 'rgba( 250, 250, 255, .08 )')
                grad.addColorStop(1, 'rgba( 250, 250, 255, 0 )')
            } else { // foreground
                grad.addColorStop(0, 'rgba( 250, 250, 255, 1 )')
                grad.addColorStop(.5, 'rgba( 250, 250, 255, .8 )')
                grad.addColorStop(1, 'rgba( 250, 250, 255, 0 )')
            }

            context.beginPath()
            context.fillStyle = grad
            context.arc(this.x, this.y, size, 0, 2 * Math.PI, false)
            context.fill()
            context.closePath()
        }
    }

    window.addEventListener('resize', resize)
    document.addEventListener('DOMContentLoaded', () => {
        if (window.matchMedia(`(prefers-reduced-motion: reduce)`) === true || window.matchMedia(`(prefers-reduced-motion: reduce)`).matches === true) {
            return
        }

        canvas = document.getElementById('snow')
        bounds = canvas.parentElement
        context = canvas.getContext('2d')
        width = bounds.offsetWidth || 0
        height = bounds.offsetHeight || 0

        resize()
        generate(500)
        animate()
    })
}())
</script>
@endpush
{{-- End snow --}}

<section class="py-20 px-4 relative bg-linear-to-b from-white to-sky-50">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-12 space-y-4 text-balance">
            <h2 class="text-4xl md:text-5xl font-bold text-sky-900">Making your holiday <span class="text-sky-500">present</span> and accounted for</h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto">Everything you need to sleigh your gift exchange</p>
        </div>
        <div class="max-w-3xl mx-auto grid grid-cols-1 gap-12 md:grid-cols-2">
            <div class="space-y-4 max-w-xs mx-auto">
                <div class="border border-sky-900/10 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-2" style="background: repeating-linear-gradient(45deg, var(--color-red-200), var(--color-red-200) 10px, white 10px, white 20px);">
                        <div class="bg-white border border-gray-200 rounded-xl p-2 overflow-hidden">
                            <img loading="lazy" width="324" height="324" src="/img/features/build.gif?v=2" alt="" class="w-full h-auto rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="text-center space-y-2 text-balance">
                    <h3 class="text-2xl font-bold text-sky-900">Build Your Wishlist in a Flurry</h3>
                    <p class="text-gray-600 text-lg text-pretty">Easily build a gift wishlist with all the items you'd love to receive.</p>
                </div>
            </div>
            <div class="space-y-4 max-w-xs mx-auto">
                <div class="border border-sky-900/10 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-2" style="background: repeating-linear-gradient(45deg, var(--color-red-200), var(--color-red-200) 10px, white 10px, white 20px);">
                        <div class="bg-white border border-gray-200 rounded-xl p-2 overflow-hidden">
                            <img loading="lazy" width="324" height="324" src="/img/features/share.jpg" alt="" class="w-full h-auto rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="text-center space-y-2 text-balance">
                    <h3 class="text-2xl font-bold text-sky-900">Share with Your Sleigh-Team</h3>
                    <p class="text-gray-600 text-lg text-pretty">Easily share your wishlist with a group using only a single, magic link.</p>
                </div>
            </div>
            <div class="space-y-4 max-w-xs mx-auto">
                <div class="border border-sky-900/10 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-2" style="background: repeating-linear-gradient(45deg, var(--color-red-200), var(--color-red-200) 10px, white 10px, white 20px);">
                        <div class="bg-white border border-gray-200 rounded-xl p-2 overflow-hidden">
                            <img loading="lazy" width="324" height="324" src="/img/features/wishlists.jpg" alt="" class="w-full h-auto rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="text-center space-y-2 text-balance">
                    <h3 class="text-2xl font-bold text-sky-900">See Everyone's List, Yule Love It</h3>
                    <p class="text-gray-600 text-lg text-pretty">Automatically see the wishlists of everyone in your group. No more duplicates!</p>
                </div>
            </div>
            <div class="space-y-4 max-w-xs mx-auto">
                <div class="border border-sky-900/10 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-2" style="background: repeating-linear-gradient(45deg, var(--color-red-200), var(--color-red-200) 10px, white 10px, white 20px);">
                        <div class="bg-white border border-gray-200 rounded-xl p-2 overflow-hidden">
                            <img loading="lazy" width="324" height="324" src="/img/features/comment.jpg" alt="" class="w-full h-auto rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="text-center space-y-2 text-balance">
                    <h3 class="text-2xl font-bold text-sky-900">Keep Things Under Wraps</h3>
                    <p class="text-gray-600 text-lg text-pretty">Leave anonymous comments to clarify gift details and keep everyone on the same page.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 px-4 relative overflow-hidden bg-sky-50">
    <div class="container mx-auto max-w-4xl">
    <div class="bg-white rounded-3xl p-12 md:p-16 text-center space-y-6 border border-sky-400/20" style="box-shadow: 0 10px 40px -5px hsl(197 71% 73% / 0.25)">
        <h2 class="text-4xl md:text-5xl font-bold text-balance">Ready to <span class="text-red-500">sleigh</span> your gift exchange?</h2>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto text-balance">You don't even need an account to get started. Build your first wishlist for free and see how easy it is.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
        <x-button-danger href="{{ route('guests.wishlists.show') }}" class="!px-12 !py-4 !text-lg">Start Building Your Wishlist</x-button-danger>
        </div>
        <p class="text-sm text-gray-500 pt-2">❄️ No credit card required • Free forever • Set up in 2 minutes</p>
    </div>
    </div>
</section>
</x-layout.marketing>
