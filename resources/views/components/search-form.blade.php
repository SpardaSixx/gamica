<section class="search mb-5 position-relative">
    <h2 class="text-center mb-3">Keress {{$totalItems}} tétel között!</h2>

    <form action="{{route('search')}}" method="get" class="text-center mb-3">
        @csrf
        <div class="search-kit d-inline-block">
            <input type="text" name="query" id="query" class="form-control w-auto d-inline-block input-dark" placeholder="Keresés..." value="{{ isset($_GET['query']) ? $_GET['query'] : '' }}">

            <select id="query-category" name="query-category" class="form-control w-auto d-inline-block input-dark">
                <option value='all' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'all' ? 'selected' : '' }}>Mindenhol</option>
                <option value='sales' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'sales' ? 'selected' : '' }}>Eladó játékok</option>
                <option value='consoles' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'consoles' ? 'selected' : '' }}>Eladó konzolok</option>
                <option value='accessories' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'accessories' ? 'selected' : '' }}>Eladó kiegészítők</option>
                <option value='packs' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'packs' ? 'selected' : '' }}>Eladó csomagok</option>
                <option value='wanteds' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'wanteds' ? 'selected' : '' }}>Kérések</option>
                <option value='games' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'games' ? 'selected' : '' }}>Gyűjtemény játékok</option>
                <option value='series' {{ isset($_GET['query-category']) && $_GET['query-category'] == 'series' ? 'selected' : '' }}>Sorozatok</option>
            </select>

            <button class="form-control w-auto d-inline-block input-dark">
                <span class="material-symbols-outlined">
                    search
                </span>
            </button>
        </div>
    </form>
</section>