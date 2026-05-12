// services/AuthService.ts 
import api from "./api";
import PersonnelModel, { IPersonnel } from "../Models/PersonnelModel";

export interface LoginResponse {
    token: string;
    personnel: IPersonnel;
    message?: string;
}

class AuthService {
    /**
     * Tentative de connexion
     * @param login_pers Email ou identifiant
     * @param pwd_pers Mot de passe
     */
    async login(login_pers: string, pwd_pers: string): Promise<LoginResponse> {
        try {
            const response = await api.post<LoginResponse>('/login', {
                login_pers,
                pwd_pers
            });

            if (response.data.token) {
                localStorage.setItem('token', response.data.token);
                // On stocke aussi les infos de base (sauf le mot de passe)
                localStorage.setItem('user', JSON.stringify(response.data.personnel));
            }

            return response.data;
        } catch (error: any) {
            throw error.response?.data || { message: "Erreur de connexion au serveur" };
        }
    }

    /**
     * Déconnexion de l'utilisateur
     */
    async logout(): Promise<void> {
        try {
            await api.post('/logout');
        } finally {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }
    }

    /**
     * Récupère l'utilisateur actuellement stocké
     */
    getCurrentUser(): PersonnelModel | null {
        const userJson = localStorage.getItem('user');
        if (!userJson) return null;
        return new PersonnelModel(JSON.parse(userJson));
    }

    /**
     * Vérifie si l'utilisateur est authentifié
     */
    isAuthenticated(): boolean {
        return !!localStorage.getItem('token');
    }
}

export default new AuthService();