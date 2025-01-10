@extends('layouts.default')

@section('content')
    <!-- Általános tudnivalók -->
    <h2 class="entity-title">Általános tudnivalók</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <p class="m-0">A Gamica egy játékosoknak és gyűjtőknek létrehozott tér, ahol kedvedre böngészhetsz mások játékai, gyűjteményei között, vagy akár te magad is feltöltheted eladásra szánt játékod, konzolod vagy kiegészítőd. Maga az adás-vétel NEM az oldalon keresztül zajlik - csupán a kapcsolatfelvételben segít! Ha csak rendszerbe szednéd gyűjteményed vagy közszemlére tennéd, akkor is a megfelelő helyen jársz!</p>
    </section>

    <h2 class="entity-title">Gyűjtemény</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <h4 class="m-0">Játékok</h4>
        <p>Lehetőséged van gyűjteményed darabjait egyesével feltölteni részletes információkkal, képpel. </p>
    
        <h4 class="m-0">Sorozatok</h4>
        <p>Gyűjteménybe szedheted a feltöltött játékaid, amiben egyesíted egy adott széria darabjait vagy akár csak a tematika szerinti példányokat (pl.: összes FIFA vagy FPS játékaim).</p>
    </section>

    <h2 class="entity-title">Piactér</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <h4 class="m-0">Játék</h4>
        <p>Ide kerülnek az eladásra szánt játékok. Feltöltésnél azokat az információkat adhatod meg, amiket a gyűjtemény játéknál is, plusz az adás-vételhez tartozó kiegészítő adatokat. Az adás-vételeknél lehetőséged van több képet is feltölteni az adott termékről.</p>

        <h4 class="m-0">Konzol és kiegészítő</h4>
        <p>Hasonlóan az előzőhöz, itt tudod meghirdetni eladó konzoljaid és/vagy kiegészítőid (pl.: kontroller, egyéb tartozékok). Érdemes több képet feltölteni, hogy kielégítő legyen az állapot kommunikálása!</p>

        <h4 class="m-0">Csomag</h4>
        <p>Itt egy picit egyszerűbb a dolgod, hiszen nem szükséges részletes leírást adni a termékről, mert nem is csak egy termékről van szó, hanem több darabról egy csomagban - ha nem akarnád külön-külön feltöltögetni őket (pl.: Eladó PS4 játékaim). Itt is érdemes több képet feltölteni az eladó termékekről akár külön-külön!</p>
    </section>

    <h2 class="entity-title">Kérések</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <p class="m-0">Az itt található játékokat keresi a feltöltő. Ha szeretnél megkaparintani egy játékot, itt tudod közölni részletes elvárásaiddal.  Ha azonban olyat látsz itt, ami neked megvan és meg is válnál tőle, a vételi szándék helyett itt azt van lehetőséged jelezni a feltöltő felé, hogy tudsz rajta segíteni.</p>
    </section>

    {{-- <h2 class="entity-title">Segítség</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <p class="m-0">Itt bárki felteheti a kérdését bármivel kapcsolatban - azokra pedig bárki válaszolhat, ha kompetensnek érzi magát a témában (pl. értékekkel, árazással, részletekkel, állapottal kapcsolatban).</p>
    </section> --}}

    <h2 class="entity-title">Tagok</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <p class="m-0">A már regisztrált tagok listája és tapasztalati szintjük. A tagok profilján megtekinthetőek az általa feltöltött tartalmak - legyen az játék, eladó konzol vagy kérés.</p>
    </section>

    <h2 class="entity-title">Rankok</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <p class="m-0">A tagok rankokat kapnak a megszerzett XP (Tapasztalati Pont) után. XP-t szerezni tartalomfeltöltéssel lehet - egy feltöltés +10 XP, de bónusz is járhat bizonyos esetekben!</p>
        <p class="m-0">A rankok a következők lehetnek:</p>
        <ul>
            <li>Újonc: Az alap rank, ami regisztráció után jár.</li>
            <li>Bronz tag: 10 és 2499 XP között</li>
            <li>Ezüst tag: 2500 és 4999 XP között</li>
            <li>Arany tag: 5000 és 7499 XP között</li>
            <li>Platina tag: 7500 és 9999 XP között</li>
            <li>Gyémánt tag: 10000 XP fölött</li>
        </ul>
    </section>

    {{-- <h2 class="entity-title">Hírfolyam</h2>
    <section class="highlighted darkbg mb-5 p-3">
        <p class="m-0">A hírfolyamon láthatod a rendszer eseményeit, illetve posztolhatsz is, ha közérdekű gondolatod támadna. Ha segítségre van szükséged valamihez, használd inkább a <a href="/contact" style="color:#eee; font-style: italic;">Kapcsolat</a> oldalt!</a></p>
    </section> --}}

    @if(Auth::check() && !Auth::user()->read_wiki)
        <a href="{{route('general-wiki-read', Auth::id())}}" class="btn btn-red d-block my-2 mx-auto px-4" style="width:fit-content";>Értem</a>
    @endif

    <br>
@stop
