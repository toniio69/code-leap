import React from 'react';
import { createRoot } from 'react-dom/client';
import AdminDashboard from './components/admin-dashboard';

const el = document.getElementById('admin-dashboard-root');
if (el) {
  const stats = JSON.parse(el.dataset.stats || '{}');
  const recentUsers = JSON.parse(el.dataset.recentUsers || '[]');
  createRoot(el).render(
    <AdminDashboard stats={stats} recentUsers={recentUsers} />
  );
}