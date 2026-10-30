<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIX ID - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
        .bg-tix-gold { background-color: #FFBE00; }
        .text-tix-gold { color: #FFBE00; }
        
        /* Custom Utilities untuk menyesuaikan font navigasi */
        .nav-link {
            font-weight: 800; /* Extra Bold */
            color: #1A2C50;
            font-size: 1.1rem;
            letter-spacing: 0.05em;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #FFBE00;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased">

    <nav class="bg-white shadow-sm fixed w-full z-50 top-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24 items-center">
                
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-1">
                        <span class="text-5xl font-black text-tix-dark tracking-tighter">TIX</span>
                        <span class="text-5xl font-black text-tix-gold tracking-tighter">ID</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-12 items-center">
                    <a href="/" class="nav-link">HOME</a>
                    <a href="#" class="nav-link">TIX NOW</a>
                    <a href="#" class="nav-link">CAREERS</a>
                </div>

                <div class="flex items-center gap-6">
                    <div class="hidden lg:flex items-center gap-4 text-tix-dark text-lg">
                        <a href="#" class="hover:text-tix-gold transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-tix-gold transition"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="hover:text-tix-gold transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-tix-gold transition"><i class="fab fa-twitter"></i></a>
                    </div>

                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ route('user.home') }}" class="text-tix-dark font-bold hover:underline">
                                Buka Aplikasi <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-tix-gold text-tix-dark px-8 py-3 rounded-full font-bold hover:opacity-90 transition uppercase tracking-wide text-sm">
                                Masuk / Daftar
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <div class="h-24"></div>

    <div class="pt-8 pb-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative w-full h-[200px] sm:h-[350px] md:h-[450px] rounded-2xl overflow-hidden shadow-xl group" id="hero-carousel">
                
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100" data-carousel-item>
                    <img src="https://asset.tix.id/microsite_v2/b93ca0cd-637e-4087-8346-34acc368c4c8.webp" class="absolute block w-full h-full object-cover" alt="Banner 1">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>

                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="https://asset.tix.id/microsite_v2/b9343c43-903b-49fc-8c5b-88a5be73ecb9.webp" class="absolute block w-full h-full object-cover" alt="Banner 2">
                </div>

                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="https://asset.tix.id/microsite_v2/f5e67eac-f954-4352-8fcb-2dd289a9b887.webp" class="absolute block w-full h-full object-cover" alt="Banner 3">
                </div>

                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0" data-carousel-item>
                    <img src="https://assets.tix.id/tix-events/junjiitoindonesia/7b06e084-b6a4-41ee-9f8e-13fba3f4bb1a.webp" class="absolute block w-full h-full object-cover" alt="Banner 4">
                </div>

                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" onclick="prevSlide()">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none transition-all opacity-0 group-hover:opacity-100">
                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" onclick="nextSlide()">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none transition-all opacity-0 group-hover:opacity-100">
                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
                
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full bg-white" aria-current="true" aria-label="Slide 1" onclick="showSlide(0)"></button>
                    <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white" aria-current="false" aria-label="Slide 2" onclick="showSlide(1)"></button>
                    <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white" aria-current="false" aria-label="Slide 3" onclick="showSlide(2)"></button>
                    <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white" aria-current="false" aria-label="Slide 4" onclick="showSlide(3)"></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('[data-carousel-item]');
        const totalSlides = slides.length;
        const indicators = document.querySelectorAll('[aria-label^="Slide"]');

        function showSlide(index) {
            // Reset semua slide ke opacity 0
            slides.forEach((slide) => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
            });

            // Reset indikator
            indicators.forEach((dot) => {
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/50');
            });

            // Tampilkan slide yang aktif
            slides[index].classList.remove('opacity-0');
            slides[index].classList.add('opacity-100');
            
            // Highlight indikator aktif
            indicators[index].classList.remove('bg-white/50');
            indicators[index].classList.add('bg-white');

            currentSlide = index;
        }

        function nextSlide() {
            let next = (currentSlide + 1) % totalSlides;
            showSlide(next);
        }

        function prevSlide() {
            let prev = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prev);
        }

        // Auto slide setiap 5 detik
        setInterval(nextSlide, 5000);
    </script>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-tix-dark mb-8 uppercase tracking-wide">
                NOW SHOWING IN CINEMAS
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($movies->take(4) as $movie)
                <div class="group relative">
                    <div class="relative overflow-hidden rounded-2xl mb-4">
                        <img src="{{ asset('storage/' . $movie->poster) }}" 
                             alt="{{ $movie->title }}" 
                             class="w-full aspect-[2/3] object-cover rounded-2xl transition transform group-hover:scale-105 duration-500">
                        
                        <a href="{{ route('login') }}" class="absolute inset-0 z-10"></a>
                    </div>
                    
                    <h3 class="font-bold text-md text-tix-dark uppercase leading-snug">
                        {{ $movie->title }}
                    </h3>
                </div>
                @empty
                <div class="col-span-full text-center py-10 text-gray-400">Belum ada film yang ditambahkan Admin.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="py-16 bg-gray-50 border-t">
        <div class="max-w-7xl mx-auto px-4">
            
            <h2 class="text-2xl md:text-3xl font-bold text-tix-dark mb-8 uppercase tracking-wide">
                SPOTLIGHT
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($spotlights as $promo)
                <a href="{{ route('login') }}" class="block group cursor-pointer">
                    
                    <div class="rounded-xl overflow-hidden mb-4 shadow-sm group-hover:shadow-md transition-all duration-300">
                        <img src="{{ asset('storage/' . $promo->banner) }}" 
                             alt="{{ $promo->title }}" 
                             class="w-full aspect-video object-cover transition transform group-hover:scale-105 duration-500">
                    </div>

                    <div class="pr-2">
                        <h3 class="font-bold text-lg text-tix-dark leading-snug mb-1 group-hover:text-yellow-600 transition-colors">
                            {{ $promo->title }}
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                            {{ $promo->description }}
                        </p>
                    </div>

                </a>
                @empty
                <div class="col-span-3 text-center text-gray-400 py-10">Belum ada promo aktif.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="py-16 bg-[#003B72] text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            
            <h2 class="text-3xl font-bold mb-10 uppercase tracking-wide">VIDEO & TRAILERS</h2>

            @php
                $trailers = [
                    [
                        'id' => 'zffO-1DjL3E', // ID Youtube Avengers (Contoh)
                        'title' => 'Penunggu Rumah: Buto Ijo Official Teaser Trailer',
                        'thumbnail' => 'data:image/jpeg;base64,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' 
                    ],
                    [
                        'id' => 'wSTPViJG2u0', // ID Youtube Spiderman (Contoh)
                        'title' => 'Malam 3 Yasinan - Teaser Trailer',
                        'thumbnail' => 'data:image/jpeg;base64,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'
                    ],
                    [
                        'id' => 'Yd9pqMem-w', // ID Youtube Inception (Contoh)
                        'title' => 'BEHIND THE SCENE | LEGENDA KELAM MALIN KUNDANG',
                        'thumbnail' => 'data:image/jpeg;base64,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'
                    ]
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                @foreach($trailers as $trailer)
                <div class="group cursor-pointer" onclick="openVideoModal('{{ $trailer['id'] }}')">
                    <div class="relative overflow-hidden rounded-xl mb-4 shadow-lg">
                        <img src="{{ $trailer['thumbnail'] }}" alt="{{ $trailer['title'] }}" class="w-full h-56 object-cover transition transform group-hover:scale-105 duration-500 opacity-90 group-hover:opacity-100">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-10 transition"></div>

                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-white group-hover:scale-110 transition duration-300">
                                <i class="fas fa-play text-white text-xl ml-1"></i>
                            </div>
                        </div>
                    </div>

                    <h3 class="font-bold text-lg leading-snug group-hover:text-tix-gold transition-colors">
                        {{ $trailer['title'] }}
                    </h3>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between mt-10 px-2">
                <button class="w-10 h-10 rounded-full border border-white flex items-center justify-center hover:bg-white hover:text-[#003B72] transition">
                    <i class="fas fa-arrow-left"></i>
                </button>
                
                <div class="flex space-x-2 items-center">
                    <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
                    <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
                    <span class="w-2 h-2 bg-white rounded-full"></span> <span class="w-2 h-2 bg-white rounded-full opacity-50"></span>
                </div>

                <button class="w-10 h-10 rounded-full border border-white flex items-center justify-center hover:bg-white hover:text-[#003B72] transition">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="videoModal" class="fixed inset-0 z-[100] hidden bg-black bg-opacity-90 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300">
        <div class="relative w-full max-w-5xl aspect-video bg-black rounded-lg overflow-hidden shadow-2xl">
            <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-50 text-white hover:text-red-500 transition transform hover:rotate-90">
                <i class="fas fa-times text-3xl"></i>
            </button>
            
            <iframe id="youtubeFrame" class="w-full h-full" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <script>
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('youtubeFrame');

        function openVideoModal(videoId) {
            // Set URL Youtube dengan Autoplay
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
            
            // Tampilkan Modal
            modal.classList.remove('hidden');
            // Sedikit delay untuk animasi fade-in (opsional)
            setTimeout(() => {
                modal.classList.remove('opacity-0');
            }, 50);
        }

        function closeVideoModal() {
            // Sembunyikan Modal
            modal.classList.add('opacity-0'); // Efek fade out bisa ditambahkan via CSS classes
            modal.classList.add('hidden');
            
            // Hentikan Video (Reset Source)
            iframe.src = '';
        }

        // Close modal jika klik di luar video area
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeVideoModal();
            }
        });
        
        // Close modal dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeVideoModal();
            }
        });
    </script>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            
            <h2 class="text-3xl font-bold text-tix-dark mb-10 uppercase tracking-wide">OUR FEATURES</h2>

            <div class="relative group">
                
                <div class="overflow-hidden rounded-xl">
                    <div id="featureTrack" class="flex transition-transform duration-500 ease-in-out">
                        
                        <div class="w-full md:w-1/2 flex-shrink-0 px-2">
                            <img src="https://asset.tix.id/wp-content/uploads/2022/01/feature4.webp" 
                                 class="w-full h-auto object-cover rounded-xl shadow-md hover:shadow-xl transition" alt="Feature 1">
                        </div>

                        <div class="w-full md:w-1/2 flex-shrink-0 px-2">
                            <img src="https://asset.tix.id/wp-content/uploads/2022/01/feature1.webp" 
                                 class="w-full h-auto object-cover rounded-xl shadow-md hover:shadow-xl transition" alt="Feature 2">
                        </div>

                        <div class="w-full md:w-1/2 flex-shrink-0 px-2">
                            <img src="https://asset.tix.id/wp-content/uploads/2022/01/feature3.webp" 
                                 class="w-full h-auto object-cover rounded-xl shadow-md hover:shadow-xl transition" alt="Feature 3">
                        </div>

                        <div class="w-full md:w-1/2 flex-shrink-0 px-2">
                            <img src="https://asset.tix.id/wp-content/uploads/2022/01/feature4.webp" 
                                 class="w-full h-auto object-cover rounded-xl shadow-md hover:shadow-xl transition" alt="Feature 4">
                        </div>

                    </div>
                </div>

                <button onclick="moveFeature(-1)" class="absolute top-1/2 -left-4 md:-left-12 transform -translate-y-1/2 w-12 h-12 rounded-full border border-gray-300 bg-white text-tix-dark flex items-center justify-center hover:bg-gray-50 shadow-sm z-20 group-hover:scale-110 transition">
                    <i class="fas fa-arrow-left text-lg"></i>
                </button>
                <button onclick="moveFeature(1)" class="absolute top-1/2 -right-4 md:-right-12 transform -translate-y-1/2 w-12 h-12 rounded-full border border-gray-300 bg-white text-tix-dark flex items-center justify-center hover:bg-gray-50 shadow-sm z-20 group-hover:scale-110 transition">
                    <i class="fas fa-arrow-right text-lg"></i>
                </button>
            </div>

            <div class="flex justify-center mt-8 space-x-2" id="featureDots">
                <button onclick="goToFeature(0)" class="w-3 h-3 rounded-full bg-tix-dark transition-all"></button>
                <button onclick="goToFeature(1)" class="w-3 h-3 rounded-full bg-gray-300 transition-all"></button>
                <button onclick="goToFeature(2)" class="w-3 h-3 rounded-full bg-gray-300 transition-all"></button>
                </div>

            <div class="mt-16 text-center">
                <h3 class="text-xl md:text-2xl font-bold text-tix-dark max-w-4xl mx-auto leading-relaxed mb-10 uppercase">
                    ENJOY THE BEST MOVIE AND ENTERTAINMENT, KEEP UP TO DATE WITH THE LATEST NEWS, AND GET ATTRACTIVE DEALS AND PROMOS!
                </h3>
                
                <div class="flex flex-col md:flex-row justify-center items-center gap-5">
                    <a href="https://apps.apple.com/id/app/tix-id/id1362497752" class="bg-[#1A2C50] text-white px-8 py-3 rounded-lg flex items-center gap-4 hover:opacity-90 transition transform hover:-translate-y-1 shadow-lg min-w-[200px]">
                        <i class="fab fa-apple text-3xl"></i>
                        <div class="text-left">
                            <div class="text-[10px] uppercase tracking-wider opacity-80">Download on the</div>
                            <div class="text-lg font-bold leading-none">App Store</div>
                        </div>
                    </a>
                    
                    <a href="https://play.google.com/store/apps/details?id=id.tix.android&hl=en&gl=US" class="bg-[#1A2C50] text-white px-8 py-3 rounded-lg flex items-center gap-4 hover:opacity-90 transition transform hover:-translate-y-1 shadow-lg min-w-[200px]">
                        <i class="fab fa-google-play text-2xl"></i>
                        <div class="text-left">
                            <div class="text-[10px] uppercase tracking-wider opacity-80">GET IT ON</div>
                            <div class="text-lg font-bold leading-none">Google Play</div>
                        </div>
                    </a>

                    <a href="https://appgallery.huawei.com/app/C103306207" class="bg-[#1A2C50] text-white px-8 py-3 rounded-lg flex items-center gap-4 hover:opacity-90 transition transform hover:-translate-y-1 shadow-lg min-w-[200px]">
                        <i class="fas fa-shopping-bag text-2xl"></i>
                        <div class="text-left">
                            <div class="text-[10px] uppercase tracking-wider opacity-80">EXPLORE IT ON</div>
                            <div class="text-lg font-bold leading-none">AppGallery</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        let featureIndex = 0;
        const track = document.getElementById('featureTrack');
        const dots = document.getElementById('featureDots').children;
        const totalItems = 4; // Total Gambar
        
        function getItemsPerView() {
            // Desktop: 2 Gambar, Mobile: 1 Gambar
            return window.innerWidth >= 768 ? 2 : 1; 
        }

        function updateSlider() {
            const itemsPerView = getItemsPerView();
            // Total slides = Total Items / Items Per View (dibulatkan ke atas)
            const totalSlides = Math.ceil(totalItems / itemsPerView); 
            const maxIndex = totalSlides - 1;
            
            if (featureIndex < 0) featureIndex = 0;
            if (featureIndex > maxIndex) featureIndex = maxIndex;

            // Geser track 100% per slide (satu slide berisi kumpulan itemsPerView)
            const translateValue = -(featureIndex * 100); 
            track.style.transform = `translateX(${translateValue}%)`;

            // Update Dots
            for (let i = 0; i < dots.length; i++) {
                // Tampilkan dot sesuai jumlah halaman slide
                if (i < totalSlides) {
                    dots[i].style.display = 'inline-block';
                    if (i === featureIndex) {
                        dots[i].classList.remove('bg-gray-300');
                        dots[i].classList.add('bg-tix-dark');
                        dots[i].style.width = '24px'; 
                    } else {
                        dots[i].classList.remove('bg-tix-dark');
                        dots[i].classList.add('bg-gray-300');
                        dots[i].style.width = '12px';
                    }
                } else {
                    dots[i].style.display = 'none';
                }
            }
        }

        function moveFeature(direction) {
            featureIndex += direction;
            updateSlider();
        }

        function goToFeature(index) {
            featureIndex = index;
            updateSlider();
        }

        window.addEventListener('resize', () => {
            featureIndex = 0; // Reset ke awal saat resize window agar layout tidak rusak
            updateSlider();
        });
        
        updateSlider();
    </script>

<div class="py-16 bg-white pb-24"> <div class="max-w-7xl mx-auto px-4">
            
            <h2 class="text-3xl font-bold text-tix-dark mb-12 uppercase tracking-wide">OUR PARTNERS</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-12 gap-x-8 items-center justify-items-center">
                
                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/xxi-300x72.png" 
                         alt="Cinema XXI" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/dana-300x72.png" 
                         alt="DANA" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/cgv-300x72.png" 
                         alt="CGV" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/cinepolis-300x72.png" 
                         alt="Cinepolis" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>


                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/vidio-300x72.png" 
                         alt="Vidio" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/viu-300x72.png" 
                         alt="Viu" class="h-8 md:h-11 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/bioskoponline-300x72.png" 
                         alt="Bioskop Online" class="h-10 md:h-12 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/cacthplay-300x72.png" 
                         alt="Catchplay+" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>


                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/genflix-300x72.png" 
                         alt="Genflix" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2022/01/sushiroll-300x72.png" 
                         alt="Sushiroll" class="h-8 md:h-12 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2025/10/Vision-logo-black-600x110.png" 
                         alt="Vision+" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

                <div class="w-full flex justify-center">
                    <img src="https://asset.tix.id/wp-content/uploads/2023/10/wetv-1-300x72.png" 
                         alt="WeTV" class="h-8 md:h-10 object-contain grayscale hover:grayscale-0 transition duration-300">
                </div>

            </div>
        </div>
    </div>
<footer class="bg-[#1A2C50] text-white pt-16 pb-10 border-t border-[#2B3F6B]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">
                
                <div class="md:col-span-4 lg:col-span-5 pr-8">
                    <a href="/" class="flex items-center gap-1 mb-6">
                        <span class="text-5xl font-black text-white tracking-tighter">TIX</span>
                        <span class="text-5xl font-black text-[#FFBE00] tracking-tighter">ID</span>
                    </a>
                    <p class="text-white text-sm leading-relaxed font-normal">
                        Best App For Movie Lovers In Indonesia! Movie Entertainment Platform From Cinema To Online Movie Streaming Selections.
                    </p>
                </div>

                <div class="md:col-span-2 lg:col-span-2">
                    <ul class="space-y-3 text-sm font-bold tracking-wide text-white">
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">NOW SHOWING</a></li>
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">TIX NOW</a></li>
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">SPOTLIGHT</a></li>
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">VIDEO & TRAILERS</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3 lg:col-span-2">
                    <ul class="space-y-3 text-sm font-bold tracking-wide text-white">
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">CAREERS</a></li>
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">CONTACT US</a></li>
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">PRIVACY POLICY</a></li>
                        <li><a href="#" class="hover:text-[#FFBE00] transition duration-300">TERMS & CONDITIONS</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3 lg:col-span-3">
                    <h4 class="font-bold text-sm mb-2 text-white">TIX ID SUPPORT</h4>
                    <p class="text-sm text-white mb-8 font-semibold hover:text-[#FFBE00] transition cursor-pointer">E-MAIL : HELP@TIX.ID</p>

                    <h4 class="font-bold text-sm mb-4 text-white">FOLLOW US</h4>
                    <div class="flex space-x-6 text-xl text-white">
                        <a href="#" class="hover:text-[#FFBE00] transition transform hover:scale-110"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-[#FFBE00] transition transform hover:scale-110"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="hover:text-[#FFBE00] transition transform hover:scale-110"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-[#FFBE00] transition transform hover:scale-110"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

            </div>
            
            <div class="text-center text-xs font-medium text-white pt-8">
                2025 TIX ID - PT NUSANTARA ELANG SEJAHTERA. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

</body>
</html>