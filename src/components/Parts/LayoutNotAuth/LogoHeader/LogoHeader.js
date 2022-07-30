import Title from '../../Title/Title';
import './LogoHeader.css';
import logo from './papierpain.png';

const LogoHeader = () => {
    return (
        <header className='logoHeader'>
            <img src={logo} alt="logo" />

            <Title />
        </header>
    );
};

export default LogoHeader;
