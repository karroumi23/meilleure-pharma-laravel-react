import { useEffect, useState } from 'react';
import { getCategories } from '../api/categories';
import { getMedicines } from '../api/medicines';
import Hero from '../components/Hero';

function Home() {
    const [categories, setCategories] = useState([]);
    const [medicines, setMedicines] = useState([]);

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const loadHomeData = async () => {
            try {
                const [categoriesResult, medicinesResult] = await Promise.all([
                    getCategories(),
                    getMedicines(),
                ]);

                setCategories(categoriesResult.data);
                setMedicines(medicinesResult.data.data);
            } catch (error) {
                console.error(error);

                setError('Impossible de charger les données.');
            } finally {
                setLoading(false);
            }
        };

        loadHomeData();
    }, []);

    if (loading) {
        return <h1>Chargement...</h1>;
    }

    if (error) {
        return <h1>{error}</h1>;
    }

    return (
        <main>
    
            <Hero />
    
            <section>
                <h2>Catégories</h2>
    
                <ul>
                    {categories.map((category) => (
                        <li key={category.id}>
                            {category.name}
                        </li>
                    ))}
                </ul>
            </section>
    
            <section>
                <h2>Médicaments</h2>
    
                <ul>
                    {medicines.map((medicine) => (
                        <li key={medicine.id}>
                            <strong>{medicine.name}</strong>
                            {' - '}
                            {medicine.price} DH
                        </li>
                    ))}
                </ul>
            </section>
    
        </main>
    );
}

export default Home;