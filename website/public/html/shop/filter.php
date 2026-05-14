<section>
    <div
        id="filters"
        class="filterDisabled
        col-12 col-sm-6 col-md-4 col-lg-6 col-xxl-4 mt-2"
    >
        <div
            class="card bg-white"
        >
            <div
                class="card-body"
            >
                <p
                    class="mb-3 fw-bold h6"
                >
                    Filtry
                </p>
                <input
                    type="text"
                    id="filterName"
                    class="form-control bg-light mb-2"
                    placeholder="Szukaj po nazwie..."
                >
                <input
                    type="number"
                    id="filterMin"
                    class="form-control bg-light mb-2"
                    step=0.01
                    placeholder="Cena minimalna"
                >
                <input
                    type="number"
                    id="filterMax"
                    class="form-control bg-light mb-3"
                    step=0.01
                    placeholder="Cena maksymalna"
                >
                <hr>
                <p
                    class="mb-3 fw-bold h6"
                >
                    Zaznacz kategorie
                </p>

                <div
                    class="row justify-content-center mb-1 gap-4"
                >
                    <button
                        id="filterIsAvailable"
                        class="btn btn-info opacity-50 col-5 h-100 mb-2"
                    >
                        Dostępne
                    </button>
                    <button 
                        id="filterIsDiscounted"
                        class="btn btn-info opacity-50 col-5 h-100"
                    >
                        Promocje
                    </button>
                </div>

                <div
                    class="row justify-content-center mb-4 gap-lg-4"
                >
                    <button
                        id="filterFood"
                        class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                    >
                        Jedzenie
                    </button>
                    <button
                        id="filterDrink"
                        class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                    >
                        Napoje
                    </button>
                    <button
                        id="filterSchool"
                        class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                    >
                        Szkoła
                    </button>
                </div>

                <button
                        id="resetFiltersBtn"
                        class="btn btn-danger col-8 offset-2"
                    >
                        Reset
                </button>

            </div>
        </div>
    </div>
</section>