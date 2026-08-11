import './Hero.css';

function Hero() {
    return (
        <section className="hero">

            <div className="hero-content">

                <div className="hero-text">

                    <span className="hero-badge">
                        💊 Votre pharmacie en ligne
                    </span>

                    <h1>
                        Votre santé,
                        <br />
                        notre priorité
                    </h1>

                    <p>
                        Retrouvez vos médicaments et produits de santé
                        facilement, rapidement et en toute sécurité.
                    </p>

                    <div className="hero-actions">

                        <a href="#medicaments" className="hero-primary-button">
                            Découvrir les médicaments
                        </a>

                        <a href="#categories" className="hero-secondary-button">
                            Voir les catégories
                        </a>

                    </div>

                </div>

                <div className="hero-visual">

                    <div className="hero-circle">
                        💊
                    </div>

                    <div className="hero-card hero-card-one">
                        <span>✓</span>
                        Livraison rapide
                    </div>

                    <div className="hero-card hero-card-two">
                        <span>✓</span>
                        Produits certifiés
                    </div>

                </div>

            </div>

        </section>
    );
}

export default Hero;