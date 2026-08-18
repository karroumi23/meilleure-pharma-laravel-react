import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import Header from '../components/Header';
import { getMedicine } from '../api/medicines';

function MedicineDetails() {

    const { id } = useParams();
    const navigate = useNavigate();

    const [medicine, setMedicine] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const [quantity, setQuantity] = useState(1);


    // =========================
    // LOAD MEDICINE
    // =========================

    useEffect(() => {

        const fetchMedicine = async () => {

            try {

                setLoading(true);

                const data = await getMedicine(id);

                setMedicine(data);

            } catch (error) {

                console.error(
                    'Erreur lors du chargement du médicament:',
                    error
                );

                setError(
                    'Impossible de charger ce médicament.'
                );

            } finally {

                setLoading(false);

            }

        };

        fetchMedicine();

    }, [id]);


    // =========================
    // LOADING
    // =========================

    if (loading) {

        return (

            <div className="details-page">

                <Header />

                <div className="details-loading">

                    <div className="loading-spinner"></div>

                    <p>
                        Chargement du médicament...
                    </p>

                </div>

            </div>

        );

    }


    // =========================
    // ERROR
    // =========================

    if (error || !medicine) {

        return (

            <div className="details-page">

                <Header />

                <div className="details-error">

                    <div className="error-icon">
                        💊
                    </div>

                    <h2>
                        Médicament introuvable
                    </h2>

                    <p>
                        Le médicament que vous recherchez
                        n'existe pas ou n'est plus disponible.
                    </p>

                    <button
                        className="back-home-btn"
                        onClick={() => navigate('/')}
                    >
                        Retour à l'accueil
                    </button>

                </div>

            </div>

        );

    }


    // =========================
    // PRICE
    // =========================

    const hasSalePrice =
        medicine.sale_price !== null &&
        medicine.sale_price !== undefined &&
        Number(medicine.sale_price) > 0;


    const currentPrice = hasSalePrice
        ? medicine.sale_price
        : medicine.price;


    const oldPrice = medicine.price;


    // =========================
    // DISCOUNT
    // =========================

    const discount = hasSalePrice
        ? Math.round(
            ((Number(oldPrice) - Number(currentPrice)) /
                Number(oldPrice)) *
                100
        )
        : 0;


    // =========================
    // QUANTITY
    // =========================

    const increaseQuantity = () => {

        if (
            medicine.stock &&
            quantity < medicine.stock
        ) {

            setQuantity(quantity + 1);

        }

    };


    const decreaseQuantity = () => {

        if (quantity > 1) {

            setQuantity(quantity - 1);

        }

    };


    return (

        <div className="details-page">

            <Header />


            <main className="product-details-container">


                {/* =========================
                    BREADCRUMB
                ========================= */}

                <div className="product-breadcrumb">

                    <button
                        onClick={() => navigate('/')}
                    >
                        Accueil
                    </button>

                    <span>›</span>

                    <button>
                        Médicaments
                    </button>

                    <span>›</span>

                    <span>
                        {medicine.name}
                    </span>

                </div>


                {/* =========================
                    MAIN PRODUCT
                ========================= */}

                <section className="product-main">


                    {/* =========================
                        PRODUCT IMAGE
                    ========================= */}

                    <div className="product-gallery">

                        <div className="product-image-box">

                            {medicine.image ? (

                                <img
                                    src={`http://127.0.0.1:8000/storage/${medicine.image}`}
                                    alt={medicine.name}
                                />

                            ) : (

                                <div className="product-image-placeholder">
                                    💊
                                </div>

                            )}

                        </div>


                        <div className="image-caption">

                            <span>
                                ✓ Produit authentique
                            </span>

                            <span>
                                ✓ Qualité garantie
                            </span>

                        </div>

                    </div>


                    {/* =========================
                        PRODUCT INFO
                    ========================= */}

                    <div className="product-info">


                        {/* CATEGORY */}

                        {medicine.category?.name && (

                            <span className="product-category">

                                {medicine.category.name}

                            </span>

                        )}


                        {/* NAME */}

                        <h1>
                            {medicine.name}
                        </h1>


                        {/* BRAND */}

                        {medicine.brand?.name && (

                            <p className="product-brand">

                                Marque :

                                <strong>
                                    {medicine.brand.name}
                                </strong>

                            </p>

                        )}


                        {/* RATING */}

                        <div className="product-rating">

                            <span className="stars">
                                ★★★★★
                            </span>

                            <span>
                                {medicine.rating || '0'} / 5
                            </span>

                        </div>


                        <div className="product-divider"></div>


                        {/* PRICE */}

                        <div className="details-price">

                            <span className="details-current-price">

                                {Number(currentPrice).toFixed(2)} DH

                            </span>


                            {hasSalePrice && (

                                <>

                                    <span className="details-old-price">

                                        {Number(oldPrice).toFixed(2)} DH

                                    </span>


                                    <span className="discount-badge">

                                           {discount}%

                                    </span>

                                </>

                            )}

                        </div>


                        {/* STOCK */}

                        <div className="details-stock">

                            {medicine.stock > 0 ? (

                                <>

                                    <span className="stock-dot"></span>

                                    <strong>
                                        En stock
                                    </strong>

                                    <span>
                                        — {medicine.stock} disponibles
                                    </span>

                                </>

                            ) : (

                                <>

                                    <span className="stock-dot out"></span>

                                    <strong>
                                        Rupture de stock
                                    </strong>

                                </>

                            )}

                        </div>


                        {/* DOSAGE */}

                        {medicine.dosage && (

                            <div className="product-dosage">

                                <span>
                                    Dosage
                                </span>

                                <strong>
                                    {medicine.dosage}
                                </strong>

                            </div>

                        )}


                        {/* QUANTITY + CART */}

                        {medicine.stock > 0 && (

                            <div className="purchase-area">


                                <div className="quantity-selector">

                                    <button
                                        onClick={decreaseQuantity}
                                    >
                                        −
                                    </button>


                                    <span>
                                        {quantity}
                                    </span>


                                    <button
                                        onClick={increaseQuantity}
                                    >
                                        +
                                    </button>

                                </div>


                                <button
                                    className="details-cart-btn"
                                >
                                    🛒 Ajouter au panier
                                </button>

                            </div>

                        )}


                        {/* FEATURES */}

                        <div className="product-features">

                            <div className="feature">

                                <div className="feature-icon">
                                    🚚
                                </div>

                                <div>
                                    <strong>
                                        Livraison rapide
                                    </strong>

                                    <span>
                                        24h - 48h
                                    </span>
                                </div>

                            </div>


                            <div className="feature">

                                <div className="feature-icon">
                                    🛡️
                                </div>

                                <div>
                                    <strong>
                                        Produit authentique
                                    </strong>

                                    <span>
                                        Qualité garantie
                                    </span>
                                </div>

                            </div>


                            <div className="feature">

                                <div className="feature-icon">
                                    💬
                                </div>

                                <div>
                                    <strong>
                                        Conseil
                                    </strong>

                                    <span>
                                        Nos pharmaciens vous conseillent
                                    </span>
                                </div>

                            </div>

                        </div>


                    </div>

                </section>


                {/* =========================
                    DESCRIPTION
                ========================= */}

                <section className="product-description-section">


                    <div className="description-tabs">

                        <button className="active">
                            Description
                        </button>

                        <button>
                            Détails du produit
                        </button>

                    </div>


                    <div className="description-content">


                        <div className="description-column">

                            <h2>
                                Description
                            </h2>

                            {medicine.description ? (

                                <p>
                                    {medicine.description}
                                </p>

                            ) : (

                                <p className="no-description">

                                    Aucune description disponible
                                    pour ce produit.

                                </p>

                            )}

                        </div>


                        <div className="details-column">

                            <h2>
                                Informations
                            </h2>


                            <div className="info-row">

                                <span>
                                    Nom
                                </span>

                                <strong>
                                    {medicine.name}
                                </strong>

                            </div>


                            {medicine.category?.name && (

                                <div className="info-row">

                                    <span>
                                        Catégorie
                                    </span>

                                    <strong>
                                        {medicine.category.name}
                                    </strong>

                                </div>

                            )}


                            {medicine.brand?.name && (

                                <div className="info-row">

                                    <span>
                                        Marque
                                    </span>

                                    <strong>
                                        {medicine.brand.name}
                                    </strong>

                                </div>

                            )}


                            {medicine.dosage && (

                                <div className="info-row">

                                    <span>
                                        Dosage
                                    </span>

                                    <strong>
                                        {medicine.dosage}
                                    </strong>

                                </div>

                            )}


                            <div className="info-row">

                                <span>
                                    Référence
                                </span>

                                <strong>
                                    #{medicine.id}
                                </strong>

                            </div>


                        </div>

                    </div>

                </section>


                {/* =========================
                    BACK BUTTON
                ========================= */}

                <div className="details-back">

                    <button
                        onClick={() => navigate('/')}
                    >
                        ← Continuer mes achats
                    </button>

                </div>


            </main>

        </div>

    );

}

export default MedicineDetails;