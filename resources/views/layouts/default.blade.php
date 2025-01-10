<!doctype html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="gamica, game, játék, játékok, videójáték, videójátékok, eladó, eladás, adás, vétel, csere, gyűjtő, gyűjtemény, konzol, playstation, ps, xbox, nintendo, gameboy, sega">
    <meta name="description" content="Videójáték gyűjtemények, adás-vétel, csere!">
    <meta name="author" content="hhtps://gamica.hu">
    <link rel="icon" href="https://gamica.hu/img/favicon.svg"> 

    <meta property="og:title" content="{{isset($pageTitle) ? $pageTitle : 'Gamica'}}" />
    <meta property="og:description" content="Videójáték gyűjtemények, adás-vétel, csere!"/>
    <meta property="og:image" content="{{isset($ogImage) ? $ogImage : 'https://gamica.hu/img/gamica_og_default.png'}}" />

    <title>{{isset($pageTitle) ? $pageTitle : 'Gamica'}}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&family=Titillium+Web:wght@300&display=swap" rel="stylesheet">

    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- FontAwesome 5.7 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- FancyBox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

    <!-- OwlCarousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- TomSelect -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <!-- CSS -->
    <link href="/css/style.css" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4YF9JYGMFJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-4YF9JYGMFJ');
    </script>

    <!-- Cookie Consent -->
    <script src="https://cdn.websitepolicies.io/lib/cconsent/cconsent.min.js" defer></script><script>window.addEventListener("load",function(){window.wpcb.init({"border":"thin","corners":"small","colors":{"popup":{"background":"#222222","text":"#ffffff","border":"#fff"},"button":{"background":"#630900","text":"#EEEEEE"}},"content":{"href":"https://gdprmost.hu/cookie-tajekoztato","message":"Az oldal sütiket használ a felhasználói élmény fokozása érdekében.","link":"További inormáció","button":"Elfogadom"}})});</script>
  </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="/img/logo.svg" style="height: 3rem;">
                        Gamica<small style="font-size: .75rem; color: #a73737;">BETA</small>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownGames" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Gyűjtemény
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownGames">
                                    <li>
                                        <a class="dropdown-item" href="/collections/games">Játékok</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/collections/series">Sorozatok</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSales" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Piactér
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownSales">
                                    <li>
                                        <a class="dropdown-item" href="/sales/games">Játékok</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/consoles">Konzolok</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/accessories">Kiegészítők</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/packs">Csomagok</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true" style="color: #666;">
                                            Licit - <small>Hamarosan!</small>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/wanteds">Kérések</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users.index') }}">Tagok</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownWiki" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Wiki
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownWiki">
                                    <li>
                                        <a class="dropdown-item" href="/wiki/platforms">Konzolok</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/wiki/general">Általános</a>
                                    </li>
                                </ul>
                            </li>

                            @if(Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" style="color: #a73737 !important;" href="#" id="navbarDropdownAdd" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Létrehozás
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownAdd">

                                    <li>
                                        <a class="dropdown-item" href="/collections/games/create">Gyűjtemény játék</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/collections/series/create">Gyűjtemény sorozat</a>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/games/create">Eladó játék</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/consoles/create">Eladó konzol</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/accessories/create">Eladó kiegészítő</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="/sales/packs/create">Eladó csomag</a>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <li>
                                        <a class="dropdown-item" href="/wanteds/create">Kérés</a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>

                        <ul class="navbar-nav ms-auto">
                            @if(Auth::check())

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if($unreadMessages > 0)
                                    <span class="notifications badge bg-danger">{{$unreadMessages}}</span>
                                    @endif
                                    Profilom
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->getRank->id == 3)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.index') }}">Admin</a>
                                    </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item" href="{{ route('messages.index') }}">
                                            @if($unreadMessages > 0)
                                            <span class="notifications badge bg-danger">{{$unreadMessages}}</span>
                                            @endif
                                            Üzenetek
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">Megtekintés</a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">Szerkesztés</a>
                                    </li>

                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">Kilépés</a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Belépés</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Regisztráció</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="pt-5">
            @yield('mainsearch')
            <div class="container">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                @yield('content')
            </div>
            @yield('recommendfromuser')
            @yield('recommendfromplatform')
        </main>

        <div class="bottom-section p-5">
            <h2>Tetszik a Gamica?</h2>
            <h3 class="mb-3">Kövess közösségi médiában is, hogy biztosan elérjenek hozzád a játékok!</h3>

            <a href="https://www.facebook.com/gamica.official.page" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                    <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/>
                </svg>
            </a>

            <a href="https://www.instagram.com/gamica_official" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                </svg>
            </a>

            <a href="https://www.tiktok.com/@gamica_official" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/>
                </svg>
            </a>
        </div>

        <footer class="p-3">
            <div class="row">
                <div class="col-12 col-lg-2 text-start">
                    <a href="/sales/games" class="d-block">Eladó játékok</a>
                    <a href="/sales/consoles" class="d-block">Eladó konzolok</a>
                    <a href="/sales/accessories" class="d-block">Eladó kiegészítők</a>
                    <a href="/sales/packs" class="d-block">Eladó csomagok</a>
                </div>

                <div class="col-12 col-lg-2 text-start">
                    <a href="/wanteds" class="d-block">Kérések</a>
                    <a href="/collections/games" class="d-block">Játékok</a>
                    <a href="/collections/series" class="d-block">Sorozatok</a>
                </div>

                <div class="col-12 col-lg-4 text-center">
                    <span>Gamica {{ now()->year }}<br>Minden jog fenntartva!</span>
                </div>

                <div class="col-12 col-lg-4 text-end">
                    <a href="https://gdprmost.hu/cookie-tajekoztato" target="_blank" class="d-block">Sütik</a>
                    <a href="/docs/aszf.pdf" target="_blank" class="d-block">ÁSZF</a>
                    <a href="/docs/adatkezelesi.pdf" target="_blank" class="d-block">Adatkezelés</a>
                </div>
            </div>
        </footer>
        
        <div id="scripts">
            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

            <!-- FancyBox -->
            <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

            <!-- OwlCarousel -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

            <!--CKEditor -->
            <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

            <!-- TomSelect -->
            <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

            <!-- Local JS -->
            <script src="/js/app.js"></script>
        </div>

        <!-- Inlinle JS -->
        <script>
            function confirmDelete() {
                if (confirm('Biztosan törölni akarod?'))
                {
                    console.log('Delete prevented!');
                } else {
                    event.preventDefault()
                }
            }
        </script>
    </body>
</html>

