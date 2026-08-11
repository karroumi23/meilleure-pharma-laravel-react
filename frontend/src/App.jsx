import { useEffect, useState } from 'react';
import Header from './components/Header';
import { getCategories } from './api/categories';
import './App.css';

function App() {
  const [categories, setCategories] = useState([]);
  const [loadingCategories, setLoadingCategories] = useState(true);

  useEffect(() => {
      const fetchCategories = async () => {
          try {
              const data = await getCategories();

              setCategories(data);
          } catch (error) {
              console.error('Erreur lors du chargement des catégories:', error);
          } finally {
              setLoadingCategories(false);
          }
      };

      fetchCategories();
  }, []);

  return (
      <div className="app">
          <Header />

          <main>

              {/* HERO */}
              <section className="hero">
                  <div className="hero-content">

                      <span className="hero-badge">
                          💊 Votre pharmacie en ligne
                      </span>

                      <h1>
                          Votre santé,
                          <br />
                          <span>notre priorité</span>
                      </h1>

                      <p>
                          Retrouvez vos médicaments et produits de santé
                          facilement, rapidement et en toute sécurité.
                      </p>

                      <div className="hero-buttons">
                          <button className="btn-primary">
                              Découvrir les médicaments
                          </button>

                          <button className="btn-secondary">
                              Voir les catégories
                          </button>
                      </div>

                  </div>
              </section>

              {/* CATEGORIES */}
              <section className="categories">

                  <h2>Nos catégories</h2>

                  {loadingCategories ? (
                      <p>Chargement des catégories...</p>
                  ) : (
                      <div className="category-grid">

                          {categories.map((category) => (
                              <div
                                  className="category-card"
                                  key={category.id}
                              >
                                  {category.name}
                              </div>
                          ))}

                      </div>
                  )}

              </section>

          </main>
      </div>
  );
}

export default App;