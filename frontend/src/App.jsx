import { BrowserRouter, Routes, Route } from 'react-router-dom';

import Home from './pages/Home';
import MedicineDetails from './pages/MedicineDetails';

import './App.css';

function App() {

    return (

        <BrowserRouter>

            <Routes>

                <Route
                    path="/"
                    element={<Home />}
                />

                <Route
                    path="/medicaments/:id"
                    element={<MedicineDetails />}
                />

            </Routes>

        </BrowserRouter>

    );

}

export default App;