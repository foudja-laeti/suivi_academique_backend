import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import AuthService from '../services/AuthService';

export default function Login() {
  const [login_pers, setLoginPers] = useState<string>('');
  const [pwd_pers, setPwdPers] = useState<string>('');
  const [error, setError] = useState<string>('');
  const [loading, setLoading] = useState<boolean>(false);
  const navigate = useNavigate();

  // Typage de l'événement de soumission du formulaire
  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      await AuthService.login(login_pers, pwd_pers);
      navigate('/dashboard');
    } catch (err: any) {
      setError(err.message || 'Identifiant ou mot de passe incorrect');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={styles.container}>
      <div style={styles.card}>
        <div style={styles.header}>
          <div style={styles.logo}>🎓</div>
          <h1 style={styles.title}>Suivi Académique</h1>
          <p style={styles.subtitle}>Connectez-vous à votre espace</p>
        </div>

        {error && <div style={styles.error}>{error}</div>}

        <form onSubmit={handleSubmit} style={styles.form}>
          <div style={styles.field}>
            <label style={styles.label}>Email / Identifiant</label>
            <input
              type="text"
              value={login_pers}
              // Typage de l'événement de changement d'input
              onChange={(e: React.ChangeEvent<HTMLInputElement>) => setLoginPers(e.target.value)}
              placeholder="votre@email.com"
              style={styles.input}
              required
            />
          </div>

          <div style={styles.field}>
            <label style={styles.label}>Mot de passe</label>
            <input
              type="password"
              value={pwd_pers}
              onChange={(e: React.ChangeEvent<HTMLInputElement>) => setPwdPers(e.target.value)}
              placeholder="••••••••"
              style={styles.input}
              required
            />
          </div>

          <button 
            type="submit" 
            style={{
              ...styles.button,
              opacity: loading ? 0.7 : 1,
              cursor: loading ? 'not-allowed' : 'pointer'
            }} 
            disabled={loading}
          >
            {loading ? 'Connexion...' : 'Se connecter'}
          </button>
        </form>
      </div>
    </div>
  );
}

// Utilisation de React.CSSProperties pour garantir que les valeurs comme "center" sont acceptées
const styles: { [key: string]: React.CSSProperties } = {
  container: {
    minHeight: '100vh',
    background: 'linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%)',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    padding: '20px',
  },
  card: {
    background: 'white',
    borderRadius: '16px',
    padding: '40px',
    width: '100%',
    maxWidth: '420px',
    boxShadow: '0 20px 60px rgba(0,0,0,0.3)',
  },
  header: { 
    textAlign: 'center', 
    marginBottom: '32px' 
  },
  logo: { fontSize: '48px', marginBottom: '12px', textAlign: 'center' },
  title: { fontSize: '24px', fontWeight: '700', color: '#1e3a5f', margin: '0 0 8px', textAlign: 'center' },
  subtitle: { color: '#666', margin: 0, fontSize: '14px', textAlign: 'center' },
  error: {
    background: '#fee2e2',
    color: '#dc2626',
    padding: '12px',
    borderRadius: '8px',
    marginBottom: '16px',
    fontSize: '14px',
    textAlign: 'center'
  },
  form: { display: 'flex', flexDirection: 'column', gap: '20px' },
  field: { display: 'flex', flexDirection: 'column', gap: '6px' },
  label: { fontSize: '14px', fontWeight: '600', color: '#374151' },
  input: {
    padding: '12px 16px',
    border: '2px solid #e5e7eb',
    borderRadius: '8px',
    fontSize: '15px',
    outline: 'none',
  },
  button: {
    background: 'linear-gradient(135deg, #1e3a5f, #2d6a9f)',
    color: 'white',
    border: 'none',
    padding: '14px',
    borderRadius: '8px',
    fontSize: '16px',
    fontWeight: '600',
    marginTop: '8px',
  },
};