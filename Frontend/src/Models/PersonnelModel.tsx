// src/Models/PersonnelModel.tsx
/**
 * Modèle de données pour le Personnel (TypeScript)
 * Aligné avec la migration Laravel
 */

export enum PersonnelType {
    RESPONSABLE_DISC = 'RESPONSABLE DISCIPLINE',
    ENSEIGNANT = 'ENSEIGNANT',
    RESPONSABLE_ACAD = 'RESPONSABLE ACADEMIQUE'
}

export enum PersonnelSexe {
    MASCULIN = 'Masculin',
    FEMININ = 'Feminin'
}

export interface IPersonnel {
    id?: string | null;
    code_pers: string;
    nom_pers: string;
    sexe_pers: PersonnelSexe;
    phone_pers: string;
    login_pers: string;
    pwd_pers?: string;
    type_pers: PersonnelType;
    created_at?: string | null;
    updated_at?: string | null;
}

class PersonnelModel implements IPersonnel {
    public id: string | null;
    public code_pers: string;
    public nom_pers: string;
    public sexe_pers: PersonnelSexe;
    public phone_pers: string;
    public login_pers: string;
    public pwd_pers: string;
    public type_pers: PersonnelType;
    public created_at: string | null;
    public updated_at: string | null;

    constructor(data: Partial<IPersonnel> = {}) {
        this.id = data.id || null;
        this.code_pers = data.code_pers || '';
        this.nom_pers = data.nom_pers || '';
        this.sexe_pers = data.sexe_pers || PersonnelSexe.FEMININ;
        this.phone_pers = data.phone_pers || '';
        this.login_pers = data.login_pers || '';
        this.pwd_pers = data.pwd_pers || '';
        this.type_pers = data.type_pers || PersonnelType.ENSEIGNANT;
        this.created_at = data.created_at || null;
        this.updated_at = data.updated_at || null;
    }

    /**
     * Prépare les données pour l'envoi à l'API Laravel
     */
    toJSON(): Partial<IPersonnel> {
        return {
            code_pers: this.code_pers,
            nom_pers: this.nom_pers,
            sexe_pers: this.sexe_pers,
            phone_pers: this.phone_pers,
            login_pers: this.login_pers,
            pwd_pers: this.pwd_pers,
            type_pers: this.type_pers,
        };
    }

    /**
     * Validation basique
     */
    isValid(): boolean {
        return (
            this.nom_pers.trim().length > 0 &&
            this.login_pers.includes('@') &&
            this.pwd_pers.length >= 5
        );
    }
}

export default PersonnelModel;