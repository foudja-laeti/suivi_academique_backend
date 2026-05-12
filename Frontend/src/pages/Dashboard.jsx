import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import api from '../services/api';

export default function Dashboard() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const [stats, setStats] = useState({ filieres: 0, niveaux: 0, ues: 0, salles: 0 });
  const [active, setActive] = useState('dashboard');

 useEffect(() => {
  const fetchStats = async () => {
    try {
      const res = await api.get('/filieres');
      const data = res.data?.filieres || res.data?.data || res.data || [];
      setStats({
        filieres: data.length,
        niveaux: 0,
        ues: 0,
        salles: 0,
      });
    } catch (e) {
      console.error(e);
    }
  };
  fetchStats();
}, []);
  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  const menuItems = [
    { id: 'dashboard', icon: '🏠', label: 'Tableau de bord' },
    { id: 'filieres', icon: '📚', label: 'Filières' },
    { id: 'niveaux', icon: '🎯', label: 'Niveaux' },
    { id: 'ues', icon: '📖', label: 'Unités d\'Enseignement' },
    { id: 'salles', icon: '🏛️', label: 'Salles' },
    { id: 'personnels', icon: '👨‍🏫', label: 'Personnels' },
    { id: 'programmations', icon: '📅', label: 'Programmations' },
  ];

  const statCards = [
    { label: 'Filières', value: stats.filieres, icon: '📚', color: '#3b82f6' },
    { label: 'Niveaux', value: stats.niveaux, icon: '🎯', color: '#10b981' },
    { label: 'UE', value: stats.ues, icon: '📖', color: '#f59e0b' },
    { label: 'Salles', value: stats.salles, icon: '🏛️', color: '#8b5cf6' },
  ];

  return (
    <div style={styles.layout}>
      {/* Sidebar */}
      <aside style={styles.sidebar}>
        <div style={styles.sidebarHeader}>
          <span style={{ fontSize: '28px' }}>🎓</span>
          <span style={styles.sidebarTitle}>Suivi Académique</span>
        </div>

        <nav style={styles.nav}>
          {menuItems.map((item) => (
            <button
              key={item.id}
              onClick={() => setActive(item.id)}
              style={{
                ...styles.navItem,
                background: active === item.id ? 'rgba(255,255,255,0.2)' : 'transparent',
                fontWeight: active === item.id ? '600' : '400',
              }}
            >
              <span>{item.icon}</span>
              <span>{item.label}</span>
            </button>
          ))}
        </nav>

        <button onClick={handleLogout} style={styles.logoutBtn}>
          🚪 Déconnexion
        </button>
      </aside>

      {/* Main */}
      <main style={styles.main}>
        {/* Topbar */}
        <div style={styles.topbar}>
          <div>
            <h2 style={styles.pageTitle}>Tableau de bord</h2>
            <p style={styles.pageSubtitle}>Bienvenue, {user?.name || 'Administrateur'}</p>
          </div>
          <div style={styles.avatar}>
            {(user?.name || 'A')[0].toUpperCase()}
          </div>
        </div>

        {/* Stats */}
        <div style={styles.statsGrid}>
          {statCards.map((card) => (
            <div key={card.label} style={{ ...styles.statCard, borderTop: `4px solid ${card.color}` }}>
              <div style={styles.statIcon}>{card.icon}</div>
              <div>
                <div style={{ ...styles.statValue, color: card.color }}>{card.value}</div>
                <div style={styles.statLabel}>{card.label}</div>
              </div>
            </div>
          ))}
        </div>

        {/* Info */}
        <div style={styles.infoGrid}>
          <div style={styles.infoCard}>
            <h3 style={styles.infoTitle}>📋 À propos du système</h3>
            <p style={styles.infoText}>
              Plateforme de gestion académique permettant le suivi des filières,
              niveaux, unités d'enseignement, programmations et du personnel enseignant.
            </p>
          </div>
          <div style={styles.infoCard}>
            <h3 style={styles.infoTitle}>🚀 Accès rapide</h3>
            <div style={styles.quickLinks}>
              {menuItems.slice(1).map((item) => (
                <button
                  key={item.id}
                  onClick={() => setActive(item.id)}
                  style={styles.quickLink}
                >
                  {item.icon} {item.label}
                </button>
              ))}
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}

const styles = {
  layout: { display: 'flex', minHeight: '100vh', fontFamily: 'Segoe UI, sans-serif' },
  sidebar: {
    width: '260px',
    background: 'linear-gradient(180deg, #1e3a5f 0%, #2d6a9f 100%)',
    display: 'flex',
    flexDirection: 'column',
    padding: '0',
    position: 'fixed',
    height: '100vh',
    overflowY: 'auto',
  },
  sidebarHeader: {
    display: 'flex',
    alignItems: 'center',
    gap: '12px',
    padding: '24px 20px',
    borderBottom: '1px solid rgba(255,255,255,0.1)',
  },
  sidebarTitle: { color: 'white', fontWeight: '700', fontSize: '16px' },
  nav: { flex: 1, padding: '16px 12px', display: 'flex', flexDirection: 'column', gap: '4px' },
  navItem: {
    display: 'flex',
    alignItems: 'center',
    gap: '12px',
    padding: '12px 16px',
    color: 'white',
    border: 'none',
    borderRadius: '8px',
    cursor: 'pointer',
    fontSize: '14px',
    width: '100%',
    textAlign: 'left',
    transition: 'background 0.2s',
  },
  logoutBtn: {
    margin: '16px 12px',
    padding: '12px 16px',
    background: 'rgba(255,255,255,0.1)',
    color: 'white',
    border: 'none',
    borderRadius: '8px',
    cursor: 'pointer',
    fontSize: '14px',
    textAlign: 'left',
  },
  main: { marginLeft: '260px', flex: 1, background: '#f1f5f9', minHeight: '100vh', padding: '24px' },
  topbar: {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    background: 'white',
    padding: '20px 24px',
    borderRadius: '12px',
    marginBottom: '24px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.1)',
  },
  pageTitle: { margin: 0, fontSize: '22px', fontWeight: '700', color: '#1e3a5f' },
  pageSubtitle: { margin: '4px 0 0', color: '#666', fontSize: '14px' },
  avatar: {
    width: '42px',
    height: '42px',
    borderRadius: '50%',
    background: 'linear-gradient(135deg, #1e3a5f, #2d6a9f)',
    color: 'white',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    fontWeight: '700',
    fontSize: '18px',
  },
  statsGrid: { display: 'grid', gridTemplateColumns: 'repeat(4, 1fr)', gap: '16px', marginBottom: '24px' },
  statCard: {
    background: 'white',
    borderRadius: '12px',
    padding: '20px',
    display: 'flex',
    alignItems: 'center',
    gap: '16px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.1)',
  },
  statIcon: { fontSize: '32px' },
  statValue: { fontSize: '28px', fontWeight: '700' },
  statLabel: { color: '#666', fontSize: '13px', marginTop: '2px' },
  infoGrid: { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px' },
  infoCard: {
    background: 'white',
    borderRadius: '12px',
    padding: '24px',
    boxShadow: '0 1px 3px rgba(0,0,0,0.1)',
  },
  infoTitle: { margin: '0 0 12px', fontSize: '16px', fontWeight: '600', color: '#1e3a5f' },
  infoText: { color: '#666', lineHeight: '1.6', fontSize: '14px', margin: 0 },
  quickLinks: { display: 'flex', flexWrap: 'wrap', gap: '8px' },
  quickLink: {
    padding: '8px 12px',
    background: '#f1f5f9',
    border: 'none',
    borderRadius: '6px',
    cursor: 'pointer',
    fontSize: '13px',
    color: '#1e3a5f',
    fontWeight: '500',
  },
};
