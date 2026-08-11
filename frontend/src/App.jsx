import { useEffect, useState } from 'react';
import { getCategories } from './api/categories';

function App() {
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const loadCategories = async () => {
            try {
                const result = await getCategories();

                setCategories(result.data);
            } catch (error) {
                console.error(error);

                setError('Impossible de charger les catégories.');
            } finally {
                setLoading(false);
            }
        };

        loadCategories();
    }, []);

    if (loading) {
        return <h1>Chargement...</h1>;
    }

    if (error) {
        return <h1>{error}</h1>;
    }

    return (
        <div>
            <h1>Meilleure Pharma</h1>

            <h2>Catégories</h2>

            <ul>
                {categories.map((category) => (
                    <li key={category.id}>
                        {category.name}
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default App;