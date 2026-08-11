import './Header.css';

function Header() {
    return (
        <header className="header">

            {/* Top Header */}
            <div className="header-main">

                {/* Logo */}
                <a href="/" className="logo">
                    Meilleure Pharma
                </a>

                {/* Search */}
                <div className="search-box">
                    <input
                        type="text"
                        placeholder="Rechercher un médicament..."
                    />

                    <button type="button">
                        🔍
                    </button>
                </div>

                {/* Actions */}
                <div className="header-actions">

                    <button type="button" className="header-action">
                        👤
                        <span>Connexion</span>
                    </button>

                    <button type="button" className="header-action cart-button">
                        🛒
                        <span>Panier</span>

                        <span className="cart-count">
                            0
                        </span>
                    </button>

                </div>

            </div>

            {/* Navigation */}
            <nav className="navigation">

                <a href="/">
                    Accueil
                </a>

                <a href="/medicaments">
                    Médicaments
                </a>

                <a href="/parapharmacie">
                    Parapharmacie
                </a>

                <a href="/promotions">
                    Promotions
                </a>

            </nav>

        </header>
    );
}

export default Header;