import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import Header from '../components/Header';
import Hero from '../components/Hero';

import { getCategories } from '../api/categories';
import { getMedicines } from '../api/medicines';

function Home() {

    const navigate = useNavigate();

    const [categories, setCategories] = useState([]);
    const [loadingCategories, setLoadingCategories] = useState(true);

    const [medicines, setMedicines] = useState([]);
    const [loadingMedicines, setLoadingMedicines] = useState(true);


    // =========================
    // LOAD CATEGORIES
    // =========================

    useEffect(() => {

        const fetchCategories = async () => {

            try {

                const data = await getCategories();

                setCategories(data);

            } catch (error) {

                console.error(
                    'Erreur lors du chargement des catégories:',
                    error
                );

            } finally {

                setLoadingCategories(false);

            }

        };

        fetchCategories();

    }, []);


    // =========================
    // LOAD MEDICINES
    // =========================

    useEffect(() => {

        const fetchMedicines = async () => {

            try {

                const data = await getMedicines();

                setMedicines(data);

            } catch (error) {

                console.error(
                    'Erreur lors du chargement des médicaments:',
                    error
                );

            } finally {

                setLoadingMedicines(false);

            }

        };

        fetchMedicines();

    }, []);


    // =========================
    // AUTOMATIC CATEGORY SLIDER
    // =========================

    useEffect(() => {

        const slider = document.querySelector(
            '.categories-slider'
        );

        if (!slider) return;

        let interval;


        const startSlider = () => {

            clearInterval(interval);

            interval = setInterval(() => {

                const maxScroll =
                    slider.scrollWidth - slider.clientWidth;


                if (
                    slider.scrollLeft >=
                    maxScroll - 10
                ) {

                    slider.scrollTo({
                        left: 0,
                        behavior: 'smooth',
                    });

                } else {

                    slider.scrollBy({
                        left: 300,
                        behavior: 'smooth',
                    });

                }

            }, 3000);

        };


        const stopSlider = () => {

            clearInterval(interval);

        };


        // Start automatic sliding

        startSlider();


        // Stop when mouse enters

        slider.addEventListener(
            'mouseenter',
            stopSlider
        );


        // Start again when mouse leaves

        slider.addEventListener(
            'mouseleave',
            startSlider
        );


        return () => {

            clearInterval(interval);

            slider.removeEventListener(
                'mouseenter',
                stopSlider
            );

            slider.removeEventListener(
                'mouseleave',
                startSlider
            );

        };

    }, [categories]);


    // =========================
    // CATEGORY SLIDER BUTTONS
    // =========================

    const scrollCategories = (amount) => {

        const slider = document.querySelector(
            '.categories-slider'
        );

        if (!slider) return;

        slider.scrollBy({
            left: amount,
            behavior: 'smooth',
        });

    };


    return (

        <div className="app">

            {/* HEADER */}

            <Header />


            <main>

                {/* =========================
                    HERO
                ========================= */}

                <Hero />


                {/* =========================
                    CATEGORIES
                ========================= */}

                <section className="categories-section">

                    <div className="section-header">

                        <h2>
                            Nos catégories
                        </h2>


                        <div className="slider-buttons">

                            <button
                                className="slider-btn"
                                onClick={() =>
                                    scrollCategories(-300)
                                }
                            >
                                ←
                            </button>


                            <button
                                className="slider-btn"
                                onClick={() =>
                                    scrollCategories(300)
                                }
                            >
                                →
                            </button>

                        </div>

                    </div>


                    {loadingCategories ? (

                        <p className="loading">
                            Chargement des catégories...
                        </p>

                    ) : categories.length === 0 ? (

                        <p className="empty-message">
                            Aucune catégorie disponible.
                        </p>

                    ) : (

                        <div className="categories-slider">

                            {categories.map((category) => (

                                <div
                                    className="category-card"
                                    key={category.id}
                                >

                                    <div className="category-icon">
                                        💊
                                    </div>


                                    <h3>
                                        {category.name}
                                    </h3>


                                    <button
                                        className="category-link"
                                    >
                                        Voir les produits
                                    </button>

                                </div>

                            ))}

                        </div>

                    )}

                </section>


                {/* =========================
                    MEDICINES
                ========================= */}

                <section className="medicines-section">

                    <h2 className="section-title">
                        Médicaments
                    </h2>


                    {loadingMedicines ? (

                        <p className="loading">
                            Chargement des médicaments...
                        </p>

                    ) : medicines.length === 0 ? (

                        <p className="empty-message">
                            Aucun médicament disponible.
                        </p>

                    ) : (

                        <div className="medicines-grid">

                            {medicines.map((medicine) => (

                                <div
                                    className="medicine-card"
                                    key={medicine.id}
                                    onClick={() =>
                                        navigate(
                                            `/medicaments/${medicine.id}`
                                        )
                                    }
                                >

                                    {/* IMAGE */}

                                    <div className="medicine-image">

                                        {medicine.image ? (

                                            <img
                                                src={`http://127.0.0.1:8000/storage/${medicine.image}`}
                                                alt={medicine.name}
                                            />

                                        ) : (

                                            <div className="medicine-image-placeholder">
                                                💊
                                            </div>

                                        )}

                                    </div>


                                    {/* CATEGORY */}

                                    <span className="medicine-category">

                                        {medicine.category?.name}

                                    </span>


                                    {/* NAME */}

                                    <h3>

                                        {medicine.name}

                                    </h3>


                                    {/* BRAND */}

                                    <p className="medicine-brand">

                                        {medicine.brand?.name}

                                    </p>


                                    {/* PRICE */}

                                    <div className="medicine-price">

                                        <span className="price">

                                            {medicine.sale_price ??
                                                medicine.price}{' '}
                                            DH

                                        </span>

                                    </div>


                                    {/* ADD TO CART */}

                                    <button
                                        className="add-cart-btn"
                                        onClick={(event) => {
                                            event.stopPropagation();
                                        }}
                                    >
                                        Ajouter au panier
                                    </button>

                                </div>

                            ))}

                        </div>

                    )}

                </section>

            </main>

        </div>

    );

}

export default Home;