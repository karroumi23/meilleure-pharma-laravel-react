import Header from '../components/Header';

function MainLayout({ children }) {
    return (
        <div className="app">

            <Header />

            <main>
                {children}
            </main>

        </div>
    );
}

export default MainLayout;