import { useContext } from "react";
import AuthContext from "../components/Auth/AuthContext";

const useRole = (role) => {
    const { auth, role: userRole } = useContext(AuthContext);
    return auth && userRole.includes(role);
}

export default useRole;
