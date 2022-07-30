import './Layout.css';
import Header from '../Header/Header';

const Layout = ({ title, children }) => {

    return (
        <div className="mainContainer">
            <Header />

            <main>
                <h1>{title}</h1>

                <section>
                    <div className="block">{children}</div>
                </section>
            </main>
        </div>
    );
};

export default Layout;
